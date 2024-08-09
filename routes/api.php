<?php

use App\Http\Controllers\Auth\VerifyTokenController;
use Illuminate\Support\Facades\Route;

Route::post('/verify-token', [VerifyTokenController::class, 'verifyToken']);
