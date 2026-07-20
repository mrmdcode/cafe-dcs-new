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

Route::middleware('auth:sanctum')->prefix('company')->name('company.')->group(function () {
    Route::get('/orders/{order}', [\App\Http\Controllers\API\Company\OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/paying/{order}', [\App\Http\Controllers\API\Company\OrderController::class, 'paying']);
    Route::post('/orders/finish/{order}', [\App\Http\Controllers\API\Company\OrderController::class, 'finish']);
    Route::post('/orders/cancel/{order}', [\App\Http\Controllers\API\Company\OrderController::class, 'cancel']);
    Route::get('/printer/cashier-data', [\App\Http\Controllers\API\Company\PrinterController::class, 'getCashierPrinter'])->name('printer.cashier.data');
    Route::get('/printer/certificate', [\App\Http\Controllers\API\Company\PrinterController::class, 'certificate'])->name('printer.certificate');
    Route::get('/menu/{menu}/items', [\App\Http\Controllers\API\Company\MenuController::class, 'getMenuItems'])->name('menu.items');
});

Route::get('/{company}', [\App\Http\Controllers\API\APIServiceMenuController::class, 'ln']);
Route::get('/{company}/menu', [\App\Http\Controllers\API\APIServiceMenuController::class, 'menus']);
