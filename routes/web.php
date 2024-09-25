<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ServiceCategoryController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\VendorController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth:adminweb', 'adminweb'])->group(function () {
    Route::get('/', [AdminController::class, 'index']);
    Route::post('/', [AdminController::class, 'update']);

    Route::get('/customer', [CustomerController::class, 'index']);
    Route::get('/customer/{id}/edit', [CustomerController::class, 'edit']);
    Route::post('/customer/{id}/edit', [CustomerController::class, 'update']);

    Route::get('/vendor', [VendorController::class, 'index']);
    Route::get('/vendor/create', [VendorController::class, 'create']);
    Route::post('/vendor/create', [VendorController::class, 'store']);
    Route::get('/vendor/{id}/edit', [VendorController::class, 'edit']);
    Route::post('/vendor/{id}/edit', [VendorController::class, 'update']);

    Route::get('/category', [ServiceCategoryController::class, 'index']);
    Route::get('/category/create', [ServiceCategoryController::class, 'create']);
    Route::post('/category/create', [ServiceCategoryController::class, 'store']);
    Route::get('/category/{id}/edit', [ServiceCategoryController::class, 'edit']);
    Route::post('/category/{id}/edit', [ServiceCategoryController::class, 'update']);

    Route::get('/vendor-service', [ServiceController::class, 'index']);
    Route::get('/vendor-service/create', [ServiceController::class, 'create']);
    Route::post('/vendor-service/create', [ServiceController::class, 'store']);
    Route::get('/vendor-service/{id}/edit', [ServiceController::class, 'edit']);
    Route::post('/vendor-service/{id}/edit', [ServiceController::class, 'update']);
    
    Route::get('/order', [OrderController::class, 'index']);
    Route::get('/order/{id}/detail', [OrderController::class, 'detail']);
    
    Route::get('/package', [PackageController::class, 'index']);
    Route::get('/package/{id}/edit', [PackageController::class, 'edit']);
    Route::post('/package/{id}/edit', [PackageController::class, 'update']);

    Route::get('/logout', function () {
        auth()->guard('adminweb')->logout();
        return redirect('/login');
    });
});


Route::middleware(['guest:adminweb'])->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');

    Route::post('/login', [AuthController::class, 'handleLogin']);
});
