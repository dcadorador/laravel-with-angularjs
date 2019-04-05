<?php namespace App\Http\Controllers\Transformers\AutologinLog;

use App\Http\Controllers\Transformers\Transformer;

class AutologinLogTransformer extends Transformer
{
	
	public function transform($item)
	{

		return [

			'id' 			=> $item['id'],

			'contact_id' 	=> $item['contact_id'],

			'email' 		=> $item['email'],

			'receipt' 		=> $item['receipt'],

			'redirect_url' 	=> wordwrap($item['redirect_url'], 50, "\n", 'true'),

			'date_time'		=> date('M d, Y h:i A', strtotime($item['date_time'])),

			'result' 		=> wordwrap($item['result'], 20, "\n", 'true'),

		];

	}

    /**
     * UTF-8 Conversion Encoding
     *  - function that might help decode data for the api
     *
     * @param $string
     * @return mixed|string
     */
    private function encodeToUtf8($string)
    {
        return mb_convert_encoding($string, "UTF-8", mb_detect_encoding($string, "UTF-8, ISO-8859-1, ISO-8859-15", true));
    }

}