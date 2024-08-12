<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\VerifyTokenController;
use App\Http\Controllers\TaskController;

Route::post('/verify-token', [VerifyTokenController::class, 'verifyToken']);
Route::apiResource('/tasks', TaskController::class);
