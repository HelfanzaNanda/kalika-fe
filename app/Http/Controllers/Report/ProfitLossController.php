<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfitLossController extends Controller
{
    public function index()
	{
		$title = 'Laporan Laba Rugi';
		return view('report.profit_loss', compact('title'));
	}
}
