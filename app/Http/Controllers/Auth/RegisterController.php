<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\AbstractInertiaController;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Kreait\Firebase\Auth as FirebaseAuth;
use Kreait\Firebase\Auth\SendActionLink\FailedToSendActionLink;
use Kreait\Firebase\Exception\AuthException;
use Kreait\Firebase\Exception\FirebaseException;

class RegisterController extends AbstractInertiaController
{
    public function __construct(protected FirebaseAuth $auth) {}

    public function index(Request $request)
    {
        return Inertia::render('Register');
    }

    public function register(RegisterRequest $request)
    {
        try {
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

            $this->auth->createUser($userProperties);
            $this->auth->sendEmailVerificationLink($email);

            return redirect()->route('login.index')->withStatus('Account created successfully');
        } catch (FailedToSendActionLink $e) {
            Log::error("Error sending email verification link: {$e->getMessage()}");

            return response()->json(['error' => 'Error sending email verification link'], 500);
        } catch (AuthException|FirebaseException $e) {
            Log::error("Firebase error creating user: {$e->getMessage()}");

            return response()->json([
                'errors' => [
                    'email' => 'Email already in use',
                ],
            ], 422);
        } catch (\Exception $e) {
            Log::error("Error creating user: {$e->getMessage()}");

            return response()->json(['error' => 'An error occurred'], 500);
        }
    }
}
