@extends('footer')
@extends('sidebar')
@extends('header')

@section('header')
@parent
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


			var asistencia = {
				diasTrabajados: 6,
				faltasSinJustificar: 0,
				diasDescanso: 1,
				horasSabado: 2.5,
				horasExtras: 5,
			}

			//obtieneDatos();
			var trabajadores = [];

				$('#genera').on('click', function() {
						// Aqui se realiza obtener los datos de todas las tablas relacionadas
						// a nomina para hacer todos los calculos

					  $('#guardar').show();
						$(this).hide();


								//     $('<table>', {
								//         'class': 'table m-b-0 toggle-arrow-tiny',
								//         'data-page-size': '5',
								//
								//     }).append(
								//       $('<thead>')
								//         .append(
								//           $('<tr>',{
								//
								//           })
								//         )
								//     )
								//
								// .show().appendTo('.tabla');
						obtieneDatos()
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

									<th data-hide="all">  </th>

							</tr>
					</thead>
						<tbody>

					`;

					for(var x=0; x<tamanio; x++) {
							var tr = trabajadores[x]
							// Percepciones
							tr.sueldoBase = (tr.sb/48) * (asistencia.diasTrabajados * 8 ) + (asistencia.diasDescanso * 8) - 8 - (2.5) + asistencia.horasSabado;
							tr.horasExtras = (tr.montoHoraExtra / 5) * (asistencia.horasExtras);
							tr.bonoPyA = (tr.Bono_Produc_Asis/6) * (asistencia.diasTrabajados + asistencia.diasDescanso - 1);
							tr.bonoExtra = (tr.Bono_Extra/6) * (asistencia.diasTrabajados + asistencia.diasDescanso - 1);
							tr.totalPercepciones = tr.sueldoBase + tr.horasExtras + tr.bonoPyA + tr.bonoExtra;

							// Deducciones
							if(tr.totalPrestamos >= 100)
								tr.abonoPrestamo = 100;
							else
								tr.abonoPrestamo = tr.totalPrestamos;
							tr.totalDeducciones = tr.abonoPrestamo + tr.Infonavit;

							//Total
							tr.Total = Math.round(tr.totalPercepciones - tr.totalDeducciones);

							html += `		<tr>
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
									</tr>`;

					}
					html += `<tbody>
							</table>`;

					$( ".tabla" ).append(html)
						//$('#cuerpo').append(html);
						$('#demo-foo-accordion').DataTable({
								dom: 'Bfrtip',
								buttons: [
										'excel', 'pdf', 'print'
								]
						});
				}

				//
				// $.ajaxSetup({
				//   headers: {
				//     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				//   }
				// });

        $('#myTable').DataTable();

            var table = $('#example').DataTable({
                "columnDefs": [{
                    "visible": false,
                    "targets": 2
                }],
                "order": [
                    [2, 'asc']
                ],
                "displayLength": 25,
                "drawCallback": function(settings) {
                    var api = this.api();
                    var rows = api.rows({
                        page: 'current'
                    }).nodes();
                    var last = null;
                    api.column(2, {
                        page: 'current'
                    }).data().each(function(group, i) {
                        if (last !== group) {
                            $(rows).eq(i).before('<tr class="group"><td colspan="5">' + group + '</td></tr>');
                            last = group;
                        }
                    });
                }
            });
            // Order by the grouping
            $('#example tbody').on('click', 'tr.group', function() {
                var currentOrder = table.order()[0];
                if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
                    table.order([2, 'desc']).draw();
                } else {
                    table.order([2, 'asc']).draw();
                }
            });




		  });
    </script>
	</div>
@endsection
@endsection
@endsection
