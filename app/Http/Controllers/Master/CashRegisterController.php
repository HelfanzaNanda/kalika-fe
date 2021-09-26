<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CashRegisterController extends Controller
{
    public function index()
    {
    	$title = 'Uang Kasir';
        return view('master.cash_register', compact('title'));
    }
}
