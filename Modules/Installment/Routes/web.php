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
	// Route::resource('client', 'ClientController')->except(['show']);

	Route::get('klien', 'ClientController@index')->name('client.index');
	Route::post('klien', 'ClientController@store')->name('client.store');
	Route::get('klien/table', 'ClientController@table')->name('client.table');
	Route::get('klien/tambah', 'ClientController@create')->name('client.create');
	Route::put('klien/{client}', 'ClientController@update')->name('client.update');
	Route::get('klien/{client}/data', 'ClientController@data')->name('client.data');
	Route::get('klien/{client}/ubah', 'ClientController@edit')->name('client.edit');
	Route::delete('klien/{client}', 'ClientController@destroy')->name('client.destroy');
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
	// Route::resource('installment', 'InstallementController')->except(['show','destroy']);

	Route::get('cicilan', 'InstallementController@index')->name('installment.index');
	Route::post('cicilan', 'InstallementController@store')->name('installment.store');
	Route::get('cicilan/table', 'InstallementController@table')->name('installment.table');
	Route::get('cicilan/tambah', 'InstallementController@create')->name('installment.create');
	Route::put('cicilan/{installment}', 'InstallementController@update')->name('installment.update');
	Route::get('cicilan/{installment}/data', 'InstallementController@data')->name('installment.data');
	Route::get('cicilan/{installment}/ubah', 'InstallementController@edit')->name('installment.edit');

	// Route::resource('installment-unit', 'InstallmentUnitController')->except(['destroy', 'create', 'store']);

	Route::get('cicilan-unit', 'InstallmentUnitController@index')->name('installment-unit.index');
	Route::get('cicilan-unit/table', 'InstallmentUnitController@table')->name('installment-unit.table');
	Route::get('cicilan-unit/{installment_unit}', 'InstallmentUnitController@show')->name('installment-unit.show');
	Route::put('cicilan-unit/{installment_unit}', 'InstallmentUnitController@update')->name('installment-unit.update');
	Route::get('cicilan-unit/{installment_unit}/data', 'InstallmentUnitController@data')->name('installment-unit.data');
	Route::get('cicilan-unit/{installment_unit}/ubah', 'InstallmentUnitController@edit')->name('installment-unit.edit');
	
	Route::put('cicilan-unit/{installment_unit}/{payment}/paid', 'InstallmentUnitController@payment')->name('manual-payment');
});

Route::group(['namespace' => 'PPJB'], function() {
	Route::get('PPJB/table', 'PPJBController@table')->name('PPJB.table');
	Route::get('PPJB/pendingtable', 'PPJBController@pendingtable')->name('PPJB.pendingtable');
	Route::get('PPJB/{PPJB}/data', 'PPJBController@data')->name('PPJB.data');
	Route::resource('PPJB', 'PPJBController')->except(['show']);
	// Route::resource('PPJB', 'PPJBController')->except(['show']);

	Route::get('ppjb', 'PPJBController@index')->name('PPJB.index');
	Route::post('ppjb', 'PPJBController@store')->name('PPJB.store');
	Route::get('ppjb/table', 'PPJBController@table')->name('PPJB.table');
	Route::get('ppjb/tambah', 'PPJBController@create')->name('PPJB.create');
	Route::put('ppjb/{PPJB}', 'PPJBController@update')->name('PPJB.update');
	Route::get('ppjb/{PPJB}/data', 'PPJBController@data')->name('PPJB.data');
	Route::get('ppjb/{PPJB}/ubah', 'PPJBController@edit')->name('PPJB.edit');
	Route::delete('ppjb/{PPJB}', 'PPJBController@destroy')->name('PPJB.destroy');
});

Route::group(['namespace' => 'Akad'], function() {
	Route::get('akad/table', 'AkadController@table')->name('akad.table');
	Route::get('akad/{akad}/data', 'AkadController@data')->name('akad.data');
	Route::get('akad/table-approved', 'AkadController@tableApproved')->name('akad.table.approved');
	Route::resource('akad', 'AkadController')->except(['show','destroy', 'create', 'store']);
});

Route::group(['namespace' => 'Ajb'], function() {
	Route::get('ajb/table', 'AjbController@table')->name('ajb.table');
	Route::get('ajb/{ajb}/data', 'AjbController@data')->name('ajb.data');
	Route::get('ajb/table-approved', 'AjbController@tableApproved')->name('ajb.table.approved');
	Route::resource('ajb', 'AjbController')->except(['show','destroy', 'create', 'store']);
});

Route::group(['namespace' => 'HandOver'], function() {
	// Route::resource('handover', 'HandOverController')->except(['show']);

	Route::get('serah-terima', 'HandOverController@index')->name('handover.index');
	Route::post('serah-terima', 'HandOverController@store')->name('handover.store');
	Route::get('serah-terima/table', 'HandOverController@table')->name('handover.table');
	Route::get('serah-terima/tambah', 'HandOverController@create')->name('handover.create');
	Route::put('serah-terima/{handover}', 'HandOverController@update')->name('handover.update');
	Route::get('serah-terima/{handover}/data', 'HandOverController@data')->name('handover.data');
	Route::get('serah-terima/{handover}/ubah', 'HandOverController@edit')->name('handover.edit');
	Route::delete('serah-terima/{handover}', 'HandOverController@destroy')->name('handover.destroy');
	Route::get('serah-terima/table', 'HandOverController@table')->name('handover.table');
	Route::get('serah-terima/table-approved', 'HandOverController@tableApproved')->name('handover.table.approved');
});

Route::group(['namespace' => 'PaymentType'], function() {
	Route::get('PaymentType/table', 'PaymentTypeController@table')->name('PaymentType.table');
	Route::get('PaymentType/{PaymentType}/data', 'PaymentTypeController@data')->name('PaymentType.data');
	Route::resource('PaymentType', 'PaymentTypeController')->except(['show']);
});

Route::group(['namespace' => 'Spr'], function() {
	Route::get('spr/table', 'SprController@table')->name('spr.table');
	Route::get('spr/table-approved', 'SprController@tableApproved')->name('spr.table.approved');
	Route::get('spr/{spr}/data', 'SprController@data')->name('spr.data');
	Route::resource('spr', 'SprController')->except(['show']);
});
