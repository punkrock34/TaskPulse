<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Login;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Auth\SignIn\FailedToSignIn;

class LoginController extends AuthController
{
    public function loginUser(Login $request)
    {
        $request->validated();

        $email = $request->input('email');
        $password = $request->input('password');

        try {
            $this->auth->signInWithEmailAndPassword($email, $password);

            return response()->json(['message' => 'User signed in successfully']);
        } catch (FailedToSignIn $e) {
            Log::error("Error signing in user: {$e->getMessage()}");

            return response()->json(['error' => 'Invalid email or password'], 401);
        } catch (\Exception $e) {
            Log::error("Error signing in user: {$e->getMessage()}");

            return response()->json(['error' => 'Error signing in user'], 500);
        }
    }
}
