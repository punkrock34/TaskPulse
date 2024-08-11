<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\GoogleLoginRequest;
use App\Services\LoginService;

class GoogleLoginController extends Controller
{
    public function __construct(
        protected LoginService $loginService
    ) {}

    public function store(GoogleLoginRequest $request)
    {
        try {
            $idToken = $request->input('idToken');
            $this->loginService->loginWithGoogle($idToken);

            return response()->json(['success' => 'Logged in with Google successfully!'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to login with Google. Please try again.'], 500);
        }
    }
}
