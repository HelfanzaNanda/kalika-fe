<?php

namespace App\Http\Controllers\DebtReceivable;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReceivableController extends Controller
{
    public function index()
    { 
		$title = 'Piutang';
        return view('debt_receivable.receivable', compact('title'));
    }
}
