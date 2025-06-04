<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Artist\ArtistController;
use App\Http\Controllers\Album\AlbumController;
use App\Http\Controllers\Dashboard\DashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

Route::middleware('auth:api')->group( function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('artists', ArtistController::class);
    Route::apiResource('albums', AlbumController::class);

    Route::post('/albums/update/{id}', [AlbumController::class, 'update']);
    Route::post('/users/logout', [AuthController::class, 'logout']);

    Route::prefix('dashboards')->group(function () {
        Route::get('total-numbers', [DashboardController::class, 'totalNumbers']);
        Route::get('combined-albums', [DashboardController::class, 'combinedAlbums']);
        Route::get('top-artist', [DashboardController::class, 'topOneArtist']);
        Route::post('search', [DashboardController::class, 'searchArtist']);
    });
});

Route::prefix('users')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

