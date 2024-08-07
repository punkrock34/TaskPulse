<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Auth as FirebaseAuth;

class ValidateFirebaseResetCode
{
    protected $auth;

    public function __construct(FirebaseAuth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->route('token');

        if (! $token) {
            return redirect('/forgot-password')->withErrors('error', 'Invalid or expired reset code.');
        }

        try {
            $signInResult = $this->auth->signInWithCustomToken($token);
            $idToken = $signInResult->idToken();

            //get if has password reset claim
            $verifiedToken = $this->auth->verifyIdToken($idToken, false, 300);
            $claims = $verifiedToken->claims();

            if (! $claims->has('password_reset')) {
                return redirect('/forgot-password')->withErrors('error', 'Invalid or expired reset code.');
            }

        } catch (\Exception $e) {
            Log::error("Error verifying Firebase reset code: {$e->getMessage()}");

            return redirect('/forgot-password')->with('error', 'Invalid or expired reset code.');
        }

        return $next($request);
    }
}
