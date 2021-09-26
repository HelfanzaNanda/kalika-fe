<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CakeTypeController extends Controller
{
    public function index()
    {
    	$title = 'Tipe Cake';
        return view('master.cake_type', compact('title'));
    }
}
