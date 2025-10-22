<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Auths (Public)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Access Public (Read All & Show)
Route::apiResource('/books', BookController::class)->only(['index', 'show']);
Route::apiResource('/genres', GenreController::class)->only(['index', 'show']);
Route::apiResource('/authors', AuthorController::class)->only(['index', 'show']);

// Protected by JWT (General)
Route::middleware(['auth:api'])->group(function(){
    Route::post('/logout', [AuthController::class, 'logout']);

    // Protected by RBAC (Role: admin)
    Route::middleware(['role:admin'])->group(function() {
        // Books (CUD - Restricted to Admin)
        Route::apiResource('/books', BookController::class)->only(['store', 'update', 'destroy']);

        // Genres (CUD - Restricted to Admin - TUGAS)
        Route::apiResource('/genres', GenreController::class)->only(['store', 'update', 'destroy']);

        // Authors (CUD - Restricted to Admin - TUGAS)
        Route::apiResource('/authors', AuthorController::class)->only(['store', 'update', 'destroy']);
    });
});
