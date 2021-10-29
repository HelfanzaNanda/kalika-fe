<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StoreMutationController extends Controller
{
    public function index()
	{
		return view('inventory.store_mutation.'.__FUNCTION__, [
			'title' => 'Mutasi Toko'
		]);
	}

	public function create()
	{
		return view('inventory.store_mutation.'.__FUNCTION__, [
			'title' => ' Tambah Mutasi Toko'
		]);
	}
	
	public function edit($id)
	{
		return view('inventory.store_mutation.'.__FUNCTION__, [
			'title' => ' Edit Mutasi Toko',
			'id' => $id
		]);
	}
}
