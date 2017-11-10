<?php

Route::pattern('slug', '(.*)');
Route::pattern('id', '([0-9]*)');

Route::get('/', 'HomeController@index')->name('home.index');
Route::post('storeEmail', 'HomeController@storeEmail')->name('home.storeEmail');
Route::post('ajax', 'HomeController@ajax')->name('home.ajax');
Route::post('updateEmail/{id}', 'HomeController@updateEmail')->name('home.updateEmail');
Route::get('delete/{id}', 'HomeController@delete')->name('home.delete');
Route::post('search', 'HomeController@search')->name('home.search');
Route::post('loadExtensions', 'HomeController@loadExtensions')->name('home.loadExtensions');
