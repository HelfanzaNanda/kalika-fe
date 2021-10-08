<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StockOpnameController extends Controller
{
    public function index()
	{
		return view('inventory.stock_opname.'.__FUNCTION__, [
			'title' => 'Stok Opname'
		]);
	}

	public function create()
	{
		return view('inventory.stock_opname.'.__FUNCTION__, [
			'title' => ' Tambah Stok Opname'
		]);
	}
	
	public function edit($id)
	{
		return view('inventory.stock_opname.'.__FUNCTION__, [
			'title' => ' Edit Stok Opname',
			'id' => $id
		]);
	}
}
