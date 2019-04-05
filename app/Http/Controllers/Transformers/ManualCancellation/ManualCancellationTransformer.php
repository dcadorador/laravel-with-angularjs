<?php namespace App\Http\Controllers\Transformers\ManualCancellation;

use App\Http\Controllers\Transformers\Transformer;

class ManualCancellationTransformer extends Transformer
{
	
	public function transform($item)
	{

		return [

			'id' 				=> $item['id'],

			'subscription_id' 	=> $item['subscription_id'],

			'email' 			=> $item['email'],

			'receipt' 			=> $item['receipt'],

			'cancellation_date' => date('M d, Y h:i A', strtotime($item['cancellation_date'])),

			'processed' 		=> $item['processed'] == 0 ? 'No' : 'Yes',

		];

	}
}

