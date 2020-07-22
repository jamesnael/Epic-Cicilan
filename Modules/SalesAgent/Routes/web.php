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

Route::group(['namespace' => 'RegionalCoordinator'], function() {
	Route::get('regional-coordinator/table', 'RegionalCoordinatorController@table')->name('regional-coordinator.table');
	Route::get('regional-coordinator/{regional_coordinator}/data', 'RegionalCoordinatorController@data')->name('regional-coordinator.data');
	Route::resource('regional-coordinator', 'RegionalCoordinatorController')->parameters(['regional-coordinator' => 'regional-coordinator'])->except(['show']);
});

Route::group(['namespace' => 'MainCoordinator'], function() {
	Route::get('main-coordinator/table', 'MainCoordinatorController@table')->name('main-coordinator.table');
	Route::get('main-coordinator/{main_coordinator}/data', 'MainCoordinatorController@data')->name('main-coordinator.data');
	Route::resource('main-coordinator', 'MainCoordinatorController')->parameters(['main-coordinator' => 'main-coordinator'])->except(['show']);
});
