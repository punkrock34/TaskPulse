<?php

namespace App\Services;

use App\Exceptions\FailedToSendVerificationEmailException;
use App\Mail\Auth\VerifyEmailMail;
use App\Services\Firebase\FirebaseTokenService;
use App\Services\Firebase\FirebaseUserService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Kreait\Firebase\Auth\UserRecord;
use Lcobucci\JWT\UnencryptedToken;

class VerifyEmailService
{
    public function __construct(
        protected FirebaseTokenService $firebaseTokenService,
        protected FirebaseUserService $firebaseUserService
    ) {}

    /**
     * Send verification email.
     *
     * @return array<string>
     */
    public function sendVerificationEmail(string $email)
    {
        $user = $this->firebaseUserService->getUserByEmail($email);
        if ($user->emailVerified) {
            Log::warning("User tried to send verification email with an already verified email: {$email}");

            return ['message' => 'Email is already verified.'];
        }

        $customToken = $this->firebaseTokenService->getCustomToken($user->uid);
        if (! $this->sendMail($user, $customToken)) {
            Log::error("Failed to send verification email to: {$email}");
            throw new FailedToSendVerificationEmailException;
        }

        return ['message' => 'Verification email sent successfully.'];
    }

    /**
     * Verify the email using the token.
     *
     * @return array<string>
     */
    public function verifyEmailToken(string $token)
    {
        $idToken = $this->firebaseTokenService->getIdToken($token);
        $uid = $this->firebaseTokenService->getUidFromIdToken($idToken);

        $user = $this->firebaseUserService->getUserByUID($uid);
        if ($user->emailVerified) {
            Log::warning("User tried to verify email which is already verified: {$user->email}");

            return ['status' => 'already_verified', 'message' => 'Email is already verified.'];
        }

        $this->firebaseUserService->updateUserEmailVerificationStatus($uid, true);

        return ['status' => 'success', 'message' => 'Email verified successfully.'];
    }

    /**
     * Send verification email to the user.
     *
     * @return bool
     */
    public function sendMail(UserRecord $user, UnencryptedToken $customToken)
    {
        try {
            Mail::to($user->email)->send(new VerifyEmailMail($customToken->toString(), $user->displayName));

            return true;
        } catch (\Exception $e) {
            Log::error("Failed to send verification email to: {$user->email}. Error: ".$e->getMessage());

            return false;
        }
    }
}
