<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\AbstractInertiaController;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Kreait\Firebase\Auth as FirebaseAuth;
use Kreait\Firebase\Auth\SignIn\FailedToSignIn;

class LoginController extends AbstractInertiaController
{
    public function __construct(protected FirebaseAuth $auth) {}

    public function index(Request $request)
    {
        return Inertia::render('Login');
    }

    public function login(LoginRequest $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $remember = $request->input('remember');

        try {
            //testing shit
            throw new FailedToSignIn('LMAO COAE TESTING SHIT');
            $signInResult = $this->auth->signInWithEmailAndPassword($email, $password);

            if ($remember) {
                // Handle remember functionality
            }

            //todo add redirect to dashboard and set session

        } catch (FailedToSignIn $e) {
            Log::error("Error signing in user: {$e->getMessage()}");

            return back()
                ->withErrors(['error' => 'Invalid email or password'])
                ->setStatusCode(301);
        } catch (\Exception $e) {
            Log::error("Error signing in user: {$e->getMessage()}");

            return back()
                ->withErrors(['error' => 'Error signing in user'])
                ->setStatusCode(301);
        }
    }
}
