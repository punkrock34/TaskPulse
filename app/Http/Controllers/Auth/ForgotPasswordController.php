<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Services\ForgotPasswordService;
use Inertia\Inertia;

class ForgotPasswordController extends Controller
{
    public function __construct(
        protected ForgotPasswordService $forgotPasswordService
    ) {}

    public function index()
    {
        return Inertia::render('ForgotPassword');
    }

    public function store(ForgotPasswordRequest $request)
    {
        $email = $request->input('email');

        try {
            $this->forgotPasswordService->forgot($email);

            return Inertia::render('ForgotPassword', ['success' => 'Password reset link sent to your email']);
        } catch (\Exception $e) {
            return Inertia::render('ForgotPassword', ['errors' => [$e->getCode() => $e->getMessage()]]);
        }
    }
}
