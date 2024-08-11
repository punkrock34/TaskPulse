<?php

namespace App\Services;

use App\Exceptions\EmailNotVerifiedException;
use App\Models\User;
use App\Services\Firebase\FirebaseTokenService;
use App\Services\Firebase\FirebaseUserService;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Auth\UserRecord;

class LoginService
{
    public function __construct(
        protected FirebaseTokenService $firebaseTokenService,
        protected FirebaseUserService $firebaseUserService,
        protected UserService $userService
    ) {}

    /**
     * Login Handler for Firebase
     *
     * @return User
     *
     * @throws EmailNotVerifiedException
     */
    public function login(string $email, string $password, bool $remember)
    {
        $signInResult = $this->firebaseUserService->signInWithFirebaseEmailAndPasswordProvider($email, $password);
        $firebaseUser = $this->firebaseUserService->getUserByUID($signInResult->firebaseUserId());

        if (! $firebaseUser->emailVerified) {
            Log::warning("User tried to login with unverified email: {$email}");
            throw new EmailNotVerifiedException;
        }

        return $this->authenticateUser($firebaseUser, $remember);
    }

    /**
     * Login With Google Handler for Firebase
     *
     * @return User
     */
    public function loginWithGoogle(string $idToken)
    {
        $uid = $this->firebaseTokenService->getUidFromIdToken($idToken);
        $firebaseUser = $this->firebaseUserService->getUserByUID($uid);

        return $this->authenticateUser($firebaseUser, true);
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
}
