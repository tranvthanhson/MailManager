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

Route::get('/', 'HomeController@index')->name('home.index');
Route::post('storeEmail', 'HomeController@storeEmail')->name('home.storeEmail');
Route::post('ajax', 'HomeController@ajax')->name('home.ajax');
// Route::post('storeEmail', [
//     'uses' => 'HomeController@ajax',
//     'as' => 'home.storeEmail',
// ]);
