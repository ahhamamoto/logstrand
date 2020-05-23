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

Route::post('register', Api\Authentication\RegisterController::class);
Route::post('login', Api\Authentication\LoginController::class);

Route::middleware(['auth:sanctum'])
    ->prefix('users')
    ->namespace('Api\Users')
    ->group(function () {
        Route::get('/', UserController::class);
        Route::put('/change-password', ChangePasswordController::class);
    });
