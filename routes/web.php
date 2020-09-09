<?php

use Illuminate\Support\Facades\Route;

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


Route::group(['namespace' => 'Auth'], function() {
	Route::get('/', function () {
	    return view('app');
	})->middleware('auth');

    Route::post('login', 'LoginController@login')->name('login');
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::match(['get', 'post'], 'logout', 'LoginController@logout')->name('logout');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/reset', 'ResetPasswordController@reset')->name('password.update');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
	
    Route::get('profile', 'ProfileController@index')->name('profile');
    Route::get('change-password', 'ProfileController@changePassword')->name('change-password');
    Route::post('change-password', 'ProfileController@store')->name('change-password');
});


// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
