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
	// Route::resource('document', 'DocumentClientController')->except(['show', 'destroy']);

	Route::get('dokumen', 'DocumentClientController@index')->name('document.index');
	Route::post('dokumen', 'DocumentClientController@store')->name('document.store');
	Route::get('dokumen/table', 'DocumentClientController@table')->name('document.table');
	Route::get('dokumen/tambah', 'DocumentClientController@create')->name('document.create');
	Route::put('dokumen/{document}', 'DocumentClientController@update')->name('document.update');
	Route::get('dokumen/{document}/data', 'DocumentClientController@data')->name('document.data');
	Route::get('dokumen/{document}/ubah', 'DocumentClientController@edit')->name('document.edit');
	Route::delete('dokumen/{document}/{file}', 'DocumentClientController@removeFile')->name('document.remove-file');
});

Route::group(['namespace' => 'DocumentAdmin'], function() {
	// Route::resource('document-admin', 'DocumentAdminController')->except(['show']);

	Route::get('dokumen-admin', 'DocumentAdminController@index')->name('document-admin.index');
	Route::post('dokumen-admin', 'DocumentAdminController@store')->name('document-admin.store');
	Route::get('dokumen-admin/table', 'DocumentAdminController@table')->name('document-admin.table');
	Route::get('dokumen-admin/tambah', 'DocumentAdminController@create')->name('document-admin.create');
	Route::put('dokumen-admin/{document_admin}', 'DocumentAdminController@update')->name('document-admin.update');
	Route::get('dokumen-admin/{document_admin}/data', 'DocumentAdminController@data')->name('document-admin.data');
	Route::get('dokumen-admin/{document_admin}/ubah', 'DocumentAdminController@edit')->name('document-admin.edit');
	Route::delete('dokumen-admin/{document_admin}', 'DocumentAdminController@destroy')->name('document-admin.destroy');
	Route::delete('dokumen-admin/{document_admin}/{file}', 'DocumentAdminController@removeFile')->name('document-admin.remove-file');
});