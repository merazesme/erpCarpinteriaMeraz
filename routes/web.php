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
		Route::get('/lista', function(){
			$modulo = "Listado de trabajadores";
			return view('trabajadores/listaTrabajadores', compact('modulo'));
		});
		Route::get('/tabla', 'Trabajadores@index');

		Route::get('agregar', function(){
			$modulo = "Agregar trabajador";
			return view('trabajadores/agregarTrabajador', compact('modulo'));
		});

		Route::post('/agregarTrabajador', 'Trabajadores@store');

		Route::get('editar', function(){
			$modulo = "Editar trabajador";
			return view('trabajadores/agregarTrabajador', compact('modulo'));
		});

		Route::get('/editarTrabajador/{id}', 'Trabajadores@edit');

		Route::get('/asistencia', function(){
			$modulo = "Asistencia";
			return view('trabajadores/asistencia', compact('modulo'));
		});
		Route::get('prestamos', function(){
			$modulo = "Prestamos";
			return view('trabajadores/prestamos', compact('modulo'));
		});
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
	Route::get('lista', 		'proveedorController@list_resources');
	Route::get('agregar', 		'proveedorController@create');
	Route::get('editar/{id}', 	'proveedorController@show');
	Route::get('gasolina', 		'proveedorController@gasoline_list');
});

Route::prefix('login')->group(function () {
	/** Temporal routes */
	Route::get ('/', 		'loginController@index');
	Route::post('ingresar', 'loginController@ingresar');
});

Route::prefix('facturas_sobrantes')->group(function () {
	/** Temporal routes */
    Route::get('lista', function () {
		$modulo = 'Facturas sobrantes';
		return view('facturas_sobrantes_show', compact('modulo'));
	});

});

Route::prefix('inventario')->group(function () {
	// Rutas para las web services
	Route::prefix('materiales')->group(function () {
		Route::get('/lista', 'materiales@index');
		Route::get('/tipo_material', 'clasificacion_materiales@index');
		Route::post('/agregar_material', 'materiales@store');
		Route::get('/especifico/{id}', 'materiales@edit');
		Route::post('/modificar/{id}', 'materiales@update');
		Route::post('/eliminar/{id}', 'materiales@status');
	});
	/** Temporal routes */
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

});

Route::prefix('perfil')->group(function () {
	/** Temporal routes */
	Route::get('ver_perfil', function(){
		$modulo = "Perfil";
		return view('perfil', compact('modulo'));
	});

	Route::get('cerrar_sesion', function(){
		$modulo = "Cerrar sesión";
		return view('cerrar_sesion', compact('modulo'));
	});

});

Route::get('/movimientos', function(){
	$modulo = "Movimientos";
	return view('movimientos', compact('modulo'));
});

//Clientes funciones de datos
Route::prefix('/clientes')->group(function () {
	Route::get('/', function(){
		$modulo = "Clientes";
		return view('clientes/clientes', compact('modulo'));
	});
	Route::get('/lista', 'clientes@index');
	Route::post('/agregar', 'clientes@store');
	Route::get('/especifico/{id}', 	'clientes@edit');
	Route::post('/modificar/{id}', 'clientes@update');
	Route::post('/eliminar/{id}', 'clientes@destroy');
});

//Cotizacion vistas y funciones
Route::prefix('/cotizaciones')->group(function () {
	Route::get('/', function(){
		$modulo = "Cotizaciones";
		return view('cotizaciones/cotizaciones', compact('modulo'));
	});

	Route::get('/nueva', function(){
		$modulo = "Nueva Cotización";
		return view('cotizaciones/nuevaCotizacion', compact('modulo'));
	});

	Route::get('/modificar', function(){
		$modulo = "Modificar Cotización";
		return view('cotizaciones/nuevaCotizacion', compact('modulo'));
	});
});

Route::prefix('nomina')->group(function () {
	Route::prefix('nominaSemanal')->group(function () {
		Route::get('/', 'NominaSemanalController@index');
		Route::get('/muestra', 'NominaSemanalController@trabajadores');
		Route::post('/saveNomina', 'NominaSemanalController@nomina');
		Route::post('/saveDetalleNomina', 'NominaSemanalController@detalleNomina');
		Route::post('/saveConceptoNomina', 'NominaSemanalController@conceptoNomina');
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

//Configuraciones vista principa


Route::prefix('/configuraciones')->group(function () {
	Route::get('/', function(){
		$modulo = "Configuraciones";
		return view('configuracion/configuracion');
	});
	Route::post('/actualizarGeneral', 'configuraciones@storeGeneral');
	Route::post('/actualizarHorario', 'configuraciones@storeHorario');
	Route::get('/datos/{id}', 'configuraciones@show');
});

Route::get('/carro', function(){
	$modulo = "Carros";
	return view('carro', compact('modulo'));
});

Route::get('/usuarios', function(){
	$modulo = "Usuarios";
	return view('usuarios', compact('modulo'));
});
