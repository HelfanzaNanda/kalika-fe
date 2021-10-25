<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SalesConsignmentController extends Controller
{
    public function index()
	{
		$title = 'Laporan Penjualan Konsinyasi';
		return view('report.sales_consignment', compact('title'));
	}
}
