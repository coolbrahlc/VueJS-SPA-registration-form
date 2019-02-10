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

Route::prefix('api')->group(function() {

    Route::resource('notes', 'NotesController');

    Route::get('/email_index', 'NotesController@email_index');
    Route::post('/notes/{note}/update', 'NotesController@updateForm');


    Route::put('/notes/{note}/toggleFavourite', 'NotesController@toggleFavourite');
});



//Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


