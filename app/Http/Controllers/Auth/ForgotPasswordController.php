<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Services\ForgotPasswordService;
use Inertia\Inertia;
use Kreait\Firebase\Auth as FirebaseAuth;

class ForgotPasswordController extends Controller
{
    public function __construct(protected FirebaseAuth $auth, protected ForgotPasswordService $forgotPasswordService) {}

    public function index()
    {
        return Inertia::render('ForgotPassword');
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $email = $request->input('email');

        try {
            $this->forgotPasswordService->forgot($email);

            return Inertia::render('ForgotPassword', ['success' => 'Password reset link sent to your email']);
        } catch (\Exception $e) {
            return Inertia::render('ForgotPassword', ['error' => $e->getMessage()]);
        }
    }
}
