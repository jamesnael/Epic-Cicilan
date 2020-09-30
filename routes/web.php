<?php

use Illuminate\Support\Facades\Route;

// \Auth::login(\Modules\AppUser\Entities\User::first());

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


// Route::get('/', 'HomeController@index')->middleware('auth');

Route::group(['namespace' => 'Auth'], function() {

    Route::post('login', 'LoginController@login')->name('post-login');
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::match(['get', 'post'], 'logout', 'LoginController@logout')->name('logout');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/reset', 'ResetPasswordController@reset')->name('password.update');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
	
    Route::get('profil', 'ProfileController@index')->name('profile');
    Route::get('ubah-password', 'ProfileController@changePassword')->name('change-password');
    Route::post('ubah-password', 'ProfileController@store')->name('post-change-password');
});


// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

Route::get('test/import', function() {
    return Excel::toCollection(new App\Imports\HandleBookingImport, storage_path('app/public/import_epic_admin_template_rev_1.xlsx'));
});