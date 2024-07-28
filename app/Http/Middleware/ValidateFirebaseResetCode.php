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
        $code = $request->route('code');

        try {
            $this->auth->verifyPasswordResetCode($code);
        } catch (\Exception $e) {
            Log::error("Error verifying Firebase reset code: {$e->getMessage()}");

            return redirect('/forgot-password')->with('error', 'Invalid or expired reset code.');
        }

        return $next($request);
    }
}
