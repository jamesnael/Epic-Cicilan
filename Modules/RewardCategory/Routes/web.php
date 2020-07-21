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

Route::group(['namespace' => 'RewardCategory'], function() {
	Route::get('reward-category/table', 'RewardCategoryController@table')->name('reward-category.table');
	Route::get('reward-category/{reward_category}/data', 'RewardCategoryController@data')->name('reward-category.data');
	Route::resource('reward-category', 'RewardCategoryController')->except(['show']);
});

