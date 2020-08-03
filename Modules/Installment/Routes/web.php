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

Route::group(['namespace' => 'Client'], function() {
	Route::get('client/table', 'ClientController@table')->name('client.table');
	Route::get('client/{client}/data', 'ClientController@data')->name('client.data');
	Route::resource('client', 'ClientController')->except(['show']);
});

Route::group(['namespace' => 'Booking'], function() {
	Route::get('booking/table', 'BookingController@table')->name('booking.table');
	Route::get('booking/{booking}/data', 'BookingController@data')->name('booking.data');
	Route::resource('booking', 'BookingController')->except(['show']);
});

Route::group(['namespace' => 'Unit'], function() {
	Route::get('unit/table', 'UnitController@table')->name('unit.table');
	Route::get('unit/{unit}/data', 'UnitController@data')->name('unit.data');
	Route::resource('unit', 'UnitController')->except(['show']);
});
