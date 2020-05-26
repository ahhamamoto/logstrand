<?php

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

Route::prefix('authentication')
    ->namespace('Api\Authentication')
    ->group(function () {
        Route::post('register', RegisterController::class);
        Route::post('login', LoginController::class);
    });

Route::middleware(['auth:sanctum'])
    ->prefix('user')
    ->namespace('Api\User')
    ->group(function () {
        Route::get('/', UserController::class);
        Route::put('/change-password', ChangePasswordController::class);
    });

Route::middleware(['auth:sanctum'])
    ->prefix('groups')
    ->namespace('Api\Groups')
    ->group(function () {
        Route::get('/{group}', ViewGroupController::class);
        Route::post('/', CreateGroupController::class);
        Route::delete('/{group}', DeleteGroupController::class);
    });
