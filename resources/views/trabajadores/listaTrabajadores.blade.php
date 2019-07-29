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
													<div class="card">
			                     	<div class="card-body">
															<!-- DETALLES TRABAJADOR -->
							                <h5 style="font-weight: bold;">DETALLES TRABAJADOR:</h5>
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
															<!-- DETALLES CONTRATO -->
															<h5 style="font-weight: bold;">DETALLES CONTRATO:</h5>
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
				<!-- /.MODAL VER DETALLES -->
			</div>
		</div>
		@section('footer')
		@parent
		<script src="{{asset('modulos/trabajadores.js')}}"></script>
		<!-- <script>
    $(document).ready(function() {
        $('#myTable').DataTable();
        $(document).ready(function() {
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
    });
    </script> -->
	</div>
@endsection
@endsection
@endsection
