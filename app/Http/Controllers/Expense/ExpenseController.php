<?php

namespace App\Http\Controllers\Expense;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
	{
		return view('expense.index', [
			'title' => 'Biaya'
		]);
	}

	public function create()
	{
		return view('expense.create', [
			'title' => ' Tambah Biaya'
		]);
	}
	
	public function edit($id)
	{
		return view('expense.edit', [
			'title' => ' Edit Biaya',
			'id' => $id
		]);
	}
}
