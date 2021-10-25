<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LedgerController extends Controller
{
    public function debt()
	{
		$title = 'Laporan Buku Besar Hutang';
		return view('report.ledger_debt', compact('title'));
	}

    public function receivable()
	{
		$title = 'Laporan Buku Besar Piutang';
		return view('report.ledger_receivable', compact('title'));
	}

	public function cashBank()
	{
		$title = 'Laporan Buku Besar Kas Bank';
		return view('report.ledger_cash_bank', compact('title'));	
	}
}
