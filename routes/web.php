<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\GoogleLoginController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'index'])->name('login.index');
    Route::get('/register', [RegisterController::class, 'index'])->name('register.index');
    Route::get('/forgot-password', [ForgotPasswordController::class, 'index'])->name('forgot-password.index');
    Route::get('/verify-email', [VerifyEmailController::class, 'index'])->name('verify-email.index');
    Route::permanentRedirect('/login', '/');

    Route::middleware('throttle:10,1')->group(function () {
        Route::post('/login', [LoginController::class, 'store'])->name('login.store');
        Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
        Route::post('/forgot-password', [ForgotPasswordController::class, 'store'])->name('forgot-password.store');
        Route::post('/resend-verification', [VerifyEmailController::class, 'store'])->name('verification.store');

        Route::post('/login/google', [GoogleLoginController::class, 'store'])->name('login.google.store');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::post('/logout', function () {
        Auth::logout();

        return redirect()->route('login.index');
    })->name('logout.store');
});

// not found page
Route::get('/{any}', function () {
    return inertia('NotFound');
})->where('any', '.*');
