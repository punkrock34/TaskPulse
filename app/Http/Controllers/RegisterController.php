<?php

namespace App\Http\Controllers;

use App\Http\Requests\Register;
use Kreait\Firebase\Auth as FirebaseAuth;

class RegisterController extends Controller
{
    protected $auth;

    public function __construct(FirebaseAuth $auth)
    {
        $this->auth = $auth;
    }

    public function show()
    {
        return view('auth.register')->with('title', 'Register');
    }

    public function register(Register $request)
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

        $this->auth->createUser($userProperties);
        $this->auth->sendEmailVerificationLink($email);

        return redirect()->route('login')->with('status', 'Account created successfully');
    }
}
