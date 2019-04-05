<?php namespace App\Http\Controllers\Transformers\Domain;

use App\Http\Controllers\Transformers\Transformer;

class DomainTransformer extends Transformer
{
	
	public function transform($item)
	{

		return [

			'id' 						=> $item['id'],

			'nickname' 					=> $item['nickname'],

			'url' 						=> $item['url'],

			'memberium_auth_key' 		=> $item['memberium_auth_key'],

			'password_generated_tag' 	=> $item['password_generated_tag'],


		];

	}
}




