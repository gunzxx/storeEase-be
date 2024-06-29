<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth:adminweb', 'adminweb'])->group(function () {
    Route::get('/', [AdminController::class, 'index']);
    Route::post('/', [AdminController::class, 'update']);

    Route::get('/customer', [CustomerController::class, 'index']);
    
    Route::get('/logout', function () {
        auth()->guard('adminweb')->logout();
        return redirect('/login');
    });
});


Route::middleware(['guest:adminweb'])->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');

    Route::post('/login', [AuthController::class, 'handleLogin']);
});
