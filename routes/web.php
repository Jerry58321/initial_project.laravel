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

Route::get('/', 'DashboardController@index');

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix' => 'platforms'], function () {
        Route::resource('database', 'PlatformController');
        Route::get('setting', 'PlatformController@setting')->name('platform.setting');
        Route::post('kick-member-all', 'PlatformController@kickMemberAll')->name('platform.kickMemberAll');
        Route::post('toggle-maintain', 'PlatformController@toggleMaintain')->name('platform.toggleMaintain');
    });

});