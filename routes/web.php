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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('configuracion', 'UserController@config')->name('config');
Route::post('usuario/actualizar', 'UserController@update')->name('user.update');
Route::get('usuario/avatar/{filename}', 'UserController@getImage')->name('user.avatar');
Route::get('imagen/subir', 'ImageController@create')->name('image.create');
Route::post('imagen/guardar', 'ImageController@save')->name('image.save');
Route::get('imagen/file/{filename}', 'ImageController@getImage')->name('image.file');
Route::get('imagen/detalle/{id}', 'ImageController@detail')->name('image.detail');
Route::post('comentario/agregar', 'CommentController@save')->name('comment.save');