<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Kreait\Firebase\Auth as FirebaseAuth;

class FirebaseUserProvider implements UserProvider
{
    public function __construct(protected FirebaseAuth $auth)
    {
        $this->auth = $auth;
    }

    public function retrieveById($identifier)
    {
        try {
            $firebaseUser = $this->auth->getUser($identifier);

            return $this->createUserFromFirebaseUser($firebaseUser);
        } catch (\Exception $e) {
            return null;
        }
    }

    public function retrieveByToken($identifier, $token)
    {
        try {
            $firebaseUser = $this->auth->verifyIdToken($token);

            return $this->createUserFromFirebaseUser($firebaseUser);
        } catch (\Exception $e) {
            return null;
        }
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
        // Laravel handles this, so this is usually left empty
    }

    public function retrieveByCredentials(array $credentials)
    {
        try {
            $signInResult = $this->auth->signInWithEmailAndPassword($credentials['email'], $credentials['password']);
            $firebaseUser = $this->auth->getUser($signInResult->firebaseUserId());

            return $this->createUserFromFirebaseUser($firebaseUser);
        } catch (\Exception $e) {
            return null;
        }
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        // Validation is handled in retrieveByCredentials
        return true;
    }

    protected function createUserFromFirebaseUser($firebaseUser)
    {
        return new User([
            'id' => $firebaseUser->uid,
            'name' => $firebaseUser->displayName,
            'email' => $firebaseUser->email,
            'email_verified_at' => $firebaseUser->emailVerified ? now() : null,
            'avatar' => $firebaseUser->photoUrl,
        ]);
    }

    public function rehashPasswordIfRequired(Authenticatable $user, array $credentials, bool $force = false)
    {
        //not needed
    }
}
