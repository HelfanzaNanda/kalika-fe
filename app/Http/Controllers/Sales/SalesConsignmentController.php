<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SalesConsignmentController extends Controller
{
    public function index()
	{
		return view('sales.consignment.'.__FUNCTION__, [
			'title' => 'Penjualan Konsinyasi'
		]);
	}

	public function create()
	{
		return view('sales.consignment.'.__FUNCTION__, [
			'title' => ' Tambah Penjualan Konsinyasi'
		]);
	}
	
	public function edit($id)
	{
		return view('sales.consignment.'.__FUNCTION__, [
			'title' => ' Edit Penjualan Konsinyasi',
			'id' => $id
		]);
	}

	public function return($id)
	{
		return view('sales.consignment.'.__FUNCTION__, [
			'title' => ' Retur Penjualan',
			'id' => $id
		]);
	}

	public function print($id)
	{
		return view('sales.consignment.'.__FUNCTION__, [
			'title' => ' Cetak Penjualan Konsinyasi',
			'id' => $id
		]);
	}
}
