<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
	{
		$title = 'Laporan Penjualan';
		return view('report.sale', compact('title'));
	}
}
