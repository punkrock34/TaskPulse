<?php

namespace App\Services;

use App\Exceptions\AuthServiceException;
use App\Exceptions\FailedToSendPasswordForgotEmailException;
use App\Exceptions\GeneralFirebaseException;
use App\Exceptions\UnexpectedErrorException;
use App\Exceptions\UserNotFoundException;
use App\Mail\Auth\ResetPasswordMail;
use Illuminate\Mail\SentMessage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Kreait\Firebase\Auth as FirebaseAuth;
use Kreait\Firebase\Auth\SendActionLink\FailedToSendActionLink;
use Kreait\Firebase\Auth\UserRecord;
use Kreait\Firebase\Exception\Auth\UserNotFound;
use Kreait\Firebase\Exception\AuthException;
use Kreait\Firebase\Exception\FirebaseException;

class ForgotPasswordService
{
    public function __construct(protected FirebaseAuth $auth) {}

    /**
     * Forgot Password Handler for Firebase
     *
     * @throws UserNotFoundException
     * @throws AuthServiceException
     * @throws GeneralFirebaseException
     * @throws UnexpectedErrorException
     */
    public function forgot(string $email)
    {
        try {
            $user = $this->auth->getUserByEmail($email);
            $this->sendVerificationEmail($user);
        } catch (UserNotFound $e) {
            Log::error("User not found when sending password reset link: {$e->getMessage()}");
            throw new UserNotFoundException('The user was not found.');
        } catch (FailedToSendActionLink|AuthServiceException|GeneralFirebaseException $e) {
            Log::error("Firebase error during forgot password: {$e->getMessage()}");
            throw $e;
        } catch (\Exception $e) {
            Log::error("Unexpected error during forgot password: {$e->getMessage()}");
            throw new UnexpectedErrorException('An unexpected error occurred. Please try again later.');
        }
    }

    /**
     * Send Forgot Password Email
     *
     * @return ?SentMessage
     *
     * @throws AuthException
     * @throws FirebaseException
     * @throws FailedToSendPasswordForgotEmailException
     */
    private function sendVerificationEmail(UserRecord $user)
    {
        try {
            $expireTime = now()->addMinutes(5)->getTimestamp();
            $customPasswordToken = $this->auth->createCustomToken($user->uid, ['password_reset' => true], $expireTime)->toString();
            Mail::to($user->email)->send(new ResetPasswordMail($customPasswordToken, $user->displayName));
        } catch (AuthException $e) {
            throw new AuthServiceException;
        } catch (FirebaseException $e) {
            throw new GeneralFirebaseException;
        } catch (FailedToSendActionLink $e) {
            Log::error("Failed to send forgot password email: {$e->getMessage()}");
            throw new FailedToSendPasswordForgotEmailException;
        }
    }
}
