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

Route::prefix('pembayaran')->name('pembayaran.')->group(function() {
	Route::prefix('cicilan')->name('cicilan.')->group(function() {
	    Route::get('{booking}', 'PaymentController@index')->name('index');
	    Route::get('{booking}/data', 'PaymentController@data')->name('data');
	});
});
