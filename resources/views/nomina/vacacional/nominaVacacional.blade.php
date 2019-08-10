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
                      <h4 class="card-title">{{ $modulo }}</h4>
											<br>
											<ul class="nav nav-tabs customtab2" role="tablist">
													<li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home7" role="tab"><span class="hidden-sm-up"><i class="ti-notepad"></i></span> <span class="hidden-xs-down">Vacacional</span></a> </li>
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
																<h5 id="anio-vacacional"></h5>
															</span>
															<div class="table-responsive m-t-40 tabla">
				                          <!-- <table id="clientes" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
				                              <thead>
				                                  <tr>
				                                    <th>Nombre</th>
				                                    <th>Sueldo Base</th>
																						<th>Vacaciones 3 días</th>
																						<th>25% Prima</th>
				                                    <th>Bono Extra</th>
				                                    <th>Infonavit</th>
				                                    <th>Total</th>


				                                  </tr>
				                              </thead>
																			<tfoot>
																				<tr>
																					<th>Totales</th>
																					<th>76565</th>
																					<th>78678</th>
																					<th>786786</th>
																					<th>89797</th>
																					<th>67576</th>
																					<th>8676</th>
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

			                      </div>
													</div>
												</div>
			              </div>

                  </div>
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
					var tipo = 'vacacional';
					var anioActual = new Date().getFullYear();
					var anioAnterior = '2018';
					var anio = `${anioAnterior}-${anioActual}`;
		    </script>
				<script src="{{asset('modulos/nomina/nomina_vacacional.js')}}"></script>
				<script src="{{asset('modulos/nomina/nomina_index.js')}}"></script>
			@stop
@endsection
@endsection
@endsection
