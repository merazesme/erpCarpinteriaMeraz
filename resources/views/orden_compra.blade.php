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
									<button type="button" class="btn waves-effect waves-light btn-primary float-right" id="boton_agregarOrdenCompra"> <i class="fa fa-plus"></i> Nueva orden de compra</button>
									<button type="button" style="margin: 0px 5px 0px 0px" class="btn waves-effect waves-light btn-primary float-right" id="boton_pagarCompra"> <i class="fa fa-money"></i>  Pagar compras</button>
									<h4 class="card-title">Orden de compra</h4>
									<ul class="nav nav-tabs" role="tablist">
                      <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#curso" role="tab"><span class="hidden-sm-up"><i class="icon-user-unfollow"></i></span> <span class="hidden-xs-down">En curso</span></a> </li>
											<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#recibido" role="tab"><span class="hidden-sm-up"><i class="icon-user"></i></span> <span class="hidden-xs-down">Recibido</span></a> </li>
                      <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#cancelado" role="tab"><span class="hidden-sm-up"><i class="icon-user"></i></span> <span class="hidden-xs-down">Cancelado</span></a> </li>
											<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#pagado" role="tab"><span class="hidden-sm-up"><i class="icon-user"></i></span> <span class="hidden-xs-down">Pagado</span></a> </li>
                  </ul>
									<div class="tab-content tabcontent-border">
										<div class="tab-pane active" id="curso" role="tabpanel">
											<div class="table-responsive m-t-40">
					                <table id="tabla_curso" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
					                    <thead>
					                        <tr>
					                          <th>#Nota</th>
					                          <th>Fecha</th>
					                          <th>Proveedor</th>
					                          <th>Acciones</th>
					                        </tr>
					                    </thead>
					                    <tfoot>
					                        <tr>
																		<th>#Nota</th>
					                          <th>Fecha</th>
					                          <th>Proveedor</th>
					                          <th>Acciones</th>
					                        </tr>
					                    </tfoot>
					                    <tbody>
					                    </tbody>
					                </table>
					            </div>
										</div>
										<div class="tab-pane" id="recibido" role="tabpanel">
											<div class="table-responsive m-t-40">
					                <table id="tabla_recibido" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
					                    <thead>
					                        <tr>
																		<th>#Nota</th>
					                          <th>Fecha</th>
					                          <th>Proveedor</th>
					                          <th>Acciones</th>
					                        </tr>
					                    </thead>
					                    <tfoot>
					                        <tr>
																		<th>#Nota</th>
					                          <th>Fecha</th>
					                          <th>Proveedor</th>
					                          <th>Acciones</th>
					                        </tr>
					                    </tfoot>
					                    <tbody>
					                    </tbody>
					                </table>
					            </div>
										</div>
										<div class="tab-pane" id="cancelado" role="tabpanel">
											<div class="table-responsive m-t-40">
					                <table id="tabla_cancelado" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
					                    <thead>
					                        <tr>
																		<th>#Nota</th>
					                          <th>Fecha</th>
					                          <th>Proveedor</th>
					                          <th>Acciones</th>
					                        </tr>
					                    </thead>
					                    <tfoot>
					                        <tr>
																		<th>#Nota</th>
					                          <th>Fecha</th>
					                          <th>Proveedor</th>
					                          <th>Acciones</th>
					                        </tr>
					                    </tfoot>
					                    <tbody>
					                    </tbody>
					                </table>
					            </div>
										</div>
										<div class="tab-pane" id="pagado" role="tabpanel">
											<div class="table-responsive m-t-40">
					                <table id="tabla_pagado" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
					                    <thead>
					                        <tr>
																		<th>#Nota</th>
					                          <th>Fecha</th>
					                          <th>Proveedor</th>
					                          <th>Acciones</th>
					                        </tr>
					                    </thead>
					                    <tfoot>
					                        <tr>
																		<th>#Nota</th>
					                          <th>Fecha</th>
					                          <th>Proveedor</th>
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

		<!-- Modal nueva orden de compra -->
		<div id="modal_nueva_ordenCompra" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
				<div class="modal-dialog">
						<div class="modal-content">
								<div class="modal-header">
										<h4 class="modal-title" id="agregarTituloNuevaCompra">Orden de compra</h4>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
								</div>
								<div class="modal-body">
										<form id="frmNuevaOrdenCompra" name="frmNuevaOrdenCompra">
											<section>
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
																<label for="recipient-name" class="control-label">Proveedor <span class="danger">*</label>
																<select id="select_CompraProveedor" class="form-control">
																</select>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group" id="compramaterialafter">
																<!-- <label for="recipient-name" class="control-label">Nombre <span class="danger">*</label> -->
																<!-- <select id="select_CompraMaterial" class="form-control">
																</select> -->
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
																<label for="message-text" class="control-label">#Nota <span class="danger">*</label>
																<input type="text" class="form-control" name="num_nota" id="num_nota">
														</div>
													</div>
													<div class="col-md-6">
														<label for="message-text" class="control-label">Cantidad <span class="danger">*</label>
														<div class="form-group" id="cantidadcrear">
																<!-- <input type="text" class="form-control" name="cantidadOrdenCompra" id="cantidadOrdenCompra"> -->
														</div>
													</div>
												</div>
												<input type="text" class="form-control d-none" id="token" name="_token" value="{{csrf_token()}}">
											<section>
										</form>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
									<button type="button" id="actionAgregarNuevaCompra" class="btn btn-success waves-effect" onclick=""><i class="mdi mdi-content-save"></i> Aceptar</button>
								</div>
						</div>
				</div>
		</div>
		<!-- End Modal nueva orden de compra -->

		<!-- Modal modificar orden de compra-->
		<div id="modal_modificar_ordenCompra" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
				<div class="modal-dialog">
						<div class="modal-content">
								<div class="modal-header">
										<h4 class="modal-title" id="agregarTituloModificarCompra">Orden de compra</h4>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
								</div>
								<div class="modal-body">
										<form id="frmModificarOrdenCompra" name="frmModificarOrdenCompra">
											<section>
												<div class="row">
													<div class="col-md-12">
														<div class="form-group">
																<label for="recipient-name" class="control-label">Proveedor <span class="danger">*</label>
																<select id="select_proCompra" name="select_proCompra" class="form-control">
																</select>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
																<label for="message-text" class="control-label">#Nota <span class="danger">*</label>
																<input type="text" class="form-control" name="num_notaModificar" id="num_notaModificar">
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
																<label for="message-text" class="control-label">$Total <span class="danger">*</label>
																<input type="text" class="form-control" name="TotalModificarCompra" id="TotalModificarCompra">
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-md-6">
													  	<label for="recipient-name" class="control-label">Estado <span class="danger">*</label>
													</div>
												</div>
												<div class="row">
														<div class="col-md-4">
															<div class="form-check">
																	<input class="form-check-input" type="radio" name="Estado_ModificarOrden" id="Estado_Curso" value="1">
																	<label class="form-check-label" for="Estado_Curso">
																		En curso
																	</label>
																</div>
														</div>
														<div class="col-md-4">
															<div class="form-check">
																<input class="form-check-input" type="radio" name="Estado_ModificarOrden" id="Estado_Recibido" value="2">
																<label class="form-check-label" for="Estado_Recibido">
																	Recibido
																</label>
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-check">
																<input class="form-check-input" type="radio" name="Estado_ModificarOrden" id="Estado_Cancelado" value="3">
																<label class="form-check-label" for="Estado_Cancelado">
																	Cancelado
																</label>
															</div>
														</div>
												</div>
												<input type="text" class="form-control d-none" id="token" name="_token" value="{{csrf_token()}}">
											<section>
										</form>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
									<button type="button" id="actionAgregarModificarCompra" class="btn btn-success waves-effect" onclick=""><i class="mdi mdi-content-save"></i> Aceptar</button>
								</div>
						</div>
				</div>
		</div>
		<!-- End Modal modificar orden de compra -->

		<!-- Modal pagar compras -->
		<div id="modal_pagar_ordenCompra" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
				<div class="modal-dialog">
						<div class="modal-content">
								<div class="modal-header">
										<h4 class="modal-title" id="agregarTituloPagarCompra">Pagar compras</h4>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
								</div>
								<div class="modal-body">
										<form id="frmPagarOrdenCompra" name="frmPagarOrdenCompra">
											<section>
												<div id ="principal">
													<!-- <div class="row">
														<div class="col-md-12">
															<div class="form-group">
																	<label for="recipient-name" class="control-label">Forma de pago <span class="danger">*</label>
																	<select id="select_PagarCompra" class="form-control">
																		<option value="0">Seleccione una opcion</option>
																		<option value="1">Cheque</option>
																		<option value="2">Transferencia</option>
																	</select>
															</div>
														</div>
													</div>
													<div id="todo">
													</div> -->
												</div>
												<input type="text" class="form-control d-none" id="token" name="_token" value="{{csrf_token()}}">
											<section>
										</form>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
									<button type="button" id="actionPagarCompra" class="btn btn-success waves-effect" onclick=""><i class="mdi mdi-content-save"></i> Aceptar</button>
								</div>
						</div>
				</div>
		</div>
		<!-- End Modal pagar compras -->

		<!-- Modal de info ordenCompra -->
    <div id="modal_info_ordenCompra" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Detalles de orden de compra</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <h4>Orden de compra</h4>
                    <table class="table table-hover" id="infoOrdenCompra">
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

		<input type="text" id="validar" class="form-control d-none">

		@section('footer')
		@parent
    <script src="{{asset('modulos/orden_compra.js')}}"></script>
	</div>
@endsection
@endsection
@endsection
