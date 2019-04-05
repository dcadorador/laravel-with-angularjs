<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\CancelManLog as Model;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Transformers\ManualCancellation\ManualCancellationTransformer;

class ManualCancellation extends ApiController
{

	protected $transformer, $search, $page, $rows, $offset;

	function __construct(ManualCancellationTransformer $transformer)
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
                ->orderBy('created_at','DESC')
            	->get();

        return $this->respondSuccessfulWithData('Request Granted.', ['data' => $this->transformer->transformCollection($data->all()), 'total' => $total]);
    }

}