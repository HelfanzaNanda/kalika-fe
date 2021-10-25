<?php

namespace App\Http\Controllers\Sales;

use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\EscposImage;
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

	public function print($sales_id)
	{
		return view('sales.sale.print', [
			'title' => 'Cetak Nota',
			'id' => $sales_id
		]);
	}
}
