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
	// Route::resource('users', 'AppUserController')->except(['show']);

	Route::get('user', 'AppUserController@index')->name('users.index');
	Route::post('user', 'AppUserController@store')->name('users.store');
	Route::get('users/table', 'AppUserController@table')->name('users.table');
	Route::get('user/tambah', 'AppUserController@create')->name('users.create');
	Route::get('users/{users}/data', 'AppUserController@data')->name('users.data');
	Route::put('user/{user}', 'AppUserController@update')->name('users.update');
	Route::get('user/{user}/ubah', 'AppUserController@edit')->name('users.edit');
	Route::delete('user/{user}', 'AppUserController@destroy')->name('users.destroy');
});

Route::group(['namespace' => 'Role'], function() {
	// Route::resource('users', 'AppUserController')->except(['show']);

	Route::get('role-user', 'RoleUserController@index')->name('role.index');
	Route::post('role-user', 'RoleUserController@store')->name('role.store');
	Route::get('role-user/table', 'RoleUserController@table')->name('role.table');
	Route::get('role-user/tambah', 'RoleUserController@create')->name('role.create');
	Route::get('role-user/{role}/data', 'RoleUserController@data')->name('role.data');
	Route::put('role-user/{role}', 'RoleUserController@update')->name('role.update');
	Route::get('role-user/{role}/ubah', 'RoleUserController@edit')->name('role.edit');
	Route::delete('role-user/{role}', 'RoleUserController@destroy')->name('role.destroy');
});

