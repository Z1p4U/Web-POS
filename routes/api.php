<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\VoucherRecordController;
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
        Route::apiResource("product", ProductController::class);
        Route::apiResource("stock", StockController::class)->only(['index', 'store']);
        Route::apiResource("brand", BrandController::class);
        Route::apiResource("voucher", VoucherController::class);
        Route::apiResource("voucher-record", VoucherRecordController::class)->only(['store', 'destroy','update']);
        Route::post("voucher-record-products", [VoucherRecordController::class, 'showProductBasedOnVoucherNumber']);

        Route::put("password-update", [PasswordController::class, 'update']);

        Route::controller(AuthController::class)->group(function () {
            Route::post('register', "register");
            Route::post("logout", 'logout');
            Route::post("logout-all", 'logoutAll');
        });
    });


    Route::post('login', [AuthController::class, 'login']);
});
