<?php

namespace App\Http\Controllers;

class ResetPasswordController extends Controller
{
    public function show()
    {
        return view('auth.passwords.email')->with('title', 'Reset Password');
    }
}
