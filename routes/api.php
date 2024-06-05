<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource("users", App\Http\Controllers\API\UserController::class);
Route::apiResource("comments", App\Http\Controllers\API\CommentController::class);
Route::apiResource("posts", App\Http\Controllers\API\PostController::class);
