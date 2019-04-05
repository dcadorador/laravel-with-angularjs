<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\SystemSetting as Model;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Transformers\SystemSetting\SystemSettingTransformer;

class SystemSetting extends ApiController
{
    protected $transformer;

    function __construct(SystemSettingTransformer $transformer)
    {
        $this->transformer = $transformer;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = Model::get();

        return $this->respondSuccessfulWithData('Request Granted.', ['data' => $this->transformer->transformCollection($data->all())]);

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $requests = $request->all();

        if(count($requests) > 0) {
            foreach ($requests as $req){
                $setting = Model::where('id', $req['id'])->first();
                if($setting) {
                    $setting->meta_value = $req['meta_value'] === null ? '' : $req['meta_value'];
                    $setting->save();
                }
            }
        }

        return $this->respondSuccessfulWithData('Request Granted.', []);
    }
}
