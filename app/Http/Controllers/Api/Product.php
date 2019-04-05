<?php

namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;
use App\Models\ProductSetting as Model;
use App\Models\DomainSetting;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Transformers\Product\ProductTransformer;

class Product extends ApiController
{
    protected $transformer, $search, $page, $rows, $offset;

    function __construct(ProductTransformer $transformer)
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
                        $query->orWhere('product_name', 'LIKE', '%'.$this->search.'%');
                    }
                })
                ->count();

        $data = Model::where(function($query){ 
                    if ($this->search !== '') {
                        $query->orWhere('product_name', 'LIKE', '%'.$this->search.'%');
                    }
                })
                ->skip($this->offset)
                ->take($this->rows)
                ->orderBy('id','DESC')
                ->get();

        return $this->respondSuccessfulWithData('Request Granted.', ['data' => $this->transformer->transformCollection($data->all()), 'total' => $total]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $requests)
    {

        $request = $requests;

        $product = new Model;

        if (!isset($request['name'])) {
            return $this->respondUnprocessable('Product Name is required.');
        }

        if (!isset($request['domain_id'])) {
            return $this->respondUnprocessable('Domain is required.');
        }

        $abandoned_order_tag = isset($request->abandoned_order_tag) ? $request->abandoned_order_tag : null;

        $product->product_name          = $request->name === null ? '' : $request->name;
        $product->domain_id             = $request->domain_id === null ? '' : $request->domain_id;
        $product->cb_sku                = $request->cbsku === null ? '' : $request->cbsku;
        $product->infs_product_id       = $request->infs_prod_id === null ? '' : $request->infs_prod_id;
        $product->infs_subplan_id       = $request->infs_sub_id === null ? '' : $request->infs_sub_id;
        $product->memberium_tags        = $request->memberium === null ? '' : $request->memberium;
        $product->sub_active_tag        = $request->sub_ac_tag === null ? '' : $request->sub_ac_tag;
        $product->sub_inactive_tag      = $request->sub_in_tag === null ? '' : $request->sub_in_tag;
        $product->event_inactive_tag    = $request->evnt_in_tag === null ? '' : $request->evnt_in_tag;
        $product->event_sale_tag        = $request->evnt_sale_tag === null ? '' : $request->evnt_sale_tag;
        $product->event_refund_tag      = $request->evnt_rfnd_tag === null ? '' : $request->evnt_rfnd_tag;
        $product->event_chargeback_tag  = $request->evnt_charge_tag === null ? '' : $request->evnt_charge_tag;
        $product->abandoned_order_tag   = $abandoned_order_tag;
        $product->save();

        return $this->respondSuccessfulWithData('Product has been added.', []);
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

        if (!isset($request['product_name'])) {
            return $this->respondUnprocessable('Product Name is required.');
        }

        if (!isset($request['domain'])) {
            return $this->respondUnprocessable('Domain is required.');
        }

        $abandoned_order_tag = !isset($request['abandoned_order_tag']) || empty($request['abandoned_order_tag']) ? null : $request['abandoned_order_tag'];

        $product = Model::find($id);
        $product->product_name  = $request['product_name'] === null ? '' : $request['product_name'];
        $product->domain_id = $request['domain']['id'] === null ? '' : $request['domain']['id'];
        $product->cb_sku = $request['cb_sku'] === null ? '' : $request['cb_sku'];
        $product->event_chargeback_tag = $request['event_chargeback_tag'] === null ? '' : $request['event_chargeback_tag'];
        $product->event_inactive_tag = $request['event_inactive_tag'] === null ? '' : $request['event_inactive_tag'];
        $product->event_refund_tag = $request['event_refund_tag'] === null ? '' : $request['event_refund_tag'];
        $product->event_sale_tag = $request['event_sale_tag'] === null ? '' : $request['event_sale_tag'];
        $product->infs_product_id = $request['infs_product_id'] === null ? '' : $request['infs_product_id'];
        $product->infs_subplan_id = $request['infs_subplan_id'] === null ? '' : $request['infs_subplan_id'];
        $product->memberium_tags = $request['memberium_tags'] === null ? '' : $request['memberium_tags'];
        $product->sub_active_tag = $request['sub_active_tag'] === null ? '' : $request['sub_active_tag'];
        $product->sub_inactive_tag = $request['sub_inactive_tag'] === null ? '' : $request['sub_inactive_tag'];
        $product->abandoned_order_tag = $abandoned_order_tag;
        $product->save();

        return $this->respondSuccessfulWithData('Product has been updated.', []);
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
