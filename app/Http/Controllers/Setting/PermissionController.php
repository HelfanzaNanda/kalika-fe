<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
    	$title = 'Hak Akses';
        return view('setting.permission', compact('title'));
    }
}
