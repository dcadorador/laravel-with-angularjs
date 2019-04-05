<?php

namespace App\Http\Controllers;

use App\Models\UpsellLog;
use Illuminate\Http\Request;
use App\Services\InfusionSoftServices;
use App\Services\ClickBankService;
use App\Models\SystemSetting;
use League\Csv\Writer;
use App\Models\OrderFlow;

class TicketController extends Controller
{
    private $cb;

    public function __construct()
    {
        $this->infs = new InfusionSoftServices;
        $this->cb = new ClickBankService(
            SystemSetting::where('meta_key','CB_DEVELOPER_KEY')->value('meta_value'),
            SystemSetting::where('meta_key','CB_CLERK_KEY')->value('meta_value'),
            SystemSetting::where('meta_key','CB_SECRET_KEY')->value('meta_value'));
    }

    /**
     * Item Number Lists
     *
     * @return
     *      initial_flow - the complete flow config
     *      initial_item_numbers - initial item number
     *      upsell_item_numbers - upsell item numbers associated with the initial item numbers
     *
     */
    public function itemNumberList()
    {
        $initialItemNoArr = [];
        $upsellItemNoArr = [];

        // use the order flow model instead of the file
        $order_flows = OrderFlow::select('flow')->get();

        // get the 1st value from the flow (initial item number)
        foreach($order_flows as $order_flow){
            $flow = explode(',',$order_flow->flow);
            $initialItemNoArr[] = reset($flow);
        }

        // get the succeeding values from the flow (succeeding item number associated with the initial, for upgrades)
        foreach($order_flows as $order_flow) {
            $flow = explode(',', $order_flow->flow);
            $values = array_slice($flow, 1);
            foreach($values as $value) {
                $upsellItemNoArr[] = $value;
            }
            $upsellItemNoArr = array_values(array_unique($upsellItemNoArr));
        }

        $data = [
            'initial_item_numbers' => $initialItemNoArr,
            'upsell_item_numbers' => array_values($upsellItemNoArr)
        ];

        // return the correct data groups
        return $data;
    }

    /**
     * Initial Receipt Finder
     *
     * @param
     *      $item_numbers - array of initial item number from itemNumberList()
     *      $start - date object : yesterday
     *      $end - date object : today
     * @return
     *      $receipt_numbers - array of objects with receipts from initial item number
     */
    public function initialReceiptFinder($item_numbers, $start, $end)
    {
        $receipt_numbers = [];
        foreach($item_numbers as $item_number) {
            $status_code = 206;
            $page = 1;
            for($status_code; $status_code == 206; $page++) {
                //\Log::info('Receipt Finder - Result Page No: '.$page.' - Item Number: '.$item_number);
                // set page header
                $this->cb->setHeader('page',$page);
                // set the url
                $url = "orders2/list?item=" . $item_number . "&startDate=" . $start . "&endDate=" . $end;
                // send the request
                $cbResult = $this->cb->get($url);
                // get the http status code to checking
                $status_code = $this->cb->getHttpCode();
                //\Log::info('Receipt Finder - HTTP Status code: '.$status_code);
                // check the result
                if($cbResult && $cbResult->orderData) {
                    if(is_array($cbResult->orderData)){
                        foreach($cbResult->orderData as $order){
                            // added for testing
                            if(env('UPSELL_TEST_FLAG') == true) {
                                if(strpos($order->email,'fusedsoftware') !== false) {
                                    //\Log::info('Upsell test flag enabled, filtering only fusedsoftware emails');
                                    $order_obj = new \stdClass();
                                    $order_obj->item_number = $item_number;
                                    $order_obj->receipt = $order->receipt;
                                    $receipt_numbers[] = $order_obj;
                                }
                            }
                            else {
                                $order_obj = new \stdClass();
                                $order_obj->item_number = $item_number;
                                $order_obj->receipt = $order->receipt;
                                $receipt_numbers[] = $order_obj;
                            }

                        }
                    } else {
                        if(env('UPSELL_TEST_FLAG') == true) {
                            if(strpos($cbResult->orderData->email,'fusedsoftware') !== false) {
                                //\Log::info('Upsell test flag enabled, filtering only fusedsoftware emails');
                                $order_obj = new \stdClass();
                                $order_obj->item_number = $item_number;
                                $order_obj->receipt = $cbResult->orderData->receipt;
                                $receipt_numbers[] = $order_obj;
                            }
                        } else {
                            $order_obj = new \stdClass();
                            $order_obj->item_number = $item_number;
                            $order_obj->receipt = $cbResult->orderData->receipt;
                            $receipt_numbers[] = $order_obj;
                        }
                    }
                }
            }
        }
        return $receipt_numbers;
    }


    /**
     * Upsell Finder for specific Receipt
     *
     * @param
     *      $receipt_numbers - from the function initialReceiptFinder
     *      $upsell_item_numbers - from the function initialReceiptFinder
     * @return
     *      $upsell_pairs - initial and upsell item numbers
     */
    public function upsellFinder($receipt_numbers, $upsell_item_numbers)
    {
        $upsell_pairs = [];

        foreach($receipt_numbers as $receipt) {
            // declare the receipt row object
            // initialize the data
            $receipt_row = new \stdClass();

            $receipt_number = $receipt->receipt;
            // format receipt to remove the dash
            $receipt_number = explode("-", $receipt_number)[0];
            $initial_item_number = $receipt->item_number;

            $receipt_row->initial_receipt = $receipt_number;
            $receipt_row->initial_item_number = $initial_item_number;

            // send the CB request
            $url = "orders2/$receipt_number/upsells";
            $cbResult = $this->cb->get($url);
            $status_code = $this->cb->getHttpCode();

            // if status code is 204 means no result and continue with the next item
            if($status_code == 204) {
                continue;
            }

            // format and check data for the upsells
            $order_upsells = [];
            $upsell_cnt = 0;

            if($cbResult && property_exists($cbResult,'orderData')) {
                if(is_array($cbResult->orderData)){
                    foreach($cbResult->orderData as $order){
                        $up_sell_row = new \stdClass();
                        $line_item_data = $order->lineItemData;
                        $up_sell_receipt = $order->receipt;
                        $item_no = $line_item_data->itemNo;
                        $transaction_time = $order->transactionTime;
                        // check if item number is inside upsell item array
                        if(in_array($item_no,$upsell_item_numbers)) {
                            $upsell_cnt++;
                            $up_sell_row->upsell_receipt = $up_sell_receipt;
                            $up_sell_row->upsell_count = $upsell_cnt;
                            $up_sell_row->item_number = $item_no;
                            $up_sell_row->transaction_time = $transaction_time;
                            $up_sell_row->product_title = $line_item_data->productTitle;
                            $order_upsells[] = $up_sell_row;
                        }
                        $receipt_row->upsells = $order_upsells;
                    }
                } else {
                    $order = $cbResult->orderData;
                    $up_sell_row = new \stdClass();
                    $line_item_data = $order->lineItemData;
                    $up_sell_receipt = $order->receipt;
                    $item_no = $line_item_data->itemNo;
                    $transaction_time = $order->transactionTime;
                    // check if item number is inside upsell item array
                    if(in_array($item_no,$upsell_item_numbers)) {
                        $upsell_cnt++;
                        $up_sell_row->upsell_receipt = $up_sell_receipt;
                        $up_sell_row->upsell_count = $upsell_cnt;
                        $up_sell_row->item_number = $item_no;
                        $up_sell_row->transaction_time = $transaction_time;
                        $up_sell_row->product_title = $line_item_data->productTitle;
                        $order_upsells[] = $up_sell_row;
                    }
                    $receipt_row->upsells = $order_upsells;
                }
            }
            $upsell_pairs[] = $receipt_row;
        }

        return $upsell_pairs;
    }

    /**
     * Order Flow Creator
     *
     * @param
     *      $upsold_orders - from the function upsellFinder
     * @return
     *      $new_order_list - new order list formatted
     */
    public function orderFlowCreator($upsold_orders){
        $new_order_list = [];

        foreach($upsold_orders as $receipt) {
            $new_row = $receipt;
            $upsells = collect($receipt->upsells);
            // sort by transaction time for the order flow creator
            $upsells = $upsells->sortBy('transaction_time')->values()->all();

            //
            $initial_item_no = $receipt->initial_item_number;
            $ordered_receipts = new \stdClass();
            $ordered_receipts->{$initial_item_no} = $receipt->initial_receipt;
            $total_item_number_flow = [];
            array_push($total_item_number_flow,$initial_item_no);

            // loop through the upsell
            foreach($upsells as $upsell){
                $upsell_item_no = $upsell->item_number;
                array_push($total_item_number_flow,$upsell->item_number);
                $ordered_receipts->{$upsell_item_no} = $upsell->upsell_receipt;
            }
            $new_row->total_item_number_flow = $total_item_number_flow;
            $new_row->ordered_receipts = $ordered_receipts;

            $new_order_list[] = $new_row;
        }

        return $new_order_list;
    }

    /**
     * Tickets to Cancel
     *
     * Function that extracts the receipt and comapres it with the order flow list
     *
     * @param
     *      $receipt_list
     *      $order_flows
     * @return
     *      $new_order_list
     */
    public function ticketsToCancel($receipt_list)
    {
        $new_order_list = [];
        foreach($receipt_list as $item) {
            $new_row = $item;
            $order_flow_data = null;
            // change this from the config file
            // use the order flow model
            $order_flows = OrderFlow::get();
            foreach($order_flows as $order_flow) {
                $flow_arr = explode(',',$order_flow->flow);
                if($item->total_item_number_flow == $flow_arr){
                    $order_flow_data = $order_flow;
                }
            }
            /*foreach($order_flows as $order_flow) {
                if($item->total_item_number_flow == $order_flow['flow']){
                    $order_flow_data = $order_flow;
                }
            }*/
            if($order_flow_data == null){
                continue;
            } else {
                $ordered_receipts = $item->ordered_receipts;
                //$which_item = $order_flow_data['which_item'];
                $which_item = $order_flow_data->item_to_process;
                $ticket_to_be_modified = $ordered_receipts->{$which_item};
                $new_row->ticket_to_be_modified = $ticket_to_be_modified;
                //$new_row->cncl_or_rfnd = $order_flow_data['cncl_or_rfnd'];
                $new_row->cncl_or_rfnd = $order_flow_data->process_type;
            }
            $new_order_list[] = $new_row;
        }
        return $new_order_list;
    }

    /**
     * Ticket Cancellation Submission
     *
     * @param
     *      $receipt_pairs - formatted data
     * @return
     *      $stat - for statistics purposes
     */
    public function ticket_creator($receipt_pairs)
    {
        $stats = [];
        foreach($receipt_pairs as $pair) {
            $stat = new \stdClass();
            // initialize the data
            $initial_receipt = $pair->initial_receipt;
            $ticket_modify = $pair->ticket_to_be_modified;
            $type = $pair->cncl_or_rfnd;

            // set up stats data
            $stat->initial_receipt = $initial_receipt;
            $stat->receipt_with_ticket = $ticket_modify;
            $stat->cancel_ticket_placed = 0;
            $stat->refund_ticket_placed = 0;
            $stat->time = '';
            $reason = '';

            // determine reason
            if($type == 'rfnd') {
                $reason = 'ticket.type.refund.8';
            }
            if($type == 'cncl') {
                $reason = 'ticket.type.cancel.7';
            }

            // create the data for the DB API
            $data = [
                'reason' => $reason,
                'type' => $type
            ];
            if($type == 'rfnd') {
                $data['refundType'] = 'FULL';
            }

            // send request
            $cb_result = $this->cb->post("tickets/$ticket_modify", $data);
            //\Log::info('CB Cancellation request: '.json_encode($cb_result));
            $status_code = $this->cb->getHttpCode();

            // added to verify if the receipt of the ticket has been cancelled
            if($status_code == 400) {
                $cb_result = $this->cb->get("tickets/list?receipt=$ticket_modify");
                //\Log::info('CB Receipt Ticket request: '.json_encode($cb_result));
                if($cb_result && property_exists($cb_result, 'ticketData')) {
                    $ticket = $cb_result->ticketData;
                } else if (property_exists($cb_result, 'ticketData') && is_array($cb_result->ticketData)) {
                    $ticket = $cb_result->ticketData[0];
                }

                if($ticket) {
                    if($type == 'cncl') {
                        $stat->cancel_ticket_placed = 1;
                    }
                    if($type == 'rfnd') {
                        $stat->refund_ticket_placed = 1;
                    }
                }
            }

            // update the stats data
            if($status_code == 200) {
                if($type == 'cncl') {
                    $stat->cancel_ticket_placed = 1;
                }
                if($type == 'rfnd') {
                    $stat->refund_ticket_placed = 1;
                }
                $stat->time = \Carbon\Carbon::now()->toDateTimeString();
            }
            $stats[] = $stat;
        }

        return $stats;
    }


    /**
     * Main Function
     *
     * @return array
     */
    public function cancelUpsell()
    {
        $start = \Carbon\Carbon::now()->subDay(1)->format('Y-m-d');
        $end = \Carbon\Carbon::now()->format('Y-m-d');

        $total_order_flows = $this->itemNumberList();
        $initial_item_numbers = $total_order_flows['initial_item_numbers'];
        $upsell_item_numbers = $total_order_flows['upsell_item_numbers'];

        // get the initial receipts for the upgradebable subscriptions
        $receipts = $this->initialReceiptFinder($initial_item_numbers,$start,$end);

        if(empty($receipts)){
            \Log::info('Cancel Upsell Function, No receipts found');
            return response(['status' => 'SUCCESS', 'msg' => "No order found"], 200);
        }

        // check of the receipts have an upsell equivalent
        $upsold_orders = $this->upsellFinder($receipts,$upsell_item_numbers);

        // build the order with the additional data
        $orders_with_order_flow = $this->orderFlowCreator($upsold_orders);

        // generate the correct and final list to process
        $final_order_list = $this->ticketsToCancel($orders_with_order_flow);

        // create tickets for CB processing
        $orders_with_new_tickets = $this->ticket_creator($final_order_list);

        // create the data to be inserted
        foreach($orders_with_new_tickets as $ticket){
            // check if the receipt has been inserted
            // skip if existing
            $upsell_log = UpsellLog::where('initial_receipt',$ticket->initial_receipt)
                ->where('cancel_ticket_placed',$ticket->cancel_ticket_placed)
                ->where('refund_ticket_placed',$ticket->refund_ticket_placed)
                ->first();

            if($upsell_log) {
                continue;
            }

            // insert if not existing
            $upsell_log = new UpsellLog();
            $upsell_log->time = \Carbon\Carbon::parse($ticket->time)->toDateTimeString();
            $upsell_log->initial_receipt = $ticket->initial_receipt;
            $upsell_log->receipt_with_ticket = $ticket->receipt_with_ticket;
            $upsell_log->cancel_ticket_placed = $ticket->cancel_ticket_placed;
            $upsell_log->refund_ticket_placed = $ticket->refund_ticket_placed;
            $upsell_log->save();

        }

        return null;
    }
}

