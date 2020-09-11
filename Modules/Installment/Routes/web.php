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
	Route::resource('booking', 'BookingController');
});

Route::group(['namespace' => 'Unit'], function() {
	Route::get('unit/table', 'UnitController@table')->name('unit.table');
	Route::get('unit/{unit}/data', 'UnitController@data')->name('unit.data');
	Route::resource('unit', 'UnitController')->except(['show']);
});

Route::group(['namespace' => 'Installment'], function() {
	Route::get('installment/table', 'InstallementController@table')->name('installment.table');
	Route::get('installment/{installment}/data', 'InstallementController@data')->name('installment.data');
	Route::resource('installment', 'InstallementController')->except(['show','destroy']);

	Route::get('installment-unit/table', 'InstallmentUnitController@table')->name('installment-unit.table');
	Route::get('installment-unit/{installment_unit}/data', 'InstallmentUnitController@data')->name('installment-unit.data');
	Route::resource('installment-unit', 'InstallmentUnitController')->except(['destroy', 'create', 'store']);
});

Route::group(['namespace' => 'PPJB'], function() {
	Route::get('PPJB/table', 'PPJBController@table')->name('PPJB.table');
	Route::get('PPJB/pendingtable', 'PPJBController@pendingtable')->name('PPJB.pendingtable');
	Route::get('PPJB/{PPJB}/data', 'PPJBController@data')->name('PPJB.data');
	Route::resource('PPJB', 'PPJBController')->except(['show']);
});

Route::group(['namespace' => 'Akad'], function() {
	Route::get('akad/table', 'AkadController@table')->name('akad.table');
	Route::get('akad/{akad}/data', 'AkadController@data')->name('akad.data');
	Route::resource('akad', 'AkadController')->except(['show','destroy', 'create', 'store']);
});

Route::group(['namespace' => 'Ajb'], function() {
	Route::get('ajb/table', 'AjbController@table')->name('ajb.table');
	Route::get('ajb/{ajb}/data', 'AjbController@data')->name('ajb.data');
	Route::resource('ajb', 'AjbController')->except(['show','destroy', 'create', 'store']);
});

Route::group(['namespace' => 'HandOver'], function() {
	Route::get('handover/table', 'HandOverController@table')->name('handover.table');
	Route::get('handover/{handover}/data', 'HandOverController@data')->name('handover.data');
	Route::resource('handover', 'HandOverController')->except(['show']);
});

Route::group(['namespace' => 'PaymentType'], function() {
	Route::get('PaymentType/table', 'PaymentTypeController@table')->name('PaymentType.table');
	Route::get('PaymentType/{PaymentType}/data', 'PaymentTypeController@data')->name('PaymentType.data');
	Route::resource('PaymentType', 'PaymentTypeController')->except(['show']);
});

Route::group(['namespace' => 'Spr'], function() {
	Route::get('spr/table', 'SprController@table')->name('spr.table');
	Route::get('spr/{spr}/data', 'SprController@data')->name('spr.data');
	Route::resource('spr', 'SprController')->except(['show']);
});
