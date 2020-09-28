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
	// Route::get('tipe-unit/table', 'PointController@table')->name('point.table');
	// Route::get('tipe-unit/{point}/data', 'PointController@data')->name('point.data');
	// Route::resource('point', 'PointController')->except(['show']);

	Route::get('tipe-unit', 'PointController@index')->name('point.index');
	Route::post('tipe-unit', 'PointController@store')->name('point.store');
	Route::get('tipe-unit/table', 'PointController@table')->name('point.table');
	Route::get('tipe-unit/tambah', 'PointController@create')->name('point.create');
	Route::get('tipe-unit/{point}/data', 'PointController@data')->name('point.data');
	Route::put('tipe-unit/{point}', 'PointController@update')->name('point.update');
	Route::get('tipe-unit/{point}/ubah', 'PointController@edit')->name('point.edit');
	Route::delete('tipe-unit/{point}', 'PointController@destroy')->name('point.destroy');
});

Route::group(['namespace' => 'RewardPoint'], function() {
	// Route::resource('reward-point', 'RewardPointController')->except(['show']);

	Route::get('reward', 'RewardPointController@index')->name('reward-point.index');
	Route::post('reward', 'RewardPointController@store')->name('reward-point.store');
	Route::get('reward/table', 'RewardPointController@table')->name('reward-point.table');
	Route::get('reward/tambah', 'RewardPointController@create')->name('reward-point.create');
	Route::put('reward/{reward_point}', 'RewardPointController@update')->name('reward-point.update');
	Route::get('reward/{reward_point}/data', 'RewardPointController@data')->name('reward-point.data');
	Route::get('reward/{reward_point}/ubah', 'RewardPointController@edit')->name('reward-point.edit');
	Route::delete('reward/{reward_point}', 'RewardPointController@destroy')->name('reward-point.destroy');
});

Route::group(['namespace' => 'RewardCategory'], function() {
	// Route::get('kategori-reward/table', 'RewardCategoryController@table')->name('reward-category.table');
	// Route::get('kategori-reward/{reward_category}/data', 'RewardCategoryController@data')->name('reward-category.data');
	// Route::resource('reward-category', 'RewardCategoryController')->except(['show']);

	Route::get('kategori-reward', 'RewardCategoryController@index')->name('reward-category.index');
	Route::post('kategori-reward', 'RewardCategoryController@store')->name('reward-category.store');
	Route::get('kategori-reward/table', 'RewardCategoryController@table')->name('reward-category.table');
	Route::get('kategori-reward/tambah', 'RewardCategoryController@create')->name('reward-category.create');
	Route::put('kategori-reward/{reward_category}', 'RewardCategoryController@update')->name('reward-category.update');
	Route::get('kategori-reward/{reward_category}/data', 'RewardCategoryController@data')->name('reward-category.data');
	Route::get('kategori-reward/{reward_category}/ubah', 'RewardCategoryController@edit')->name('reward-category.edit');
	Route::delete('kategori-reward/{reward_category}', 'RewardCategoryController@destroy')->name('reward-category.destroy');
});

Route::group(['namespace' => 'TukarPoint'], function() {
	Route::get('tukar-point/table-sales', 'TukarPointController@tableSales')->name('tukar-point-sales.table');
	Route::get('tukar-point/table-agent', 'TukarPointController@tableAgent')->name('tukar-point-agent.table');
	Route::get('tukar-point/table-koordinator-wilayah', 'TukarPointController@tableKorwil')->name('tukar-point-korwil.table');
	Route::get('tukar-point/table-koordinator-utama', 'TukarPointController@tableKorut')->name('tukar-point-korut.table');
	Route::get('tukar-point/table-sales-history/{id}', 'TukarPointController@tableSalesHistory')->name('tukar-point-history-sales.table');
	Route::get('tukar-point/table-sales-history-get-point/{id}', 'TukarPointController@tableSalesHistoryGetPoint')->name('tukar-point-history-sales-get-point.table');
	Route::get('tukar-point/table-agent-history/{id}', 'TukarPointController@tableAgentHistory')->name('tukar-point-history-agent.table');
	Route::get('tukar-point/table-agent-history-get-point/{id}', 'TukarPointController@tableAgentHistoryGetPoint')->name('tukar-point-history-agent-get-point.table');
	Route::get('tukar-point/table-koordinator-wilayah-history/{id}', 'TukarPointController@tableKorwilHistory')->name('tukar-point-history-korwil.table');
	Route::get('tukar-point/table-koordinator-wilayah-history-get-point/{id}', 'TukarPointController@tableKorwilHistoryGetPoint')->name('tukar-point-history-korwil-get-point.table');
	Route::get('tukar-point/table-koordinator-utama-history/{id}', 'TukarPointController@tableKorutHistory')->name('tukar-point-history-korut.table');
	Route::get('tukar-point/table-koordinator-utama-history-get-point/{id}', 'TukarPointController@tableKorutHistoryGetPoint')->name('tukar-point-history-korut-get-point.table');
	Route::get('tukar-point/{tukar_point}/data', 'TukarPointController@data')->name('tukar-point.data');
	Route::get('tukar-point/{tukar_point}/history_sales', 'TukarPointController@historySales')->name('tukar-point-sales.history');
	Route::get('tukar-point/{tukar_point}/history_agent', 'TukarPointController@historyAgent')->name('tukar-point-agent.history');
	Route::get('tukar-point/{tukar_point}/history_koordinator_wilayah', 'TukarPointController@historyKorwil')->name('tukar-point-korwil.history');
	Route::get('tukar-point/{tukar_point}/history_koordinator_utama', 'TukarPointController@historyKorut')->name('tukar-point-korut.history');
	Route::delete('tukar-point/{tukar_point}/cancel_sales', 'TukarPointController@cancelSales')->name('tukar-point-sales.destroy');
	Route::delete('tukar-point/{tukar_point}/cancel_agent', 'TukarPointController@cancelAgent')->name('tukar-point-agent.destroy');
	Route::delete('tukar-point/{tukar_point}/cancel_koordinator_wilayah', 'TukarPointController@cancelKorwil')->name('tukar-point-korwil.destroy');
	Route::delete('tukar-point/{tukar_point}/cancel_koordinator_utama', 'TukarPointController@cancelKorut')->name('tukar-point-korut.destroy');
	Route::get('tukar-point/tambah/sales', 'TukarPointController@createSales')->name('tukar-point-sales.create');
	Route::get('tukar-point/tambah/sub-agent', 'TukarPointController@createAgent')->name('tukar-point-agency.create');
	Route::get('tukar-point/tambah/koordinator-wilayah', 'TukarPointController@createKorwil')->name('tukar-point-korwil.create');
	Route::get('tukar-point/tambah/koordinator-utama', 'TukarPointController@createKorut')->name('tukar-point-korut.create');

	Route::get('tukar-point/{tukar_point}/pdf-history-sales', 'TukarPointController@print_sales')->name('tukar-point-sales.print');
	Route::get('tukar-point/{tukar_point}/pdf-history-agency', 'TukarPointController@print_agent')->name('tukar-point-agent.print');
	Route::get('tukar-point/{tukar_point}/pdf-history-korwil', 'TukarPointController@print_korwil')->name('tukar-point-korwil.print');
	Route::get('tukar-point/{tukar_point}/pdf-history-korut', 'TukarPointController@print_korut')->name('tukar-point-korut.print');

	Route::resource('tukar-point', 'TukarPointController')->except(['show', 'edit', 'destroy', 'create']);
});
