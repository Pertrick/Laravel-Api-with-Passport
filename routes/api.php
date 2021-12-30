<?php

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


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/


Route::post('/register', [\App\Http\Controllers\Api\AuthController::class, 'register'])
    ->name('register');

Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login'])
    ->name('login');

Route::group(['middleware' => ['auth:api']], function (){

    Route::get('/profile', [\App\Http\Controllers\Api\AuthController::class, 'profile'])
        ->name('profile');

    Route::post('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout'])
        ->name('logout');

    Route::apiResource('blog', \App\Http\Controllers\Api\BlogController::class);
});


