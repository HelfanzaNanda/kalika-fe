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
	Route::get('/payment_methods');
	Route::get('/raw_materials');
	Route::get('/customers');
	Route::get('/categories');
	Route::get('/store_consignments');
	Route::get('/products');
	Route::get('/suppliers');
	Route::get('/sellers');
	Route::get('/cash_registers');
	Route::get('/cake_types');
	Route::get('/stores');
	Route::get('/cake_variants');
	Route::get('/divisions');
});

Route::group(['prefix' => 'sales'], function() {
	Route::get('/sales_consignments');
	Route::get('/sales_returns');
	Route::get('/sales');
	Route::get('/custom_orders');
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
	Route::get('/users');
	Route::get('/permissions');
	Route::get('/roles');
});