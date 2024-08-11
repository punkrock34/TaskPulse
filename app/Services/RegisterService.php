<?php

namespace App\Services;

use App\Exceptions\FailedToSendVerificationEmailException;
use App\Services\Firebase\FirebaseTokenService;
use App\Services\Firebase\FirebaseUserService;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Auth\UserRecord;

class RegisterService
{
    public function __construct(
        protected FirebaseTokenService $firebaseTokenService,
        protected FirebaseUserService $firebaseUserService,
        protected VerifyEmailService $verifyEmailService
    ) {}

    /**
     * Register Handler for Firebase
     *
     * @return UserRecord
     */
    public function register(string $name, string $email, string $password)
    {
        $user = $this->firebaseUserService->createUser($name, $email, $password);
        $customToken = $this->firebaseTokenService->getCustomToken($user->uid);

        if (! $this->verifyEmailService->sendMail($user, $customToken)) {
            Log::error("Failed to send verification email to: {$email}");
            throw new FailedToSendVerificationEmailException;
        }

        return $user;
    }
}
