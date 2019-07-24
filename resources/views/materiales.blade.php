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
									<!-- Table -->
								<div class="card-body">
									<button type="button" class="btn waves-effect waves-light btn-primary float-right" id="boton_agregarMaterial" onclick="agregarMaterial()"> <i class="fa fa-plus"></i> Agregar material</button>
									<h4 class="card-title">Materiales</h4>
									<div class="table-responsive m-t-40">
										<table id="materiales_table" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th>Nombre</th>
													<th>Categoria</th>
													<th>Existencia</th>
													<th>Estado</th>
													<th>Acciones</th>
												</tr>
											</thead>
											<tfoot>
												<tr>
													<th>Nombre</th>
													<th>Concepto</th>
													<th>Existencia</th>
													<th>Estado</th>
													<th>Acciones</th>
												</tr>
											</tfoot>
											<tbody>

											</tbody>
										</table>
									</div>
								</div>
									<!-- Table -->
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Start Modal -->
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
											<!-- <input type="text" class="form-control d-none" id="token" name="_token" value="{{csrf_token()}}"> -->
											<section>
												<input type="text" class="form-control d-none" id="token" name="_token" value="{{csrf_token()}}">
												<input type="text" class="form-control d-none" id="select_tipoMateriall" name="select_tipoMateriall">
												<input type="text" class="form-control d-none" id="estado_material" name="estado_material">
												<input type="text" class="form-control d-none" id="idUsuario_material" name="idUsuario_material">
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
		<!-- End Modal -->

		@section('footer')
		@parent
	</div>
@endsection
@endsection
@endsection
