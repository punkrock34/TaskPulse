<?php

namespace App\Services;

use App\Services\Firebase\FirebaseTokenService;
use App\Services\Firebase\FirebaseUserService;

class ResetPasswordService
{
    public function __construct(
        protected FirebaseTokenService $firebaseTokenService,
        protected FirebaseUserService $firebaseUserService,
    ) {}

    /**
     * Reset Password Handler for Firebase
     */
    public function resetPassword($token, $password)
    {
        $idToken = $this->firebaseTokenService->getIdToken($token);
        $uid = $this->firebaseTokenService->getUidFromIdToken($idToken);

        $user = $this->firebaseUserService->getUserByUID($uid);
        $this->firebaseUserService->updateUserPassword($user->uid, $password);
    }
}
