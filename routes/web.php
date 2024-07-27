<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\ResetPasswordRequestController;
use App\Http\Middleware\ValidateFirebaseResetCode;
use Illuminate\Support\Facades\Route;

Route::get('/', [LoginController::class, 'show'])->name('login');
Route::get('/register', [RegisterController::class, 'show'])->name('register');
Route::get('/password/reset', [ResetPasswordRequestController::class, 'show'])->name('reset-password.request');
Route::post('/password/reset', [ResetPasswordRequestController::class, 'request'])->name('reset-password.request.send');
Route::get('/password/reset/{code}', [ResetPasswordController::class, 'show'])
    ->middleware(ValidateFirebaseResetCode::class)->name('reset-password.reset');
