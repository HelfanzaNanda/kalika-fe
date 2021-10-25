<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GeneralSettingController extends Controller
{
    public function index()
    {
    	$title = 'Pengaturan Umum';
        return view('setting.general_setting', compact('title'));
    }
}
