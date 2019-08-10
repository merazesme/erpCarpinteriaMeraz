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
	return view('dashboard.dashboard', compact('modulo'));
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

		Route::get('/agregar', function(){
			$modulo = "Agregar trabajador";
			return view('trabajadores/formulario', compact('modulo'));
		});

		Route::post('/agregarTrabajador', 'Trabajadores@store');

		Route::get('/editar/{id}', function(){
			$modulo = "Editar trabajador";
			return view('trabajadores/formulario', compact('modulo'));
		});

		Route::get('/trabajador/{id}', 'Trabajadores@edit');
		Route::post('/editarTrabajador/{id}', 'Trabajadores@update');

		Route::get('/asistencia', function(){
			$modulo = "Asistencia";
			return view('trabajadores/asistencia', compact('modulo'));
		});
		Route::get('/prestamos', function(){
			$modulo = "Prestamos";
			return view('trabajadores/prestamos', compact('modulo'));
		});
});

Route::get('/pagosdelmes', function(){
	$modulo = "Listado";
	return view('pagosDelMes.pagosdelmes', compact('modulo'));
});

Route::get('/cajachica', function(){
	$modulo = "Caja chica";
	return view('cajaChica.cajachica', compact('modulo'));
});

Route::prefix('proveedores')->group(function () {
	/** Vistas */
	Route::get('lista', 		'proveedorController@list_resources');
	Route::get('agregar', 		'proveedorController@create');
	Route::get('editar/{id}', 	'proveedorController@show');
	Route::get('gasolina', 		'proveedorController@gasoline_list');
	/** Información */
	Route::get('lista/data',			'proveedorController@datos_proveedores');
	Route::get('especifico/{id}',		'proveedorController@datos_proveedor_especifico');
	Route::get('gasolina/data',			'proveedorController@datos_gasolina');
	Route::get('gasolina/data/cheques',	'proveedorController@datos_gasolina_cheques');
	Route::get('carros/data',			'proveedorController@datos_carros');
	/** Envío de información */
	Route::post	('agregar/proveedor',					'proveedorController@agregar_proveedor');
	Route::post	('actualizar/proveedor/estatus/{id}',	'proveedorController@actualizar_proveedor_estatus');
	Route::post	('actualizar/proveedor/{id}',			'proveedorController@actualizar_proveedor');
	Route::post	('agregar/factura/gasolina',			'proveedorController@agregar_factura_gasolina');
});

Route::prefix('login')->group(function () {
	Route::get ('/', 		'loginController@index');
	Route::post('ingresar', 'loginController@ingresar');
	Route::get('salir',     'loginController@salir');
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
		Route::post('/agregar_Tipomaterial', 'clasificacion_materiales@store');
		Route::get('/especifico/{id}', 'materiales@edit');
		Route::post('/modificar/{id}', 'materiales@update');
		Route::post('/eliminar/{id}', 'materiales@status');
		Route::post('/eliminarTipoMaterial/{id}', 'clasificacion_materiales@update');
	});
	Route::prefix('orden_compra')->group(function () {
		Route::get('/lista', 'compras@index');
		Route::get('/lista_materiales', 'compras@datosmaterial');
		Route::get('/lista_proveedor', 'compras@datosproveedor');
		// Route::post('/agregar_Tipomaterial', 'clasificacion_materiales@store');
		// Route::get('/especifico/{id}', 'materiales@edit');
		// Route::post('/modificar/{id}', 'materiales@update');
		// Route::post('/eliminar/{id}', 'materiales@status');
		// Route::post('/eliminarTipoMaterial/{id}', 'clasificacion_materiales@update');
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
		Route::get('/historialNomina', 'NominaSemanalController@historialNominaSemanal');
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

//Rutas del modulo de citas
Route::get('/consultarClientes', 'clientes@listarClientes');
Route::post('/nuevaCita', 'citas@store');
Route::get('/consultarCitas/{week}', 'citas@listarCitas');
Route::get('/consultaCitaFecha/{date}', 'citas@buscarCitaPorFecha');
Route::get('/montarDatosCita/{id}', 'citas@buscarCita');
Route::post('/editarCita/{id}', 'citas@update');
Route::post('/eliminarCita', 'citas@destroy');


//Rutas del modulo de pendientes
Route::get('/consultarPendientes', 'pendientes@listarPendientes');
Route::post('/nuevoPendiente', 'pendientes@store');
Route::post('/editarPendiente/{id}', 'pendientes@update');
Route::get('/montarDatosPendiente/{id}', 'pendientes@buscarPendiente');
Route::post('/actualizarEstatusPendiente', 'pendientes@actualizarEstatusPendiente');
Route::get('/eliminarPendientes', 'pendientes@destroy');

//Rutas del modulo de reporte del dia
Route::get('/consultarPagoCompras/{fecha}', 'carpeta_del_mes@pagoCompras');
Route::get('/consultarDetallePagoCompras/{id}', 'carpeta_del_mes@detallePagoCompras');
Route::get('/consultarPagoCotizaciones/{fecha}', 'carpeta_del_mes@pagoCotizaciones');
Route::get('/consultarPagoGasolina/{fecha}', 'carpeta_del_mes@pagoGasolina');
Route::get('/consultarDetallePagoGasolina/{id}', 'carpeta_del_mes@detallePagoGasolinas');
Route::get('/consultarFacturasSobrantes/{fecha}', 'carpeta_del_mes@facturasSobrantes');

//Rutas del modulo cotizaciones dashboard
Route::get('/consultarCotizacionesDashboard/{mes}', 'cotizaciones_dashborad@consultarCotizaciones');

//Rutas del modulo pagos del mes
Route::get('/consultarPagos', 'pagos_del_mes@listarPagos');
Route::get('/consultarUltimo', 'pagos_del_mes@consultarUltimoMes');
Route::post('/renovarHojaPagos', 'pagos_del_mes@renovarPagos');
Route::post('/subirArchivo/{id}', 'pagos_del_mes@pagoConcepto');
Route::get('/estadoVencido/{id}', 'pagos_del_mes@estadoVencido');
Route::post('/eliminarConcepto', 'pagos_del_mes@destroy');
Route::get('/montarDatosConcepto/{id}', 'pagos_del_mes@montarDatos'); 
Route::post('/nuevoConcepto', 'pagos_del_mes@store');
Route::post('/editarConcepto/{id}', 'pagos_del_mes@update');

//Rutas del modulo caja chica
Route::post('/nuevoCajaChica', 'Caja_chicas@store');
Route::get('/consultarCajaChica/{fechaInicial}/{fechaFinal}', 'Caja_chicas@consultar');
Route::get('/consultarConfiguracionCajaChica', 'Caja_chicas@consultarConfiguracion');
Route::get('/montarDatosRegistroCajaChica/{id}', 'Caja_chicas@montarDatos');
Route::post('/editarRegistroCajaChica/{id}', 'Caja_chicas@update');
Route::post('/eliminarRegistroCajaChica', 'Caja_chicas@destroy'); 
Route::get('/consultarUltimoCajaChica', 'Caja_chicas@consultarUltimaSemana');
Route::post('/nuevaHoja', 'Caja_chicas@nuevaHoja'); 


//Rutas del header para caja chica
Route::get('/consultarUltimoCajaChicaHeader', 'Headers@consultarUltimaSemana');
Route::get('/consultarCajaChicaHeader/{fechaInicial}/{fechaFinal}', 'Headers@consultar');
Route::get('/consultarConfiguracionCajaChicaHeader', 'Headers@consultarConfiguracion');