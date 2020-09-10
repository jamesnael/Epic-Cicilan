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

Route::group(['namespace' => 'Province', 'prefix' => 'provinces', 'as' => 'provinces.'], function() {
	Route::get('/', 'ProvinceController@provinceList')->name('index');
});

Route::group(['namespace' => 'Bank', 'prefix' => 'banks', 'as' => 'banks.'], function() {
	Route::get('/', 'BankController@bankList')->name('index');
});

Route::group(['namespace' => 'Occupation', 'prefix' => 'occupations', 'as' => 'occupations.'], function() {
	Route::get('/', 'OccupationController@occupationList')->name('index');
});

Route::group(['namespace' => 'PaymentMethod', 'prefix' => 'payment-methods', 'as' => 'payment-methods.'], function() {
	Route::get('/', 'PaymentMethodController@paymentMethodList')->name('index');
});

