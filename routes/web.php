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

Route::get('/secret-login', 'SessionsController@create');
Route::post('/secret-login', 'SessionsController@store');
Route::get('/secret-logout', 'SessionsController@destroy');

Route::get('/', function () {
    return redirect('http://www.amazingvideos.mobi/?sl=1887130-2e95b&data1=Track1&data2=Track2');
});

Route::get('/home', 'LinksController@create')->name('home');
Route::post('/home', 'LinksController@store');

Route::get('/link-ad', 'VideoLinksController@create');
Route::post('/link-ad', 'VideoLinksController@store');

Route::get('/linksad', 'VideoLinksController@index');

Route::post('/get-info', 'VideoLinksController@getInfo');

Route::get('/youtube/{link}', 'VideoLinksController@show');

Route::get('/salary', 'ReportsController@show');
// Route::post('/reports', 'ReportsController@store');

Route::get('/setting', 'UsersController@index');
Route::post('/setting', 'UsersController@update');

Route::get('token', 'TokensController@create');

Route::get('/links', 'LinksController@index');
Route::get('{link}', 'LinksController@oldLink');
Route::get('/appstore/{sub}/{link}.{random}', 'LinksController@show');

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::get('/users', 'Admin\UsersController@index');
    Route::get('/users/create', 'Admin\UsersController@create');
    Route::post('/users', 'Admin\UsersController@store');

    Route::get('/users/{user}/edit', 'Admin\UsersController@edit');
    Route::post('/users/{user}', 'Admin\UsersController@update');

    Route::delete('/users/{user}', 'Admin\UsersController@destroy');

    Route::get('/links/{link}/edit', 'LinksController@edit');
    Route::post('/links/{link}', 'LinksController@update');
    Route::delete('/links/{link}', 'LinksController@destroy');

    Route::get('/clients', 'Admin\ClientsController@index');

    Route::get('/domains', 'Admin\DomainsController@index');

    Route::get('/domains/create', 'Admin\DomainsController@create');
    Route::post('/domains', 'Admin\DomainsController@store');

    Route::delete('/domains/{domain}', 'Admin\DomainsController@destroy');

    Route::get('/quotes', 'Admin\QuotesController@index');
    Route::post('/quotes', 'Admin\QuotesController@store');
});
