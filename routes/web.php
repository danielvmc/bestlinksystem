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

Route::get('/login', 'SessionsController@create');
Route::post('/login', 'SessionsController@store');
Route::get('/logout', 'SessionsController@destroy');

Route::get('/', 'LinksController@create')->name('home');
Route::post('/', 'LinksController@store');

Route::get('/{link}', 'LinksController@show');

Route::group(['prefix' => 'admin'], function () {
    Route::get('users', 'Admin\UsersController@index');
    Route::get('users/create', 'Admin\UsersController@create');
    Route::post('users', 'Admin\UsersController@store');

    Route::get('links', 'Admin\LinksController@index');
});
