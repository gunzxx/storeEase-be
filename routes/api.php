<?php

use App\Http\Controllers\api\admin\AdminController;
use App\Http\Controllers\api\auth\AuthAdminController;
use App\Http\Controllers\api\auth\AuthCustomerController;
use App\Http\Controllers\api\auth\AuthVendorController;
use App\Http\Controllers\api\product\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\VendorController;
use Illuminate\Support\Facades\Route;


Route::prefix('auth')->group(function(){
    Route::prefix('admin')->group(function(){
        Route::post('login', [AuthAdminController::class, 'login']);
        Route::post('register', [AuthAdminController::class, 'register']);
    });
    Route::prefix('vendor')->group(function(){
        Route::post('login', [AuthVendorController::class, 'login']);
        Route::post('register', [AuthVendorController::class, 'register']);
    });
    Route::prefix('customer')->group(function(){
        Route::post('login', [AuthCustomerController::class, 'login']);
        Route::post('register', [AuthCustomerController::class, 'register']);
    });
});


Route::prefix('admin')->group(function(){
    Route::get('/', [AdminController::class, 'index']);
});

Route::prefix('product')->group(function(){
    Route::get('/', [ProductController::class, 'index']);
    Route::post('/', [ProductController::class, 'create']);
    Route::put('/', [ProductController::class, 'update']);
    Route::delete('/', [ProductController::class, 'delete']);
});




/**
 * Route for web only
 */
Route::middleware(['admin'])->group(function(){
    Route::delete('/customer/{id}', [CustomerController::class, 'delete']);
    Route::delete('/vendor/{id}', [VendorController::class, 'delete']);
    Route::delete('/category/{id}', [CategoryController::class, 'delete']);
    Route::delete('/product/{id}', [App\Http\Controllers\ProductController::class, 'delete']);
    Route::delete('/order/{id}', [App\Http\Controllers\OrderController::class, 'delete']);
    Route::delete('/package/{id}', [App\Http\Controllers\PackageController::class, 'delete']);
});