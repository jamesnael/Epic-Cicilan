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

Route::get('/', 'DashboardController@index')->name('dashboard.index');
Route::get('dashboard/table', 'DashboardController@table')->name('dashboard.table');
Route::get('dashboard/table-paid', 'DashboardController@tablePaid')->name('dashboard-paid.table');
