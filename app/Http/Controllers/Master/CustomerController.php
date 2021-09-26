<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
    	$title = 'Kustomer';
        return view('master.customer', compact('title'));
    }
}
