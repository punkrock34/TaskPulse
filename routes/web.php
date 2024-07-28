<?php

use App\Http\Middleware\ValidateFirebaseResetCode;
use Illuminate\Support\Facades\Route;

Route::get('/reset-password/{code?}', function () {
    return view('app');
})->name('reset-password')->middleware(ValidateFirebaseResetCode::class);

Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');
