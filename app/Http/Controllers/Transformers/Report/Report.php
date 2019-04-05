<?php namespace App\Http\Controllers\Transformers\Report;

use App\Http\Controllers\Transformers\Transformer;

class Report extends Transformer
{
	
	public function transform($item)
	{

		return [

			'id' => $item['id'],

			'created_at' => date('M d, Y h:i A', strtotime($item['created_at'])),

		];

	}
}