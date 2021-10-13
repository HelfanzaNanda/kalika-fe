<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
	{
		$title = 'Laporan Pembayaran';
		return view('report.payment', compact('title'));
	}
}
