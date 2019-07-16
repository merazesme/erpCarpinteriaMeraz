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

Route::get('/', function(){
	$modulo = "Home";
	return view('dashboard', compact('modulo'));
});

Route::get('/modal', function(){
	$modulo = "Modal";
	return view('modal', compact('modulo'));
});

Route::prefix('trabajadores')->group(function () {
		Route::get('lista', function(){
			$modulo = "Listado trabajadores";
			return view('listaTrabajadores', compact('modulo'));
		});
		Route::get('agregar', function(){
			$modulo = "Agregar trabajador";
			return view('agregarTrabajador', compact('modulo'));
		});
		Route::get('/asistencia', function(){
			$modulo = "Asistencia";
			return view('asistencia', compact('modulo'));
		});
		Route::get('prestamos', function(){
			$modulo = "Prestamos";
			return view('prestamos', compact('modulo'));
		});
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
});

Route::prefix('proveedores')->group(function () {
	/** Temporal routes */
	Route::get('lista', 		'proveedorController@list_resources');
	Route::get('agregar', 		'proveedorController@create');
	Route::get('editar/{id}', 	'proveedorController@show');
	Route::get('gasolina', 		'proveedorController@gasoline_list');
});

Route::prefix('facturas_sobrantes')->group(function () {
	/** Temporal routes */
    Route::get('lista', function () {
		$modulo = 'Facturas sobrantes';
		return view('facturas_sobrantes_show', compact('modulo'));
	});
});

Route::get('/materiales', function(){
	$modulo = "Materiales";
	return view('materiales', compact('modulo'));
});

Route::get('/orden_compra', function(){
	$modulo = "Orden de Compra";
	return view('orden_compra', compact('modulo'));
});

Route::get('/orden_salida', function(){
	$modulo = "Orden de Salida";
	return view('orden_salida', compact('modulo'));
});

Route::get('/movimientos', function(){
	$modulo = "Movimientos";
	return view('movimientos', compact('modulo'));
});

Route::get('/clientes', function(){
	$modulo = "Clientes";
	return view('clientes', compact('modulo'));
});

Route::prefix('/clientes')->group(function () {
	/** Temporal routes */
	Route::get('/lista', 'clientes@index');
	Route::post('/agregar', 'clientes@store');
	Route::get('/especifico/{id}', 	'clientes@edit');
	Route::post('/modificar/{id}', 'clientes@update');
	// Route::get('gasolina', 		'proveedorController@gasoline_list');
});

Route::get('/cotizaciones', function(){
	$modulo = "Cotizaciones";
	return view('cotizaciones', compact('modulo'));
});

Route::get('/nuevaCotizacion', function(){
	$modulo = "Nueva Cotización";
	return view('nuevaCotizacion', compact('modulo'));
});

Route::get('/modificarCotizacion', function(){
	$modulo = "Modificar Cotización";
	return view('nuevaCotizacion', compact('modulo'));
});

Route::prefix('nomina')->group(function () {

	Route::prefix('nominaSemanal')->group(function () {
		Route::get('/', 'NominaController@index');
		Route::post('/save', 'NominaController@store');
	});
	
	Route::get('/historialNomina', function(){
		$modulo = "Nómina Semanal";
		return view('nomina/nominaSemanalIndex', compact('modulo'));
	});

	Route::get('/detalleNomina', function(){
		$modulo = "Nómina del: ";
		return view('nomina/detalleNomina', compact('modulo'));
	});

	Route::get('/nominaUtilidad', function(){
		$modulo = "Nómina de utilidades";
		return view('nomina/nominaUtilidad', compact('modulo'));
	});

	Route::get('/nominaAguinaldo', function(){
		$modulo = "Nómina Aguinaldo";
		return view('nomina/nominaAguinaldo', compact('modulo'));
	});

	Route::get('/nominaVacacional', function(){
		$modulo = "Nómina Vacacional";
		return view('nomina/nominaVacacional', compact('modulo'));
	});

});

Route::get('/configuracion', function(){
	$modulo = "Configuraciones";
	return view('configuracion', compact('modulo'));
});

Route::get('/carro', function(){
	$modulo = "Carros";
	return view('carro', compact('modulo'));
});

Route::get('/usuarios', function(){
	$modulo = "Usuarios";
	return view('usuarios', compact('modulo'));
});
