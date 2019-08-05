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
								<button type="button" class="btn waves-effect waves-light btn-primary float-right" id="boton_agregarOrdenSalida"> <i class="fa fa-plus"></i> Nueva orden de salida</button>
                <h4 class="card-title">Orden de salida</h4>
								<ul class="nav nav-tabs" role="tablist">
										<li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#activas" role="tab"><span class="hidden-sm-up"><i class="icon-user-unfollow"></i></span> <span class="hidden-xs-down">Activas</span></a> </li>
										<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#canceladas" role="tab"><span class="hidden-sm-up"><i class="icon-user"></i></span> <span class="hidden-xs-down">Canceladas</span></a> </li>
								</ul>
								<div class="tab-content tabcontent-border">
									<div class="tab-pane active" id="activas" role="tabpanel">
										<div class="table-responsive m-t-40">
		                    <table id="tabla_ordenSalidaActivas" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
		                        <thead>
		                            <tr>
		                              <th>Concepto</th>
		                              <th>Descripción</th>
		                              <th>Fecha</th>
		                              <th>Cantidad</th>
		                              <th>Acciones</th>
		                            </tr>
		                        </thead>
		                        <tfoot>
		                          <tr>
		                            <th>Concepto</th>
		                            <th>Descripción</th>
		                            <th>Fecha</th>
		                            <th>Cantidad</th>
		                            <th>Acciones</th>
		                          </tr>
		                      </tfoot>
		                      <tbody>
		                      </tbody>
		                  </table>
		                </div>
									</div>
									<div class="tab-pane" id="canceladas" role="tabpanel">
										<div class="table-responsive m-t-40">
		                    <table id="tabla_ordenSalidaCancelada" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
		                        <thead>
		                            <tr>
		                              <th>Concepto</th>
		                              <th>Descripción</th>
		                              <th>Fecha</th>
		                              <th>Cantidad</th>
		                              <th>Acciones</th>
		                            </tr>
		                        </thead>
		                        <tfoot>
		                          <tr>
		                            <th>Concepto</th>
		                            <th>Descripción</th>
		                            <th>Fecha</th>
		                            <th>Cantidad</th>
		                            <th>Acciones</th>
		                          </tr>
		                      </tfoot>
		                      <tbody>
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

		<!-- Modal agregar orden de salida -->
		<div id="modal_agregar_ordenSalida" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
				<div class="modal-dialog">
						<div class="modal-content">
								<div class="modal-header">
										<h4 class="modal-title">Orden de salida</h4>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
								</div>
								<div class="modal-body">
										<form>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
															<label for="recipient-name" class="control-label">Trabajador <span class="danger">*</label>
															<select class="form-control" id="select_trabajadorOrdenSalida">
															</select>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group" id="materiales_orden_salida">
															<!-- <label for="recipient-name" class="control-label">Nombre <span class="danger">*</label>
															<select class="form-control" id="select_materialesOrdenSalida">
															</select> -->
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
															<label for="recipient-name" class="control-label">Descripción <span class="danger">*</label>
															<textarea class="form-control" id="txtDescripcion" rows="2"></textarea>
													</div>
												</div>
												<div class="col-md-6">
													<label for="recipient-name" class="control-label">Cantidad <span class="danger">*</label>
													<div class="form-group" id="DinamicoOrdenSalida">
															<!-- <input type="text" class="form-control" id="recipient-name"> -->
													</div>
												</div>
											</div>
										</form>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
									<button type="button" id="actionAgregarOrdenSalida" class="btn btn-success waves-effect" onclick=""><i class="mdi mdi-content-save"></i> Aceptar</button>
								</div>
						</div>
				</div>
		</div>
		<!-- end Modal agregar orden de salida -->

		<input type="text" id="validar" class="form-control d-none">

		@section('footer')
		@parent
    <script src="{{asset('modulos/orden_salida.js')}}"></script>
	</div>
@endsection
@endsection
@endsection
