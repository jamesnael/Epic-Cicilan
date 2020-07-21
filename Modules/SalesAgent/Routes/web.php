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

Route::group(['namespace' => 'Agency'], function() {
	Route::get('agencies/table', 'AgencyController@table')->name('agencies.table');
	Route::get('agencies/{agency}/data', 'AgencyController@data')->name('agencies.data');
	Route::resource('agencies', 'AgencyController')->except(['show']);
});

Route::group(['namespace' => 'Sales'], function() {
	Route::get('sales/table', 'SalesController@table')->name('sales.table');
	Route::get('sales/{sales}/data', 'SalesController@data')->name('sales.data');
	Route::resource('sales', 'SalesController')->parameters(['sales' => 'sales'])->except(['show']);
});
