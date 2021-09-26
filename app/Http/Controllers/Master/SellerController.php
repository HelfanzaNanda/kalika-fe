<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function index()
    {
    	$title = 'penjual';
        return view('master.seller', compact('title'));
    }
}
