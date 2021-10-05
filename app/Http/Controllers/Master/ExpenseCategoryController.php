<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExpenseCategoryController extends Controller
{
    public function index()
    {
    	$title = 'Kategori Biaya';
        return view('master.expense_category', compact('title'));
    }
}
