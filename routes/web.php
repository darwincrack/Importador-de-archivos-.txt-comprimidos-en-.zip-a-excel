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


Route::get('/', 'ImportController@index');

Route::post('dropzone/store', 'ImportController@dropzoneStore')->name('dropzone.store');

Route::post('importar', 'ImportController@importar');

Route::post('procesando', 'ImportController@procesando');

Route::post('formstore', 'ImportController@formstore');

Route::get('descarga', 'ImportController@descarga');



