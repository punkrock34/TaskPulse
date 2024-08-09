<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Auth as FirebaseAuth;
use Kreait\Firebase\Exception\Auth\FailedToVerifyToken;
use Kreait\Firebase\Exception\Auth\RevokedIdToken;

class VerifyTokenController
{
    public function __construct(protected FirebaseAuth $auth) {}

    public function verifyIdToken(Request $request)
    {
        $idToken = $request->input('idToken');

        try {
            $verifiedIdToken = $this->auth->verifyIdToken($idToken);
            $uid = $verifiedIdToken->claims()->get('sub');

            // Use the UID to fetch user information from your database or create a new user.
            // TODO: @Gogu20 - Sync user here most likely idk you do your graphql shit ❤️

            return response()->json(['uid' => $uid]);
        } catch (FailedToVerifyToken|RevokedIdToken $e) {
            Log::error("Error verifying Firebase id token: {$e->getMessage()}");

            return response()->json(['error' => 'Invalid ID token'], 401);
        }
    }
}
