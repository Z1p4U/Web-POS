<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::prefix("v1")->group(function () {

    Route::middleware('auth:sanctum')->group(function () {

        Route::put("password-update", [PasswordController::class, 'update']);

        Route::controller(AuthController::class)->group(function () {
            Route::post('register', "register");
            Route::post("logout", 'logout');
            Route::post("logout-all", 'logoutAll');
        });
    });

    Route::post('login', [AuthController::class, 'login']);
});
