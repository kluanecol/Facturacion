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

Auth::routes();

Route::post('log_out', 'Auth\LoginController@logout')->name('log_out');
Route::get('log_out', 'Auth\LoginController@logout')->name('log_out');

Route::group(['middleware' => 'auth'], function()
{

    Route::get('/', function () {
        return view('home');
    });

    Route::get('lang/{lang}', 'LanguageController@swap')->name('lang.swap');
    Route::get('changecountry/{id}', 'LanguageController@swapcountry')->name('lang.swapcountry');
});
