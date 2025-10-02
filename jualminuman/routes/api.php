<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\KategoriMinumanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MinumanController;


Route::apiResource('kategori-minuman', KategoriMinumanController::class);
Route::prefix('')->group(function () {
    Route::apiResource('products', ProductController::class);
});
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::apiResource('minuman', MinumanController::class);
