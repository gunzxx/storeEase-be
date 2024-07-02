<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VendorController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth:adminweb', 'adminweb'])->group(function () {
    Route::get('/', [AdminController::class, 'index']);
    Route::post('/', [AdminController::class, 'update']);

    Route::get('/customer', [CustomerController::class, 'index']);
    Route::get('/customer/{id}/edit', [CustomerController::class, 'edit']);
    Route::post('/customer/{id}/edit', [CustomerController::class, 'update']);

    Route::get('/vendor', [VendorController::class, 'index']);
    Route::get('/vendor/{id}/edit', [VendorController::class, 'edit']);
    Route::post('/vendor/{id}/edit', [VendorController::class, 'update']);

    Route::get('/category', [CategoryController::class, 'index']);
    Route::get('/category/create', [CategoryController::class, 'create']);
    Route::post('/category/create', [CategoryController::class, 'store']);
    Route::get('/category/{id}/edit', [CategoryController::class, 'edit']);
    Route::post('/category/{id}/edit', [CategoryController::class, 'update']);

    Route::get('/product', [ProductController::class, 'index']);
    Route::get('/product/{id}/edit', [ProductController::class, 'edit']);
    Route::post('/product/{id}/edit', [ProductController::class, 'update']);
    
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
