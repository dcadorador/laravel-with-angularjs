<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\DomainSetting as Model;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Transformers\Domain\DomainTransformer;

class Domain extends ApiController
{

	protected $transformer, $search, $page, $rows, $offset;

	function __construct(DomainTransformer $transformer)
	{
		$this->transformer = $transformer;
	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

    	$this->search   = isset($request->search) ? $request->search : '';

        $this->page     = isset($request->page)   ? $request->page   : 1;

        $this->rows     = isset($request->rows) && $request->rows <= 50 ? $request->rows : 50;

        $this->offset   = ($this->page - 1) * $this->rows;

        $total = Model::where(function($query){ 
                    if ($this->search !== '') {
                        $query->orWhere('nickname', 'LIKE', '%'.$this->search.'%');
                        $query->orWhere('url', 'LIKE', '%'.$this->search.'%');
                    }
                })
                ->count();

    	$data = Model::where(function($query){ 
                    if ($this->search !== '') {
                        $query->orWhere('nickname', 'LIKE', '%'.$this->search.'%');
                        $query->orWhere('url', 'LIKE', '%'.$this->search.'%');
                    }
                })
                ->skip($this->offset)
                ->take($this->rows)
                ->orderBy('created_at','DESC')
            	->get();

        return $this->respondSuccessfulWithData('Request Granted.', ['data' => $this->transformer->transformCollection($data->all()), 'total' => $total]);
    }

    public function all()
    {
        $data = Model::orderBy('created_at','DESC')
                ->get();

        return $this->respondSuccessfulWithData('Request Granted.', ['data' => $this->transformer->transformCollection($data->all())]);
    }

    public function store(Request $requests)
    {
        $request = $requests->all();

        $domain = new Model;

        if (!isset($request['nickname'])) {
            return $this->respondUnprocessable('Domain Name is required.');
        }

        if (!isset($request['url'])) {
            return $this->respondUnprocessable('URL is required.');
        }

        if (!isset($request['memberium_auth_key'])) {
            return $this->respondUnprocessable('Memberium Auth Key is required.');
        }

        if (!isset($request['password_generated_tag'])) {
            return $this->respondUnprocessable('Password Generated Tag is required.');
        }

        $domain->nickname = $request['nickname'];
        $domain->url = $request['url'];
        $domain->memberium_auth_key = $request['memberium_auth_key'];
        $domain->password_generated_tag = $request['password_generated_tag'];
        $domain->save();

        return $this->respondSuccessfulWithData('Domain has been added.', []);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $requests, $id)
    {
        $request = $requests->all();

        if (!isset($request['nickname'])) {
            return $this->respondUnprocessable('Domain Name is required.');
        }

        if (!isset($request['url'])) {
            return $this->respondUnprocessable('URL is required.');
        }

        if (!isset($request['memberium_auth_key'])) {
            return $this->respondUnprocessable('Memberium Auth Key is required.');
        }

        if (!isset($request['password_generated_tag'])) {
            return $this->respondUnprocessable('Password Generated Tag is required.');
        }

        $domain = Model::find($id);
        $domain->nickname               = $request['nickname'];
        $domain->url                    = $request['url'];
        $domain->memberium_auth_key     = $request['memberium_auth_key'];
        $domain->password_generated_tag = $request['password_generated_tag'];
        $domain->save();

        return $this->respondSuccessfulWithData('Domain has been updated.', []);
    }    


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Model::where('id', $id)->first();
        if (!$data) {
            return $this->respondUnprocessable('No Settings Found.');
        }

        $data->delete();

        return $this->respondSuccessfulWithData('Request Granted.', []);        
    }

}