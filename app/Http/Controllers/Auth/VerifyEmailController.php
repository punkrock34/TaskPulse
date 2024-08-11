<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SendVerifyEmailRequest;
use App\Http\Requests\Auth\VerifyEmailRequest;
use App\Services\VerifyEmailService;
use Inertia\Inertia;

class VerifyEmailController extends Controller
{
    public function __construct(
        protected VerifyEmailService $verifyEmailService
    ) {}

    public function index(VerifyEmailRequest $request)
    {
        try {
            $token = $request->input('token');
            $result = $this->verifyEmailService->verifyEmailToken($token);

            return Inertia::render('VerifyEmail', $result);
        } catch (\Exception $e) {
            return Inertia::render('VerifyEmail', ['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function store(SendVerifyEmailRequest $request)
    {
        try {
            $email = $request->input('email');
            $result = $this->verifyEmailService->sendVerificationEmail($email);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            $statusCode = $e->getCode() ?: 500;

            return response()->json(['error' => $e->getMessage()], $statusCode);
        }
    }
}
