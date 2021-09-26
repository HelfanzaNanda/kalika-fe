<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
    	$title = 'Kategori';
        return view('master.category', compact('title'));
    }
}
