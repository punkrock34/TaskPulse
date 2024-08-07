<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\LoginService;
use Inertia\Inertia;

class LoginController extends Controller
{
    public function __construct(protected LoginService $loginService) {}

    public function index()
    {
        return Inertia::render('Login');
    }

    public function store(LoginRequest $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $remember = $request->input('remember');

        try {
            $this->loginService->login($email, $password, $remember);
            $request->session()->regenerate(true);

            return redirect()->route('dashboard.index');
        } catch (\Exception $e) {
            return Inertia::render('Login', ['errors' => [$e->getCode() => $e->getMessage()]]);
        }
    }
}
