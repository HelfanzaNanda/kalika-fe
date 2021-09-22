<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;

class DivisionController extends Controller
{
    public function index()
    {
    	$title = 'Divisi';

        return view('master.division', compact('title'));
    }
}
