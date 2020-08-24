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
	Route::get('commission/table', 'CommissionController@table')->name('commission.table');
	Route::get('commission/{commission}/data', 'CommissionController@data')->name('commission.data');
	Route::resource('commission', 'CommissionController')->except(['show']);
});