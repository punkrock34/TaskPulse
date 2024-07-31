<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\AbstractInertiaController;
use App\Http\Requests\ForgotPasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Kreait\Firebase\Auth as FirebaseAuth;
use Kreait\Firebase\Auth\SendActionLink\FailedToSendActionLink;

class ForgotPasswordController extends AbstractInertiaController
{
    public function __construct(protected FirebaseAuth $auth) {}

    public function index(Request $request)
    {
        return Inertia::render('ForgotPassword');
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $request->validated();

        $email = $request->input('email');

        try {
            $this->auth->sendPasswordResetLink($email);

            return response()->json(['status' => 'Password reset link sent to your email']);
        } catch (FailedToSendActionLink $e) {
            Log::error("Error sending password reset link: {$e->getMessage()}");

            return response()->json(['error' => 'Error sending password reset link'], 500);
        } catch (\Exception $e) {
            Log::error("Error sending password reset link: {$e->getMessage()}");

            return response()->json(['error' => 'Error sending password reset link'], 500);
        }
    }
}
