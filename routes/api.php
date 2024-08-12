<?php

use App\Http\Controllers\Auth\VerifyTokenController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::apiResource('/tasks', TaskController::class);
