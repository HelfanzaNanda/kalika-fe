<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
	{
		$title = 'Laporan Biaya';
		return view('report.expense', compact('title'));
	}
}
