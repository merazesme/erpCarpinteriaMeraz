@extends('footer')
@extends('breadcrumbs')
@extends('sidebar')
@extends('header')

@section('header')
@parent
	<div id="main-wrapper">
		@csrf

		@section('sidebar')
		@parent
		<div class="page-wrapper">
			<div class="container-fluid">
				@section('breadcrumbs')
				@parent
				<div class="row">
		          <div class="col-12">
		              <div class="card">
		                  <div class="card-body">
		                      <!-- <h6 class="card-subtitle">Lista de Clientes</h6> -->
		                      <button type="button" class="btn waves-effect waves-light btn-primary float-right" onclick="agregarCliente()"> <i class="fa fa-plus"></i> Agregar cliente</button>
		                      <h4 class="card-title">Lista de Clientes</h4>

							  <ul class="nav nav-tabs" role="tablist">
		                          <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#activo" role="tab"><span class="hidden-sm-up"><i class="icon-user"></i></span> <span class="hidden-xs-down">Activos</span></a> </li>
		                          <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#inactivo" role="tab"><span class="hidden-sm-up"><i class="icon-user-unfollow"></i></span> <span class="hidden-xs-down">Inactivos</span></a> </li>
		                      </ul>

							  <div class="tab-content tabcontent-border">
		                         <div class="tab-pane active" id="activo" role="tabpanel">
									  <div class="table-responsive p-20">
				                          <table id="clientes" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
				                              <thead>
				                                  <tr>
				                                    <th>Nombre</th>
				                                    <th>Correo</th>
													<th>Teléfono</th>
													<th></th>
				                                  </tr>
				                              </thead>
				                              <tfoot>
				                                  <tr>
				                                      <th>Nombre</th>
				                                      <th>Correo</th>
											          <th>Teléfono</th>
													  <th></th>
				                                  </tr>
				                              </tfoot>
				                              <tbody>
				                                  <!-- <tr>
				                                      <td>Itzel Rendón</td>
				                                      <td>itzel@gmail.com</td>
				                                      <td><a href="tel:669 986 8966">669 986 8966</a></td>
				    								  <td class="text-nowrap">
						                                  <span data-toggle="modal" data-target="#modalAgregar">
					                                      	<a href="#" class="modificarCliente" data-toggle="tooltip" data-original-title="Editar"> <i class="icon-pencil text-inverse m-r-10"></i></a>
					                                      </span>
						                                  <a class="eliminarCliente" href="#" data-toggle="tooltip" data-original-title="Borrar"> <i class="icon-close text-danger m-r-10"></i> </a>
						                                  <span data-toggle="modal" data-target="#modalDetalles">
					                                      	<a cliente="1" class="detalleClientes" href="#" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye "></i> </a>
					                                      </span>
					                                  </td>
				                                  </tr>-->
				                              </tbody>
				                          </table>
				                      </div>
								  </div>
								  <div class="tab-pane" id="inactivo" role="tabpanel">
									  <div class="table-responsive p-20">
				                          <table id="clientesInactivos" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
				                              <thead>
				                                  <tr>
				                                    <th>Nombre</th>
				                                    <th>Correo</th>
													<th>Teléfono</th>
													<th>Acciones</th>
				                                  </tr>
				                              </thead>
				                              <tfoot>
				                                  <tr>
				                                      <th>Nombre</th>
				                                      <th>Correo</th>
											          <th>Teléfono</th>
													  <th>Acciones</th>
				                                  </tr>
				                              </tfoot>
				                              <tbody>
				                                  <!-- <tr>
				                                      <td>Itzel Rendón</td>
				                                      <td>itzel@gmail.com</td>
				                                      <td><a href="tel:669 986 8966">669 986 8966</a></td>
				    								  <td class="text-nowrap">
						                                  <span data-toggle="modal" data-target="#modalAgregar">
					                                      	<a href="#" class="modificarCliente" data-toggle="tooltip" data-original-title="Editar"> <i class="icon-pencil text-inverse m-r-10"></i></a>
					                                      </span>
						                                  <a class="eliminarCliente" href="#" data-toggle="tooltip" data-original-title="Borrar"> <i class="icon-close text-danger m-r-10"></i> </a>
						                                  <span data-toggle="modal" data-target="#modalDetalles">
					                                      	<a cliente="1" class="detalleClientes" href="#" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye "></i> </a>
					                                      </span>
					                                  </td>
				                                  </tr>-->
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
	    <div id="modalDetalles" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	        <div class="modal-dialog modal-lg">
	            <div class="modal-content">
	                <div class="modal-header">
	                    <h4 class="modal-title" id="myModalLabel">Detalles del cliente</h4>
	                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	                </div>
	                <div class="modal-body">
	                    <h4>Cotizaciones</h4>
	                    <table class="table table-hover" id="tablaCotizaciones">
	                      <thead>
	                        <tr>
	                          <th scope="col">#</th>
							  <th scope="col">Inicio</th>
							  <th scope="col">Terminación</th>
							  <th scope="col">Descripción</th>
	                          <th scope="col">Precio</th>
	                          <th scope="col">Estado</th>
	                          <th scope="col"></th>
	                        </tr>
	                      </thead>
	                      <tbody>
	                        <tr>
	                          <th>1</th>
	                          <td>Ropero de madera de roble</td>
	                          <td>$5,000</td>
	                          <td><span class="badge badge-success">Aceptada</span></td>
	                          <td><a href="/cotizaciones" data-toggle="tooltip" data-original-title="Ver cotización" type="button" class="btn waves-effect waves-light btn-info"><i class="mdi mdi-eye"></i></a></td>
	                        </tr>
	                        <tr>
	                          <th>2</th>
	                          <td>Puerta de recámara</td>
	                          <td>$1,200</td>
	                          <td><span class="badge badge-danger">Rechazada</span></td>
	                          <td><a href="/cotizaciones" data-toggle="tooltip" data-original-title="Ver cotización" type="button" class="btn waves-effect waves-light btn-info"><i class="mdi mdi-eye"></i></a></td>
	                        </tr>
	                        <tr>
	                          <th>3</th>
	                          <td>Escritorio largo de 1.20 mts</td>
	                          <td>$2,500</td>
	                          <td><span class="badge badge-warning">En taller</span></td>
	                          <td><a href="/cotizaciones" data-toggle="tooltip" data-original-title="Ver cotización" type="button" class="btn waves-effect waves-light btn-info"><i class="mdi mdi-eye"></i></a></td>
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

		<div id="modalDetallesCotizacion" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	        <div class="modal-dialog modal-lg">
				<div class="modal-content">
	                <div class="modal-header">
	                    <h4 class="modal-title" id="myModalLabel">Detalles de la cotización</h4>
	                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	                </div>
	                <div class="modal-body">
	                    <h4>Cotizacion</h4>
						<div class="container" id="descCotizacion">
							<h5>Descripción</h5>
							<p></p>
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

	    <!-- Modal de agregar cliente -->
	    <div id="modalAgregar" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	        <div class="modal-dialog modal-lg">
	            <div class="modal-content">
	                <div class="modal-header">
	                    <h4 class="modal-title" id="agregarTitulo">Agregar Cliente</h4>
	                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	                </div>
	                <div class="modal-body">
	                    <form id="frmCliente" name="frmCliente">
							<input type="text" class="form-control d-none" id="token" name="_token" value="{{csrf_token()}}">
	                      <!-- Datos Personales -->
	                      <h6>Datos Personales</h6>
	                      <section>
	                          <div class="row">
	                              <div class="col-md-6">
	                                  <div class="form-group">
	                                      <label for="nombre">Nombre(s): <span class="danger">*</span> </label>
	                                      <input type="text" class="form-control required" id="txtNombre" name="txtNombre">
	                                  </div>
	                              </div>
	                              <div class="col-md-6">
	                                  <div class="form-group">
	                                      <label for="apellidos">Apellidos: </label>
	                                      <input type="text" class="form-control required" id="txtApellidos" name="txtApellidos">
	                                  </div>
	                              </div>
	                          </div>
	                          <div class="row">
	                              <div class="col-md-6">
	                                  <div class="form-group">
	                                    <label for="celular">Email: <span class="danger">*</span> </label>
	                                    <input type="email" class="form-control required" id="txtEmail" name="txtEmail">
										<label id="txtEmail-error" class="text-danger" for="txtEmail" style="display: none;">El email es inválido.</label>
									</div>
	                              </div>
	                              <div class="col-md-6">
	                                  <div class="form-group">
	                                      <label for="numero_alternativo">Teléfono: <span class="danger">*</span> </label>
	                                      <input type="tel" class="form-control required" id="txtTelefono" name="txtTelefono">
										  <label id="txtTelefono-error" class="text-danger" for="txtEmail" style="display: none;">El teléfono es inválido.</label>
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
	    <!-- Fin modal agregar cliente  -->
			@section('footer')
			@parent
	</div>
@endsection
@endsection
@endsection
@endsection
