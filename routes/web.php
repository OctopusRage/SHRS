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
Route::group(['namespace'=>'Admin'], function(){
    Route::get('/admin/movements/custom_create/{id}', 'MoveCrudController@customCreate')->name('custom.movements.create');
    Route::post('/admin/movements/save', 'MoveCrudController@customSave')->name('custom.movements.save');
});
