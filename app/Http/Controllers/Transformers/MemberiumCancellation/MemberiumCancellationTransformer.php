<?php namespace App\Http\Controllers\Transformers\MemberiumCancellation;

use App\Http\Controllers\Transformers\Transformer;

class MemberiumCancellationTransformer extends Transformer
{
	
	public function transform($item)
	{

		return [

			'id' 			=> $item['id'],

			'cb_sku' 		=> $item['cb_sku'],

			'cb_receipt' 	=> $item['cb_receipt'],

			'cb_result' 	=> wordwrap(json_encode($item['cb_result']),25,"\n", 'true'),

			'email' 		=> $item['email'],

			'tries' 		=> $item['tries'],

			'status' 		=> $item['status'] == 1 ? 'Processed' : 'Open',

		];

	}
}