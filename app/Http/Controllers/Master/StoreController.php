<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StoreController extends Controller
{
	public function index()
    {
    	$title = 'Toko';
        return view('master.store', compact('title'));
    }
}
