<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestPasswordReset;

class ResetPasswordRequestController extends Controller
{
    public function show()
    {
        return view('auth.reset-password.request')->with('title', 'Reset Password');
    }

    public function request(RequestPasswordReset $request)
    {
        $request->validated();

        return redirect()->back()->with('status', 'Password reset link sent to your email');
    }
}
