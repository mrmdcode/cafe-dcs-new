<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
//    event(new \App\Events\order_registration('don_club',[],11));
    return view('home.index');
//    \App\Events\order_registration::broadcast('don_club',['sdsd','sdsdsd'],11);
});
Route::post('/con', function (\Illuminate\Support\Facades\Request $request) {
    return $request->all();
})->name('home.contact_us');
Route::post('/subscribe_mail', function (\Illuminate\Support\Facades\Request $request) {
    return $request->all();
})->name('home.subscribe_mail');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::prefix('admin')->middleware(['auth', 'checkAdmin'])->group(function () {
    Route::get('/', [\App\Http\Controllers\AdminActionController::class, 'dashboard'])->name('admin.dashboard');
    Route::resource('companies', \App\Http\Controllers\AdminCompanyActionController::class);
    Route::get('companies/{company}/active', [\App\Http\Controllers\AdminCompanyActionController::class, 'active'])->name('companies.active');
    Route::get('companies/{company}/de_active', [\App\Http\Controllers\AdminCompanyActionController::class, 'de_active'])->name('companies.de_active');

});
Route::prefix('company')->middleware(['auth', 'checkCompanyManager'])->group(function () {
    Route::get('/', [\App\Http\Controllers\Company\ManagerActionController::class, 'dashboard'])->name('company.manager.dashboard');
    Route::resource('employee', \App\Http\Controllers\Company\ManagerEmployeeController::class)->names('company.employee');
    Route::get('employee/{employee}/de_suspension', [\App\Http\Controllers\Company\ManagerEmployeeController::class, 'de_suspension'])->name('company.employee.de_suspension');
    Route::get('employee/{employee}/dismissal', [\App\Http\Controllers\Company\ManagerEmployeeController::class, 'dismissal'])->name('company.employee.dismissal');
    Route::get('employee/{employee}/suspension', [\App\Http\Controllers\Company\ManagerEmployeeController::class, 'suspension'])->name('company.employee.suspension');
    Route::apiResource('category', \App\Http\Controllers\Company\ManagerCategoryController::class)->names('company.category');
    Route::apiResource('menu', \App\Http\Controllers\Company\ManagerMenuController::class)->names('company.menu');
    Route::get('menu/{menu}/sor_hide', [\App\Http\Controllers\Company\ManagerMenuController::class, 'sor_hide'])->name('company.menu.sor_hide');
    Route::get('menu/{menu}/sor_show', [\App\Http\Controllers\Company\ManagerMenuController::class, 'sor_show'])->name('company.menu.sor_show');
    Route::get('menu/{menu}/sc_hide', [\App\Http\Controllers\Company\ManagerMenuController::class, 'sc_hide'])->name('company.menu.sc_hide');
    Route::get('menu/{menu}/sc_show', [\App\Http\Controllers\Company\ManagerMenuController::class, 'sc_show'])->name('company.menu.sc_show');
    Route::apiResource('menu_item', \App\Http\Controllers\Company\ManagerMenuItemController::class)->names('company.menu_item');
    Route::get('menu_item/{menu_item}/sor_hide', [\App\Http\Controllers\Company\ManagerMenuItemController::class, 'sor_hide'])->name('company.menu_item.sor_hide');
    Route::get('menu_item/{menu_item}/sor_show', [\App\Http\Controllers\Company\ManagerMenuItemController::class, 'sor_show'])->name('company.menu_item.sor_show');
    Route::get('menu_item/{menu_item}/sc_hide', [\App\Http\Controllers\Company\ManagerMenuItemController::class, 'sc_hide'])->name('company.menu_item.sc_hide');
    Route::get('menu_item/{menu_item}/sc_show', [\App\Http\Controllers\Company\ManagerMenuItemController::class, 'sc_show'])->name('company.menu_item.sc_show');
    Route::get('menu_item/{menu_item}/de_active', [\App\Http\Controllers\Company\ManagerMenuItemController::class, 'de_active'])->name('company.menu_item.de_active');
    Route::get('menu_item/{menu_item}/active', [\App\Http\Controllers\Company\ManagerMenuItemController::class, 'active'])->name('company.menu_item.active');
    Route::apiResource('printer', \App\Http\Controllers\Company\ManagerPrinterController::class)->names('company.printer');
    Route::apiResource('table', \App\Http\Controllers\Company\ManagerTableController::class)->names('company.table');
    Route::post('/orders/indexData/', [\App\Http\Controllers\Company\ManagerOrderController::class, 'indexData'])->name('company.order.index.data');
    Route::get('/orders/init_modal', [\App\Http\Controllers\Company\ManagerOrderController::class, 'init_modal'])->name('company.order.index.data');
    Route::get('/orders/tables-menus', [\App\Http\Controllers\Company\ManagerOrderController::class, 'getTablesAndMenus'])->name('company.order.tables-menus');
    Route::get('/orders/edit/{id}-{unique_key}', [\App\Http\Controllers\Company\ManagerOrderController::class, 'edit'])->name('company.order.eddit');
    Route::get('/orders/view/{id}-{unique_key}', [\App\Http\Controllers\Company\ManagerOrderController::class, 'show'])->name('company.order.eddit');
    Route::post('/orders/padding/{id}-{unique_key}', [\App\Http\Controllers\Company\ManagerOrderController::class, 'paidding'])->name('company.order.eddit');
    Route::post('/orders/finishing/{id}-{unique_key}', [\App\Http\Controllers\Company\ManagerOrderController::class, 'finishing'])->name('company.order.eddit');
    Route::apiResource('/orders', \App\Http\Controllers\Company\ManagerOrderController::class)->names('company.order');
    Route::get('/orders/{id}/{unique_key}/factor', [\App\Http\Controllers\Company\ManagerOrderController::class, 'showFactor'])->name('company.orders.factor');
});
Route::prefix('cashier')->middleware(['auth', 'checkCashier'])->group(function () {
    Route::get('/', [\App\Http\Controllers\Company\CashierActionController::class, 'dashboard'])->name('company.cashier.dashboard');
    Route::post('/orders/indexData/', [\App\Http\Controllers\Company\CashierOrderController::class, 'indexData'])->name('company.cashier.order.index.data');
    Route::get('/orders/init_modal', [\App\Http\Controllers\Company\CashierOrderController::class, 'init_modal'])->name('company.cashier.order.index.data');
    Route::get('/orders/edit/{id}-{unique_key}', [\App\Http\Controllers\Company\CashierOrderController::class, 'edit'])->name('company.cashier.order.eddit');
    Route::get('/orders/view/{id}-{unique_key}', [\App\Http\Controllers\Company\CashierOrderController::class, 'show'])->name('company.cashier.order.eddit');
    Route::post('/orders/padding/{id}-{unique_key}', [\App\Http\Controllers\Company\CashierOrderController::class, 'paidding'])->name('company.cashier.order.eddit');
    Route::post('/orders/finishing/{id}-{unique_key}', [\App\Http\Controllers\Company\CashierOrderController::class, 'finishing'])->name('company.cashier.order.eddit');
    Route::apiResource('/orders', \App\Http\Controllers\Company\CashierOrderController::class)->names('company.cashier.order');
});
Route::prefix('order_recipient')->middleware(['auth', 'OrderRecipient'])->group(function () {
    Route::get('/', [\App\Http\Controllers\Company\OrderRecipientActionController::class, 'dashboard'])->name('company.order_recipient.dashboard');
    Route::post('/', [\App\Http\Controllers\Company\OrderRecipientActionController::class, 'store'])->name('company.order_recipient.store');
    Route::get('/indexData', [\App\Http\Controllers\Company\OrderRecipientActionController::class, 'indexData'])->name('company.order_recipient.data');
    Route::get('/{id}', [\App\Http\Controllers\Company\OrderRecipientActionController::class, 'edit'])->name('company.order_recipient.edit');
    Route::post('/update/{id}-{unique_key}', [\App\Http\Controllers\Company\OrderRecipientActionController::class, 'update'])->name('company.order_recipient.edit');
    Route::post('/subscription_code', [\App\Http\Controllers\Company\OrderRecipientActionController::class, 'subscription_code'])->name('company.order_recipient.edit');
});
Route::get('/{company_username}/check_order/{order_id}-{order_unique_key}', [\App\Http\Controllers\SiteLayoutsController::class, 'check_order'])->name('user.check_order');
