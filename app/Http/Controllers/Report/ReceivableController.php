<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReceivableController extends Controller
{
    public function index()
	{
		$title = 'Laporan Piutang';
		return view('report.receivable', compact('title'));
	}
}
