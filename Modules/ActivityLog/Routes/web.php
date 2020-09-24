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

Route::prefix('catatan-aktivitas')->group(function() {
    Route::get('/', 'ActivityLogController@index')->name('log.index');
	Route::get('/table', 'ActivityLogController@table')->name('log.table');
	Route::get('/tambah', 'ActivityLogController@create')->name('log.create');
	Route::get('/{log}/data', 'ActivityLogController@data')->name('log.data');
	Route::put('/{log}', 'ActivityLogController@update')->name('log.update');
	Route::get('/{log}/ubah', 'ActivityLogController@edit')->name('log.edit');
});
