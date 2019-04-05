<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\User as Model;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Transformers\User\UserTransformer;

class User extends ApiController
{
    protected $transformer, $search, $page, $rows, $offset;

    function __construct(UserTransformer $transformer)
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
                        $query->orWhere('name', 'LIKE', '%'.$this->search.'%');
                        $query->orWhere('email', 'LIKE', '%'.$this->search.'%');
                    }
                })
                ->count();

        $data = Model::where(function($query){ 
                    if ($this->search !== '') {
                        $query->orWhere('name', 'LIKE', '%'.$this->search.'%');
                        $query->orWhere('email', 'LIKE', '%'.$this->search.'%');
                    }
                })
                ->skip($this->offset)
                ->take($this->rows)
                ->orderBy('created_at','DESC')
                ->get();

        return $this->respondSuccessfulWithData('Request Granted.', ['data' => $this->transformer->transformCollection($data->all()), 'total' => $total]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $user = new Model;

        if (!isset($request->name)) {
            return $this->respondUnprocessable('Name is required.');
        }

        if (!isset($request->password)) {
            return $this->respondUnprocessable('Password is required.');
        }

        if (!isset($request->email)) {
            return $this->respondUnprocessable('Email is required/invalid.');
        }

        $user->name = $request->name;
        $user->password = \Hash::make($request->password);
        $user->email = $request->email;
        $user->save();

        return $this->respondSuccessfulWithData('User has been added.', []);
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

        if (!isset($request->name)) {
            return $this->respondUnprocessable('Name is required.');
        }
        
        if (!isset($request->email)) {
            return $this->respondUnprocessable('Email is required/invalid.');
        }

        $user = Model::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return $this->respondSuccessfulWithData('User has been updated.', []);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Model::where('id', $id)->delete();
        return $this->respondSuccessfulWithData('User has been deleted.', []);        
    }
}
