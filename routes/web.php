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
	Route::get('/expense_categories', 'Master\ExpenseCategoryController@index');
});



Route::group(['prefix' => 'sales'], function() {
	Route::prefix('sales_consignments')->group(function() {
		Route::get('/', 'Sales\SalesConsignmentController@index')->name('sales.consignment.index');
		Route::get('/create', 'Sales\SalesConsignmentController@create')->name('sales.consignment.create');
		Route::get('/edit/{id}', 'Sales\SalesConsignmentController@edit')->name('sales.consignment.edit');
	});
	Route::get('/sales_returns');
	
	Route::get('/pos', 'Sales\SaleController@pos')->name('sales.pos');
	
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
	Route::prefix('purchase_orders')->group(function(){
		Route::get('', 'Purchase\PurchaseOrderController@index')->name('purchase_order.index');
		Route::get('/create', 'Purchase\PurchaseOrderController@create')->name('purchase_order.create');
		Route::get('/edit/{id}', 'Purchase\PurchaseOrderController@edit')->name('purchase_order.edit');
	});
	Route::get('/purchase_invoices');
});

Route::group(['prefix' => 'inventory'], function() {
	Route::prefix('stock_opnames')->group(function(){
		Route::get('', 'Inventory\StockOpnameController@index')->name('stock_opname.index');
		Route::get('/create', 'Inventory\StockOpnameController@create')->name('stock_opname.create');
		Route::get('/edit/{id}', 'Inventory\StockOpnameController@edit')->name('stock_opname.edit');
	});
});

Route::group(['prefix' => 'debt_receivable'], function() {
	Route::get('/receivables');
	Route::get('/debts');
});

Route::group(['prefix' => 'production'], function() {
	Route::get('', 'Production\ProductionController@index')->name('production.index');
	Route::get('/create', 'Production\ProductionController@create')->name('production.create');
	Route::get('/edit/{id}', 'Production\ProductionController@edit')->name('production.edit');
});

Route::prefix('expense')->group(function(){
	Route::get('/', 'Expense\ExpenseController@index')->name('expense.index');
	Route::get('/create', 'Expense\ExpenseController@create')->name('expense.create');
	Route::get('/edit/{id}', 'Expense\ExpenseController@edit')->name('expense.edit');
});

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