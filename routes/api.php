<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/verify-id-token', [AuthController::class, 'verifyIdToken']);
