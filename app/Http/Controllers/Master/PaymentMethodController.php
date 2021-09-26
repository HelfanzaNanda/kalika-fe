<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function index()
    {
    	$title = 'Metode Pembayaran';
        return view('master.payment_method', compact('title'));
    }
}
