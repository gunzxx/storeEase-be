<?php

use App\Http\Controllers\api\auth\AuthAdminController;
use App\Http\Controllers\api\auth\AuthCustomerController;
use App\Http\Controllers\api\auth\AuthVendorController;
use App\Http\Controllers\api\CustomerProfileController;
use App\Http\Controllers\api\DetailServicePackageController;
use App\Http\Controllers\api\DocumentController;
use App\Http\Controllers\api\OrderController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ServiceCategoryController;
use App\Http\Controllers\VendorController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->group(function () {
    Route::prefix('auth')->group(function () {
        Route::prefix('admin')->group(function () {
            Route::post('login', [AuthAdminController::class, 'login']);
            Route::post('register', [AuthAdminController::class, 'register']);
        });
        Route::prefix('vendor')->group(function () {
            Route::post('login', [AuthVendorController::class, 'login']);
            Route::post('register', [AuthVendorController::class, 'register']);
        });
        Route::prefix('customer')->group(function () {
            Route::post('login', [AuthCustomerController::class, 'login']);
            Route::post('register', [AuthCustomerController::class, 'register']);
        });
    });
});

Route::middleware(['jwt-verify', 'multi-auth:vendor,admin,customer'])->group(function () {
    Route::get('/homepage', [DetailServicePackageController::class, 'index']);
    Route::get('/package/{id}', [DetailServicePackageController::class, 'single']);

    Route::get('/packages', [DetailServicePackageController::class, 'all']);
    
    Route::get('/document/{order_id}', [DocumentController::class, 'index']);
});

Route::middleware(['jwt-verify', 'multi-auth:customer'])->group(function () {
    Route::get('/customer', [CustomerProfileController::class, 'detail']);
    Route::post('/customer', [CustomerProfileController::class, 'update']);


    Route::post('/order/create', [OrderController::class, 'create']);
    Route::get('/order/{id}/detail', [OrderController::class, 'single']);
    Route::get('/order/category', [OrderController::class, 'category']);
    Route::get('/order', [OrderController::class, 'category']);
});



/**
 * API for web admin
 */
Route::middleware(['admin'])->group(function () {
    Route::delete('/customer/{id}', [CustomerController::class, 'delete']);
    Route::delete('/vendor/{id}', [VendorController::class, 'delete']);
    Route::delete('/category/{id}', [ServiceCategoryController::class, 'delete']);
    Route::delete('/product/{id}', [App\Http\Controllers\ServiceController::class, 'delete']);
    Route::delete('/order/{id}', [App\Http\Controllers\OrderController::class, 'delete']);
    Route::delete('/package/{id}', [App\Http\Controllers\PackageController::class, 'delete']);
    Route::delete('/package-category/{id}', [App\Http\Controllers\PackageCategoryController::class, 'delete']);
    Route::delete('/package-detail/{id}', [App\Http\Controllers\DetailServicePackageController::class, 'delete']);
    Route::delete('/preview-package/{id}', [App\Http\Controllers\PackageController::class, 'deletePreview']);
    Route::put('/job-list/{id}', [App\Http\Controllers\JobListController::class, 'updateStatus']);
    Route::delete('/job-list/{id}', [App\Http\Controllers\JobListController::class, 'delete']);
});
