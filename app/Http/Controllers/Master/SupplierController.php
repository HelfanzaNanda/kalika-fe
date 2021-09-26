<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
    	$title = 'Supplier';
        return view('master.supplier', compact('title'));
    }
}
