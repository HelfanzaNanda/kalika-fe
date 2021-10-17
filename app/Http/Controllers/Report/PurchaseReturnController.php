<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PurchaseReturnController extends Controller
{
    public function index()
	{
		$title = 'Laporan Retur Pembelian';
		return view('report.purchase_return', compact('title'));
	}
}
