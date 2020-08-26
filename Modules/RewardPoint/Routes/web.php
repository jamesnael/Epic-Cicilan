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

Route::group(['namespace' => 'Point'], function() {
	Route::get('point/table', 'PointController@table')->name('point.table');
	Route::get('point/{point}/data', 'PointController@data')->name('point.data');
	Route::resource('point', 'PointController')->except(['show']);
});

Route::group(['namespace' => 'RewardPoint'], function() {
	Route::get('reward-point/table', 'RewardPointController@table')->name('reward-point.table');
	Route::get('reward-point/{reward_point}/data', 'RewardPointController@data')->name('reward-point.data');
	Route::resource('reward-point', 'RewardPointController')->except(['show']);
});

Route::group(['namespace' => 'RewardCategory'], function() {
	Route::get('reward-category/table', 'RewardCategoryController@table')->name('reward-category.table');
	Route::get('reward-category/{reward_category}/data', 'RewardCategoryController@data')->name('reward-category.data');
	Route::resource('reward-category', 'RewardCategoryController')->except(['show']);
});

Route::group(['namespace' => 'TukarPoint'], function() {
	Route::get('tukar-point/table', 'TukarPointController@table')->name('tukar-point.table');
	Route::get('tukar-point/{tukar-point}/data', 'TukarPointController@data')->name('tukar-point.data');
	Route::resource('tukar-point', 'TukarPointController')->except(['show']);
});
