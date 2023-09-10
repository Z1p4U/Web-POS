<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\VoucherRecordController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SaleController;
use App\Http\Middleware\AcceptJson;
use App\Http\Middleware\CheckUserBanned;
use App\Http\Middleware\SaleClosedCheck;
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

    Route::middleware(['auth:sanctum', AcceptJson::class])->group(function () {
        Route::middleware(CheckUserBanned::class)->group(function () {

            Route::apiResource("product", ProductController::class);
            Route::apiResource("stock", StockController::class)->only(['index', 'store']);
            Route::apiResource("brand", BrandController::class);
            Route::apiResource("voucher", VoucherController::class);
            Route::apiResource("voucher-record", VoucherRecordController::class)->only(['store', 'destroy', 'update'])->middleware(SaleClosedCheck::class);
            Route::post("voucher-record-products", [VoucherRecordController::class, 'showProductBasedOnVoucherNumber'])->middleware(SaleClosedCheck::class);
            Route::post("voucher-record-products-multiple", [VoucherRecordController::class, 'bulkStore']);
            Route::apiResource('photo', PhotoController::class)->only(['index', "store", "show", "destroy"]);
            Route::post('photo/multiple-delete', [PhotoController::class, 'deleteMultiplePhotos']);

            Route::put("password-update", [PasswordController::class, 'update']);

            Route::post("check-out", [CheckoutController::class, 'run'])->middleware(SaleClosedCheck::class);
            Route::controller(SaleController::class)->group(function () {
                Route::post('sale-close', 'saleClose');
                Route::post('sale-open', 'openSale');
            });

            Route::controller(FinanceController::class)->middleware('can:admin-only')->group(function () {
                Route::get('monthly-sale', 'monthlySale');
                Route::get('yearly-sale', 'yearlySale');
                Route::get('custom-search-by-day', 'customSearch');
            });

            Route::prefix('report')->controller(ReportController::class)->group(function () {
                Route::get('overview', "overview");
                Route::get('sale', "saleReport");
                Route::get('brand', 'brandReport');
                Route::get('stock', 'stockReport');
            });
        });

        Route::controller(AuthController::class)->group(function () {
            Route::middleware(CheckUserBanned::class)->group(function () {
                Route::post('register', "register");
                Route::get('user-lists', 'showUserLists');
                Route::get('profile', 'getYourProfile');
                Route::get('check-profile/{id}', 'checkUserProfile');
                Route::put('edit', "edit");
            });
            Route::post("logout", 'logout');
            Route::post("logout-all", 'logoutAll');
            Route::post('user/{id}/ban', 'banUser');
            Route::post('user/{id}/unban', 'unbanUser');
        });
    });


    Route::post('login', [AuthController::class, 'login']);
});
