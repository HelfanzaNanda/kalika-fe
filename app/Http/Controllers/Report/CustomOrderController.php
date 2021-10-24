<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomOrderController extends Controller
{
    public function index()
	{
		$title = 'Laporan Penjualan Pesanan';
		return view('report.custom_order', compact('title'));
	}
}
