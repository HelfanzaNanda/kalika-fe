<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
    	$title = 'Produk';
        return view('master.product', compact('title'));
    }
}
