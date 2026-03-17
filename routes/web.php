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
    Route::get('pendiente', [SolicitudController::class, 'pendiente'])->name('solicitud-pendiente');
    Route::get('completado', [SolicitudController::class, 'completado'])->name('solicitud-completado');

    Route::post('solicitud-datosGenerales', [SolicitudController::class, 'paso1']);
    Route::get('solicitud-datosGenerales/{id?}', [SolicitudController::class, 'mostrarPaso1'])
    ->name('solicitud-credito.datos-generales');

    //Paso 2

    Route::post('servicio-financiero', [SolicitudController::class, 'paso2']);
	Route::get('servicio-financiero/{id?}', [SolicitudController::class, 'mostrarPaso2'])->name('solicitud-credito.servicio-financiero');
    
    
    //Paso 3
    Route::post('solicitud-datosEmprendimiento', [SolicitudController::class, 'paso3']);
    Route::get('solicitud-datosEmprendimiento/{idPersona?}/{idServicioFinanciero?}', [SolicitudController::class, 'mostrarPaso3'])
    ->name('solicitud-credito.datos-emprendimiento');

    //Paso 4
    Route::post('solicitud-datosConyugue', [SolicitudController::class, 'paso4']);
    Route::get('solicitud-datosConyugue/{idServicioFinanciero?}', [SolicitudController::class, 'mostrarPaso4'])
    ->name('solicitud-credito.datos-conyugue');

    //Paso 5
    Route::post('solicitud-datosFiador', [SolicitudController::class, 'paso5']);
    Route::get('solicitud-datosFiador/{idServicioFinanciero?}', [SolicitudController::class, 'mostrarPaso5'])
    ->name('solicitud-credito.datos-fiador');

    //Paso 6
    Route::post('solicitud-datosReferencia', [SolicitudController::class, 'paso6']);
    Route::get('solicitud-datosReferencia/{idServicioFinanciero?}', [SolicitudController::class, 'mostrarPaso6'])
    ->name('solicitud-credito.datos-referencia');

});

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
