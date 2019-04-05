<?php namespace App\Http\Controllers\Transformers\SyncLog;

use App\Http\Controllers\Transformers\Transformer;

class SyncLogTransformer extends Transformer
{
	
	public function transform($item)
	{

		return [

			'id' 							=> $item['id'],

			'trans_status' 					=> $item['trans_status'],

			'email' 						=> $item['email'],

			'contact_id' 					=> $item['contact_id'],

			'receipt' 						=> $item['receipt'],

			'infs_contact_processing' 		=> $item['infs_contact_processing'],

			'infs_contact_opt_in' 			=> $item['infs_contact_opt_in'],

			'infs_gdpr_tag' 				=> $item['infs_gdpr_tag'],

			'infs_subscription_processing' 	=> $item['infs_subscription_processing'],

			'infs_subscription_result' 		=> $item['infs_subscription_result'],

			'infs_invoice_result' 			=> $item['infs_invoice_result'],

			'infs_next_billing_result' 		=> $item['infs_next_billing_result'],

            'sub_tag' 		                => $item['sub_tag'],

            'event_tag' 			        => $item['event_tag'],

            'event_inactive_tag' 		    => $item['event_inactive_tag'],

		];

	}
}