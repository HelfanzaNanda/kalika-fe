<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index()
	{
		$title = 'Laporan Pembelian';
		return view('report.purchase', compact('title'));
	}
}
