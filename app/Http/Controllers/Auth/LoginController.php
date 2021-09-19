<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;

class LoginController extends Controller
{
    public function __construct()
    {
        if (Session::get('_login')) {
            return redirect('/');
        }
    }

    public function index()
    {
        return view('auth.login');
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();
        
        return redirect('/');
    }

    public function forgotPassword(Request $request)
    {
        // $params = $request->all();
        // return Users::resetPassword($params);
    }
}
