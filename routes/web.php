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
	Route::get('/payment_methods', 'Master\PaymentMethodController@index');
	Route::get('/raw_materials', 'Master\RawMaterialController@index');
	Route::get('/customers', 'Master\CustomerController@index');
	Route::get('/categories', 'Master\CategoryController@index');
	Route::get('/store_consignments', 'Master\StoreConsignmentController@index');
	Route::prefix('products')->group(function(){
		Route::get('/', 'Master\ProductController@index')->name('product.index');
		Route::get('/create', 'Master\ProductController@create')->name('product.create');
		Route::get('/edit/{id}', 'Master\ProductController@edit')->name('product.edit');
	});
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
	Route::prefix('sales_returns')->group(function(){
		Route::get('', 'Sales\SalesReturnController@index')->name('sales_return.index');
		Route::get('/create', 'Sales\SalesReturnController@create')->name('sales_return.create');
		Route::get('/edit/{id}', 'Sales\SalesReturnController@edit')->name('sales_return.edit');
	});
	
	Route::get('/pos', 'Sales\SaleController@pos')->name('sales.pos');
	Route::get('/pos/print/{sales_id}', 'Sales\SaleController@print')->name('sales.print');
	
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
		Route::get('/receipt/{id}', 'Purchase\PurchaseOrderController@receipt')->name('purchase_order.receipt');
	});
	Route::prefix('purchase_returns')->group(function(){
		Route::get('', 'Purchase\PurchaseReturnController@index')->name('purchase_return.index');
		Route::get('/create', 'Purchase\PurchaseReturnController@create')->name('purchase_return.create');
		Route::get('/edit/{id}', 'Purchase\PurchaseReturnController@edit')->name('purchase_return.edit');
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
	Route::get('/receivables', 'DebtReceivable\ReceivableController@index');
	Route::get('/debts', 'DebtReceivable\DebtController@index');
});

Route::group(['prefix' => 'production'], function() {
	Route::get('', 'Production\ProductionController@index')->name('production.index');
	Route::get('/create', 'Production\ProductionController@create')->name('production.create');
	Route::get('/edit/{id}', 'Production\ProductionController@edit')->name('production.edit');
});

Route::prefix('expense')->group(function() {
	Route::get('/', 'Expense\ExpenseController@index')->name('expense.index');
	Route::get('/create', 'Expense\ExpenseController@create')->name('expense.create');
	Route::get('/edit/{id}', 'Expense\ExpenseController@edit')->name('expense.edit');
});

Route::group(['prefix' => 'report'], function() {
	Route::get('/receivables', 'Report\ReceivableController@index');
	Route::get('/purchase_returns', 'Report\PurchaseReturnController@index');
	Route::get('/sales_returns', 'Report\SalesReturnController@index');
	Route::get('/purchase', 'Report\PurchaseController@index');
	Route::get('/debts', 'Report\DebtController@index');
	Route::get('/sales', 'Report\SaleController@index');
	Route::get('/costs', 'Report\ExpenseController@index');
	Route::get('/profit_loss', 'Report\ProfitLossController@index');
	Route::get('/payments', 'Report\PaymentController@index');
	Route::get('/ledger_receivables', 'Report\LedgerController@receivable');
	Route::get('/ledger_debts', 'Report\LedgerController@debt');
});

Route::group(['prefix' => 'setting'], function() {
	Route::get('/users', 'Setting\UserController@index');
	Route::get('/permissions', 'Setting\PermissionController@index');
	Route::get('/roles', 'Setting\RoleController@index');
});