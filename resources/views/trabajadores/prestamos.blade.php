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
													<a class="btn waves-effect waves-light btn-primary float-right" onclick="mostrarModalAgregarPrestamo()"> <i class="fa fa-plus"></i> Agregar prestamo</a>
		                      <h4 class="card-title">Prestamos</h4>
		                      <div class="table-responsive m-t-40">
                          <table id="prestamos" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                              <thead>
                                  <tr>
																		<th>Trabajador</th>
										                <th>Monto</th>
																		<th>Resta</th>
																		<th>Acciones</th>
                                  </tr>
                              </thead>
                              <tfoot>
                                  <tr>
																		<th>Trabajador</th>
                                    <th>Monto</th>
                                    <th>Resta</th>
																		<th>Acciones</th>
                                  </tr>
                              </tfoot>
                              <tbody>
                                 	<!-- Se llena el el prestamos.js -->
                          		</tbody>
                      		</table>
                      </div>
                  </div>
              </div>
          </div>
      	</div>
				<!-- MODAL NUEVO PRESTAMO -->
				<div class="modal fade" id="modalAgregarPrestamo" role="dialog" aria-labelledby="agregarPrestamo">
  					<div class="modal-dialog" role="document">
		            <div class="modal-content">
	                  <div class="modal-header">
	                      <h4 class="modal-title" id="exampleModalLabel1">Nuevo prestamo</h4>
	                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                  </div>
	                  <div class="modal-body">
	                  	<form id="formularioPrestamo" name="formularioPrestamo">
													<input type="text" class="form-control d-none" id="token" name="_token" value="{{csrf_token()}}">
													<div class="form-group">
														<label for="id_trabajador" class="control-label">Trabajador <span class="danger">*</span> </label>
														<select id="id_trabajador" name="id_trabajador" class="select2 form-control custom-select" style="width: 100%; height:36px;">
						                  <option>Seleccionar</option>
						                  <optgroup id="selectTrabajadores" label="Trabajadores">
						                      <!-- SE AGREGA EN EL PRESTAMOS.JS -->
						                  </optgroup>
						                </select>
														<div id="validacionTrabajador" name="validacionTrabajador">
														</div>
													</div>
													<div class="row">
															<div class="col-md-6">
																	<div class="form-group">
																			<label for="concepto" class="control-label">Concepto: <span class="danger">*</span> </label>
																			<input type="text" class="form-control" id="concepto" name="concepto">
																	</div>
															</div>
															<div class="col-md-6">
																	<div class="form-group">
																		<label for="montoPrestamo" class="control-label">Monto: <span class="danger">*</span> </label>
																		<input type="text" class="form-control input-number" id="montoPrestamo" name="montoPrestamo">
																	</div>
															</div>
													</div>
													<div class="form-group">
				                      <label>Descripción: <span class="danger">*</span> </label>
				                      <textarea class="form-control" rows="2" id="descripcion" name="descripcion"></textarea>
		                      </div>
													<div class="form-group">
		                          <label for="firma">Firma(trabajador): <span class="danger">*</span> </label>
		                          <input type="password" class="form-control input-number" id="firma" name="firma">
															<div id="validacionFirma" name="validacionFirma">
															</div>
		                      </div>
	                   	</form>
	                  </div>
	                  <div class="modal-footer">
	                      <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
	                      <button type="button" id="btnAgregar" class="btn btn-info">Guardar</button>
	                  </div>
	              </div>
	          </div>
	      </div>
	      <!-- /.MODAL AGREGAR -->
				<!-- MODAL ABONAR -->
				<div class="modal fade" id="modalAbonar" tabindex="-1" role="dialog" aria-labelledby="abonar">
	          <div class="modal-dialog" role="document">
	              <div class="modal-content">
	                  <div class="modal-header">
	                      <h4 class="modal-title" id="exampleModalLabel1">Nuevo abono</h4>
	                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                  </div>
	                  <div class="modal-body">
	                      <form>
													<div class="row">
															<div class="col-md-6">
																	<div class="form-group">
																		<label for="montoAbono" class="control-label">Monto:</label>
																		<input type="text" class="form-control input-number" id="montoAbono">
																	</div>
															</div>
															<div class="col-md-6">
																	<div class="form-group">
																			<label for="comentario" class="control-label">Comentario:</label>
																			<input type="text" class="form-control" id="comentario">
																	</div>
															</div>
													</div>
													<div class="form-group">
                              <label>Firma(trabajador):</label>
                              <input type="password" class="form-control input-number" value="firma">
                          </div>
	                      </form>
	                  </div>
	                  <div class="modal-footer">
	                      <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
	                      <button type="button" class="btn btn-info">Guardar</button>
	                  </div>
	              </div>
	          </div>
	      </div>
	      <!-- /.MODAL ABONAR -->
			</div>
		</div>
		@section('footer')
		@parent
		<script src="{{asset('modulos/prestamos.js')}}"></script>
	</div>
@endsection
@endsection
@endsection
