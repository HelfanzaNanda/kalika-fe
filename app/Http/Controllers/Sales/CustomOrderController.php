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

	public function print($type, $id)
	{
		$view = '';
		if ($type == 'nota-pengambilan') {
			$view = 'sales.custom_order.print.nota-pengambilan';	
		} else if ($type == 'faktur') {
			$view = 'sales.custom_order.print.faktur';
		} else if ($type == 'tanda-terima') {
			$view = 'sales.custom_order.print.tanda-terima';
		} else if ($type == 'pesanan-produksi') {
			$view = 'sales.custom_order.print.pesanan-produksi';
		} else if ($type == 'topper') {
			$view = 'sales.custom_order.print.topper';
		} else if ($type == 'tanda-terima-kasir') {
			$view = 'sales.custom_order.print.tanda-terima-kasir';
		}

		return view($view, [
			'title' => ' Cetak Penjualan Pesanan',
			'id' => $id
		]);
	}
}
