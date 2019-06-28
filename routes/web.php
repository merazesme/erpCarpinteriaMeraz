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
<<<<<<< HEAD
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
=======
    return view('dashboard');
});

Route::get('/dashboard', function(){
	$modulo = "Dashboard";
	return view('dashboard', compact('modulo'));
});

Route::get('/login', function(){
	return view('login');
});

Route::get('/pagosdelmes_lista', function(){
	$modulo = "Listado";
	return view('pagosdelmes_lista', compact('modulo'));
});

Route::get('/pagosdelmes_conceptos', function(){
	$modulo = "Conceptos";
	return view('pagosdelmes_conceptos', compact('modulo'));
});

Route::get('/cajachica', function(){
	$modulo = "Caja chica";
	return view('cajachica', compact('modulo'));
>>>>>>> 8a906181fdf231319246e88cfa3701fd16e98f34
});
