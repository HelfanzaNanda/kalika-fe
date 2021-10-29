<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductionRequestController extends Controller
{
    public function index()
	{
		return view('inventory.production_request.'.__FUNCTION__, [
			'title' => 'Permintaan Produksi'
		]);
	}

	public function create()
	{
		return view('inventory.production_request.'.__FUNCTION__, [
			'title' => ' Tambah Permintaan Produksi'
		]);
	}
	
	public function edit($id)
	{
		return view('inventory.production_request.'.__FUNCTION__, [
			'title' => ' Edit Permintaan Produksi',
			'id' => $id
		]);
	}
}
