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
	Route::resource('agencies', 'AgencyController')->except(['show']);
});
