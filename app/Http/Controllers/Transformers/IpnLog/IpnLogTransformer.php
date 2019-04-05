<?php namespace App\Http\Controllers\Transformers\IpnLog;

use App\Http\Controllers\Transformers\Transformer;

class IpnLogTransformer extends Transformer
{
	
	public function transform($item)
	{

		return [

			'id' => $item['id'],

			'receipt' => $item['receipt'],

			'email' => $item['email'],

			'trans_type' => $item['trans_type'],

			'total_amount' => number_format($item['total_amount'], 2),

			'product_id' => $item['product_id'],

			'product_name' => $item['product_name'],

			'affiliate' => $item['affiliate'],

			'processed_to_ga' => $item['processed_to_ga'] == 0 ? 'Pending' : 'Completed',

			'processed_to_fb' => $item['processed_to_fb'] == 0 ? 'Pending' : ($item['processed_to_fb'] == 1 ? 'Completed' : 'Skipped'),

			'created_at' => date('M d, Y h:i A', strtotime($item['created_at'])),

		];

	}
}