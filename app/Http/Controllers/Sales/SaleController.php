<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
	{
		return view('sales.sale.index', [
			'title' => 'Penjualan'
		]);
	}

	public function create()
	{
		return view('sales.sale.create', [
			'title' => ' Tambah Penjualan'
		]);
	}

	public function pos()
	{
		return view('sales.sale.pos', [
			'title' => ' Kasir'
		]);
	}
	
	public function edit($id)
	{
		return view('sales.sale.edit', [
			'title' => ' Edit Penjualan',
			'id' => $id
		]);
	}
}
