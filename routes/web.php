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

Route::group([
    'prefix' => '{locale}',
    'where' => ['locale' => '[a-zA-Z]{2}'],
    'middleware' => 'setlocale',
], function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('welcome');

    Auth::routes();

    Route::get('/home', 'HomeController@index')->name('home');

    Route::group(['middleware' => 'auth'], function () {
        Route::get('profile', 'UserController@show')->name('user.show');
        Route::get('profile/edit', 'UserController@edit')->name('user.edit');
        Route::patch('profile', 'UserController@update')->name('user.update');
        Route::delete('profile', 'UserController@destroy')->name('user.destroy');

        Route::group([
            'prefix' => 'admin',
            'namespace' => 'Admin',
            'as' => 'admin.',
        ], function () {
            Route::resource('user', 'UserController')->except('show');
        });
    });
});

Route::get('/', function () {
    return redirect()->route('welcome', app()->getLocale());
});
