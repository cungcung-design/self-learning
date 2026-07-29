<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AdventureController;
use App\Http\Controllers\Api\BookingController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/adventures', [AdventureController::class, 'index']);
    Route::post('/bookings', [BookingController::class, 'store']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
