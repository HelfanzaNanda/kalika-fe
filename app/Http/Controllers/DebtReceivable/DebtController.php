<?php

namespace App\Http\Controllers\DebtReceivable;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DebtController extends Controller
{
    public function index()
    { 
		$title = 'Hutang';
        return view('debt_receivable.debt', compact('title'));
    }
}
