<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth/login');
});

Route::get('/logout', 'App\Http\Controllers\Auth\LoginController@logout');

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
	Route::get('/', 'App\Http\Controllers\HomeController@index');
	Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');
	Route::get('/{slug?}','App\Http\Controllers\HomeController@index');

});

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
