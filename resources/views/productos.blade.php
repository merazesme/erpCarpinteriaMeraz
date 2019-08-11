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
								<button type="button" class="btn waves-effect waves-light btn-primary float-right" id="boton_agregarProducto"> <i class="fa fa-plus"></i> Nuevo Producto</button>
                <h4 class="card-title">Productos</h4>
								<ul class="nav nav-tabs" role="tablist">
										<li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#activos" role="tab"><span class="hidden-sm-up"><i class="icon-user-unfollow"></i></span> <span class="hidden-xs-down">Activos</span></a> </li>
										<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#cancelados" role="tab"><span class="hidden-sm-up"><i class="icon-user"></i></span> <span class="hidden-xs-down">Cancelados</span></a> </li>
								</ul>
								<div class="tab-content tabcontent-border">
									<div class="tab-pane active" id="activos" role="tabpanel">
										<div class="table-responsive m-t-40">
		                    <table id="tabla_productosActivos" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
		                        <thead>
		                            <tr>
		                              <th>Descripcion</th>
																	<th>Subtotal</th>
																	<th>IVA</th>
		                              <th>Total</th>
		                              <th>Acciones</th>
		                            </tr>
		                        </thead>
		                        <tfoot>
		                          <tr>
																<th>Descripcion</th>
																<th>Subtotal</th>
																<th>IVA</th>
																<th>Total</th>
																<th>Acciones</th>
		                          </tr>
		                      </tfoot>
		                      <tbody>
		                      </tbody>
		                  </table>
		                </div>
									</div>
									<div class="tab-pane" id="cancelados" role="tabpanel">
										<div class="table-responsive m-t-40">
		                    <table id="tabla_productosCancelados" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
		                        <thead>
		                            <tr>
																	<th>#Nota</th>
																	<th>Fecha</th>
																	<th>Trabajador</th>
		                              <th>Descripción</th>
		                              <th>Acciones</th>
		                            </tr>
		                        </thead>
		                        <tfoot>
		                          <tr>
																<th>#Nota</th>
																<th>Fecha</th>
																<th>Trabajador</th>
																<th>Descripción</th>
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
		<div id="modal_agregar_productos" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
				<div class="modal-dialog">
						<div class="modal-content">
								<div class="modal-header">
										<h4 class="modal-title">Nuevo producto</h4>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
								</div>
								<div class="modal-body">
										<form>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
															<label for="recipient-name" class="control-label">Descripción <span class="danger">*</label>
															<textarea class="form-control" id="txtDescripcionProductos" rows="2"></textarea>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group" id="materiaprima">
															<!-- <label for="recipient-name" class="control-label">Materia prima <span class="danger">*</label>
															<select class="form-control" id="select_materiaPrima">
															</select> -->
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label for="recipient-name" class="control-label">Costos adicionales <span class="danger">*</label>
														<input type="number" class="form-control" id="txtCostosAdicionales" name="txtCostosAdicionales">
													</div>
												</div>
												<div class="col-md-6">
													<label for="recipient-name" class="control-label"></label>
													<p></p>
													<div class="input-group">
                              <span class="input-group-addon"><i class="fa fa-usd"></i>  Subtotal</span>
                              <input type="number" id="totalMateriaPrima" name="totalMateriaPrima" class="form-control" placeholder="0.00" disabled>
                          </div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
												</div>
												<div class="col-md-6">
													<div class="input-group">
                              <span class="input-group-addon"><i class="fa fa-usd"></i>  Total</span>
                              <input type="number" id="totalMateriaPrimaFinal" name="totalMateriaPrimaFinal" class="form-control" placeholder="0.00" disabled>
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

		<!-- Modal modificar orden de salida -->
		<div id="modal_agregar_ordenSalidaModificar" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
				<div class="modal-dialog">
						<div class="modal-content">
								<div class="modal-header">
										<h4 class="modal-title">Modificar orden de salida</h4>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
								</div>
								<div class="modal-body">
										<form>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
															<label for="recipient-name" class="control-label">Trabajador <span class="danger">*</label>
															<select class="form-control" id="select_trabajadorOrdenSalidaModificar">
															</select>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="recipient-name" class="control-label">#Nota <span class="danger">*</label>
														<input type="text" class="form-control" id="txtNotaOrdenSalidaModificar">
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-12">
													<div class="form-group">
															<label for="recipient-name" class="control-label">Descripción <span class="danger">*</label>
															<textarea class="form-control" id="txtDescripcionModificar" rows="2"></textarea>
													</div>
												</div>
											</div>
										</form>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
									<button type="button" id="actionAgregarOrdenSalidaModificar" class="btn btn-success waves-effect" onclick=""><i class="mdi mdi-content-save"></i> Aceptar</button>
								</div>
						</div>
				</div>
		</div>
		<!-- end Modal modificar orden de salida -->

		<!-- Modal de info ordenCompra -->
    <div id="modal_info_ordenSalida" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Detalles de orden de salida</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <h4>Orden de salida</h4>
                    <table class="table table-hover" id="infoOrdenSalida">
                      <thead>
                        <tr>
                          <th scope="col">Nombre</th>
                          <th scope="col">Cantidad</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin modal info ordenCompra  -->

		<div id="valores" class="d-none">

		</div>
		<input type="text" id="validar" class="form-control d-none">

		@section('footer')
		@parent
    <script src="{{asset('modulos/productos.js')}}"></script>
	</div>
@endsection
@endsection
@endsection
