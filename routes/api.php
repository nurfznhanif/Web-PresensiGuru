<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GuruController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// API routes yang memerlukan autentikasi
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('gurus', GuruController::class);
});
