<?php

namespace App\Http\Controllers\Common\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MemberiumCancellation extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.memberium_cancellations.index');
    }
}
