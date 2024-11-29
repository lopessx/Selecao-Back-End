<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->group(function (){
    Route::get('/user/{id}',[UserController::class, 'get']);
    Route::put('/user/{id}',[UserController::class, 'update']);
    Route::delete('/user/{id}',[UserController::class, 'delete']);

    Route::get('/comment/{id}',[CommentController::class, 'get']);
    Route::post('/comment/post',[CommentController::class, 'store']);
    Route::put('/comment/{id}',[CommentController::class,'update']);
    Route::delete('/comment/{id}',[CommentController::class,'delete']);

    Route::post('/logout',[UserController::class, 'logout']);
});
Route::post('/login',[UserController::class, 'login']);
Route::post('/user',[UserController::class, 'store']);
Route::get('/comment',[CommentController::class, 'getAll']);
