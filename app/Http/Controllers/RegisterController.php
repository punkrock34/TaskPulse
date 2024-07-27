<?php

namespace App\Http\Controllers;

class RegisterController extends Controller
{
    public function show()
    {
        return view('auth.register')->with('title', 'Register');
    }
}
