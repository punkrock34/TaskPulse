<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Register;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Auth\SendActionLink\FailedToSendActionLink;
use Kreait\Firebase\Exception\AuthException;
use Kreait\Firebase\Exception\FirebaseException;

class RegisterController extends AuthController
{
    public function registerUser(Register $request)
    {
        $request->validated();

        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');

        $userProperties = [
            'email' => $email,
            'emailVerified' => false,
            'password' => $password,
            'displayName' => $name,
            'disabled' => false,
        ];

        try {
            $this->auth->createUser($userProperties);
            $this->auth->sendEmailVerificationLink($email);

            return redirect()->route('login')->with('status', 'Account created successfully');
        } catch (FailedToSendActionLink $e) {
            Log::error("Error sending email verification link: {$e->getMessage()}");

            return response()->json(['error' => 'Error sending email verification link'], 500);
        } catch (AuthException|FirebaseException $e) {
            Log::error("Firebase error creating user: {$e->getMessage()}");

            return redirect()->back()->with('error', 'Error creating user');
        } catch (\Exception $e) {
            Log::error("Error creating user: {$e->getMessage()}");

            return redirect()->back()->with('error', 'Error creating user');
        }
    }
}
