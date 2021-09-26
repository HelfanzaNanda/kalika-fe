<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index()
    {
    	$title = 'Unit';
        return view('master.unit', compact('title'));
    }
}
