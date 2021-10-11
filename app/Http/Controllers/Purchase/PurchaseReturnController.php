<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PurchaseReturnController extends Controller
{
    public function index()
	{
		return view('purchase.purchase_return.index', [
			'title' => 'Return Pembelian'
		]);
	}

	public function create()
	{
		return view('purchase.purchase_return.create', [
			'title' => ' Tambah Return Pembelian'
		]);
	}
	
	public function edit($id)
	{
		return view('purchase.purchase_return.edit', [
			'title' => ' Edit Return Pembelian',
			'id' => $id
		]);
	}
}
