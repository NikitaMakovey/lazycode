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
    return view('main');
});

Route::get('/admin', function () {
    return view('layouts.master');
})->name('admin');

Auth::routes();

Route::get('{path}', 'HomeController@index')->where('path', '([A-z/0-9]+)?'); //([A-z\d-\/_.]+)?

