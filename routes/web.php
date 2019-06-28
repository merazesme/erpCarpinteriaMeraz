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
    return view('content');
});

Route::get('/modal', function(){
	return view('modal');
});

Route::get('/trabajadores', function(){
	return view('trabajadores');
});

Route::get('/agregarTrabajadores', function(){
	return view('agregarTrabajadores');
});

Route::get('/proveedores', function(){
	return view('proveedores');
});
