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

Route::post('/imoveis/busca/', 'ImoveisController@buscaPorCodigo')->name('busca_codigo_imoveis');

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware'=>'auth'], function(){

	Route::group(['prefix' => 'imoveis'], function(){
		Route::get('/lista', 'ImoveisController@lista')->name('lista_imoveis');
		Route::get('/cadastro', 'ImoveisController@cadastro')->name('cadastro_imoveis');
		Route::post('/gravar', 'ImoveisController@gravar')->name('gravar_imoveis');
		Route::get('/editar/{id}', 'ImoveisController@editar')->name('editar_imoveis');
		Route::post('/salvar', 'ImoveisController@salvar')->name('salvar_imoveis');
		Route::get('/deletar/{id}', 'ImoveisController@deletar')->name('deletar_imoveis');
	});

});