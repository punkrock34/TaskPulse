<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\ResetPasswordRequestController;
use App\Http\Middleware\ValidateFirebaseResetCode;
use Illuminate\Support\Facades\Route;

// GET routes
Route::get('/', [LoginController::class, 'show'])->name('login');
Route::get('/register', [RegisterController::class, 'show'])->name('register');
Route::get('/password/reset', [ResetPasswordRequestController::class, 'show'])->name('reset-password.request');
Route::get('/password/reset/{code}', [ResetPasswordController::class, 'show'])
    ->middleware(ValidateFirebaseResetCode::class)->name('reset-password.reset');

// POST routes
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
Route::post('/password/reset', [ResetPasswordRequestController::class, 'request'])->name('reset-password.request.post');
