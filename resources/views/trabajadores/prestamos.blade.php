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
													<button type="button" class="btn waves-effect waves-light btn-primary float-right" onclick="mostrarModalAgregarPrestamo(0,'agregar',-1)"> <i class="fa fa-plus"></i> Agregar prestamo</button>
		                      <h4 class="card-title">Prestamos</h4>
		                      <div class="table-responsive m-t-40">
                          <table id="prestamos" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                              <thead>
                                  <tr>
																		<th>Trabajador</th>
																		<th>#</th>
										                <th>Monto</th>
                                    <th>Resta</th>
																		<th>Acciones</th>
                                  </tr>
                              </thead>
                              <tfoot>
                                  <tr>
																		<th>Trabajador</th>
																		<th>#</th>
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
			</div>
		</div>

		<!-- MODAL NUEVO PRESTAMO -->
		<div class="modal" id="modalAgregarPrestamo" role="dialog" aria-labelledby="agregarPrestamo">
				<div class="modal-dialog" role="document">
						<div class="modal-content">
								<div class="modal-header">
										<button id="cerrar"  name="cerrar" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								</div>
								<div class="modal-body">
									<div id="prestamo" name="prestamo">
										<form id="formularioPrestamo" name="formularioPrestamo">
											 <input type="text" class="form-control d-none" id="token" name="_token" value="{{csrf_token()}}">
											 <input type="text" class="form-control d-none" id="id_tra" name="id_tra">
											 <input type="text" class="form-control d-none" id="id_pre" name="id_pre">
											 <input type="text" class="form-control d-none" id="tituloValor" name="tituloValor">
										</form>
									</div>
								</div>
								<div class="modal-footer">
										<button id="btnCancelar" name="btnCancelar" type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
								</div>
						</div>
				</div>
		</div>
		<!-- /.MODAL NUEVO PRESTAMO -->
		@section('footer')
		@parent
		<script src="{{asset('modulos/prestamos.js')}}"></script>
	</div>
@endsection
@endsection
@endsection
