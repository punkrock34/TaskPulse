<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordResetRequest;

class ResetPasswordRequestController extends Controller
{
    public function show()
    {
        return view('auth.reset-password.request')->with('title', 'Reset Password');
    }

    public function request(PasswordResetRequest $request)
    {
        return redirect()->back()->with('status', 'Password reset link sent to your email');
    }
}
