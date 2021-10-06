<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index()
    {
    	$title = 'Pembelian';
        return view('purchase.purchase.'.__FUNCTION__, compact('title'));
    }
}
