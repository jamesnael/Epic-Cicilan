<?php

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

Route::group(['namespace' => 'Commission'], function() {
	// Route::resource('commission', 'CommissionController')->except(['show']);

	Route::get('komisi', 'CommissionController@index')->name('commission.index');
	Route::post('komisi', 'CommissionController@store')->name('commission.store');
	Route::get('komisi/table', 'CommissionController@table')->name('commission.table');
	Route::get('komisi/tambah', 'CommissionController@create')->name('commission.create');
	Route::get('komisi/{commission}/data', 'CommissionController@data')->name('commission.data');
	Route::put('komisi/{commission}', 'CommissionController@update')->name('commission.update');
	Route::get('komisi/{commission}/ubah', 'CommissionController@edit')->name('commission.edit');
	Route::delete('komisi/{commission}', 'CommissionController@destroy')->name('commission.destroy');
});

Route::group(['namespace' => 'Sales'], function() {
	// Route::resource('salescommission', 'SalesCommissionController')->except(['show']);

	Route::get('komisi-sales', 'SalesCommissionController@index')->name('salescommission.index');
	Route::post('komisi-sales', 'SalesCommissionController@store')->name('salescommission.store');
	Route::get('komisi-sales/table', 'SalesCommissionController@table')->name('salescommission.table');
	Route::get('komisi-sales/table/korwil', 'SalesCommissionController@tableKorwil')->name('salescommission.table.korwil');
	Route::get('komisi-sales/table/korut', 'SalesCommissionController@tableKorut')->name('salescommission.table.korut');
	Route::get('komisi-sales/table/closingfee', 'SalesCommissionController@tableClosingFee')->name('salescommission.table.closingfee');
	Route::get('komisi-sales/tambah', 'SalesCommissionController@create')->name('salescommission.create');
	Route::get('komisi-sales/{salescommission}/data', 'SalesCommissionController@data')->name('salescommission.data');
	Route::put('komisi-sales/{salescommission}', 'SalesCommissionController@update')->name('salescommission.update');
	Route::get('komisi-sales/{salescommission}/ubah', 'SalesCommissionController@edit')->name('salescommission.edit');
	Route::get('komisi-sales/{salescommission}/ubah-korwil', 'SalesCommissionController@editKorwil')->name('salescommission.edit.korwil');
	Route::get('komisi-sales/{salescommission}/ubah-korut', 'SalesCommissionController@editKorut')->name('salescommission.edit.korut');
	Route::get('komisi-sales/{salescommission}/ubah-closingfee', 'SalesCommissionController@editClosingFee')->name('salescommission.edit.closingfee');
	Route::delete('komisi-sales/{salescommission}', 'SalesCommissionController@destroy')->name('salescommission.destroy');
});