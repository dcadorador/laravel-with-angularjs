<?php namespace App\Http\Controllers\Transformers\UpsellLog;

use App\Http\Controllers\Transformers\Transformer;

class UpsellLogTransformer extends Transformer
{

    public function transform($item)
    {

        return [

            'time' 			            => date('M d,Y h:i:s', strtotime($item['time'])),

            'initial_receipt' 		    => $item['initial_receipt'],

            'receipt_with_ticket' 	    => $item['receipt_with_ticket'],

            'cancel_ticket_placed' 		=> $item['cancel_ticket_placed'],

            'refund_ticket_placed' 	    => $item['refund_ticket_placed'],

        ];

    }
}