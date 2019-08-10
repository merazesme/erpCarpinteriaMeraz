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
		Route::post('/liquidarTrabajador/{id}', 'Trabajadores@liquidar');
		Route::post('/contratarTrabajador/{id}', 'Trabajadores@contratar');

		Route::get('/contrato/{id}', function(){
			$modulo = "Generar contrato";
			return view('trabajadores/formulario', compact('modulo'));
		});

		Route::get('/asistencias', function(){
			$modulo = "Asistencias";
			return view('trabajadores/asistencias', compact('modulo'));
		});

		Route::get('asistencias/tabla', 'Asistencias@index');

		Route::get('/prestamos', function(){
			$modulo = "Prestamos";
			return view('trabajadores/prestamos', compact('modulo'));
		});

		Route::get('prestamos/tabla', 'Prestamos@index');
		Route::post('prestamos/agregarPrestamo', 'Prestamos@store');
		Route::get('prestamos/trabajadores', 'Prestamos@trabajadores');
		Route::get('prestamos/verificarFirma/{id}/{firma}', 'Prestamos@verificarFirma');
		Route::get('prestamos/trabajador/{id}/{estado}', 'Prestamos@edit');
		Route::post('prestamos/editarPrestamo/{id}', 'Prestamos@update');
		Route::post('prestamos/agregarMovimiento', 'Prestamos@movimiento');
		Route::get('prestamos/consultarMovimientos/{id}', 'Prestamos@movimientosPrestamo');
});

Route::get('/pagosdelmes_lista', function(){
	$modulo = "Listado";
	return view('pagosDelMes.pagosdelmes_lista', compact('modulo'));
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
	Route::post	('agregar/pagar/factura',				'proveedorController@agregar_pagar_factura');
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
		//Para listar las ordenes de compra
		Route::get('/lista', 'compras@index');
		//Para listar los materiales y proveedores
		Route::get('/lista_materiales', 'compras@datosmaterial');
		Route::get('/lista_proveedor', 'compras@datosproveedor');
		//Para insertar una nueva orden de compra
		Route::post('/agregar_ordenCompra', 'compras@store');
		Route::post('/id_ordenCompra', 'compras@new_compra');
		//Para mostrar detalles de compra
		Route::get('/especifico/{id}', 'compras@show');
		//Para modificar la orden de compra
		Route::post('/modificar/{idcompra}', 'compras@update');
		Route::post('/modificar_material/{idMa}/{idmov}/{idprove}/{idCompra}', 'compras@actualizarcantidad');
		Route::post('/eliminarorden/{id}', 'compras@cancelar');
		//Pago compras
		//Route::post('/eliminarorden/{id}', 'compras@cancelar');
		Route::get('/lista_compras/{id}', 'compras@showcompras');
		Route::get('/proveedor_adeudo/{id}', 'compras@showAdeudoProveedor');
		Route::get('/cantidad_compras/{id}', 'compras@showTotalesCompras');
		Route::post('/insertar_pago_proveedor/{id}', 'compras@insertar_pago_proveedor');

	});
	Route::prefix('orden_salida')->group(function () {
		//Para tabla general de orden salida
		Route::get('/lista', 'orden_salidas@showTablaOrdenSalida');
		//Para nueva orden de salida
		Route::get('/lista_trabajador', 'orden_salidas@showTrabajadores');
		Route::get('/lista_materiales', 'orden_salidas@showMateriales');
		Route::get('/lista_materialesExistencia/{id}', 'orden_salidas@showMaterialesExistencia');
		Route::post('/agregar_ordenSalida', 'orden_salidas@new_ordeSalida');
		Route::post('/agregar_movmateriales', 'orden_salidas@new_movmateriales');
		Route::post('/modificar_existencia/{id}', 'orden_salidas@update_materialExistencia');
		Route::post('/agregar_salidamovmateriales', 'orden_salidas@new_salida_movmateriales');
		//Para modificar orden de salida
		Route::get('/lista_orden_salidas/{id}', 'orden_salidas@showOrdenSalida');
		Route::post('/modificar_ordenSalida/{id}', 'orden_salidas@update_ordenSalida');
		Route::post('/eliminar_ordenSalida/{id}', 'orden_salidas@cancel_ordenSalida');
		Route::get('/detalles_ordenSalida/{id}', 'orden_salidas@showOrdenSalidaDetalles');
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


Route::prefix('/productos')->group(function (){
	Route::get('/', function(){
		$modulo = "Productos";
		return view('productos', compact('modulo'));
	});

	Route::get('/lista_productos', 'productos@index');
	Route::get('/lista_matprima', 'productos@showMateriaPrima');
	Route::get('/lista_matprima_especifico/{id}', 'productos@showMateriaPrimaEspecifico');
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

	Route::get('/modificar/{id}', function(){
		$modulo = "Modificar Cotización";
		return view('cotizaciones/nuevaCotizacion', compact('modulo'));
	});

	Route::get('/getRecomendados', 'cotizaciones@listRecomendados');
	Route::post('/nuevoRecomendado', 'cotizaciones@storeRecomendado');
	Route::get('/getSpecificRecomendados/{id}', 'cotizaciones@showRecomendado');
	Route::post('/modificarRecomendado/{id}', 'cotizaciones@updateRecomendado');

	Route::get('/getClientes', 'cotizaciones@listClientes');

	Route::get('/getProductos', 'cotizaciones@listProductos');
	Route::get('/getSpecificProducto/{id}', 'cotizaciones@showProducto');
	Route::get('/getSpecificProductoMaterial/{id}', 'cotizaciones@showProductoMaterial');
	Route::post('/nuevoProducto', 'cotizaciones@storeProducto');
	Route::post('/modificarProducto/{id}', 'cotizaciones@updateProducto');

	Route::get('/getMateria', 'cotizaciones@listMateria');

	Route::get('/getIVA', 'cotizaciones@getIVA');

	Route::post('/nuevaCotizacion', 'cotizaciones@store');
	Route::get('/getCotizaciones', 'cotizaciones@index');
	Route::post('/cambiarEstado/{id}', 'cotizaciones@updateEstado');
	Route::get('/cotizacion/{id}', 'cotizaciones@edit');
	Route::get('/cotizacionProducto/{id}', 'cotizaciones@editCotiProducto');
	Route::post('/modificarCotizacion/{id}', 'cotizaciones@update');

	Route::get('/cotizacionesCliente/{id}', 'cotizaciones@getCotizaciones_Cliente');
	Route::get('/cotizacionDetalle/{id}', 'cotizaciones@getCotizacionDetalle');
});

Route::prefix('nomina')->group(function () {
	Route::prefix('nominaSemanal')->group(function () {
		Route::get('/', 'NominaSemanalController@index');
		Route::get('/detalles/{semana}', 'NominaSemanalController@detalles');
		Route::get('/detalleNomina/{semana}/{fechai?}/{fechaf?}', 'NominaSemanalController@detalleNomina');
		Route::get('/muestra/{fechai}/{fechaf}', 'NominaSemanalController@trabajadores');
		Route::get('/historialNomina/{tipo}', 'NominaSemanalController@historialNominaSemanal');
		Route::post('/saveNomina', 'NominaSemanalController@nomina');
		Route::get('/confirma/{numero}', 'NominaSemanalController@validaNomina');
	});

	Route::prefix('nominaAguinaldo')->group(function () {
		Route::get('/', 'NominaAguinaldoController@index');
		Route::get('/muestra', 'NominaAguinaldoController@create');
		Route::get('/detalles/{semana}', 'NominaAguinaldoController@detalles');
	});

	Route::prefix('nominaVacacional')->group(function () {
		Route::get('/', function() {
			$modulo = "Nómina Vacacional";
			return view('nomina/vacacional/nominaVacacional', compact('modulo'));
		});

		Route::get('/detalles/{anios}', function($anios){
			$modulo = "Detalles de Nómina Vacacional";
			return view('nomina/vacacional/detalles', compact('modulo', 'anios'));
		});

	});
});

Route::prefix('roles')->group(function () {
	/** Vistas */
	Route::get('/', 'rolController@index');
	/** Obtener información */
	Route::get('data', 					'rolController@list_resources');
	Route::get('data/rol/usuario/{id}', 'rolController@usuarios_per_role');
	Route::get('data/especifico/{id}', 	'rolController@show');
	/** Mandar información */
	Route::post('agregar', 					'rolController@store');
	Route::post('actualizar/{id}', 			'rolController@update');
	Route::post('actualizar/estatus/{id}', 	'rolController@update_estatus');
});

//Configuraciones vista principal
Route::prefix('/configuraciones')->group(function () {
	Route::get('/', function(){
		$modulo = "Configuraciones";
		return view('configuracion/configuracion');
	});
	Route::post('/actualizarGeneral', 'configuraciones@storeGeneral');
	Route::post('/actualizarHorario', 'configuraciones@storeHorario');
	Route::get('/datos/{id}', 'configuraciones@show');
});

Route::prefix('/carro')->group(function () {
	/** Vistas */
	Route::get('/', 'carroController@index');

	Route::get('data', 'carroController@data');
	Route::get('dataTrabajadores', 'carroController@dataTrabajadores');

	Route::post('agregar', 	 'carroController@store');
	Route::post('actualizar/{id}', 'carroController@update');
	Route::post('actualizar/estatus/{id}', 'carroController@update_estatus');

});

Route::get('/usuarios', function(){
	$modulo = "Usuarios";
	return view('usuarios', compact('modulo'));
});

Route::get('/consultarClientes', 'clientes@listarClientes');

Route::post('/nuevaCita', 'citas@store');

Route::get('/consultarCitas/{week}', 'citas@listarCitas');

Route::get('/montarDatosCita/{id}', 'citas@buscarCita');

Route::post('/editarCita/{id}', 'citas@update');
