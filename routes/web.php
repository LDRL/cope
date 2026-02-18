<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Catalogo\NacionalidadController;
use App\Http\Controllers\Catalogo\EtniaController;
use App\Http\Controllers\Catalogo\EstadoCivilController;

use App\Http\Controllers\Credito\SolicitudController;


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


Route::prefix('catalogos')->group(function () {
    Route::get('nacionalidades', [NacionalidadController::class, 'index']);
    Route::get('etnias', [EtniaController::class, 'index']);
    Route::get('estado-civil', [EstadoCivilController::class, 'index']);
});


Route::prefix('credito')->group(function () {
	Route::get('servicio-financiero', [SolicitudController::class, 'mostrarPaso1'])->name('solicitud-credito.servicio-financiero');
    Route::post('servicio-financiero', [SolicitudController::class, 'paso1']);


    //Paso 2
    Route::post('solicitud-datosGenerales', [SolicitudController::class, 'paso2']);
    Route::get('solicitud-datosGenerales/{id?}', [SolicitudController::class, 'mostrarPaso2'])
    ->name('solicitud-credito.datos-generales');
    
    
    //Paso 3
    Route::get('solicitud-datosEmprendimiento/{id?}', [SolicitudController::class, 'mostrarPaso3'])
    ->name('solicitud-credito.datos-emprendimiento');

});

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
