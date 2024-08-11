<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\RegisterService;
use Inertia\Inertia;

class RegisterController extends Controller
{
    public function __construct(
        protected RegisterService $registerService
    ) {}

    public function index()
    {
        return Inertia::render('Register');
    }

    public function store(RegisterRequest $request)
    {
        try {
            $name = $request->input('name');
            $email = $request->input('email');
            $password = $request->input('password');

            $this->registerService->register($name, $email, $password);

            return redirect()->route('login.index')->withSuccess('Account created successfully! Please check your email to verify your account, and then login.');
        } catch (\Exception $e) {
            return Inertia::render('Register', ['errors' => [$e->getCode() => $e->getMessage()]]);
        }
    }
}
