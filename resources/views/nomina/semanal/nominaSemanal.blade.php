@extends('footer')
@extends('sidebar')
@extends('header')
@extends('nomina/semanal/modal')

@section('header')
@parent

<style media="screen">
	.deshabilitado {
		border: none;
    background-color: white;
	}
	.form-control:disabled {
		background-color: white;
	}
	.errorPrestamo {
		border-color: red !important;
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
										<li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home7" role="tab"><span class="hidden-sm-up"><i class="ti-notepad"></i></span> <span class="hidden-xs-down">Semanal</span></a> </li>
										<li class="nav-item" id="historial"> <a class="nav-link" data-toggle="tab" href="#profile7" role="tab"><span class="hidden-sm-up"><i class="ti-layers"></i></span> <span class="hidden-xs-down">Historial</span></a> </li>
								</ul>
									<!-- Tab panes -->
									<div class="tab-content">
										<div class="tab-pane active" id="home7" role="tabpanel">
											<div class="p-20">
												<div class="text-center" id="btnGenerar">

												</div>
												<br>
												<span id="guardar">

												</span>
												<span class="text-center">
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

            </div>
          </div>
      	</div>
			</div>
		</div>

		<!-- Se importa el modal -->
		@section('modal')
		@parent
		@stop

		@section('footer')
		@parent
			@section('java')
		<script src="{{asset('plugins/toast-master/js/jquery.toast.js')}}"></script>
		<script src="{{asset('js/toastr2.js')}}"></script>
		<script type="text/javascript">
				// Funcion que regresa la semana del año de la fecha actual
				Date.prototype.getWeekNumber = function () {
						var d = new Date(+this);  //Creamos un nuevo Date con la fecha de "this".
						d.setHours(0, 0, 0, 0);   //Nos aseguramos de limpiar la hora.
						d.setDate(d.getDate() + 4 - (d.getDay() || 7)); // Recorremos los días para asegurarnos de estar "dentro de la semana"
						//Finalmente, calculamos redondeando y ajustando por la naturaleza de los números en JS:
						return Math.ceil((((d - new Date(d.getFullYear(), 0, 1)) / 8.64e7) + 1) / 7);
				};
				var numSemana = new Date().getWeekNumber(); // Resultado
				//var numSemana = 30; // Resultado
				var tipo = 'semanal'; 
		</script>
		<script src="{{asset('modulos/nomina/nomina_semanal_index.js')}}"></script>
		<script src="{{asset('modulos/nomina/nomina_semanal.js')}}"></script>
		<script src="{{asset('modulos/nomina/nomina_index.js')}}"></script>
	@stop
@endsection
@endsection
@endsection
