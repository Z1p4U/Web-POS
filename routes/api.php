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


        Route::post('register', [AuthController::class, "register"]);
        Route::put("password-update", [PasswordController::class, 'update']);
        Route::post("logout", [AuthController::class, 'logout']);
        Route::post("logout-all", [AuthController::class, 'logoutAll']);
    });

    Route::post('login', [AuthController::class, 'login']);
});
