<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomOrderController extends Controller
{
    public function index()
	{
		return view('sales.custom_order.index', [
			'title' => 'Penjualan Pesanan'
		]);
	}

	public function create()
	{
		return view('sales.custom_order.create', [
			'title' => ' Tambah Penjualan Pesanan'
		]);
	}
	
	public function edit($id)
	{
		return view('sales.custom_order.edit', [
			'title' => ' Edit Penjualan Pesanan',
			'id' => $id
		]);
	}
}
