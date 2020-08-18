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
Route::group(['namespace' => 'DocumentClient'], function() {
	Route::get('document/table', 'DocumentClientController@table')->name('document.table');
	Route::get('document/{document}/data', 'DocumentClientController@data')->name('document.data');
	Route::resource('document', 'DocumentClientController')->except(['show']);
});
