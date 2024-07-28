<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerifyTokenController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [LoginController::class, 'loginUser']);
Route::post('/register', [RegisterController::class, 'registerUser']);
Route::post('/forgot-password', [PasswordResetController::class, 'requestPasswordReset']);
Route::post('/reset-password', [PasswordResetController::class, 'resetPassword']);
Route::post('/verify-token', [VerifyTokenController::class, 'verifyIdToken']);
