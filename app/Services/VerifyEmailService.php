<?php

namespace App\Services;

use App\Exceptions\FailedToSendVerificationEmailException;
use App\Exceptions\FailedToSignInWithTokenException;
use App\Exceptions\GeneralFirebaseException;
use App\Exceptions\TokenVerificationException;
use App\Exceptions\TooManyAttemptsException;
use App\Exceptions\UnexpectedErrorException;
use App\Exceptions\UserNotFoundException;
use App\Mail\Auth\VerifyEmailMail;
use Illuminate\Mail\SentMessage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Kreait\Firebase\Auth as FirebaseAuth;
use Kreait\Firebase\Auth\SignIn\FailedToSignIn;
use Kreait\Firebase\Auth\UserRecord;
use Kreait\Firebase\Exception\Auth\FailedToVerifyToken;
use Kreait\Firebase\Exception\Auth\RevokedIdToken;
use Kreait\Firebase\Exception\Auth\UserNotFound;
use Kreait\Firebase\Exception\AuthException;
use Kreait\Firebase\Exception\FirebaseException;
use Lcobucci\JWT\UnencryptedToken;

class VerifyEmailService
{
    public function __construct(protected FirebaseAuth $auth) {}

    /**
     * Send verification email.
     *
     * @throws GeneralFirebaseException
     */
    public function sendVerificationEmail(string $email)
    {
        try {
            $user = $this->getUserByEmail($email);
            if ($user->emailVerified) {
                Log::info('Verification email not sent. Email already verified.');

                return ['message' => 'Email is already verified.'];
            }

            $customToken = $this->getCustomToken($user->uid);
            if (! $this->sendMail($user, $customToken)) {
                Log::error('Failed to send verification email.');
                throw new FailedToSendVerificationEmailException;
            }

            Log::info('Verification email sent successfully.');

            return ['message' => 'Verification email sent successfully.'];
        } catch (\Exception $e) {
            Log::error("Unexpected error while sending verification email: {$e->getMessage()}");
            throw new GeneralFirebaseException;
        }
    }

    /**
     * Verify the email using the token.
     *
     * @return array<string, string>
     *
     * @throws TooManyAttemptsException
     * @throws FailedToSignInWithTokenException
     * @throws TokenVerificationException
     * @throws UserNotFoundException
     * @throws UnexpectedErrorException
     */
    public function verifyEmailToken(string $token)
    {
        try {
            $idToken = $this->getIdToken($token);
            $verifiedToken = $this->verifyIdToken($idToken);
            $uid = $verifiedToken->claims()->get('sub');

            $user = $this->getUserByUID($uid);
            if ($user->emailVerified) {
                return ['status' => 'already_verified', 'message' => 'Email is already verified.'];
            }

            $this->auth->updateUser($uid, ['emailVerified' => true]);

            return ['status' => 'success', 'message' => 'Email verified successfully.'];
        } catch (TooManyAttemptsException|FailedToSignInWithTokenException|TokenVerificationException|UserNotFoundException $e) {
            Log::error("Error while verifying email: {$e->getMessage()}");
            throw $e;
        } catch (\Exception $e) {
            Log::error("Unexpected error while verifying email: {$e->getMessage()}");
            throw new UnexpectedErrorException;
        }
    }

    /**
     * Get the custom token generated from the user's uid.
     *
     * @return UnencryptedToken
     *
     * @throws TooManyAttemptsException
     * @throws GeneralFirebaseException
     */
    private function getCustomToken(string $uid)
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
    private function getIdToken(string $token)
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
     * Get the user from the Firebase using the email.
     *
     * @return UserRecord
     *
     * @throws UserNotFoundException
     * @throws TooManyAttemptsException
     * @throws GeneralFirebaseException
     */
    private function getUserByEmail(string $email)
    {
        try {
            return $this->auth->getUserByEmail($email);
        } catch (UserNotFound $e) {
            Log::error("User not found: {$e->getMessage()}");
            throw new UserNotFoundException;
        } catch (FirebaseException|AuthException $e) {
            Log::error("Firebase error while getting user: {$e->getMessage()}");
            if ($e->getMessage() == 'TOO_MANY_ATTEMPTS_TRY_LATER') {
                throw new TooManyAttemptsException;
            }
            throw new GeneralFirebaseException;
        }
    }

    /**
     * Get the user from the Firebase using the UID.
     *
     * @return UserRecord
     *
     * @throws UserNotFoundException
     * @throws TooManyAttemptsException
     * @throws GeneralFirebaseException
     */
    private function getUserByUID(string $uid)
    {
        try {
            return $this->auth->getUser($uid);
        } catch (UserNotFoundException $e) {
            Log::error("User not found: {$e->getMessage()}");
            throw new UserNotFoundException;
        } catch (FirebaseException|AuthException $e) {
            Log::error("Firebase error while getting user: {$e->getMessage()}");
            if ($e->getMessage() == 'TOO_MANY_ATTEMPTS_TRY_LATER') {
                throw new TooManyAttemptsException;
            }
            throw new GeneralFirebaseException;
        }
    }

    /**
     * Send verification email to the user.
     *
     * @return bool
     */
    private function sendMail(UserRecord $user, UnencryptedToken $customToken)
    {
        return Mail::to($user->email)->send(new VerifyEmailMail($customToken->toString(), $user->displayName)) instanceof SentMessage;
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
