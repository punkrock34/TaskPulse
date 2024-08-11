<?php

namespace App\Services;

use App\Exceptions\FailedToSendPasswordForgotEmailException;
use App\Mail\Auth\ResetPasswordMail;
use App\Services\Firebase\FirebaseTokenService;
use App\Services\Firebase\FirebaseUserService;
use Illuminate\Mail\SentMessage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Kreait\Firebase\Auth\UserRecord;
use Lcobucci\JWT\UnencryptedToken;

class ForgotPasswordService
{
    public function __construct(
        protected FirebaseTokenService $firebaseTokenService,
        protected FirebaseUserService $firebaseUserService,
    ) {}

    /**
     * Forgot Password Handler for Firebase
     *
     * @throws FailedToSendPasswordForgotEmailException
     */
    public function forgot(string $email)
    {
        $user = $this->firebaseUserService->getUserByEmail($email);
        $customToken = $this->firebaseTokenService->getCustomToken($user->uid);

        if (! $this->sendMail($user, $customToken)) {
            throw new FailedToSendPasswordForgotEmailException;
        }
    }

    /**
     * Send Forgot Password Email
     *
     * @return bool
     */
    private function sendMail(UserRecord $user, UnencryptedToken $customToken)
    {
        try {
            Mail::to($user->email)->send(new ResetPasswordMail($customToken->toString(), $user->displayName));
            return true;
        } catch (\Exception $e) {
            Log::error("Failed to send forgot password email to: {$user->email}. Error: " . $e->getMessage());
            return false;
        }
    }
}
