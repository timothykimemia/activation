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

Route::group(['namespace' => 'Auth'], function () {
    Route::get('activate/email/{token}', 'Activation\ActivationTokenController@activate')->name('activate.email');
    Route::get('activate/resend', 'Activation\ActivationTokenController@resend')->name('resend.email');
});

Route::get('/home', 'HomeController@index')->name('home');
