<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DebtController extends Controller
{
    public function index()
	{
		$title = 'Laporan Hutang';
		return view('report.debt', compact('title'));
	}
}
