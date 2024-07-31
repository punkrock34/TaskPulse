<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\AbstractInertiaController;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ResetPasswordController extends AbstractInertiaController
{
    public function index(Request $request)
    {
        return Inertia::render('ResetPassword')->withToken($request->token)->withEmail($request->email);
    }

    public function resetPassword(Request $request)
    {
        //todo implement reset password
    }
}
