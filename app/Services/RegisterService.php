<?php

namespace App\Services;

use App\Exceptions\AuthServiceException;
use App\Exceptions\EmailAlreadyInUseException;
use App\Exceptions\FailedToSendVerificationEmailException;
use App\Exceptions\GeneralFirebaseException;
use App\Exceptions\UnexpectedErrorException;
use App\Mail\Auth\VerifyEmailMail;
use Illuminate\Mail\SentMessage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Kreait\Firebase\Auth as FirebaseAuth;
use Kreait\Firebase\Auth\SendActionLink\FailedToSendActionLink;
use Kreait\Firebase\Auth\UserRecord;
use Kreait\Firebase\Exception\Auth\EmailExists;
use Kreait\Firebase\Exception\AuthException;
use Kreait\Firebase\Exception\FirebaseException;

class RegisterService
{
    public function __construct(protected FirebaseAuth $auth) {}

    /**
     * Register Handler for Firebase
     *
     * @return UserRecord
     *
     * @throws AuthServiceException
     * @throws GeneralFirebaseException
     * @throws FailedToSendVerificationEmailException
     * @throws UnexpectedErrorException
     */
    public function register(string $name, string $email, string $password)
    {
        try {
            $user = $this->createFirebaseUser($name, $email, $password);
            $this->sendVerificationEmail($user);

            return $user;
        } catch (EmailAlreadyInUseException|FailedToSendActionLink $e) {
            Log::error("Firebase error during user registration: {$e->getMessage()}");
            throw $e;
        } catch (\Exception $e) {
            Log::error("Unexpected error during user registration: {$e->getMessage()}");
            throw new UnexpectedErrorException;
        }
    }

    /**
     * Create a new user in Firebase
     *
     * @return UserRecord
     *
     * @throws EmailAlreadyInUseException
     * @throws AuthServiceException
     * @throws GeneralFirebaseException
     */
    private function createFirebaseUser(string $name, string $email, string $password)
    {
        try {
            $userProperties = $this->prepareUserProperties($name, $email, $password);

            return $this->auth->createUser($userProperties);
        } catch (EmailExists $e) {
            throw new EmailAlreadyInUseException;
        } catch (AuthException $e) {
            throw new AuthServiceException;
        } catch (FirebaseException $e) {
            throw new GeneralFirebaseException;
        }
    }

    /**
     * Prepare user properties for Firebase
     *
     * @return array<string, string|bool>
     */
    private function prepareUserProperties(string $name, string $email, string $password): array
    {
        return [
            'email' => $email,
            'emailVerified' => false,
            'password' => $password,
            'displayName' => $name,
            'disabled' => false,
        ];
    }

    /**
     * Send verification email to the user
     *
     * @return ?SentMessage
     *
     * @throws AuthException
     * @throws FirebaseException
     * @throws FailedToSendVerificationEmailException
     */
    private function sendVerificationEmail(UserRecord $user)
    {
        try {
            $customToken = $this->auth->createCustomToken($user->uid);

            return Mail::to($user->email)->send(new VerifyEmailMail($customToken->toString(), $user->displayName));
        } catch (AuthException $e) {
            throw new AuthServiceException;
        } catch (FirebaseException $e) {
            throw new GeneralFirebaseException;
        } catch (FailedToSendActionLink $e) {
            Log::error("Failed to send verification email link: {$e->getMessage()}");
            throw new FailedToSendVerificationEmailException;
        }
    }
}
