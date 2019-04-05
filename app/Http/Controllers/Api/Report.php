<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\IpnLog;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class Report extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $today = true;

        if($request->report_date) {

            $dates = explode(' - ', $request->report_date);

            $to = Carbon::parse($dates[1])->toDateString().' 23:59:59';

            $from = Carbon::parse($dates[0])->toDateString().' 00:00:00';

            $today = false;

        } else {

            $to = Carbon::now()->toDateString().' 23:59:59';

            $from = Carbon::now()->toDateString().' 00:00:00';

        }

        // Total Orders
        $total_order = IpnLog::where(function($query){
                                    $query->orWhere('trans_type','SALE');
                                    $query->orWhere('trans_type','BILL');
                                    $query->orWhere('trans_type','TEST_SALE');
                                    $query->orWhere('trans_type','TEST_BILL');
                                })->where('created_at','>=',$from)
                                    ->where('created_at','<=',$to)
                                    ->count();

        $total_order_amt =  IpnLog::where(function($query){
                                    $query->orWhere('trans_type','SALE');
                                    $query->orWhere('trans_type','BILL');
                                    $query->orWhere('trans_type','TEST_SALE');
                                    $query->orWhere('trans_type','TEST_BILL');
                                })->where('created_at','>=',$from)
                                    ->where('created_at','<=',$to)
                                    ->sum('total_amount');

        $total_order_amt_dis = number_format(round(($total_order_amt),2),2);

        // Total Refund
        $total_refund = IpnLog::where(function($query){
                                    $query->orWhere('trans_type','RFND');
                                    $query->orWhere('trans_type','CGBK');
                                })->where('created_at','>=',$from)
                                    ->where('created_at','<=',$to)
                                    ->count();

        $total_refund_amt = IpnLog::where(function($query){
                                    $query->orWhere('trans_type','RFND');
                                    $query->orWhere('trans_type','CGBK');
                                })->where('created_at','>=',$from)
                                    ->where('created_at','<=',$to)
                                    ->sum('total_amount');

        $total_order_count = $total_order - $total_refund;

        $total_refund_amt_dis = number_format(round((str_replace('-','',$total_refund_amt)),2),2);
        // Net Total
        $net_total = number_format(round(($total_order_amt + $total_refund_amt),2),2);

        // Total Orders GA
        $total_order_ga = IpnLog::where('processed_to_ga',1)
                            ->where(function($query){
                                $query->orWhere('trans_type','SALE');
                                $query->orWhere('trans_type','BILL');
                                $query->orWhere('trans_type','TEST_SALE');
                                $query->orWhere('trans_type','TEST_BILL');
                            })
                            ->where('created_at','>=',$from)
                            ->where('created_at','<=',$to)
                            ->count();

        $total_order_ga_amt = IpnLog::where('processed_to_ga',1)
                                ->where(function($query){
                                    $query->orWhere('trans_type','SALE');
                                    $query->orWhere('trans_type','BILL');
                                    $query->orWhere('trans_type','TEST_SALE');
                                    $query->orWhere('trans_type','TEST_BILL');
                                })
                                ->where('created_at','>=',$from)
                                ->where('created_at','<=',$to)
                                ->sum('total_amount');

        $total_order_ga_amt_dis = number_format(round(($total_order_ga_amt),2),2);

        // Total Refund GA
        $total_refund_ga = IpnLog::where('processed_to_ga',1)
                            ->where(function($query){
                                $query->orWhere('trans_type','RFND');
                                $query->orWhere('trans_type','CGBK');
                            })
                            ->where('created_at','>=',$from)
                            ->where('created_at','<=',$to)
                            ->count();

        $total_refund_ga_amt = IpnLog::where('processed_to_ga',1)
                                ->where(function($query){
                                    $query->orWhere('trans_type','RFND');
                                    $query->orWhere('trans_type','CGBK');
                                })
                                ->where('created_at','>=',$from)
                                ->where('created_at','<=',$to)
                                ->sum('total_amount');

        $total_refund_ga_amt_dis = number_format(round((str_replace('-','',$total_refund_ga_amt)),2),2);

        // Net Total GA
        $net_total_ga = number_format(round(($total_order_ga_amt + $total_refund_ga_amt),2),2);
        $total_ga_count = $total_order_ga - $total_refund_ga;

        // Total Orders FB
        $total_order_fb = IpnLog::where('processed_to_fb',1)
                                ->where(function($query){
                                    $query->orWhere('trans_type','SALE');
                                    $query->orWhere('trans_type','BILL');
                                    $query->orWhere('trans_type','TEST_SALE');
                                    $query->orWhere('trans_type','TEST_BILL');
                                })
                            ->where('created_at','>=',$from)
                            ->where('created_at','<=',$to)
                            ->count();

        $total_order_fb_amt = IpnLog::where('processed_to_fb',1)
                            ->where(function($query){
                                $query->orWhere('trans_type','SALE');
                                $query->orWhere('trans_type','BILL');
                                $query->orWhere('trans_type','TEST_SALE');
                                $query->orWhere('trans_type','TEST_BILL');
                            })
                            ->where('created_at','>=',$from)
                            ->where('created_at','<=',$to)
                            ->sum('total_amount');

        $total_order_fb_amt_dis = number_format(round($total_order_fb_amt,2),2);

        return $this->respondSuccessfulWithData('Request Granted.', [
            'total_order'               => $total_order,
            'total_order_amt'           => $total_order_amt,
            'total_order_amt_dis'       => $total_order_amt_dis,
            'total_refund'              => $total_refund,
            'total_refund_amt'          => $total_refund_amt,
            'total_order_count'         => $total_order_count,
            'total_refund_amt_dis'      => $total_refund_amt_dis,
            'net_total'                 => $net_total,
            'total_order_ga'            => $total_order_ga,
            'total_order_ga_amt'        => $total_order_ga_amt,
            'total_order_ga_amt_dis'    => $total_order_ga_amt_dis,
            'total_refund_ga'           => $total_refund_ga,
            'total_refund_ga_amt'       => $total_refund_ga_amt,
            'total_refund_ga_amt_dis'   => $total_refund_ga_amt_dis,
            'net_total_ga'              => $net_total_ga,
            'total_ga_count'            => $total_ga_count,
            'total_order_fb'            => $total_order_fb,
            'total_order_fb_amt'        => $total_order_fb_amt,
            'total_order_fb_amt_dis'    => $total_order_fb_amt_dis,
        ]);

    }
}
