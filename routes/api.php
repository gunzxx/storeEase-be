<?php

use App\Http\Controllers\api\auth\AuthAdminController;
use App\Http\Controllers\api\auth\AuthCustomerController;
use App\Http\Controllers\api\auth\AuthVendorController;
use Illuminate\Http\Request;
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