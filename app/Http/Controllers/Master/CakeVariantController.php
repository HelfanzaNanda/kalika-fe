<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CakeVariantController extends Controller
{
    public function index()
    {
    	$title = 'Varian Cake';
        return view('master.cake_variant', compact('title'));
    }
}
