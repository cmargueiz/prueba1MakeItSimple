<?php

use App\Http\Controllers\Task\TaskApiController;
use App\Http\Controllers\User\AuthController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);

Route::post('/infouser',[AuthController::class,'infouser'])->middleware('auth:sanctum');
Route::post('/logout',[AuthController::class,'logout'])->middleware('auth:sanctum');
Route::get('/task/{user_id}',[TaskApiController::class,'index'])->middleware('auth:sanctum');
Route::post('/task',[TaskApiController::class,'store'])->middleware('auth:sanctum');
Route::put('/task/{id}',[TaskApiController::class,'update'])->middleware('auth:sanctum');
Route::delete('/task/{id}',[TaskApiController::class,'destroy'])->middleware('auth:sanctum');