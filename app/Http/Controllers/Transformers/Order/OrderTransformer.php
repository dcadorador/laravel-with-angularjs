<?php namespace App\Http\Controllers\Transformers\Order;

use App\Http\Controllers\Transformers\Transformer;

class OrderTransformer extends Transformer
{
	
	public function transform($item)
	{

		return [

			'id' 						=> $item['id'],

			'flow' 						=> $item['flow'],

			'process_type' 				=> $item['process_type'],

			'item_to_process' 			=> $item['item_to_process'],

		];

	}
}