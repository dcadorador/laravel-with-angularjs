<?php namespace App\Http\Controllers\Transformers\Product;

use App\Http\Controllers\Transformers\Transformer;

class ProductTransformer extends Transformer
{
	
	public function transform($item)
	{

		return [

			'id' 					=> $item['id'],

			'domain' 				=> $item['domain'],

			'product_name' 			=> $item['product_name'],

			'cb_sku' 				=> $item['cb_sku'],

			'infs_product_id' 		=> $item['infs_product_id'],

			'infs_subplan_id' 		=> $item['infs_subplan_id'],

			'memberium_tags' 		=> $item['memberium_tags'],

			'sub_active_tag' 		=> $item['sub_active_tag'],

			'sub_inactive_tag' 		=> $item['sub_inactive_tag'],

			'event_inactive_tag' 	=> $item['event_inactive_tag'],

			'event_sale_tag' 		=> $item['event_sale_tag'],

			'event_refund_tag' 		=> $item['event_refund_tag'],

			'event_chargeback_tag' 	=> $item['event_chargeback_tag'],

            'abandoned_order_tag' 	=> $item['abandoned_order_tag'],
		];

	}
}

