<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\IpnLog as Model;
use App\Models\IpnProduct;
use App\Models\ProductSetting;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Transformers\IpnLog\IpnLogTransformer;

class IpnLog extends ApiController
{

	protected $transformer, $search, $page, $rows, $offset;

	function __construct(IpnLogTransformer $transformer)
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
                        $query->orWhere('receipt', 'LIKE', '%'.$this->search.'%');
                        $query->orWhere('email', 'LIKE', '%'.$this->search.'%');
                    }
                })
                ->count();

        $data = Model::where(function($query){ 
                    if ($this->search !== '') {
                        $query->orWhere('receipt', 'LIKE', '%'.$this->search.'%');
                        $query->orWhere('email', 'LIKE', '%'.$this->search.'%');
                    }
                })
                ->skip($this->offset)
                ->take($this->rows)
                ->orderBy('created_at', 'DESC')
                ->get();

        $processedLogs = [];
        $ipnFormattedLogs = [];
        //$processedIpnRecords = IpnLog::where('processed_to_ga', 1)->orderBy('created_at', 'DESC')->take(100)->get();

        foreach($data as $ipnLog){

            $ipnProductRecord = IpnProduct::where('ipn_log_id', $ipnLog->id)->orderBy('created_at', 'DESC')->first();
            $product = ProductSetting::where('cb_sku',$ipnProductRecord->sku)->first();

            $ipnLog['product_name'] = $ipnProductRecord->name;
            $ipnLog['product_id']   = $product ? $product->infs_product_id : null;

        }

        return $this->respondSuccessfulWithData('Request Granted.', ['data' => $this->transformer->transformCollection($data->all()), 'total' => $total]);
    }

}