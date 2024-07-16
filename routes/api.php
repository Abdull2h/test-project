<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('register',[AuthController::class,'register']);
    Route::post('login',[AuthController::class,'login']);
    Route::post('logout',[AuthController::class,'logout'])
  ->middleware('auth:sanctum');


Route::middleware('auth:sanctum')->group(function () {
    Route::get('posts',[PostController::class,'index']);
    Route::post('posts',[PostController::class,'store']);
    Route::get('posts/{id}',[PostController::class,'show']);
});
