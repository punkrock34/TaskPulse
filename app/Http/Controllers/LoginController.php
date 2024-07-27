<?php

namespace App\Http\Controllers;

class LoginController extends Controller
{
    public function show()
    {
        return view('auth.login')->with('title', 'Login');
    }
}
