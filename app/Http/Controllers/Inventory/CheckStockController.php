<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CheckStockController extends Controller
{
    public function index()
	{
		$title = 'Cek Stok';
		return view('inventory.check_stock.index', compact('title'));
	}
}
