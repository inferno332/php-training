<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController; // Import the PostController class
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hello', function () {
    return 'Hello World';
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login1');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/dashboard', [AuthController::class, 'dashboard']);
Route::post('/logout', [AuthController::class, 'logout']);

// API test
Route::prefix('api')->group(function () {
    Route::get('/test', function() {
        return response()->json(['message' => 'API is working']);
    });

    Route::get('/posts', [PostController::class, 'index']);
    Route::post('/posts', [PostController::class, 'store']);
    Route::delete('/posts/{id}', [PostController::class, 'destroy']);
});
