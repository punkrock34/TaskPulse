<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Services\ResetPasswordService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ResetPasswordController extends Controller
{
    public function __construct(
        protected ResetPasswordService $resetPasswordService,
    ) {}

    public function index(Request $request)
    {
        if (! $request->has('token')) {
            return redirect()->route('forgot-password.index')->withErrors(['error' => 'Invalid or expired reset password link']);
        }

        return Inertia::render('ResetPassword');
    }

    public function store(ResetPasswordRequest $request)
    {
        try {
            $token = $request->input('token');
            $password = $request->input('password');

            $this->resetPasswordService->resetPassword($token, $password);

            return Inertia::render('ResetPassword', ['success' => 'Password reset successfully']);
        } catch (\Exception $e) {
            return Inertia::render('Login', ['errors' => [$e->getCode() => $e->getMessage()]]);
        }
    }
}
