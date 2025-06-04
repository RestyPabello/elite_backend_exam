<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

Route::middleware('auth:api')->group( function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/users/logout', [AuthController::class, 'logout']);
});

Route::prefix('users')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});