<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', 'Auth\LoginController@index');
Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/', 'Dashboard\DashboardController@index');

Route::group(['prefix' => 'master'], function() {
	Route::get('/payment_methods', 'Master\paymentMethodController@index');
	Route::get('/raw_materials', 'Master\RawMaterialController@index');
	Route::get('/customers', 'Master\CustomerController@index');
	Route::get('/categories', 'Master\CategoryController@index');
	Route::get('/store_consignments', 'Master\StoreConsignmentController@index');
	Route::get('/products', 'Master\ProductController@index');
	Route::get('/suppliers', 'Master\SupplierController@index');
	Route::get('/sellers', 'Master\SellerController@index');
	Route::get('/cash_registers', 'Master\CashRegisterController@index');
	Route::get('/cake_types', 'Master\CakeTypeController@index');
	Route::get('/stores', 'Master\StoreController@index');
	Route::get('/cake_variants', 'Master\CakeVariantController@index');
	Route::get('/divisions', 'Master\DivisionController@index');
	Route::get('/units', 'Master\UnitController@index');
});

Route::group(['prefix' => 'sales'], function() {
	Route::get('/sales_consignments');
	Route::get('/sales_returns');

	Route::prefix('sales')->group(function(){
		Route::get('/', 'Sales\SaleController@index')->name('sales.index');
		Route::get('/create', 'Sales\SaleController@create')->name('sales.create');
		Route::get('/edit/{id}', 'Sales\SaleController@edit')->name('sales.edit');
	});

	Route::prefix('custom_orders')->group(function(){
		Route::get('/', 'Sales\CustomOrderController@index')->name('custom.order.index');
		Route::get('/create', 'Sales\CustomOrderController@create')->name('custom.order.create');
		Route::get('/edit/{id}', 'Sales\CustomOrderController@edit')->name('custom.order.edit');
	});
});

Route::group(['prefix' => 'purchase'], function() {
	Route::get('/purchase_returns');
	Route::get('/purchase_orders');
	Route::get('/purchase_invoices');
});

Route::group(['prefix' => 'debt_receivable'], function() {
	Route::get('/receivables');
	Route::get('/debts');
});

Route::get('expense');
Route::get('production');

Route::group(['prefix' => 'report'], function() {
	Route::get('/receivables');
	Route::get('/purchase_returns');
	Route::get('/sales_returns');
	Route::get('/purchase');
	Route::get('/debts');
	Route::get('/sales');
});

Route::group(['prefix' => 'setting'], function() {
	Route::get('/users', 'Setting\UserController@index');
	Route::get('/permissions', 'Setting\PermissionController@index');
	Route::get('/roles', 'Setting\RoleController@index');
});