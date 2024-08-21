<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Kreait\Firebase\Auth\UserRecord;

class UserService
{
    /**
     * Log in the user
     *
     * @return void
     */
    public function loginUser(string $userId, bool $remember)
    {
        Auth::loginUsingId($userId, $remember);
    }

    /**
     * Update or create user in the database
     *
     * @return User
     */
    public function updateOrCreateUser(UserRecord $firebaseUser)
    {
        $user = User::where('email', $firebaseUser->email)->first();

        if ($user) {
            $user = $this->updateUser($user, $firebaseUser);
        } else {
            $user = $this->createUser($firebaseUser);
        }

        return $user;
    }

    /**
     * Create user in the database
     *
     * @return User
     */
    private function createUser(UserRecord $firebaseUser)
    {
        return User::create([
            'firebase_uid' => $firebaseUser->uid,
            'name' => $firebaseUser->displayName,
            'email' => $firebaseUser->email,
            'email_verified_at' => $firebaseUser->emailVerified ? now() : null,
            'avatar' => $firebaseUser->photoUrl,
        ]);
    }

    /**
     * Update an existing user in the database
     *
     * @return User
     */
    private function updateUser(User $user, UserRecord $firebaseUser)
    {
        $user->update([
            'firebase_uid' => $firebaseUser->uid,
            'name' => $firebaseUser->displayName,
            'email_verified_at' => $firebaseUser->emailVerified ? now() : null,
            'avatar' => $firebaseUser->photoUrl,
        ]);

        return $user;
    }
}
