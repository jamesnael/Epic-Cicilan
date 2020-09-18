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
	// Route::resource('agencies', 'AgencyController')->except(['show']);

	Route::get('sub-agent', 'AgencyController@index')->name('agencies.index');
	Route::post('sub-agent', 'AgencyController@store')->name('agencies.store');
	Route::get('sub-agent/table', 'AgencyController@table')->name('agencies.table');
	Route::get('sub-agent/tambah', 'AgencyController@create')->name('agencies.create');
	Route::put('sub-agent/{agency}', 'AgencyController@update')->name('agencies.update');
	Route::get('sub-agent/{agency}/data', 'AgencyController@data')->name('agencies.data');
	Route::get('sub-agent/{agency}/ubah', 'AgencyController@edit')->name('agencies.edit');
	Route::delete('sub-agent/{agency}', 'AgencyController@destroy')->name('agencies.destroy');
});

Route::group(['namespace' => 'Sales'], function() {
	Route::get('sales/table', 'SalesController@table')->name('sales.table');
	Route::get('sales/{sales}/data', 'SalesController@data')->name('sales.data');
	Route::resource('sales', 'SalesController')->parameters(['sales' => 'sales'])->except(['show']);
});

Route::group(['namespace' => 'RegionalCoordinator'], function() {
	// Route::get('regional-coordinator/table', 'RegionalCoordinatorController@table')->name('regional-coordinator.table');
	// Route::get('regional-coordinator/{regional_coordinator}/data', 'RegionalCoordinatorController@data')->name('regional-coordinator.data');
	// Route::resource('regional-coordinator', 'RegionalCoordinatorController')->parameters(['regional-coordinator' => 'regional-coordinator'])->except(['show']);

	Route::get('koodinator-wilayah', 'RegionalCoordinatorController@index')->name('regional-coordinator.index');
	Route::post('koodinator-wilayah', 'RegionalCoordinatorController@store')->name('regional-coordinator.store');
	Route::get('koodinator-wilayah/table', 'RegionalCoordinatorController@table')->name('regional-coordinator.table');
	Route::get('koodinator-wilayah/tambah', 'RegionalCoordinatorController@create')->name('regional-coordinator.create');
	Route::put('koodinator-wilayah/{regional_coordinator}', 'RegionalCoordinatorController@update')->name('regional-coordinator.update');
	Route::get('koodinator-wilayah/{regional_coordinator}/data', 'RegionalCoordinatorController@data')->name('regional-coordinator.data');
	Route::get('koodinator-wilayah/{regional_coordinator}/ubah', 'RegionalCoordinatorController@edit')->name('regional-coordinator.edit');
	Route::delete('koodinator-wilayah/{regional_coordinator}', 'RegionalCoordinatorController@destroy')->name('regional-coordinator.destroy');
});

Route::group(['namespace' => 'MainCoordinator'], function() {
	// Route::get('main-coordinator/table', 'MainCoordinatorController@table')->name('main-coordinator.table');
	// Route::get('main-coordinator/{main_coordinator}/data', 'MainCoordinatorController@data')->name('main-coordinator.data');
	// Route::resource('main-coordinator', 'MainCoordinatorController')->parameters(['main-coordinator' => 'main-coordinator'])->except(['show']);

	Route::get('koordinator-utama', 'MainCoordinatorController@index')->name('main-coordinator.index');
	Route::post('koordinator-utama', 'MainCoordinatorController@store')->name('main-coordinator.store');
	Route::get('koordinator-utama/table', 'MainCoordinatorController@table')->name('main-coordinator.table');
	Route::get('koordinator-utama/tambah', 'MainCoordinatorController@create')->name('main-coordinator.create');
	Route::put('koordinator-utama/{main_coordinator}', 'MainCoordinatorController@update')->name('main-coordinator.update');
	Route::get('koordinator-utama/{main_coordinator}/data', 'MainCoordinatorController@data')->name('main-coordinator.data');
	Route::get('koordinator-utama/{main_coordinator}/ubah', 'MainCoordinatorController@edit')->name('main-coordinator.edit');
	Route::delete('koordinator-utama/{main_coordinator}', 'MainCoordinatorController@destroy')->name('main-coordinator.destroy');
});
