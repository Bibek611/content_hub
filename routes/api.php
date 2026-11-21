<?php

use App\Http\Controllers\Api\PostApiController;
use Illuminate\Support\Facades\Route;

Route::get('/posts', [PostApiController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/posts/my', [PostApiController::class, 'myPosts']);
    Route::post('/posts', [PostApiController::class, 'store']);
    Route::put('/posts/{post}', [PostApiController::class, 'update']);
    Route::delete('/posts/{post}', [PostApiController::class, 'destroy']);
});