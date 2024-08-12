<?php

use App\Http\Controllers\Auth\VerifyTokenController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::post('/verify-token', [VerifyTokenController::class, 'verifyToken']);
Route::apiResource('/tasks', TaskController::class);
