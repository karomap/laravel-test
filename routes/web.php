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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::resource('user', 'UserController')->except('index', 'create', 'store');
});

Route::group([
    'prefix' => 'admin',
    'middleware' => ['has_access_level:admin'],
    'namespace' => 'Admin',
    'as' => 'admin.',
], function () {
    Route::resource('user', 'UserController');
});
