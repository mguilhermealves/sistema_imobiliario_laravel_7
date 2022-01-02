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
    return view('auth.login');
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
    Route::match(['get', 'post'], '/clientes/show/{id}', 'ClientesController@show')->name('clientes.show');
    Route::put('/clientes/update/{id}', 'ClientesController@update')->name('clientes.update');

    /* Locatarios */
    Route::get('/locatarios', 'LocatariosController@index')->name('locatarios');
    Route::get('/locatarios/create', 'LocatariosController@create')->name('locatarios.create');
    Route::get('/locatarios/contract', 'LocatariosController@contract')->name('locatarios.contract');
    Route::post('/locatarios/store', 'LocatariosController@store')->name('locatarios.store');
    Route::get('/locatarios/show/{id}', 'LocatariosController@show')->name('locatarios.show');
    Route::put('/locatarios/update/{id}', 'LocatariosController@update')->name('locatarios.update');
    Route::post('/locatarios/autocomplete', 'LocatariosController@autocomplete')->name('locatarios.autocomplete');

    /* Contas a Receber */
    Route::get('/contas_receber', 'ContasReceberController@index')->name('contas_receber');
    Route::get('/contas_receber/show/{id}', 'ContasReceberController@show')->name('contas_receber.show');
    Route::match(['get', 'post'], '/contas_receber/edit/{id}', 'ContasReceberController@edit')->name('contas_receber.edit');
    Route::post('/contas_receber/payment/{id}', 'ContasReceberController@payment')->name('contas_receber.payment');
    Route::post('/contas_receber/payment/edit/{id}', 'ContasReceberController@payment_edit')->name('contas_receber.payment_edit');
    Route::post('/contas_receber/payment/send_email/{id}', 'ContasReceberController@sendEmail')->name('contas_receber.send_email');

    /* Categorias Contas a Pagar */
    Route::get('/contas_pagar_categoria', 'CategoriasContasPagarController@index')->name('contas_pagar_categoria');
    Route::get('/contas_pagar/categoria/create', 'CategoriasContasPagarController@create')->name('contas_pagar.categoria.create');
    Route::post('/contas_pagar/categoria/store', 'CategoriasContasPagarController@store')->name('contas_pagar.categoria.store');

    /* Contas a Pagar*/
    Route::get('/contas_pagar', 'ContasPagarController@index')->name('contas_pagar');
    Route::get('/contas_pagar/create', 'ContasPagarController@createAccountPays')->name('contas_pagar.contas.create');
    Route::post('/contas_pagar/autocomplete', 'ContasPagarController@autocomplete')->name('contas_pagar.contas.autocomplete');
    Route::post('/contas_pagar/store', 'ContasPagarController@store')->name('contas_pagar.contas.store');

    /* EXPORT EXCEL */
    route::get('export_client', 'ExportExcelController@export_client')->name('export_client');
    route::get('export_propertie', 'ExportExcelController@export_propertie')->name('export_propertie');
    route::get('export_tenants', 'ExportExcelController@export_tenants')->name('export_tenants');
});
