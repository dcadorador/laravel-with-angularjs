<?php namespace App\Http\Controllers\Transformers\User;

use App\Http\Controllers\Transformers\Transformer;

class UserTransformer extends Transformer
{
	
	public function transform($item)
	{

		return [

			'id' => $item['id'],

			'name' => $item['name'],

			'email' => $item['email'],

		];

	}
}