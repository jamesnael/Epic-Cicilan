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
	Route::get('tukar-point/table-sales', 'TukarPointController@tableSales')->name('tukar-point-sales.table');
	Route::get('tukar-point/table-agent', 'TukarPointController@tableAgent')->name('tukar-point-agent.table');
	Route::get('tukar-point/table-korwil', 'TukarPointController@tableKorwil')->name('tukar-point-korwil.table');
	Route::get('tukar-point/table-korut', 'TukarPointController@tableKorut')->name('tukar-point-korut.table');
	Route::get('tukar-point/table-sales-history/{id}', 'TukarPointController@tableSalesHistory')->name('tukar-point-history-sales.table');
	Route::get('tukar-point/table-sales-history-get-point/{id}', 'TukarPointController@tableSalesHistoryGetPoint')->name('tukar-point-history-sales-get-point.table');
	Route::get('tukar-point/table-agent-history/{id}', 'TukarPointController@tableAgentHistory')->name('tukar-point-history-agent.table');
	Route::get('tukar-point/table-agent-history-get-point/{id}', 'TukarPointController@tableAgentHistoryGetPoint')->name('tukar-point-history-agent-get-point.table');
	Route::get('tukar-point/table-korwil-history/{id}', 'TukarPointController@tableKorwilHistory')->name('tukar-point-history-korwil.table');
	Route::get('tukar-point/table-korwil-history-get-point/{id}', 'TukarPointController@tableKorwilHistoryGetPoint')->name('tukar-point-history-korwil-get-point.table');
	Route::get('tukar-point/table-korut-history/{id}', 'TukarPointController@tableKorutHistory')->name('tukar-point-history-korut.table');
	Route::get('tukar-point/table-korut-history-get-point/{id}', 'TukarPointController@tableKorutHistoryGetPoint')->name('tukar-point-history-korut-get-point.table');
	Route::get('tukar-point/{tukar_point}/data', 'TukarPointController@data')->name('tukar-point.data');
	Route::get('tukar-point/{tukar_point}/history_sales', 'TukarPointController@historySales')->name('tukar-point-sales.history');
	Route::get('tukar-point/{tukar_point}/history_agent', 'TukarPointController@historyAgent')->name('tukar-point-agent.history');
	Route::get('tukar-point/{tukar_point}/history_korwil', 'TukarPointController@historyKorwil')->name('tukar-point-korwil.history');
	Route::get('tukar-point/{tukar_point}/history_korut', 'TukarPointController@historyKorut')->name('tukar-point-korut.history');
	Route::delete('tukar-point/{tukar_point}/cancel_sales', 'TukarPointController@cancelSales')->name('tukar-point-sales.destroy');
	Route::delete('tukar-point/{tukar_point}/cancel_agent', 'TukarPointController@cancelAgent')->name('tukar-point-agent.destroy');
	Route::delete('tukar-point/{tukar_point}/cancel_korwil', 'TukarPointController@cancelKorwil')->name('tukar-point-korwil.destroy');
	Route::delete('tukar-point/{tukar_point}/cancel_korut', 'TukarPointController@cancelKorut')->name('tukar-point-korut.destroy');
	Route::get('tukar-point/tambah/sales', 'TukarPointController@createSales')->name('tukar-point-sales.create');
	Route::get('tukar-point/tambah/agency', 'TukarPointController@createAgent')->name('tukar-point-agency.create');
	Route::get('tukar-point/tambah/korwil', 'TukarPointController@createKorwil')->name('tukar-point-korwil.create');
	Route::get('tukar-point/tambah/korut', 'TukarPointController@createKorut')->name('tukar-point-korut.create');

	Route::resource('tukar-point', 'TukarPointController')->except(['show', 'edit', 'destroy', 'create']);
});
