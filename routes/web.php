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

Route::get('/symlink', function (){
    $exitCode=Artisan::call('storage:link');
    echo $exitCode;


});
Route::get('/', 'FrontendController@index');
Route::get('/o_mnie', 'FrontendController@about')->name('about');
Route::get('/kontakt', 'FrontendController@contact')->name('contact');
Route::get('/tematy/{id}', 'FrontendController@topics')->name('topics');
Route::get('/szukaj', 'FrontendController@result')->name('result');
Route::get('/tagi/{id}', 'FrontendController@tags')->name('tags');
Route::get('/artykul/{slug}', 'FrontendController@single')->name('single');
Route::get('/pesel', 'FrontendController@pesel')->name('pesel');
Route::get('/gus', 'FrontendController@gus')->name('gus');
Route::post('/ajax-gus', 'FrontendController@ajaxGus')->name('ajax_gus');
Route::get('/ajax-gus/pdf', 'FrontendController@ajaxGusPdf')->name('ajax_gus_pdf');
Route::get('/dowcipy', 'FrontendController@jokes')->name('jokes');
Route::get('/polityka-cookie', 'FrontendController@cookie')->name('cookie');
Route::post('/mail', 'FrontendController@send')->name('mail');
Auth::routes(['register' => false]);
Route::middleware(['auth'])->group(function (){
    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('/jokes', 'JokesController');
    Route::resource('/topics', 'TopicsController');
    Route::resource('/tags', 'TagsController');
    Route::resource('/posts', 'PostsController');
    Route::get('/trashed', 'PostsController@trashed')->name('trashed');
    Route::delete('/trashed/{id}', 'PostsController@delete')->name('trashed-delete');
    Route::post('/restore/{id}', 'PostsController@restore')->name('trashed-restore');
    Route::get('/settings', 'SettingsController@index')->name('settings');
    Route::put('/settings', 'SettingsController@store')->name('change_settings');
    Route::get('/files', 'BackendPagesController@file')->name('file');
    Route::get('/image', 'BackendPagesController@image')->name('image');
    Route::get('/user', 'UsersController@index')->name('user');
    Route::put('/user', 'UsersController@update')->name('user_update');

});






