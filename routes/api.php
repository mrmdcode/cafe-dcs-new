<?php

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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/orders/{order}', [\App\Http\Controllers\API\Company\OrderController::class, 'show'])->name('company.orders.show');
    Route::get('/printer/cashier-data', [\App\Http\Controllers\API\Company\PrinterController::class, 'getCashierPrinter'])->name('company.printer.cashier.data');
    Route::get('/printer/certificate', [\App\Http\Controllers\API\Company\PrinterController::class, 'certificate'])->name('company.printer.certificate');
});

Route::get('/{company}', [\App\Http\Controllers\API\APIServiceMenuController::class, 'ln']);
Route::get('/{company}/menu', [\App\Http\Controllers\API\APIServiceMenuController::class, 'menus']);
