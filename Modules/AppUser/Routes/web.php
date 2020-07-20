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

Route::group(['namespace' => 'User'], function() {
	Route::get('users/table', 'AppUserController@table')->name('users.table');
	Route::get('users/{users}/data', 'AppUserController@data')->name('users.data');
	Route::resource('users', 'AppUserController')->except(['show']);
});

