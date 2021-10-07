<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
    	$title = 'Produk';
        return view('master.product.index', compact('title'));
    }

	public function create()
	{
		return view('master.product.create', [
			'title' => ' Tambah Product'
		]);
	}
	
	public function edit($id)
	{
		return view('master.product.edit', [
			'title' => ' Edit Product',
			'id' => $id
		]);
	}
}
