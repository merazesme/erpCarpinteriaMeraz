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
								<ul class="nav nav-tabs customtab2" role="tablist">
										<li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home7" role="tab"><span class="hidden-sm-up"><i class="ti-notepad"></i></span> <span class="hidden-xs-down">Semanal</span></a> </li>
										<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#profile7" role="tab"><span class="hidden-sm-up"><i class="ti-layers"></i></span> <span class="hidden-xs-down">Historial</span></a> </li>
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
													<h5 id="semanas"></h5>
													<h5 id="rango-semana"></h5>
												</span>
												<div class="table-responsive m-t-40 tabla" >
													<!--<table id="demo-foo-accordion" class="table m-b-0 toggle-arrow-tiny">
														<thead>
																<tr>
																		<th data-toggle="true" data-sort-ignore="true"> First Name </th>

																		<th data-hide="phone"> Percepciones </th>
																		<th data-hide="phone"> Deducciones </th>
																		<th data-hide="phone"> Neto a pagar </th>
																		<th data-hide="phone"> Acciones </th>

																		<th data-hide="all">  </th>

																</tr>
														</thead>
														<tbody>
																<tr>
																		<td>Isidra</td>
																		<td>$198712</td>
																		<td>$81731</td>
																		<td>8273823</td>
																		<td class="text-nowrap" style="padding-left: 50px;">
																				<a href="#" data-toggle="tooltip" data-original-title="Editar"> <i class="icon-pencil text-inverse m-r-10"></i> </a>
																		</td>
																		<td >
																			<div class="row" style="padding-top: 15px;background: gainsboro;">
																				<div class="col-md-4">

																					<table class="table .table-bordered">

																						<tbody>
																							<tr>
																								<td><strong>Dias trabajados</strong></td>
																								<td>2</td>
																							</tr>
																							<tr>
																								<td><strong>Faltas sin justicar</strong></td>
																								<td>1323</td>
																							</tr>
																							<tr>
																								<td><strong>Dias de descanso</strong></td>
																								<td>2237</td>
																							</tr>
																							<tr>
																								<td><strong>Horas sábado</strong></td>
																								<td>2237</td>
																							</tr>
																							<tr>
																								<td><strong>Horas extra</strong></td>
																								<td>2237</td>
																							</tr>
																						</tbody>
																					</table>
																				</div>
																				<div class="col-md-4">
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
																								<td>1323</td>
																							</tr>
																							<tr>
																								<td>Hrs. Extra</td>
																								<td>2237</td>
																							</tr>
																							<tr>
																								<td>Bono P y A</td>
																								<td>2237</td>
																							</tr>
																							<tr>
																								<td>Bono Extra</td>
																								<td>2237</td>
																							</tr>
																						</tbody>
																					</table>
																				</div>
																				<div class="col-md-4">
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
																								<td>1323</td>
																							</tr>
																							<tr>
																								<td>Infonavit</td>
																								<td>2237</td>
																							</tr>
																						</tbody>
																					</table>
																				</div>
																			</div>
																		</td>
																</tr>
														</tbody>
												</table>-->
												</div>
											</div>
										</div>
										<div class="tab-pane  p-20" id="profile7" role="tabpanel">
											<div class="table-responsive m-t-20" >
                        <table id="myTable" class="table table-bordered table-striped">
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
                            <tr>
                              <td>2</td>
                              <td><i class="fa fa-clock-o"></i> 19/07/2019</td>
                              <td>Paola Cardenas</td>
                              <td class="text-nowrap">
                                <button type="button" class="btn waves-effect waves-light btn-xs btn-info">Excel</button>
                                <button type="button" class="btn waves-effect waves-light btn-xs btn-info">PDF</button>
                                <button type="button" class="btn waves-effect waves-light btn-xs btn-info">Printf</button>
                                <a href="#" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye "></i> </a>
                              </td>
                            </tr>
                            <tr>
                              <td>3</td>
                              <td><i class="fa fa-clock-o"></i> 23/07/2019</td>
                              <td>Paola Cardenas</td>
                              <td class="text-nowrap">
                                <button type="button" class="btn waves-effect waves-light btn-xs btn-info">Excel</button>
                                <button type="button" class="btn waves-effect waves-light btn-xs btn-info">PDF</button>
                                <button type="button" class="btn waves-effect waves-light btn-xs btn-info">Printf</button>
                                <a href="#" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye "></i> </a>
                              </td>
                            </tr>
                          </tbody>
                        </table>
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
																	<td> <input type="text" name="" value="" class="form-control" id="abonoPrestamo"> </td>
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
												<div class="row">
													<div class="col-md-12">
														<div class="form-group m-t-40 row">

                                <label for="total" class="col-2 col-form-label">Total</label>
                                <div class="col-10">
                                    <input class="form-control" type="text" value="" id="total">
                                </div>

                            </div>
													</div>
												</div>
											</div>
										</div>

										<div class="modal-footer">
												<button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
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
		<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.js"></script>

		<script>
    $(document).ready(function() {
			// Desactiva los inputs del modal
			$('input').prop('disabled', true).addClass('hola');
			// Boton para guardar nomina
			var boton = `<button type="button" class="btn waves-effect waves-light btn-primary float-right" id="btnGuardar"><i class="fa fa-plus"></i> Guardar</button>`;
			// Funcion que regresa la semana del año de la fecha actual
			Date.prototype.getWeekNumber = function () {
			    var d = new Date(+this);  //Creamos un nuevo Date con la fecha de "this".
			    d.setHours(0, 0, 0, 0);   //Nos aseguramos de limpiar la hora.
			    d.setDate(d.getDate() + 4 - (d.getDay() || 7)); // Recorremos los días para asegurarnos de estar "dentro de la semana"
			    //Finalmente, calculamos redondeando y ajustando por la naturaleza de los números en JS:
			    return Math.ceil((((d - new Date(d.getFullYear(), 0, 1)) / 8.64e7) + 1) / 7);
			};
			var numSemana = new Date().getWeekNumber(); // Resultado
			$('#semanas').text(`Semana ${numSemana} del año`);
			var meses = ["enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"];
			/* Obtiene el primer y ultimo dia de la semana (objetos) numero 'x' de año
					https://es.stackoverflow.com/questions/7003/c%C3%B3mo-puedo-obtener-el-primer-y-ultimo-d%C3%ADa-de-una-semana-concreta-en-javascript
					https://momentjs.com/docs/#/displaying/as-object/
			*/
			var fechai = moment().isoWeek(numSemana).startOf("isoweek").toObject();
			var fechaf = moment().isoWeek(numSemana).endOf("isoweek").toObject();

			$('#rango-semana').text(`${fechai.date} de ${meses[fechai.months]} de ${fechai.years} al ${fechaf.date} de ${meses[fechai.months]} de ${fechaf.years}`);
			// Objeto de asistencia
			var asistencia = {
				diasTrabajados: 6,
				faltasSinJustificar: 0,
				diasDescanso: 1,
				horasSabado: 2.5,
				horasExtras: 5,
			}

			// Aqui se guardan todos los datos de nomina del trabajador
			var trabajadores = [];

			$('#genera').on('click', function() {
					$(this).attr('disabled', true);
					obtieneDatos();
			});

			// Funcion que obtiene los datos necesarios para generar la nomina del trabajador
			function obtieneDatos() {
				$.ajax({
					type: "GET",
					dataType: "json",
					url: 'nominaSemanal/muestra',
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

			// Funcion que hace los calculos y genera las filas de la tabla
			function muestra() {
				var tamanio = trabajadores.length;
				var html =
				 `<table id="demo-foo-accordion" class="table m-b-0 toggle-arrow-tiny">
						<thead>
								<tr>
										<th data-toggle="true" data-sort-ignore="true"> Nombre  </th>
										<th data-hide="phone"> Percepciones </th>
										<th data-hide="phone"> Deducciones </th>
										<th data-hide="phone"> Neto a pagar </th>
										<th data-hide="phone"> Acciones </th>
								</tr>
						</thead>
						<tbody>`;
				for(var x=0; x<tamanio; x++) {
						trabajadores[x].Nomina = {
							xDeducciones: {}
						};
						var tr = trabajadores[x]
						tr.NombreyApodo = tr.Nombre + ' ' + tr.Apellidos + ' (' + tr.Apodo + ')'
						// 	* 	Percepciones	* 	//
						tr.Nomina.xPercepciones = {
							'Sueldo':  (tr.Sueldo/48) * (asistencia.diasTrabajados * 8 ) + (asistencia.diasDescanso * 8) - 8 - (2.5) + asistencia.horasSabado,
							'Horas Extras':  (tr.Monto_Hora_Extra / 5) * (asistencia.horasExtras),
							'Bono P y A':  (tr.Bono_Produc_Asis/6) * (asistencia.diasTrabajados + asistencia.diasDescanso - 1),
							'Bono Extra':  (tr.Bono_Extra/6) * (asistencia.diasTrabajados + asistencia.diasDescanso - 1),
						};
						tr.Nomina.xPercepciones['Total Percepciones']=tr.Nomina.xPercepciones['Sueldo'] + tr.Nomina.xPercepciones['Horas Extras'] + tr.Nomina.xPercepciones['Bono P y A'] + tr.Nomina.xPercepciones['Bono Extra'];
						// * 		Deducciones		*		//
						tr.totalPrestamos >= 100 ? tr.Nomina.xDeducciones["Abono Prestamo"] = 100 :
						tr.totalPrestamos > 0 ? tr.Nomina.xDeducciones["Abono Prestamo"] = tr.totalPrestamos :
						tr.Nomina.xDeducciones["Abono Prestamo"] = 0;

						tr.Infonavit != 0 ? tr.Nomina.xDeducciones['Infonavit'] = tr.Infonavit :
						tr.Nomina.xDeducciones['Infonavit'] = 0;

						tr.Nomina.xDeducciones['Total Deducciones'] = tr.Nomina.xDeducciones["Abono Prestamo"] + tr.Nomina.xDeducciones['Infonavit'];
						// Redondea el total
						tr.xTotal = Math.round(tr.Nomina.xPercepciones['Total Percepciones'] - tr.Nomina.xDeducciones['Total Deducciones']);

						html += `<tr>
												<td>${tr.Nombre} ${tr.Apellidos}</td>
												<td>${tr.Nomina.xPercepciones['Total Percepciones']}</td>
												<td>${tr.Nomina.xDeducciones['Total Deducciones']}</td>
												<td>${tr.xTotal}</td>
												<td>
														<span data-toggle="modal" data-target=".bs-example-modal-lg" data-body="${tr.id}" class="modal-edit">
																<a data-toggle="tooltip" data-original-title="Editar"> <i class="icon-pencil text-inverse m-r-10"></i> </a>
														</span>
														<span data-toggle="modal" data-target=".bs-example-modal-lg" data-body="${tr.id}" class="modal-show">
																<a data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye "></i> </a>
														</span>
												</td>

										 </tr>`;
				}
				html += `<tbody>
						</table>`;
				$( ".tabla" ).append(html);
				$('#demo-foo-accordion').DataTable({
						dom: 'Bfrtip',
						buttons: [
								'excel', 'pdf', 'print'
						]
				});
			}

			// Funcion que muestra los datos en el modal
			function setData(data) {
				var results = trabajadores.filter(function (trabajador) { return trabajador.id == data; });
				var objeto = (results.length > 0) ? results[0] : null;
				$('#nombre').text(objeto.NombreyApodo);
				$('#diasTrabajados').val(asistencia.diasTrabajados);
				$('#faltasSinJustificar').val(asistencia.faltasSinJustificar);
				$('#diasDescanso').val(asistencia.diasDescanso);
				$('#horasSabado').val(asistencia.horasSabado);
				$('#horasExtras').val(asistencia.horasExtras);
				$('#sueldoBase').val(objeto.Sueldo);
				$('#horasExtrasMonto').val(objeto.Nomina.xPercepciones['Horas Extras']);
				$('#bonopya').val(objeto.Nomina.xPercepciones['Bono P y A']);
				$('#bonoExtra').val(objeto.Nomina.xPercepciones['Bono Extra']);
				$('#totalPercepciones').val(objeto.Nomina.xPercepciones['Total Percepciones']);
				$('#abonoPrestamo').val(objeto.Nomina.xDeducciones['Abono Prestamo']);
				$('#infonavit').val(objeto.Infonavit);
				$('#totalDeducciones').val(objeto.Nomina.xDeducciones['Total Deducciones']);
				$('#total').val(objeto.xTotal);
			}

			// Muestra el modal para editar nomina
			$(document).on('click','.modal-edit', function() {
				$('.modal-title').text('Editar nómina');
				var data = $(this).data('body')
				$('#abonoPrestamo').prop('disabled', false).removeClass('hola');
				setData(data);
			});

			// Muestra el modal de detalles de nomina
			$(document).on('click','.modal-show', function() {
				$('.modal-title').text('Detalles nómina');
				var data = $(this).data('body')
				$('#abonoPrestamo').prop('disabled', true).addClass('hola');
				setData(data);
			});

			$(document).on('click','#btnGuardar', function() {
					$(this).attr('disabled', true);
					saveNomina();
			});

			// Funcion que guarda la nomina en la base de datos
			function saveNomina() {
				$.ajax({
						 type: 'POST',
						 url: 'nominaSemanal/saveNomina',
						 data: {
							 '_token': $('meta[name="csrf-token"]').attr('content'),
							 'trabajadores':trabajadores,
						 },
						 success: function(data) {
								 console.log(data);
								 if(data['Error'])
	 								swal("Error", "Ha ocurrido un error, inténtelo más tarde.", "error");
		 						 else {
									 toastSuccess("Nómina guardada exitosamente.");
									 $('#guardar').hide("slow");
								 }
						}, error: function(error) {
								toastError();
						}
				});
			}
		});
    </script>
	@stop
@endsection
@endsection
@endsection
