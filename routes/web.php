<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Middleware\ValidateFirebaseResetCode;
use Illuminate\Support\Facades\Route;

//route for login, register, forgot password, reset password will be used inertia js to render the vue component
Route::group(['middleware' => 'guest'], function () {
    Route::get('/', [LoginController::class, 'index'])->name('login.index');
    Route::get('/register', [RegisterController::class, 'index'])->name('register.index');
    Route::get('/forgot-password', [ForgotPasswordController::class, 'index'])->name('forgot-password.index');
    Route::get('/reset-password/{code}', [ResetPasswordController::class, 'index'])->middleware(ValidateFirebaseResetCode::class)->name('reset-password.index');

    Route::post('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/register', [RegisterController::class, 'register'])->name('register');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'forgotPassword'])->name('forgot-password');
    Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword'])->middleware(ValidateFirebaseResetCode::class)->name('reset-password');
});
