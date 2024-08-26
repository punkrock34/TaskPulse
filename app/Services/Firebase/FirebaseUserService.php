<?php

namespace App\Services\Firebase;

use App\Exceptions\AuthServiceException;
use App\Exceptions\EmailAlreadyInUseException;
use App\Exceptions\GeneralFirebaseException;
use App\Exceptions\InvalidCredentialsException;
use App\Exceptions\TooManyAttemptsException;
use App\Exceptions\UserNotFoundException;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Auth as FirebaseAuth;
use Kreait\Firebase\Auth\SignIn\FailedToSignIn;
use Kreait\Firebase\Auth\SignInResult;
use Kreait\Firebase\Auth\UserRecord;
use Kreait\Firebase\Exception\Auth\EmailExists;
use Kreait\Firebase\Exception\Auth\UserNotFound;
use Kreait\Firebase\Exception\AuthException;
use Kreait\Firebase\Exception\FirebaseException;

class FirebaseUserService
{
    public function __construct(protected FirebaseAuth $auth) {}

    /**
     * Create a new user in Firebase
     *
     * @return UserRecord
     *
     * @throws EmailAlreadyInUseException
     * @throws AuthServiceException
     * @throws GeneralFirebaseException
     */
    public function createUser(string $name, string $email, string $password)
    {
        try {
            $userProperties = $this->prepareUserProperties($name, $email, $password);

            return $this->auth->createUser($userProperties);
        } catch (EmailExists $e) {
            Log::warning("User tried to register with an email that is already in use: {$email}");
            throw new EmailAlreadyInUseException;
        } catch (AuthException $e) {
            Log::error("Firebase Authentication error during user registration: {$e->getMessage()}");
            throw new AuthServiceException;
        } catch (FirebaseException $e) {
            Log::error("General Firebase error during user registration: {$e->getMessage()}");
            throw new GeneralFirebaseException;
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
    public function getUserByEmail(string $email)
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
    public function getUserByUID(string $uid)
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
     * Sign In with Firebase using email and password
     *
     * @return SignInResult
     *
     * @throws InvalidCredentialsException
     */
    public function signInWithFirebaseEmailAndPasswordProvider(string $email, string $password)
    {
        try {
            return $this->auth->signInWithEmailAndPassword($email, $password);
        } catch (FailedToSignIn $e) {
            Log::error("Failed to sign in with Firebase: {$e->getMessage()}");
            throw new InvalidCredentialsException;
        }
    }

    /**
     * Update the user's email verification status.
     *
     * @return void
     */
    public function updateUserEmailVerificationStatus(string $uid, bool $status)
    {
        $this->auth->updateUser($uid, ['emailVerified' => $status]);
    }

    /**
     * Update the user's password.
     *
     * @return void
     */
    public function updateUserPassword(string $uid, string $password)
    {
        $this->auth->updateUser($uid, ['password' => $password]);
    }

    /**
     * Prepare the user properties for creating a new user.
     *
     * @return array
     */
    private function prepareUserProperties(string $name, string $email, string $password)
    {
        return [
            'email' => $email,
            'emailVerified' => false,
            'password' => $password,
            'displayName' => $name,
        ];
    }
}
