<?php

namespace App\Services;

use App\Exceptions\AuthServiceException;
use App\Exceptions\EmailNotVerifiedException;
use App\Exceptions\GeneralFirebaseException;
use App\Exceptions\InvalidCredentialsException;
use App\Exceptions\TokenVerificationException;
use App\Exceptions\UnexpectedErrorException;
use App\Exceptions\UserNotFoundException;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Auth as FirebaseAuth;
use Kreait\Firebase\Auth\SignIn\FailedToSignIn;
use Kreait\Firebase\Auth\UserRecord;
use Kreait\Firebase\Exception\Auth\FailedToVerifyToken;
use Kreait\Firebase\Exception\Auth\RevokedIdToken;
use Kreait\Firebase\Exception\Auth\UserNotFound;
use Kreait\Firebase\Exception\AuthException;
use Kreait\Firebase\Exception\FirebaseException;

class LoginService
{
    public function __construct(protected FirebaseAuth $auth, protected UserService $userService) {}

    /**
     * Login Handler for Firebase
     *
     * @return User
     *
     * @throws InvalidCredentialsException
     * @throws EmailNotVerifiedException
     * @throws UnexpectedErrorException
     * @throws UserNotFoundException
     * @throws AuthServiceException
     * @throws GeneralFirebaseException
     */
    public function login(string $email, string $password, bool $remember)
    {
        try {
            $firebaseUser = $this->signInWithFirebase($email, $password);

            if (! $firebaseUser->emailVerified) {
                throw new EmailNotVerifiedException;
            }

            return $this->authenticateUser($firebaseUser, $remember);
        } catch (InvalidCredentialsException|EmailNotVerifiedException|UserNotFoundException $e) {
            Log::error("Firebase error during sign in: {$e->getMessage()}");
            throw $e;
        } catch (\Exception $e) {
            Log::error("Unexpected error during sign in: {$e->getMessage()}");
            throw new UnexpectedErrorException;
        }
    }

    /**
     * Login With Google Handler for Firebase
     *
     * @return User
     *
     * @throws UnexpectedErrorException
     */
    public function loginWithGoogle(string $idToken)
    {
        try {
            $verifiedIdToken = $this->auth->verifyIdToken($idToken, false, 300);
            $firebaseUser = $this->auth->getUser($verifiedIdToken->claims()->get('sub'));

            return $this->authenticateUser($firebaseUser, true);
        } catch (FailedToVerifyToken|RevokedIdToken $e) {
            Log::error("Token verification failed: {$e->getMessage()}");
            throw new TokenVerificationException;
        } catch (\Exception $e) {
            Log::error("Failed to login with Google: {$e->getMessage()}");
            throw new UnexpectedErrorException('Failed to login with Google. Please try again.');
        }
    }

    /**
     * Authenticate User using User Service
     *
     * @return User
     */
    private function authenticateUser(UserRecord $firebaseUser, bool $remember)
    {
        $user = $this->userService->updateOrCreateUser($firebaseUser);
        $this->userService->loginUser($user->id, $remember);

        return $user;
    }

    /**
     * Sign In with Firebase using email and password
     *
     * @return UserRecord
     *
     * @throws UserNotFoundException
     * @throws AuthServiceException
     * @throws GeneralFirebaseException
     */
    private function signInWithFirebase(string $email, string $password)
    {
        try {
            $signInResult = $this->auth->signInWithEmailAndPassword($email, $password);

            return $this->auth->getUser($signInResult->firebaseUserId());
        } catch (FailedToSignIn $e) {
            throw new InvalidCredentialsException;
        } catch (UserNotFound $e) {
            throw new UserNotFoundException;
        } catch (AuthException $e) {
            throw new AuthServiceException;
        } catch (FirebaseException $e) {
            throw new GeneralFirebaseException;
        }
    }
}
