<?php

namespace App\Http\Controllers;

class ResetPasswordController extends Controller
{
    public function show()
    {
        return view('auth.reset-password.reset')->with('title', 'Reset Password');
    }
}
