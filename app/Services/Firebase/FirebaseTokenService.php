<?php

namespace App\Services\Firebase;

use App\Exceptions\AuthServiceException;
use App\Exceptions\FailedToSignInWithTokenException;
use App\Exceptions\GeneralFirebaseException;
use App\Exceptions\TokenVerificationException;
use App\Exceptions\TooManyAttemptsException;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Auth as FirebaseAuth;
use Kreait\Firebase\Auth\SignIn\FailedToSignIn;
use Kreait\Firebase\Exception\Auth\FailedToVerifyToken;
use Kreait\Firebase\Exception\Auth\RevokedIdToken;
use Kreait\Firebase\Exception\AuthException;
use Kreait\Firebase\Exception\FirebaseException;
use Lcobucci\JWT\UnencryptedToken;

class FirebaseTokenService
{
    public function __construct(protected FirebaseAuth $auth) {}

    /**
     * Get the custom token generated from the user's uid.
     *
     * @return UnencryptedToken
     *
     * @throws TooManyAttemptsException
     * @throws GeneralFirebaseException
     */
    public function getCustomToken(string $uid)
    {
        try {
            return $this->auth->createCustomToken($uid);
        } catch (FirebaseException|AuthException $e) {
            Log::error("Firebase error while creating custom token: {$e->getMessage()}");
            if ($e->getMessage() == 'TOO_MANY_ATTEMPTS_TRY_LATER') {
                throw new TooManyAttemptsException;
            }
            throw new GeneralFirebaseException;
        }
    }

    /**
     * Get the ID token from the custom token.
     *
     * @return string|null
     *
     * @throws FailedToSignInWithTokenException
     */
    public function getIdToken(string $token)
    {
        try {
            $signInResult = $this->auth->signInWithCustomToken($token);

            return $signInResult->idToken();
        } catch (FailedToSignIn $e) {
            Log::error("Failed to sign in using custom token: {$e->getMessage()}");
            throw new FailedToSignInWithTokenException;
        }
    }

    /**
     * Get Claims from the ID token, and return the UID.
     *
     * @return string
     */
    public function getUidFromIdToken(string $idToken)
    {
        $claims = $this->verifyIdToken($idToken)->claims();

        return $claims->get('sub');
    }

    /**
     * Create custom password reset token.
     *
     * @return string
     */
    public function createCustomPasswordResetToken(string $uid)
    {
        try {
            $expireTime = now()->addMinutes(5)->getTimestamp();

            return $this->auth->createCustomToken($uid, ['password_reset' => true], $expireTime)->toString();
        } catch (AuthException $e) {
            throw new AuthServiceException;
        } catch (FirebaseException $e) {
            throw new GeneralFirebaseException;
        }
    }

    /**
     * Verify the ID token.
     *
     * @return UnencryptedToken
     *
     * @throws TokenVerificationException
     */
    private function verifyIdToken(string $idToken)
    {
        try {
            return $this->auth->verifyIdToken($idToken, false, 300);
        } catch (FailedToVerifyToken|RevokedIdToken $e) {
            Log::error("Error verifying ID token: {$e->getMessage()}");
            throw new TokenVerificationException;
        }
    }
}
