<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\PostController; // Import the PostController class



Route::get('/', function () {
    return view('welcome');
});

Route::get('/hello', function () {
    return 'Hello World';
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request)
{
    return $request->user();
});

Route::get('/get', [PostController::class, 'index']);

Route::post('/post', [PostController::class, 'store']);

Route::delete('/delete/{id}', [PostController::class, 'destroy']);
