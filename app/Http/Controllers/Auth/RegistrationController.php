<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;

class RegistrationController extends Controller
{
    public function index()
    {
        return view('auth.registration');
    }

    public function post(Request $request)
    {
        $params = $request->all();
        return Users::createOrUpdate($params, $request->method(), $request);
    }
}
