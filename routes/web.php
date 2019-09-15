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
Route::get('/tematy/{$id}', 'FrontendController@topics')->name('topics');
Auth::routes();
Route::middleware(['auth'])->group(function (){
    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('/jokes', 'JokesController');
    Route::resource('/topics', 'TopicsController');
    Route::resource('/tags', 'TagsController');
    Route::get('/settings', 'SettingsController@index')->name('settings');
    Route::put('/settings', 'SettingsController@store')->name('change_settings');
    Route::get('/files', 'BackendPagesController@file')->name('file');
    Route::get('/image', 'BackendPagesController@image')->name('image');
    Route::get('/user', 'UsersController@index')->name('user');
    Route::put('/user', 'UsersController@update')->name('user_update');

});






