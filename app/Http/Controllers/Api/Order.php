<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\OrderFlow as Model;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Transformers\Order\OrderTransformer;

class Order extends ApiController
{

	protected $transformer, $search, $page, $rows, $offset;

	function __construct(OrderTransformer $transformer)
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
                        $query->orWhere('flow', 'LIKE', '%'.$this->search.'%');
                    }
                })
                ->count();

    	$data = Model::where(function($query){ 
                    if ($this->search !== '') {
                        $query->orWhere('flow', 'LIKE', '%'.$this->search.'%');
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

        $order = new Model;

        if (!isset($request['flow'])) {
            return $this->respondUnprocessable('Flow is required.');
        }

        if (!isset($request['item_to_process'])) {
            return $this->respondUnprocessable('Item to process is required.');
        }

        if (!isset($request['process_type'])) {
            return $this->respondUnprocessable('Process type is required.');
        }

        $order->flow            = $request['flow'];
        $order->item_to_process = $request['item_to_process'];
        $order->process_type    = $request['process_type'];
        $order->save();

        return $this->respondSuccessfulWithData('Order Flow has been added.', []);
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

        if (!isset($request['flow'])) {
            return $this->respondUnprocessable('Flow is required.');
        }

        if (!isset($request['item_to_process'])) {
            return $this->respondUnprocessable('Item to process is required.');
        }

        if (!isset($request['process_type'])) {
            return $this->respondUnprocessable('Process type is required.');
        }

        $order = Model::find($id);
        $order->flow            = $request['flow'];
        $order->item_to_process = $request['item_to_process'];
        $order->process_type    = $request['process_type'];
        $order->save();

        return $this->respondSuccessfulWithData('Order Flow has been updated.', []);
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
            return $this->respondUnprocessable('No Order Found.');
        }

        $data->delete();

        return $this->respondSuccessfulWithData('Request Granted.', []);        
    }

}