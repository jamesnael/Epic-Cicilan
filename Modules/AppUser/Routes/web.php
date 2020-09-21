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

	Route::get('hak-akses', 'RoleUserController@index')->name('role.index');
	Route::post('hak-akses', 'RoleUserController@store')->name('role.store');
	Route::get('hak-akses/table', 'RoleUserController@table')->name('role.table');
	Route::get('hak-akses/tambah', 'RoleUserController@create')->name('role.create');
	Route::put('hak-akses/{role}', 'RoleUserController@update')->name('role.update');
	Route::get('hak-akses/{role}/data', 'RoleUserController@data')->name('role.data');
	Route::get('hak-akses/{role}/ubah', 'RoleUserController@edit')->name('role.edit');
	Route::delete('hak-akses/{role}', 'RoleUserController@destroy')->name('role.destroy');
});

