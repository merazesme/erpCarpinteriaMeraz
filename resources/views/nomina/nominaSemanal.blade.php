@extends('footer')
@extends('sidebar')
@extends('header')

@section('header')
@parent
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
									@csrf
										<ul class="nav nav-tabs customtab2" role="tablist">
												<li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home7" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Semanal</span></a> </li>
												<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#profile7" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Historial</span></a> </li>
												<li class="nav-item" hidden> <a class="nav-link" data-toggle="tab" href="#messages7" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">Messages</span></a> </li>
										</ul>
										<!-- Tab panes -->
										<div class="tab-content">
												<div class="tab-pane active" id="home7" role="tabpanel">
														<div class="p-20">
															<div style="text-align:center">
																<button id="genera" type="button" class="btn waves-effect waves-light btn-primary"><i class="fa fa-plus"></i> Generar nómina</button>
															</div>
															<br>
															<button type="button" class="btn waves-effect waves-light btn-primary float-right" id="guardar"><i class="fa fa-plus"></i> Guardar</button>
															<h6 class="card-title" style="text-align:center"> 23 de junio de 2019 a 29 de junio de 2019</h6>

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
												<div class="tab-pane p-20" id="messages7" role="tabpanel">3</div>
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
		<script>
    $(document).ready(function() {
			// Objeto de asistencia
			$('#guardar').hide();
			$('input').prop('disabled', true).addClass('hola');
			var asistencia = {
				diasTrabajados: 6,
				faltasSinJustificar: 0,
				diasDescanso: 1,
				horasSabado: 2.5,
				horasExtras: 5,
			}

			var trabajadores = [];
			$('#genera').on('click', function() {
				  $('#guardar').show();
					$(this).hide();
					obtieneDatos();
			});


			function obtieneDatos() {
				$.ajax({
					type: "GET",
					dataType: "json",
					url: 'nominaSemanal/muestra',
					success: function (data) {
									console.log(data)
								  trabajadores = data;
								  muestra();
					}
				});
			}

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
																<a href="#" data-toggle="tooltip" data-original-title="Editar"> <i class="icon-pencil text-inverse m-r-10"></i> </a>
														</span>
														<span data-toggle="modal" data-target=".bs-example-modal-lg" data-body="${tr.id}" class="modal-show">
																<a href="#" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye "></i> </a>
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
			$(document).on('click','.modal-edit', function() {
				$('.modal-title').text('Editar nómina');
				var data = $(this).data('body')
				console.log(data);
				setData(data);
			});

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
				$('#abonoPrestamo').prop('disabled', false).removeClass('hola');
			}

			$(document).on('click','.modal-show', function() {
				$('.modal-title').text('Detalles nómina');
				var data = $(this).data('body')
				console.log(data);
				$('#abonoPrestamo').prop('disabled', true).addClass('hola');
				setData(data);
			});

			$(document).on('click','#guardar', function() {
					saveNomina();
			});

				// function mostrarPropiedades(objeto, nombreObjeto) {
				//   var resultado = ``;
				//   for (var i in objeto) {
				//     //objeto.hasOwnProperty se usa para filtrar las propiedades del objeto
				//     if (objeto.hasOwnProperty(i)) {
				//         resultado += `${nombreObjeto}.${i} = ${objeto[i]}\n`;
				// 				console.log(resultado)
				//     }
				//   }
				//   return resultado;
				// }
				function saveNomina() {
					$.ajax({
							 type: 'POST',
							 url: 'nominaSemanal/saveNomina',
							 data: {
								 '_token': $('meta[name="csrf-token"]').attr('content'),
								 'trabajadores':trabajadores,
							 },
								 success: function(data) {
											 console.log(data)
								}
					});
				}
				// function saveDetalleNomina() {
				// 	$.ajax({
			 	//        type: 'POST',
			 	//        url: 'nominaSemanal/saveDetalleNomina',
			 	//        data: {
				// 				 '_token': $('meta[name="csrf-token"]').attr('content'),
				// 				 'trabajadores':trabajadores,
				// 			 },
				// 		 	   success: function(data) {
				// 		 	         console.log(data)
				// 		 	  }
			 	//   });
				// }
				//
				// function conceptoNomina() {
				// 	$.ajax({
				// 			 type: 'POST',
				// 			 url: 'nominaSemanal/saveConceptoNomina',
				// 			 data: {
				// 				 '_token': $('meta[name="csrf-token"]').attr('content'),
				// 				 'trabajadores':trabajadores[0],
				// 			 },
				// 				 success: function(data) {
				// 							 console.log(data)
				// 				}
				// 	});
				// }
		 });
    </script>
@endsection
@endsection
@endsection
