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
          <div class="col-md-12">
              <div class="card">
                  <div class="card-body p-b-0">
                      <a class="btn waves-effect waves-light btn-primary float-right" href="/trabajadores/agregar"> <i class="fa fa-plus"></i> Agregar trabajador</a>
                      <h4 class="card-title">Lista de trabajadores</h4>
                      <!-- Nav tabs -->
                      <ul class="nav nav-tabs" role="tablist">
                          <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Activos</span></a> </li>
                          <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#profile" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Inactivos</span></a> </li>
                      </ul>
                      <!-- Tab panes -->
                      <div class="tab-content tabcontent-border">
                          <div class="tab-pane active" id="home" role="tabpanel">
                              <div class="p-20">
                                  <div class="table-responsive">
                                      <table id="trabajadoresActivos" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                          <thead>
                                              <tr>
                                                  <th>Nombre</th>
                                                  <th>Puesto</th>
                                                  <th>Fecha de liquidación</th>
                                                  <th>Acciones</th>
                                              </tr>
                                          </thead>
                                          <tfoot>
                                              <tr>
                                                  <th>Nombre</th>
                                                  <th>Puesto</th>
                                                  <th>Fecha de liquidación</th>
                                                  <th>Acciones</th>
                                              </tr>
                                          </tfoot>
                                          <tbody>
																						<!-- Se agrega en trabajadores.js -->
                                          </tbody>
                                      </table>
                                  </div>
                              </div>
                          </div>
                          <div class="tab-pane" id="profile" role="tabpanel">
                              <div class="p-20">
                                    <div class="table-responsive">
                                        <table id="trabajadoresInactivos" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Nombre</th>
                                                    <th>Puesto</th>
                                                    <th>Fecha de liquidación</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>Nombre</th>
                                                    <th>Puesto</th>
                                                    <th>Fecha de liquidación</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
																							<!-- Se agrega en trabajadores.js -->
                                            </tbody>
                                        </table>
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

		<!-- MODAL VER DETALLES -->
		<div class="modal fade bs-example-modal-lg" id="modalDetalles" tabindex="-1" role="dialog" aria-labelledby="modalDetalles">
				<div class="modal-dialog modal-lg" role="document">
						<div class="modal-content">
								<div class="modal-header">
									<h4 class="modal-title" id="exampleModalLabel1">Detalles</h4>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								</div>
								<div class="modal-body">
									<div id="datos" class="row">
										<div class="col-md-12">
											<div class="card" style="margin-bottom: 0px;">
												<div class="card-body" style="padding: 0px 0px;">
													<div class="activity-box">
														<div class="date-devider">
															<span>DETALLES TRABAJADOR</span>
														</div>
														<!-- DETALLES TRABAJADOR -->
														<table id="detallesTrabajador" class="table vm no-th-brd pro-of-month">
															<!-- <thead>
																	<tr>
																			<th>sdsad</th>
																			<th>asdasdasd</th>
																	</tr>
															</thead> -->
															<tbody>
																<!-- <tr>
																		<td class="m-b-0"><strong>Celular: </strong></td>
																		<td class="m-b-0"><strong>Número alternativo: </strong></td>
																</tr>
																<tr>
																		<td class="m-b-0"><strong>Fecha de nacimiento: </strong></td>
																		<td class="m-b-0"><strong>Lugar de nacimiento: </strong></td>
																</tr>
																<tr>
																		<td class="m-b-0"><strong>Domicilio: </strong></td>
																		<td class="m-b-0"><strong>Estado civil:</strong></td>
																</tr>
																<tr>
																		<td class="m-b-0"><strong>Apodo: </strong></td>
																		<td class="m-b-0"><strong>Escolaridad: </strong></td>
																</tr> -->
															</tbody>
														</table>
														<!-- FIN DETALLES TRABAJADOR -->
														<div class="date-devider">
															<span>DETALLES ÚLTIMO CONTRATO</span>
														</div>
														<!-- DETALLES CONTRATO -->
														<table id="detallesContrato" class="table vm no-th-brd pro-of-month">
															<tbody>
																<!-- <tr>
																		<td class="m-b-0"><strong>Fecha inicio: </strong></td>
																		<td class="m-b-0"><strong>Fecha final: </strong></td>
																</tr>
																<tr>
																		<td class="m-b-0"><strong>Hora extra: </strong></td>
																		<td class="m-b-0"><strong>Bono extra: </strong></td>
																</tr>
																<tr>
																		<td class="m-b-0"><strong>Bono asistencia: </strong></td>
																		<td class="m-b-0"><strong></strong></td>
																</tr> -->
															</tbody>
														</table>
														<!-- FIN DETALLES CONTRATO -->
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
						</div>
				</div>
		</div>
		<!-- /.MODAL VER DETALLES -->
		<!-- MODAL VER HISTORIAL -->
		<div class="modal fade bs-example-modal-lg" id="modalHistorial" tabindex="-1" role="dialog" aria-labelledby="modalDetalles">
				<div class="modal-dialog modal-lg" role="document">
						<div class="modal-content">
								<div class="modal-header">
									<h4 class="modal-title" id="exampleModalLabel1">Historial</h4>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								</div>
								<div class="modal-body">
									<div id="datos2" class="row">
										<div class="col-md-12">
											<div class="card" style="margin-bottom: 0px;">
												<div class="card-body" style="padding: 0px 0px;">
													<div class="ml-auto" style="text-align: right;">
														<select class="custom-select b-0">
															<option selected="">Contratos</option>
															<option value="1">Liquidaciones</option>
														</select>
													</div>
													<div class="activity-box">
														<div class="date-devider">
															<span>HISTORIAL CONTRATOS</span>
														</div>
														<!-- HISTORIAL CONTRATOS -->
														<div class="p-20">
															<div class="table-responsive">
																<table id="historialContratos" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%" style="font-size:12px;">
																		<thead>
																				<tr>
																						<th>Puesto</th>
																						<th>Fecha inicio</th>
																						<th>Fecha fin</th>
																						<th>Sueldo</th>
																						<th>Hora extra</th>
																						<th>Bono extra</th>
																						<th>Bono asistencia</th>
																				</tr>
																		</thead>
																		<tfoot>
																				<tr>
																						<th>Puesto</th>
																						<th>Fecha inicio</th>
																						<th>Fecha fin</th>
																						<th>Sueldo</th>
																						<th>Hora extra</th>
																						<th>Bono extra</th>
																						<th>Bono asistencia</th>
																				</tr>
																		</tfoot>
																		<tbody>
																			<!-- Se agrega en trabajadores.js -->
																		</tbody>
																</table>
															</div>
														</div>
														<!-- FIN HISTORIAL CONTRATOS -->
														<!-- <div class="date-devider">
															<span>DETALLES CONTRATO</span>
														</div> -->
														<!-- DETALLES CONTRATO -->

														<!-- FIN DETALLES CONTRATO -->
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
						</div>
				</div>
		</div>
		<!-- /.MODAL VER HISTORIAL -->
		@section('footer')
		@parent
		<script src="{{asset('modulos/trabajadores.js')}}"></script>
	</div>
@endsection
@endsection
@endsection
