<?php

use App\Http\Controllers\CommentsController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\UserAuthenticationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::post('logout', [UserAuthenticationController::class, 'logout']);
});

Route::prefix('v1')->group(function () {
    Route::post('login', [UserAuthenticationController::class, 'login']);
    Route::post('register', [UserAuthenticationController::class, 'register']);
    Route::apiResource('posts', PostsController::class);
    Route::apiResource('comments', CommentsController::class);
});
