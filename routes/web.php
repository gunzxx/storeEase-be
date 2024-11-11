<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DetailServicePackageController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\JobDeskController;
use App\Http\Controllers\JobListController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderController2;
use App\Http\Controllers\OrderController3;
use App\Http\Controllers\OrderController4;
use App\Http\Controllers\OrderController5;
use App\Http\Controllers\OrderController6;
use App\Http\Controllers\OrderController7;
use App\Http\Controllers\OrderController8;
use App\Http\Controllers\OrderController9;
use App\Http\Controllers\PackageCategoryController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ServiceCategoryController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\VendorController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['auth:adminweb']], function () {
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

    // Route::get('/package', [PackageController::class, 'index']);
    // Route::get('/package/create', [PackageController::class, 'create']);
    // Route::post('/package/create', [PackageController::class, 'store']);
    // Route::get('/package/{id}/edit', [PackageController::class, 'edit']);
    // Route::post('/package/{id}/edit', [PackageController::class, 'update']);

    Route::get('/package-category', [PackageCategoryController::class, 'index']);
    Route::get('/package-category/create', [PackageCategoryController::class, 'create']);
    Route::post('/package-category/create', [PackageCategoryController::class, 'store']);
    Route::get('/package-category/{id}/edit', [PackageCategoryController::class, 'edit']);
    Route::post('/package-category/{id}/edit', [PackageCategoryController::class, 'update']);

    // Route::get('/package-detail', [DetailServicePackageController::class, 'index']);
    // Route::get('/package-detail/create', [DetailServicePackageController::class, 'create']);
    // Route::post('/package-detail/create', [DetailServicePackageController::class, 'store']);
    // Route::get('/package-detail/{id}/edit', [DetailServicePackageController::class, 'edit']);
    // Route::post('/package-detail/{id}/edit', [DetailServicePackageController::class, 'update']);

    Route::get('/order/list', [OrderController::class, 'index']);
    Route::get('/order/{orderId}/detail', [OrderController::class, 'detail']);
    Route::post('/order/{orderId}/to2', [OrderController2::class, 'to2']);
    Route::get('/order/{orderId}/first_meet', [OrderController2::class, 'uploadMeetingReport']);
    Route::post('/order/{orderId}/first_meet', [OrderController2::class, 'storeMeetingReport']);

    Route::get('/order/{orderId}/to3', [OrderController3::class, 'to3']);
    Route::get('/order/{orderId}/down_payment', [OrderController3::class, 'downPayment']);
    Route::post('/order/{orderId}/down_payment', [OrderController3::class, 'storeDownPayment']);
    Route::get('/order/{orderId}/invoice/down_payment', [OrderController3::class, 'invoiceDownPayment']);
    Route::post('/order/{orderId}/invoice/down_payment', [OrderController3::class, 'storeInvoiceDownPayment']);

    Route::get('/order/{uuid}/to4', [OrderController4::class, 'to4']);

    Route::get('/order/{orderId}/job-desk/{jobDeskId}', [JobListController::class, 'index']);
    Route::get('/order/{orderId}/job-desk/{jobDeskId}/create', [JobListController::class, 'create']);
    Route::post('/order/{orderId}/job-desk/{jobDeskId}/create', [JobListController::class, 'store']);
    Route::get('/order/{orderId}/job-desk/{jobDeskId}/job-list/{jobListId}', [JobListController::class, 'edit']);
    Route::post('/order/{orderId}/job-desk/{jobDeskId}/job-list/{jobListId}', [JobListController::class, 'updateName']);

    Route::get('/order/{orderId}/new-document', [DocumentController::class, 'create']);
    Route::post('/order/{orderId}/new-document', [DocumentController::class, 'store']);
    Route::get('/order/{orderId}/document/{documentId}', [DocumentController::class, 'edit']);
    Route::post('/order/{orderId}/document/{documentId}', [DocumentController::class, 'update']);

    Route::get('/order/{uuid}/to5', [OrderController5::class, 'to5']);
    Route::get('/order/{orderId}/final_payment', [OrderController5::class, 'finalPayment']);
    Route::post('/order/{orderId}/final_payment', [OrderController5::class, 'storeFinalPayment']);
    Route::get('/order/{orderId}/invoice/final_payment', [OrderController5::class, 'invoiceFinalPayment']);
    Route::post('/order/{orderId}/invoice/final_payment', [OrderController5::class, 'storeInvoiceFinalPayment']);

    Route::get('/order/{uuid}/to6', [OrderController6::class, 'to6']);

    Route::get('/order/{uuid}/to7', [OrderController7::class, 'to7']);

    Route::get('/order/{uuid}/to8', [OrderController8::class, 'to8']);

    Route::get('/order/{uuid}/to9', [OrderController9::class, 'to9']);

    Route::get('/tes', [TestController::class, 'test']);

    Route::get('/logout', function () {
        auth()->guard('adminweb')->logout();
        return redirect('/login');
    });
});


Route::middleware('guest:adminweb')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'handleLogin']);
});
