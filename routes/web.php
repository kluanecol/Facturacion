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

Route::get('/', function () {
    return view('home');
});

Route::post('log_out', 'Auth\LoginController@logout')->name('log_out');
Route::get('log_out', 'Auth\LoginController@logout')->name('log_out');

Route::get('lang/{lang}', 'LanguageController@swap')->name('lang.swap');
Route::get('changecountry/{id}', 'LanguageController@swapcountry')->name('lang.swapcountry');

Route::get('test', function () {
    //$users = DB::table('users')->get();
    //dd($users);

    Excel::create('Filename', function($excel) {
        $excel->sheet('Sheetname', function($sheet) {

            // Sheet manipulation

        });
    })->export('xlsx');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
