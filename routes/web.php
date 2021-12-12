<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Auth::routes(['register' => false]);

Route::middleware(['auth'])->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');

    /* Imoveis */
    Route::get('/imoveis', 'ImoveisController@index')->name('imoveis');
    Route::get('/imoveis/create', 'ImoveisController@create')->name('imoveis.create');
    Route::post('/imoveis/store', 'ImoveisController@store')->name('imoveis.store');
    Route::get('/imoveis/show/{id}', 'ImoveisController@show')->name('imoveis.show');
    Route::put('/imoveis/update/{id}', 'ImoveisController@update')->name('imoveis.update');

    /* Clientes */
    Route::get('/clientes', 'ClientesController@index')->name('clientes');
    Route::get('/clientes/create', 'ClientesController@create')->name('clientes.create');
    Route::post('/clientes/store', 'ClientesController@store')->name('clientes.store');
    Route::get('/clientes/show/{id}', 'ClientesController@show')->name('clientes.show');
    Route::put('/clientes/update/{id}', 'ClientesController@update')->name('clientes.update');

    /* Locatarios */
    Route::get('/locatarios', 'LocatariosController@index')->name('locatarios');
    Route::get('/locatarios/create', 'LocatariosController@create')->name('locatarios.create');
    Route::post('/locatarios/store', 'LocatariosController@store')->name('locatarios.store');
    Route::get('/locatarios/show/{id}', 'LocatariosController@show')->name('locatarios.show');
    Route::put('/locatarios/update/{id}', 'LocatariosController@update')->name('locatarios.update');
    Route::post('/locatarios/autocomplete', 'LocatariosController@autocomplete')->name('locatarios.autocomplete');
});
