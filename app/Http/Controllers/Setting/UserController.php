<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
    	$title = 'Pengguna';
        return view('setting.user', compact('title'));
    }
}
