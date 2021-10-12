<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SalesReturnController extends Controller
{
    public function index()
	{
		return view('sales.sales_return.index', [
			'title' => 'Return Penjualan'
		]);
	}

	public function create()
	{
		return view('sales.sales_return.create', [
			'title' => ' Tambah Return Penjualan'
		]);
	}
	
	public function edit($id)
	{
		return view('sales.sales_return.edit', [
			'title' => ' Edit Return Penjualan',
			'id' => $id
		]);
	}
}
