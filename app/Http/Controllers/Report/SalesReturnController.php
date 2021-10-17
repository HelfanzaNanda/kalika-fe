<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SalesReturnController extends Controller
{
    public function index()
	{
		$title = 'Laporan Retur Penjualan';
		return view('report.sales_return', compact('title'));
	}
}
