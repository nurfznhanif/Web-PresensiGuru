<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GuruController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// API routes yang memerlukan autentikasi web session
Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/gurus', [GuruController::class, 'index']); // ubah ke 'index'
    Route::post('/gurus', [GuruController::class, 'store']);
    Route::put('/gurus/{id}', [GuruController::class, 'update']);
    Route::delete('/gurus/{id}', [GuruController::class, 'destroy']);
});
