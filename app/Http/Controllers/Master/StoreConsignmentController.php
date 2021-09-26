<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StoreConsignmentController extends Controller
{
    public function index()
    {
    	$title = 'Konsiyasi';
        return view('master.store_consignment', compact('title'));
    }
}
