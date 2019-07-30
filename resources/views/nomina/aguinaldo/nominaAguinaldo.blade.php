@extends('footer')
@extends('sidebar')
@extends('header')

@section('header')
@parent
<link href="{{asset('plugins/toast-master/css/jquery.toast.css')}}" rel="stylesheet">

<style media="screen">
	.hola {
		border: none;
    background-color: white;
	}
	.form-control:disabled {
		background-color: white;
	}
</style>
	<div id="main-wrapper">
		@section('sidebar')
		@parent
		<div class="page-wrapper">
			<div class="container-fluid">
				<div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
								<h4 class="card-title">{{ $modulo }}</h4>
								<br>
								<ul class="nav nav-tabs customtab2" role="tablist">
										<li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home7" role="tab"><span class="hidden-sm-up"><i class="ti-notepad"></i></span> <span class="hidden-xs-down">Aguinaldos</span></a> </li>
										<li class="nav-item" id="historial"> <a class="nav-link" data-toggle="tab" href="#profile7" role="tab"><span class="hidden-sm-up"><i class="ti-layers"></i></span> <span class="hidden-xs-down">Historial</span></a> </li>
								</ul>
									<!-- Tab panes -->
									<div class="tab-content">
										<div class="tab-pane active" id="home7" role="tabpanel">
											<div class="p-20">
												<div style="text-align:center">
													<button id="genera" type="button" class="btn waves-effect waves-light btn-primary"><i class="fa fa-plus"></i> Generar nómina</button>
												</div>
												<br>
												<span id="guardar">

												</span>
												<span style="text-align:center">
													<h5 id="anio-aguinaldo"></h5>
												</span>
												<div class="table-responsive m-t-40 tabla" >
													<!-- <table id="aguinaldos" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                              <thead>
                                  <tr>
                                    <th>Nombre</th>
                                    <th>Dias Trabajados</th>
																		<th>Sueldo Base</th>
																		<th>Subtotal</th>
                                    <th>Bono Extra</th>
                                    <th>Bono P y A</th>
                                    <th>Total</th>

                                  </tr>
                              </thead>
															<tfoot>
																<tr>
																	<th></th>
																	<th></th>
																	<th>Totales</th>
																	<th>12313</th>
																	<th>234</th>
																	<th>14124</th>
																	<th>123123</th>
																</tr>
                              </tfoot>
                              <tbody>
                                  <tr>
                                      <td>Itzel Rendón</td>
                                      <td>123</td>
                                      <td>123</td>
                                      <td>123</td>
                                      <td>123</td>
                                      <td>123</td>
                                      <td>123</td>
                                  </tr>
                                  <tr>
                                      <td>Itzel Rendón</td>
                                      <td>123</td>
                                      <td>123</td>
                                      <td>123</td>
                                      <td>123</td>
                                      <td>123</td>
                                      <td>123</td>
                                  </tr>
                                  <tr>
                                      <td>Itzel Rendón</td>
                                      <td>123</td>
                                      <td>123</td>
                                      <td>123</td>
                                      <td>123</td>
                                      <td>123</td>
                                      <td>123</td>
                                  </tr>
                                  <tr>
                                      <td>Itzel Rendón</td>
                                      <td>123</td>
                                      <td>123</td>
                                      <td>123</td>
                                      <td>123</td>
                                      <td>123</td>
                                      <td>123</td>
                                  </tr>
                              </tbody>
                          </table> -->
												</div>
											</div>
										</div>
										<div class="tab-pane   p-20" id="profile7" role="tabpanel">
											<div class="table-responsive m-t-20 tablaHistorial">
                        <!--<table id="myTable" class="table table-bordered table-striped">
                          <thead>
                              <tr>
                                <th>No. de nomina</th>
                                <th>Fecha</th>
																<th>Elaborada por</th>
                                <th>Acciones</th>
                              </tr>
                          </thead>
													<tfoot>
														<tr>
                              <th>No. de nomina</th>
                              <th>Fecha</th>
                              <th>Elaborada por</th>
                              <th>Acciones</th>
														</tr>
                          </tfoot>
                          <tbody>
                            <tr>
                              <td>1</td>
                              <td><i class="fa fa-clock-o"></i> 12/07/2019</td>
                              <td>Paola Cardenas</td>
                              <td class="text-nowrap">
                                <button type="button" class="btn waves-effect waves-light btn-xs btn-info">Excel</button>
                                <button type="button" class="btn waves-effect waves-light btn-xs btn-info">PDF</button>
                                <button type="button" class="btn waves-effect waves-light btn-xs btn-info">Printf</button>
                                <a href="#" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye "></i> </a>
                              </td>
                            </tr>

                          </tbody>
                        </table>-->
                      </div>
										</div>
									</div>
              </div>
							<!-- sample modal content -->
							<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
								<div class="modal-dialog modal-lg">
									<div class="modal-content">
										<div class="modal-header">
												<h4 class="modal-title" id="myLargeModalLabel"></h4>
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										</div>
										<div class="modal-body">
											<div class="container">
												<input type="text" name="" value="" hidden id="posic">
												<div class="row" >
													<div class="col-md-12 col-lg-4">
														<table class="table .table-bordered">
															<thead>
																<tr>
																	<th colspan="2" style="text-align-last: center"> <strong><p id="nombre"><p></strong></th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td><strong>Dias trabajados</strong></td>
																	<td> <input type="text" name="" value="" class="form-control" id="diasTrabajados"> </td>
																</tr>
																<tr>
																	<td><strong>Faltas sin justicar</strong></td>
																	<td> <input type="text" name="" value="" class="form-control" id="faltasSinJustificar"> </td>
																</tr>
																<tr>
																	<td><strong>Dias de descanso</strong></td>
																	<td> <input type="text" name="" value="" class="form-control" id="diasDescanso"> </td>
																</tr>
																<tr>
																	<td><strong>Horas sábado</strong></td>
																	<td> <input type="text" name="" value="" class="form-control" id="horasSabado"> </td>
																</tr>
																<tr>
																	<td><strong>Horas extra</strong></td>
																	<td> <input type="text" name="" value="" class="form-control" id="horasExtras"> </td>
																</tr>
															</tbody>
														</table>
													</div>
													<div class="col-md-12 col-lg-4">
														<table class="table .table-bordered">
															<thead>
																<tr>
																	<th colspan="2" style="text-align-last: center">Percepciones</th>
																</tr>
																<tr>
																	<th>Concepto</th>
																	<th>Importe</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td>Sueldo Base</td>
																	<td> <input type="text" name="" value="" class="form-control" id="sueldoBase"> </td>
																</tr>
																<tr>
																	<td>Hrs. Extra</td>
																	<td> <input type="text" name="" value="" class="form-control" id="horasExtrasMonto"> </td>
																</tr>
																<tr>
																	<td>Bono P y A</td>
																	<td> <input type="text" name="" value="" class="form-control" id="bonopya"> </td>
																</tr>
																<tr>
																	<td>Bono Extra</td>
																	<td> <input type="text" name="" value="" class="form-control" id="bonoExtra"> </td>
																</tr>
																<tr>
																	<th><strong>Total</strong></th>
																	<th><strong><input type="text" name="" value="" class="form-control" id="totalPercepciones"></strong></th>
																</tr>
															</tbody>
														</table>
													</div>
													<div class="col-md-12 col-lg-4">
														<table class="table .table-bordered">
															<thead>
																<tr>
																	<th colspan="2" style="text-align-last: center">Deducciones</th>
																</tr>
																<tr>
																	<th>Concepto</th>
																	<th>Importe</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td>Abono prestamo</td>
																	<td> <input type="number" name="" value="" class="form-control" id="abonoPrestamo"> </td>
																</tr>
																<tr>
																	<td>Infonavit</td>
																	<td><input type="text" name="" value="" class="form-control" id="infonavit"> </td>
																</tr>
																<tr>
																	<th><strong>Total</strong></th>
																	<th><strong><input type="text" name="" value="" class="form-control" id="totalDeducciones"></strong></th>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
												<div class="form-group row">
														<div class="col-8"></div>
                            <label for="total" class="col-2 col-form-label" style="font-weight: bold;">Total</label>
                            <div class="col-2">
                                <input class="form-control" type="text" value="" id="total"  style="font-weight: bold;">
                            </div>
                        </div>
											</div>
										</div>

										<div class="modal-footer">
											<span id="ver">
												<button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cerrar</button>
											</span>
											<span id="editar">
												<button type="button" class="btn btn-secondary waves-effect"  data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
						 						<button type="button" id="guardarDatos" class="btn btn-success waves-effect" data-dismiss="modal"><i class="mdi mdi-content-save"></i> Aceptar</button>
											</span>
										</div>
									</div>
									<!-- /.modal-content -->
								</div>
								<!-- /.modal-dialog -->
							</div>
							<!-- /.modal -->
            </div>
          </div>
      	</div>
			</div>
		</div>
		@section('footer')
		@parent
			@section('java')
		<script src="{{asset('plugins/toast-master/js/jquery.toast.js')}}"></script>
		<script src="{{asset('js/toastr2.js')}}"></script>

		<script>
    $(document).ready(function() {
			// $('#aguinaldos').DataTable({
	    //     dom: 'Bfrtip',
	    //     buttons: [
	    //         'excel', 'pdf', 'print'
	    //     ]
	    // });
			// Boton para guardar nomina
			var boton = `<button type="button" class="btn waves-effect waves-light btn-primary float-right" id="btnGuardar"><i class="fa fa-plus"></i> Guardar</button>`;
			var trabajadores = [];

			var anio = new Date();
			console.log(new Date())

		//	obtieneDatos();
			// Funcion que obtiene los datos necesarios para generar la nomina del trabajador

			// Funcion que hace los calculos y genera las filas de la tabla
			function muestra() {
				var tamanio = trabajadores.length;
				var html =
				 `<table id="aguinaldos" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
						 <thead>
								 <tr>
									 <th>Nombre</th>
									 <th>Dias Trabajados</th>
									 <th>Sueldo Base</th>
									 <th>Subtotal</th>
									 <th>Bono Extra</th>
									 <th>Bono P y A</th>
									 <th>Total</th>

								 </tr>
						 </thead>
						 <tfoot>
							 <tr>
								 <th></th>
								 <th></th>
								 <th>Totales</th>
								 <th>12313</th>
								 <th>234</th>
								 <th>14124</th>
								 <th>123123</th>
							 </tr>
						 </tfoot>
						<tbody>`;
				for(var x=0; x<tamanio; x++) {

						var tr = trabajadores[x]
						tr.diasTrabajados = 365;
						tr.bonoPyA = 0;
						tr.subtotal = (tr.Sueldo * 2) / 365 * tr.diasTrabajados;
						tr.bonoExtra = (((tr.Bono_Extra * 2) / 365) * tr.diasTrabajados) - tr.subtotal;
						tr.total = tr.subtotal + tr.bonoExtra + tr.bonoPyA;
						html += `<tr>
												<td>${tr.Nombre} ${tr.Apellidos}</td>
												<td>${tr.diasTrabajados}</td>
												<td>${tr.Sueldo}</td>
												<td>${tr.subtotal}</td>
												<td>${tr.bonoExtra}</td>
												<td>${tr.bonoPyA}</td>
												<td>${tr.total}</td>
										</tr>`;
				}
				html += `<tbody>
						</table>`;
				$( ".tabla" ).append(html);
			}

			function obtieneDatos() {
				$.ajax({
					type: "GET",
					dataType: "json",
					url: 'nominaAguinaldo/muestra',
					success: function (data) {
							console.log(data)
							if(data['Error'])
								swal("Error", "Ha ocurrido un error, inténtelo más tarde.", "error");
							else {
								//swal("Nómina generada", "Nómina generada exitosamente.", "success");
								toastSuccess("Nómina generada exitosamente.");
								trabajadores = data;
								muestra();
								$('#guardar').append(boton);
								$('#genera').hide("slow");
							}
					}, error: function(error) {
							toastError();
					}
				});
			}

			$('#genera').on('click', function() {
					$(this).attr('disabled', true);
					obtieneDatos();
			});
		});
    </script>
	@stop
@endsection
@endsection
@endsection
