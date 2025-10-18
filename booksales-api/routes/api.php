<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// Books
Route::apiResource('/books', BookController::class);

// Genres
Route::apiResource('/genres', GenreController::class);

// Authors
Route::apiResource('/authors', AuthorController::class);
