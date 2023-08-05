<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockController;
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
        Route::apiResource("product", ProductController::class);
        Route::apiResource("stock", StockController::class)->only(['index','store']);
        Route::apiResource("brand", BrandController::class);


        Route::post("logout", [AuthController::class, 'logout']);
        Route::post("logout-all", [AuthController::class, 'logoutAll']);
    });


    Route::post('login', [AuthController::class, 'login']);
});
