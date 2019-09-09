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

Route::get('/', 'FrontendController@index');
Route::get('/o_mnie', 'FrontendController@about')->name('about');
Route::get('/kontakt', 'FrontendController@contact')->name('contact');
Auth::routes();

Route::resource('/jokes', 'JokesController');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/ustawienia', 'SettingsController@index')->name('settings');
Route::put('/ustawienia', 'SettingsController@store')->name('change_settings');


