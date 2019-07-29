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
									<button type="button" class="btn waves-effect waves-light btn-primary float-right" id="boton_agregarMaterial"> <i class="fa fa-plus"></i> Agregar material</button>
									<button type="button" style="margin: 0px 5px 0px 0px" class="btn waves-effect waves-light btn-primary float-right" id="boton_nuevoTipoMaterial"> <i class="fa fa-bars"></i>  Tipo material</button>
									<h4 class="card-title">Materiales</h4>
									<ul class="nav nav-tabs" role="tablist">
                      <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#activo" role="tab"><span class="hidden-sm-up"><i class="icon-user"></i></span> <span class="hidden-xs-down">Activos</span></a> </li>
                      <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#inactivo" role="tab"><span class="hidden-sm-up"><i class="icon-user-unfollow"></i></span> <span class="hidden-xs-down">Inactivos</span></a> </li>
                  </ul>
									<div class="tab-content tabcontent-border">

										<div class="tab-pane active" id="activo" role="tabpanel">

											<div class="table-responsive m-t-40">
												<table id="materiales_tableActivos" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
													<thead>
														<tr>
															<th>Nombre</th>
															<th>Categoria</th>
															<th>Existencia</th>
															<th>Acciones</th>
														</tr>
													</thead>
													<tfoot>
														<tr>
															<th>Nombre</th>
															<th>Concepto</th>
															<th>Existencia</th>
															<th>Acciones</th>
														</tr>
													</tfoot>
													<tbody>

													</tbody>
												</table>
											</div>

										</div>

										<div class="tab-pane" id="inactivo" role="tabpanel">

											<div class="table-responsive m-t-40">
												<table id="materiales_tableInactivos" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
													<thead>
														<tr>
															<th>Nombre</th>
															<th>Categoria</th>
															<th>Existencia</th>
															<th>Acciones</th>
														</tr>
													</thead>
													<tfoot>
														<tr>
															<th>Nombre</th>
															<th>Concepto</th>
															<th>Existencia</th>
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

		<!-- Start Modal Agregar MATERIAL -->
		<div id="modal_agregar_material" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
				<div class="modal-dialog">
						<div class="modal-content">
								<div class="modal-header">
										<h4 class="modal-title" id="agregarTitulo">Agregar material</h4>
								</div>
								<div class="modal-body">
									<div class="form-group">
											<label for="recipient-name" class="control-label">Tipo <span class="danger">*</label>
											<select id="select_tipoMaterial" class="form-control">
											</select>
									</div>
										<form id="frmAgregarMaterial" name="frmAgregarMaterial">
											<section>
												<input type="text" class="form-control d-none" id="token" name="_token" value="{{csrf_token()}}">
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
																<label for="recipient-name" class="control-label">Cantidad <span class="danger">*</label>
																<input type="text" class="form-control required" id="txtCantidadMaterial" name="txtCantidadMaterial">
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
																<label for="recipient-name" class="control-label">Nombre <span class="danger">*</label>
																<input type="text" class="form-control required" id="txtNombreMaterial" name="txtNombreMaterial">
														</div>
													</div>
												</div>
											</section>
										</form>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
									<button type="button" id="actionAgregar" class="btn btn-success waves-effect" onclick=""><i class="mdi mdi-content-save"></i> Aceptar</button>
								</div>
						</div>
				</div>
		</div>
		<!-- End Modal Agregar MATERIAL -->

		<!-- Start Modal Editar MATERIAL -->
		<div id="modal_editar_material" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
				<div class="modal-dialog">
						<div class="modal-content">
								<div class="modal-header">
										<h4 class="modal-title" id="agregarTituloModificar">Editar material</h4>
								</div>
								<div class="modal-body">

										<form id="frmModificarMaterial" name="frmModificarMaterial">
											<section>
												<input type="text" class="form-control d-none" id="token" name="_token" value="{{csrf_token()}}">
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
																<label for="recipient-name" class="control-label">Tipo <span class="danger">*</label>
																<select id="select_tipoMaterialModificar" class="form-control">
																</select>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
																<label for="recipient-name" class="control-label">Nombre <span class="danger">*</label>
																<input type="text" class="form-control required" id="txtNombreMaterialModificar" name="txtNombreMaterialModificar">
														</div>
													</div>
												</div>
												<div class="row">

													<div class="col-md-6">
														<div class="form-group">
																<label for="recipient-name" class="control-label">Cantidad <span class="danger">*</label>
																<input type="text" class="form-control required" id="txtCantidadMaterialModificar" name="txtCantidadMaterialModificar">
														</div>
													</div>

													<div class="col-md-6">
														<label for="recipient-name" class="control-label">Estado <span class="danger">*</label>

														<div class="row">
																<div class="col-md-6">
																	<div class="form-check">
																		  <input class="form-check-input" type="radio" name="Estado_Modificar" id="Estado_Activo" value="1"> <!-- checked -->
																		  <label class="form-check-label" for="Estado_Activo">
																		  	Activo
																		  </label>
																		</div>
																</div>
																<div class="col-md-6">
																	<div class="form-check">
																		<input class="form-check-input" type="radio" name="Estado_Modificar" id="Estado_Inactivo" value="0">
																		<label class="form-check-label" for="Estado_Inactivo">
																			Inactivo
																		</label>
																	</div>
																</div>
														</div>

													</div>
												</div>

											</section>
										</form>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
									<button type="button" id="actionAgregarModificar" class="btn btn-success waves-effect" onclick=""><i class="mdi mdi-content-save"></i> Aceptar</button>
								</div>
						</div>
				</div>
		</div>
		<!-- End Modal Editar MATERIAL -->

		<!-- Start Modal Agregar Tipo material -->
		<div id="modal_agregar_tipoMaterial" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
				<div class="modal-dialog">
						<div class="modal-content">
								<div class="modal-header">
										<h4 class="modal-title" id="agregarTituloTipoMaterial">Agregar nuevo tipo material</h4>
								</div>
								<div class="modal-body">
										<form id="frmAgregarTipoMaterial" name="frmAgregarTipoMaterial">
											<section>
												<input type="text" class="form-control d-none" id="token" name="_token" value="{{csrf_token()}}">
														<h6>Agregar nuevo tipo material</h6>
														<div class="form-group">
																<label for="recipient-name" class="control-label">Nombre <span class="danger">*</label>
																<input type="text" class="form-control required" id="txtNombreTipoMaterial" name="txtNombreTipoMaterial">
														</div>
										</form>
											<div class="row">
											  <div class="col-md-6">
													<h6>Eliminar tipo material</h6>
													<div class="form-group">
															<input type="text" class="form-control d-none" id="validar" name="validar">
															<label for="recipient-name" class="control-label">Tipo <span class="danger">*</label>
															<select id="select_tipoMaterial_Tipo" class="form-control">
															</select>
													</div>
											  </div>
												<div class="col-md-6">
													<h6>Activar tipo material</h6>
													<div class="form-group">
															<input type="text" class="form-control d-none" id="validar" name="validar">
															<label for="recipient-name" class="control-label">Tipo <span class="danger">*</label>
															<select id="select_tipoMaterial_TipoInactivo" class="form-control">
															</select>
													</div>
												</div>
											</div>
										</section>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
									<button type="button" id="actionAgregarTipoMaterial" class="btn btn-success waves-effect" onclick=""><i class="mdi mdi-content-save"></i> Aceptar</button>
								</div>
						</div>
				</div>
		</div>
		<!-- End Modal Agregar Tipo material -->

		@section('footer')
		@parent
		<script src="{{asset('modulos/materiales.js')}}"></script>
	</div>
@endsection
@endsection
@endsection
