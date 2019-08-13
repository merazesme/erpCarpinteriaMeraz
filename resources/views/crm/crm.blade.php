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
		                      <!-- <h6 class="card-subtitle">Lista de Clientes</h6> -->
		                      <h4 class="card-title">CRM</h4>

							  <ul class="nav nav-tabs" role="tablist">
								<li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#activo" role="tab"><span class="hidden-sm-up"><i class="icon-folder-alt"></i></span> <span class="hidden-xs-down">Cotizaciones</span></a> </li>
								<!-- <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#inactivo" role="tab"><span class="hidden-sm-up"><i class="icon-paper-clip"></i></span> <span class="hidden-xs-down">Terminados</span></a> </li>
								<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#rechazada" role="tab"><span class="hidden-sm-up"><i class="icon-close"></i></span> <span class="hidden-xs-down">Rechazadas</span></a> </li> -->
							</ul>

							<div class="tab-content tabcontent-border">
							   <div class="tab-pane active" id="activo" role="tabpanel">
                                   <div class="row  p-20">
                                       <div class="col-lg-12">
                                           <button class="btn waves-effect waves-light btn-primary float-right" onclick="correos()"> <i class="fa fa-envelope"></i> Mandar correo a todos</button>
                                       </div>
                                   </div>
								   <div class="table-responsive p-20">
		                              <table id="cotizaciones" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
										 <thead>
											 <tr>
												 <th>Inicio</th>
												 <th>Fin</th>
												 <th class="w-75">Descripción</th>
												 <th>Estado</th>
												 <th>Cliente</th>
												 <th></th>
											 </tr>
										 </thead>
										 <tfoot>
											 <tr>
												 <th>Inicio</th>
												 <th>Fin</th>
												 <th>Descripción</th>
												 <th>Estado</th>
												 <th>Cliente</th>
												 <th></th>
											 </tr>
										 </tfoot>
										 <tbody>
											 <!-- <tr>
												 <td>03-Agosto-19</td>
												 <td>Ropero de madera de roble</td>
												 <td><span class="badge badge-success">Aceptada</span></td>
												 <td>Itzel Rendón</td>
												 <td>$xx,xxx.xx</td>
												 <td><span class="badge badge-pill badge-primary">Alta</span></td>
												 <td class="text-nowrap">
													 <a href="/modificarCotizacion" data-toggle="tooltip" data-original-title="Editar"> <i class="icon-pencil text-inverse m-r-10"></i></a>
													 <a class="eliminarCotizacion" href="#" data-toggle="tooltip" data-original-title="Borrar"> <i class="icon-close text-danger m-r-10"></i> </a>
													 <span data-toggle="modal" data-target="#modalCotizacion">
													   <a class="detalleCotizacion" href="#" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye m-r-10"></i> </a>
													</span>
													<a class="cambiarEstado" href="#" data-toggle="tooltip" data-original-title="Cambiar Estado"> <i class="text-primary icon-note"></i> </a>
												 </td>
											 </tr>
											 <tr>
												 <td>03-Agosto-19</td>
												 <td>Puerta de recámara</td>
												 <td><span class="badge badge-danger">Rechazada</span></td>
												 <td>Itzel Rendón</td>
												 <td>$xx,xxx.xx</td>
												 <td><span class="badge badge-pill badge-info">Media</span></td>
												 <td class="text-nowrap">
												   <a href="/modificarCotizacion" data-toggle="tooltip" data-original-title="Editar"> <i class="icon-pencil text-inverse m-r-10"></i> </a>
												   <a class="eliminarCotizacion" href="#" data-toggle="tooltip" data-original-title="Borrar"> <i class="icon-close text-danger m-r-10"></i> </a>
												   <span data-toggle="modal" data-target="#modalCotizacion">
													 <a class="detalleCotizacion" href="#" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye m-r-10"></i> </a>
												   </span>
												   <a class="cambiarEstado" href="#" data-toggle="tooltip" data-original-title="Cambiar Estado"> <i class="text-primary icon-note"></i> </a>
												 </td>
											 </tr>
											  <tr>
												 <td>03-Agosto-19</td>
												 <td>Escritorio largo de 1.20 mts</td>
												 <td><span class="badge badge-warning">En taller</span></td>
												 <td>Itzel Rendón</td>
												 <td>$xx,xxx.xx</td>
												 <td><span class="badge badge-pill badge-inverse">Baja</span></td>
												 <td class="text-nowrap">
												   <a href="/modificarCotizacion" data-toggle="tooltip" data-original-title="Editar"> <i class="icon-pencil text-inverse m-r-10"></i> </a>
												   <a class="eliminarCotizacion" href="#" data-toggle="tooltip" data-original-title="Borrar"> <i class="icon-close text-danger m-r-10"></i> </a>
												   <span data-toggle="modal" data-target="#modalCotizacion">
													 <a class="detalleCotizacion" href="#" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye m-r-10"></i></a>
												   </span>
												   <a class="cambiarEstado" href="#" data-toggle="tooltip" data-original-title="Cambiar Estado"> <i class="text-primary icon-note"></i> </a>
												 </td>
											 </tr> -->
										 </tbody>
									 </table>
								 </div>
							   </div>

							   <div class="tab-pane" id="inactivo" role="tabpanel">
								   <div class="table-responsive p-20">
									 <table id="cotizacionesTerminadas" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
										 <thead>
											 <tr>
												 <th>Inicio</th>
												 <th>Fin</th>
												 <th class="w-75">Descripción</th>
												 <th>Estado</th>
												 <th>Cliente</th>
												 <th></th>
											 </tr>
										 </thead>
										 <tfoot>
											 <tr>
												 <th>Inicio</th>
												 <th>Fin</th>
												 <th>Descripción</th>
												 <th>Estado</th>
												 <th>Cliente</th>
												 <th></th>
											 </tr>
										 </tfoot>
										 <tbody>
											 <!-- <tr>
												 <td>03-Agosto-19</td>
												 <td>Ropero de madera de roble</td>
												 <td><span class="badge badge-success">Aceptada</span></td>
												 <td>Itzel Rendón</td>
												 <td>$xx,xxx.xx</td>
												 <td><span class="badge badge-pill badge-primary">Alta</span></td>
												 <td class="text-nowrap">
													 <a href="/modificarCotizacion" data-toggle="tooltip" data-original-title="Editar"> <i class="icon-pencil text-inverse m-r-10"></i></a>
													 <a class="eliminarCotizacion" href="#" data-toggle="tooltip" data-original-title="Borrar"> <i class="icon-close text-danger m-r-10"></i> </a>
													 <span data-toggle="modal" data-target="#modalCotizacion">
													   <a class="detalleCotizacion" href="#" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye m-r-10"></i> </a>
													</span>
													<a class="cambiarEstado" href="#" data-toggle="tooltip" data-original-title="Cambiar Estado"> <i class="text-primary icon-note"></i> </a>
												 </td>
											 </tr>
											 <tr>
												 <td>03-Agosto-19</td>
												 <td>Puerta de recámara</td>
												 <td><span class="badge badge-danger">Rechazada</span></td>
												 <td>Itzel Rendón</td>
												 <td>$xx,xxx.xx</td>
												 <td><span class="badge badge-pill badge-info">Media</span></td>
												 <td class="text-nowrap">
												   <a href="/modificarCotizacion" data-toggle="tooltip" data-original-title="Editar"> <i class="icon-pencil text-inverse m-r-10"></i> </a>
												   <a class="eliminarCotizacion" href="#" data-toggle="tooltip" data-original-title="Borrar"> <i class="icon-close text-danger m-r-10"></i> </a>
												   <span data-toggle="modal" data-target="#modalCotizacion">
													 <a class="detalleCotizacion" href="#" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye m-r-10"></i> </a>
												   </span>
												   <a class="cambiarEstado" href="#" data-toggle="tooltip" data-original-title="Cambiar Estado"> <i class="text-primary icon-note"></i> </a>
												 </td>
											 </tr>
											  <tr>
												 <td>03-Agosto-19</td>
												 <td>Escritorio largo de 1.20 mts</td>
												 <td><span class="badge badge-warning">En taller</span></td>
												 <td>Itzel Rendón</td>
												 <td>$xx,xxx.xx</td>
												 <td><span class="badge badge-pill badge-inverse">Baja</span></td>
												 <td class="text-nowrap">
												   <a href="/modificarCotizacion" data-toggle="tooltip" data-original-title="Editar"> <i class="icon-pencil text-inverse m-r-10"></i> </a>
												   <a class="eliminarCotizacion" href="#" data-toggle="tooltip" data-original-title="Borrar"> <i class="icon-close text-danger m-r-10"></i> </a>
												   <span data-toggle="modal" data-target="#modalCotizacion">
													 <a class="detalleCotizacion" href="#" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye m-r-10"></i></a>
												   </span>
												   <a class="cambiarEstado" href="#" data-toggle="tooltip" data-original-title="Cambiar Estado"> <i class="text-primary icon-note"></i> </a>
												 </td>
											 </tr> -->
										 </tbody>
									 </table>
								 </div>
							   </div>

							   <div class="tab-pane" id="rechazada" role="tabpanel">
								    <div class="table-responsive p-20">
										<table id="cotizacionesRechazadas" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th>Inicio</th>
												<th>Fin</th>
												<th class="w-75">Descripción</th>
												<th>Estado</th>
												<th>Cliente</th>
												<th>Prioridad</th>
												<th></th>
											</tr>
										</thead>
										<tfoot>
											<tr>
												<th>Inicio</th>
												<th>Fin</th>
												<th>Descripción</th>
												<th>Estado</th>
												<th>Cliente</th>
												<th>Prioridad</th>
												<th></th>
											</tr>
										</tfoot>
										<tbody>
											<!-- <tr>
												<td>03-Agosto-19</td>
												<td>Ropero de madera de roble</td>
												<td><span class="badge badge-success">Aceptada</span></td>
												<td>Itzel Rendón</td>
												<td>$xx,xxx.xx</td>
												<td><span class="badge badge-pill badge-primary">Alta</span></td>
												<td class="text-nowrap">
													<a href="/modificarCotizacion" data-toggle="tooltip" data-original-title="Editar"> <i class="icon-pencil text-inverse m-r-10"></i></a>
													<a class="eliminarCotizacion" href="#" data-toggle="tooltip" data-original-title="Borrar"> <i class="icon-close text-danger m-r-10"></i> </a>
													<span data-toggle="modal" data-target="#modalCotizacion">
													  <a class="detalleCotizacion" href="#" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye m-r-10"></i> </a>
												   </span>
												   <a class="cambiarEstado" href="#" data-toggle="tooltip" data-original-title="Cambiar Estado"> <i class="text-primary icon-note"></i> </a>
												</td>
											</tr>
											<tr>
												<td>03-Agosto-19</td>
												<td>Puerta de recámara</td>
												<td><span class="badge badge-danger">Rechazada</span></td>
												<td>Itzel Rendón</td>
												<td>$xx,xxx.xx</td>
												<td><span class="badge badge-pill badge-info">Media</span></td>
												<td class="text-nowrap">
												  <a href="/modificarCotizacion" data-toggle="tooltip" data-original-title="Editar"> <i class="icon-pencil text-inverse m-r-10"></i> </a>
												  <a class="eliminarCotizacion" href="#" data-toggle="tooltip" data-original-title="Borrar"> <i class="icon-close text-danger m-r-10"></i> </a>
												  <span data-toggle="modal" data-target="#modalCotizacion">
													<a class="detalleCotizacion" href="#" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye m-r-10"></i> </a>
												  </span>
												  <a class="cambiarEstado" href="#" data-toggle="tooltip" data-original-title="Cambiar Estado"> <i class="text-primary icon-note"></i> </a>
												</td>
											</tr>
											 <tr>
												<td>03-Agosto-19</td>
												<td>Escritorio largo de 1.20 mts</td>
												<td><span class="badge badge-warning">En taller</span></td>
												<td>Itzel Rendón</td>
												<td>$xx,xxx.xx</td>
												<td><span class="badge badge-pill badge-inverse">Baja</span></td>
												<td class="text-nowrap">
												  <a href="/modificarCotizacion" data-toggle="tooltip" data-original-title="Editar"> <i class="icon-pencil text-inverse m-r-10"></i> </a>
												  <a class="eliminarCotizacion" href="#" data-toggle="tooltip" data-original-title="Borrar"> <i class="icon-close text-danger m-r-10"></i> </a>
												  <span data-toggle="modal" data-target="#modalCotizacion">
													<a class="detalleCotizacion" href="#" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye m-r-10"></i></a>
												  </span>
												  <a class="cambiarEstado" href="#" data-toggle="tooltip" data-original-title="Cambiar Estado"> <i class="text-primary icon-note"></i> </a>
												</td>
											</tr> -->
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
	    <!-- Modal de info extra -->
	    <div id="modalCotizacion" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	        <div class="modal-dialog modal-lg">
	            <div class="modal-content">
	                <div class="modal-header">
	                    <h4 class="modal-title" id="myModalLabel">Detalles de la cotización</h4>
	                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	                </div>
	                <div class="modal-body">
	                    <h4>Cotizacion</h4>
						<div class="row">
						  <div class="col-lg-6">
							  <p>Costo</p>
						  </div>
						</div>
						<table class="table table-hover" id="tablaDetalleCotizacion">
	                      <thead>
	                        <tr>
							  <th scope="col">Cantidad</th>
	                          <th scope="col">Producto</th>
	                          <th scope="col">Descripción</th>
	                          <th scope="col">Material</th>
	                          <th scope="col">Subtotal</th>
	                          <th scope="col">IVA</th>
	                          <th scope="col">Total</th>
	                        </tr>
	                      </thead>
	                      <tbody>
	                        <tr>
							  <td>1</td>
	                          <td>Ropero de madera de roble</td>
	                          <td>Pintura obscura, decorado...</td>
	                          <td>
	                            <ul>
	                              <li>Madera</li>
	                              <li>Clavos</li>
	                              <li>Pegamento</li>
	                            </ul>
	                          </td>
	                          <td>$4,900</td>
	                          <td>$1,600</td>
	                          <td>$6,500</td>
	                        </tr>
	                        <tr>
							  <td>1</td>
	                          <td>Ropero de madera de roble</td>
	                          <td>Pintura obscura, decorado...</td>
	                          <td>
	                            <ul>
	                              <li>Madera</li>
	                              <li>Clavos</li>
	                              <li>Pegamento</li>
	                            </ul>
	                          </td>
	                          <td>$4,900</td>
	                          <td>$1,600</td>
	                          <td>$6,500</td>
	                        </tr>
	                        <tr>
							  <td>1</td>
	                          <td>Ropero de madera de roble</td>
	                          <td>Pintura obscura, decorado...</td>
	                          <td>
	                            <ul>
	                              <li>Madera</li>
	                              <li>Clavos</li>
	                              <li>Pegamento</li>
	                            </ul>
	                          </td>
	                          <td>$4,900</td>
	                          <td>$1,600</td>
	                          <td>$6,500</td>
	                        </tr>
	                      </tbody>
	                    </table>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Aceptar</button>
	                </div>
	            </div>
	        </div>
	    </div>
	    <!-- Fin modal info extra  -->

		<!-- /.modal modificar estado -->
		<div class="modal fade bs-example-modal-sm" id="modalEstado" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
		  <div class="modal-dialog modal-sm">
			  <div class="modal-content">
				  <div class="modal-header">
					  <h4 class="modal-title" id="mySmallModalLabel">Actualizar estado</h4>
					  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				  </div>
				  <div class="modal-body">
					  <form name="formProducto" id="formEstadoCotizacion" name="formEstadoCotizacion">
						  @csrf
						  <div class="row">
							  <div class="form-group col-md-12">
								  <h5>Estado</h5>
								  <select class="form-control custom-select" name="selectEstadoCotizacion" id="selectEstadoCotizacion">
									  <option value="0">Rechazada</option>
									  <option value="1">Aceptada</option>
									  <option value="2">En taller</option>
									  <option value="3">Por confirmar</option>
									  <option value="4">Terminado</option>
								  </select>
							  </div>
						  </div>
					  </form>
				  </div>
				  <div class="modal-footer">
					  <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
					  <button type="button" id="botonModalEstadoCotizacion" class="btn btn-success" onclick="cambiarEstadoCotizacion()"><i class="fa fa-save"></i> Aceptar</button>
				  </div>
			  </div>
		  </div>
	  </div>
	  <!-- /.modal-dialog -->

	</div>
		@section('footer')
		@parent
@endsection
@endsection
@endsection
