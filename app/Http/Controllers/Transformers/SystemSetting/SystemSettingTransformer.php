<?php namespace App\Http\Controllers\Transformers\SystemSetting;

use App\Http\Controllers\Transformers\Transformer;

class SystemSettingTransformer extends Transformer
{
	
	public function transform($item)
	{

		return [

			'id' 			=> $item['id'],

			'meta_key' 		=> $item['meta_key'],

			'meta_value' 	=> $item['meta_value'],

		];

	}
}