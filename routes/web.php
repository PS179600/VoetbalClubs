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
Auth::routes();

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/voetbalclubs', 'HomeController@index')->name('voetbalclubs');
Route::get('/clubinfo/{clubnaam}/{filter?}', 'HomeController@clubinfo')->name('clubinfo');

Route::post('/speler_toevoegen', 'HomeController@spelerToevoegen')->name('speler_toevoegen');
Route::delete('/speler_verwijderen/{id}', 'HomeController@SpelerVerwijderen')->name('speler_verwijderen');
Route::post('/speler_wijzigen/{id}', 'HomeController@SpelerWijzigen')->name('speler_wijzigen');