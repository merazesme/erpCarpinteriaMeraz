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
					                          <th>Concepto</th>
					                          <th>Cantidad</th>
					                          <th>Acciones</th>
					                        </tr>
					                    </thead>
					                    <tfoot>
					                        <tr>
																		<th>#Nota</th>
					                          <th>Fecha</th>
					                          <th>Proveedor</th>
					                          <th>Concepto</th>
					                          <th>Cantidad</th>
					                          <th>Acciones</th>
					                        </tr>
					                    </tfoot>
					                    <tbody>
					                        <tr>
					                          <td>1</td>
					                          <td>02/07/2019</td>
					                          <td>Ferreteria</td>
					                          <td>20</td>
					                          <td>System Architect</td>
					                          <!-- <td><span class="label label-success"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Pagado</font></font></span></td> -->
					                          <td class="text-nowrap">
					                            <a href="#" data-toggle="tooltip" data-original-title="Editar"> <i class="icon-pencil text-inverse m-r-10"></i> </a>
					                            <a href="#" data-toggle="tooltip" data-original-title="Borrar"> <i class="icon-close text-danger m-r-10"></i> </a>
					                            <a href="#" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye "></i> </a>
					                          </td>
					                        </tr>
					                        <tr>
					                          <td>1</td>
					                          <td>02/07/2019</td>
					                          <td>Ferreteria</td>
					                          <td>20</td>
					                          <td>System Architect</td>
					                          <!-- <td><span class="label label-info"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">En curso</font></font></span></td> -->
					                          <td class="text-nowrap">
					                            <a href="#" data-toggle="tooltip" data-original-title="Editar"> <i class="icon-pencil text-inverse m-r-10"></i> </a>
					                            <a href="#" data-toggle="tooltip" data-original-title="Borrar"> <i class="icon-close text-danger m-r-10"></i> </a>
					                            <a href="#" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye "></i> </a>
					                          </td>
					                        </tr>
					                        <tr>
					                          <td>1</td>
					                          <td>02/07/2019</td>
					                          <td>Ferreteria</td>
					                          <td>20</td>
					                          <td>System Architect</td>
					                          <!-- <td><span class="label label-warning"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Recibido</font></font></span></td> -->
					                          <td class="text-nowrap">
					                            <a href="#" data-toggle="tooltip" data-original-title="Editar"> <i class="icon-pencil text-inverse m-r-10"></i> </a>
					                            <a href="#" data-toggle="tooltip" data-original-title="Borrar"> <i class="icon-close text-danger m-r-10"></i> </a>
					                            <a href="#" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye "></i> </a>
					                          </td>
					                        </tr>
					                        <tr>
					                          <td>1</td>
					                          <td>02/07/2019</td>
					                          <td>Ferreteria</td>
					                          <td>20</td>
					                          <td>System Architect</td>
					                          <!-- <td><span class="label label-danger"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Cancelado</font></font></span></td> -->
					                          <td class="text-nowrap">
					                            <a href="#" data-toggle="tooltip" data-original-title="Editar"> <i class="icon-pencil text-inverse m-r-10"></i> </a>
					                            <a href="#" data-toggle="tooltip" data-original-title="Borrar"> <i class="icon-close text-danger m-r-10"></i> </a>
					                            <a href="#" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye "></i> </a>
					                          </td>
					                        </tr>
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
					                          <th>Cantidad</th>
					                          <th>Concepto</th>
					                          <th>Acciones</th>
					                        </tr>
					                    </thead>
					                    <tfoot>
					                        <tr>
					                          <th>#Nota</th>
					                          <th>Fecha</th>
					                          <th>Proveedor</th>
					                          <th>Cantidad</th>
					                          <th>Concepto</th>
					                          <th>Acciones</th>
					                        </tr>
					                    </tfoot>
					                    <tbody>
					                        <tr>
					                          <td>1</td>
					                          <td>02/07/2019</td>
					                          <td>Ferreteria</td>
					                          <td>20</td>
					                          <td>System Architect</td>
					                          <!-- <td><span class="label label-success"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Pagado</font></font></span></td> -->
					                          <td class="text-nowrap">
					                            <a href="#" data-toggle="tooltip" data-original-title="Editar"> <i class="icon-pencil text-inverse m-r-10"></i> </a>
					                            <a href="#" data-toggle="tooltip" data-original-title="Borrar"> <i class="icon-close text-danger m-r-10"></i> </a>
					                            <a href="#" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye "></i> </a>
					                          </td>
					                        </tr>
					                        <tr>
					                          <td>1</td>
					                          <td>02/07/2019</td>
					                          <td>Ferreteria</td>
					                          <td>20</td>
					                          <td>System Architect</td>
					                          <!-- <td><span class="label label-info"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">En curso</font></font></span></td> -->
					                          <td class="text-nowrap">
					                            <a href="#" data-toggle="tooltip" data-original-title="Editar"> <i class="icon-pencil text-inverse m-r-10"></i> </a>
					                            <a href="#" data-toggle="tooltip" data-original-title="Borrar"> <i class="icon-close text-danger m-r-10"></i> </a>
					                            <a href="#" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye "></i> </a>
					                          </td>
					                        </tr>
					                        <tr>
					                          <td>1</td>
					                          <td>02/07/2019</td>
					                          <td>Ferreteria</td>
					                          <td>20</td>
					                          <td>System Architect</td>
					                          <!-- <td><span class="label label-warning"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Recibido</font></font></span></td> -->
					                          <td class="text-nowrap">
					                            <a href="#" data-toggle="tooltip" data-original-title="Editar"> <i class="icon-pencil text-inverse m-r-10"></i> </a>
					                            <a href="#" data-toggle="tooltip" data-original-title="Borrar"> <i class="icon-close text-danger m-r-10"></i> </a>
					                            <a href="#" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye "></i> </a>
					                          </td>
					                        </tr>
					                        <tr>
					                          <td>1</td>
					                          <td>02/07/2019</td>
					                          <td>Ferreteria</td>
					                          <td>20</td>
					                          <td>System Architect</td>
					                          <!-- <td><span class="label label-danger"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Cancelado</font></font></span></td> -->
					                          <td class="text-nowrap">
					                            <a href="#" data-toggle="tooltip" data-original-title="Editar"> <i class="icon-pencil text-inverse m-r-10"></i> </a>
					                            <a href="#" data-toggle="tooltip" data-original-title="Borrar"> <i class="icon-close text-danger m-r-10"></i> </a>
					                            <a href="#" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye "></i> </a>
					                          </td>
					                        </tr>
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
					                          <th>Cantidad</th>
					                          <th>Concepto</th>
					                          <th>Acciones</th>
					                        </tr>
					                    </thead>
					                    <tfoot>
					                        <tr>
					                          <th>#Nota</th>
					                          <th>Fecha</th>
					                          <th>Proveedor</th>
					                          <th>Cantidad</th>
					                          <th>Concepto</th>
					                          <th>Acciones</th>
					                        </tr>
					                    </tfoot>
					                    <tbody>
					                        <tr>
					                          <td>1</td>
					                          <td>02/07/2019</td>
					                          <td>Ferreteria</td>
					                          <td>20</td>
					                          <td>System Architect</td>
					                          <!-- <td><span class="label label-success"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Pagado</font></font></span></td> -->
					                          <td class="text-nowrap">
					                            <a href="#" data-toggle="tooltip" data-original-title="Editar"> <i class="icon-pencil text-inverse m-r-10"></i> </a>
					                            <a href="#" data-toggle="tooltip" data-original-title="Borrar"> <i class="icon-close text-danger m-r-10"></i> </a>
					                            <a href="#" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye "></i> </a>
					                          </td>
					                        </tr>
					                        <tr>
					                          <td>1</td>
					                          <td>02/07/2019</td>
					                          <td>Ferreteria</td>
					                          <td>20</td>
					                          <td>System Architect</td>
					                          <!-- <td><span class="label label-info"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">En curso</font></font></span></td> -->
					                          <td class="text-nowrap">
					                            <a href="#" data-toggle="tooltip" data-original-title="Editar"> <i class="icon-pencil text-inverse m-r-10"></i> </a>
					                            <a href="#" data-toggle="tooltip" data-original-title="Borrar"> <i class="icon-close text-danger m-r-10"></i> </a>
					                            <a href="#" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye "></i> </a>
					                          </td>
					                        </tr>
					                        <tr>
					                          <td>1</td>
					                          <td>02/07/2019</td>
					                          <td>Ferreteria</td>
					                          <td>20</td>
					                          <td>System Architect</td>
					                          <!-- <td><span class="label label-warning"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Recibido</font></font></span></td> -->
					                          <td class="text-nowrap">
					                            <a href="#" data-toggle="tooltip" data-original-title="Editar"> <i class="icon-pencil text-inverse m-r-10"></i> </a>
					                            <a href="#" data-toggle="tooltip" data-original-title="Borrar"> <i class="icon-close text-danger m-r-10"></i> </a>
					                            <a href="#" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye "></i> </a>
					                          </td>
					                        </tr>
					                        <tr>
					                          <td>1</td>
					                          <td>02/07/2019</td>
					                          <td>Ferreteria</td>
					                          <td>20</td>
					                          <td>System Architect</td>
					                          <!-- <td><span class="label label-danger"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Cancelado</font></font></span></td> -->
					                          <td class="text-nowrap">
					                            <a href="#" data-toggle="tooltip" data-original-title="Editar"> <i class="icon-pencil text-inverse m-r-10"></i> </a>
					                            <a href="#" data-toggle="tooltip" data-original-title="Borrar"> <i class="icon-close text-danger m-r-10"></i> </a>
					                            <a href="#" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye "></i> </a>
					                          </td>
					                        </tr>
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
					                          <th>Cantidad</th>
					                          <th>Concepto</th>
					                          <th>Acciones</th>
					                        </tr>
					                    </thead>
					                    <tfoot>
					                        <tr>
					                          <th>#Nota</th>
					                          <th>Fecha</th>
					                          <th>Proveedor</th>
					                          <th>Cantidad</th>
					                          <th>Concepto</th>
					                          <th>Acciones</th>
					                        </tr>
					                    </tfoot>
					                    <tbody>
					                        <tr>
					                          <td>1</td>
					                          <td>02/07/2019</td>
					                          <td>Ferreteria</td>
					                          <td>20</td>
					                          <td>System Architect</td>
					                          <!-- <td><span class="label label-success"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Pagado</font></font></span></td> -->
					                          <td class="text-nowrap">
					                            <a href="#" data-toggle="tooltip" data-original-title="Editar"> <i class="icon-pencil text-inverse m-r-10"></i> </a>
					                            <a href="#" data-toggle="tooltip" data-original-title="Borrar"> <i class="icon-close text-danger m-r-10"></i> </a>
					                            <a href="#" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye "></i> </a>
					                          </td>
					                        </tr>
					                        <tr>
					                          <td>1</td>
					                          <td>02/07/2019</td>
					                          <td>Ferreteria</td>
					                          <td>20</td>
					                          <td>System Architect</td>
					                          <!-- <td><span class="label label-info"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">En curso</font></font></span></td> -->
					                          <td class="text-nowrap">
					                            <a href="#" data-toggle="tooltip" data-original-title="Editar"> <i class="icon-pencil text-inverse m-r-10"></i> </a>
					                            <a href="#" data-toggle="tooltip" data-original-title="Borrar"> <i class="icon-close text-danger m-r-10"></i> </a>
					                            <a href="#" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye "></i> </a>
					                          </td>
					                        </tr>
					                        <tr>
					                          <td>1</td>
					                          <td>02/07/2019</td>
					                          <td>Ferreteria</td>
					                          <td>20</td>
					                          <td>System Architect</td>
					                          <!-- <td><span class="label label-warning"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Recibido</font></font></span></td> -->
					                          <td class="text-nowrap">
					                            <a href="#" data-toggle="tooltip" data-original-title="Editar"> <i class="icon-pencil text-inverse m-r-10"></i> </a>
					                            <a href="#" data-toggle="tooltip" data-original-title="Borrar"> <i class="icon-close text-danger m-r-10"></i> </a>
					                            <a href="#" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye "></i> </a>
					                          </td>
					                        </tr>
					                        <tr>
					                          <td>1</td>
					                          <td>02/07/2019</td>
					                          <td>Ferreteria</td>
					                          <td>20</td>
					                          <td>System Architect</td>
					                          <!-- <td><span class="label label-danger"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Cancelado</font></font></span></td> -->
					                          <td class="text-nowrap">
					                            <a href="#" data-toggle="tooltip" data-original-title="Editar"> <i class="icon-pencil text-inverse m-r-10"></i> </a>
					                            <a href="#" data-toggle="tooltip" data-original-title="Borrar"> <i class="icon-close text-danger m-r-10"></i> </a>
					                            <a href="#" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye "></i> </a>
					                          </td>
					                        </tr>
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

		<!-- Modal nueva orden de compra-->
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
												<input type="text" class="form-control d-none" id="token" name="_token" value="{{csrf_token()}}">
												<div class="form-group">
														<label for="recipient-name" class="control-label">Nombre <span class="danger">*</label>
														<select id="select_CompraMaterial" class="form-control">
														</select>
												</div>
												<div class="form-group">
														<label for="recipient-name" class="control-label">Proveedor <span class="danger">*</label>
														<select id="select_CompraProveedor" class="form-control">
												</select>
												</div>
													<div class="form-group">
															<label for="message-text" class="control-label">Cantidad <span class="danger">*</label>
															<input type="text" class="form-control" id="cantidadOrdenCompra">
													</div>
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
		<!-- Modal -->

		<input type="text" id="validar" class="form-control d-none">

		@section('footer')
		@parent
    <script src="{{asset('modulos/orden_compra.js')}}"></script>
	</div>
@endsection
@endsection
@endsection
