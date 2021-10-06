<?php

namespace App\Http\Controllers\Production;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductionController extends Controller
{
    public function index()
	{
		return view('production.'.__FUNCTION__, [
			'title' => 'HPP/Resep'
		]);
	}

	public function create()
	{
		return view('production.'.__FUNCTION__, [
			'title' => ' Tambah HPP/Resep'
		]);
	}
	
	public function edit($id)
	{
		return view('production.'.__FUNCTION__, [
			'title' => ' Edit HPP/Resep',
			'id' => $id
		]);
	}
}
