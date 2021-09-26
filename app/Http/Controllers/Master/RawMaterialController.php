<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RawMaterialController extends Controller
{
    public function index()
    {
    	$title = 'Bahan Baku';
        return view('master.raw_material', compact('title'));
    }
}
