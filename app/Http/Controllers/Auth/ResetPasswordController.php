<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Kreait\Firebase\Auth as FirebaseAuth;

class ResetPasswordController extends Controller
{
    public function __construct(protected FirebaseAuth $auth) {}

    public function index(Request $request)
    {
        return Inertia::render('ResetPassword')->withToken($request->token);
    }

    public function resetPassword(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $code = $request->input('code');

        try {
            $this->auth->verifyPasswordResetCode($code);
            $this->auth->changeUserPassword($email, $password);

            return response()->json(['message' => 'Password reset successfully']);
        } catch (\Exception $e) {
            return Inertia::render('Login', ['error' => $e->getMessage()]);
        }
    }
}
