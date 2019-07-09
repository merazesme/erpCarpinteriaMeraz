@extends('footer')
@extends('breadcrumbs')
@extends('sidebar')
@extends('header')

@section('header')
@parent
	<div id="main-wrapper">
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
                      <button data-toggle="modal" data-target="#modalAgregar" type="button" class="btn waves-effect waves-light btn-primary float-right"> <i class="fa fa-plus"></i> Agregar cliente</button>
                      <h4 class="card-title">Lista de Clientes</h4>
                      <div class="table-responsive m-t-40">
                          <table id="clientes" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
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
                                  <tr>
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
                                  </tr>
                                   <tr>
                                      <td>Itzel Rendón</td>
                                      <td>itzel@gmail.com</td>
                                      <td><a href="tel:669 986 8966">669 986 8966</a></td>
                                      <td class="text-nowrap">
                                        <span data-toggle="modal" data-target="#modalAgregar">
                                          <a href="#" class="modificarCliente" data-toggle="tooltip" data-original-title="Editar"> <i class="icon-pencil text-inverse m-r-10"></i> </a>
                                        </span>
                                        <a class="eliminarCliente" href="#" data-toggle="tooltip" data-original-title="Borrar"> <i class="icon-close text-danger m-r-10"></i> </a>
                                        <span data-toggle="modal" data-target="#modalDetalles">
                                          <a class="detalleClientes" href="#" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye "></i> </a>
                                        </span>
                                      </td>
                                  </tr>
                                   <tr>
                                      <td>Itzel Rendón</td>
                                      <td>itzel@gmail.com</td>
                                      <td><a href="tel:669 986 8966">669 986 8966</a></td>
                                      <td class="text-nowrap">
                                        <span data-toggle="modal" data-target="#modalAgregar">
                                          <a href="#" class="modificarCliente" data-toggle="tooltip" data-original-title="Editar"> <i class="icon-pencil text-inverse m-r-10"></i> </a>
                                        </span>
                                        <a class="eliminarCliente" href="#" data-toggle="tooltip" data-original-title="Borrar"> <i class="icon-close text-danger m-r-10"></i> </a>
                                        <span data-toggle="modal" data-target="#modalDetalles">
                                          <a class="detalleClientes" href="#" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye "></i> </a>
                                        </span>
                                      </td>
                                  </tr>
                                   <tr>
                                      <td>Itzel Rendón</td>
                                      <td>itzel@gmail.com</td>
                                      <td><a href="tel:669 986 8966">669 986 8966</a></td>
                                      <td class="text-nowrap">
                                        <span data-toggle="modal" data-target="#modalAgregar">
                                          <a href="#" class="modificarCliente" data-toggle="tooltip" data-original-title="Editar"> <i class="icon-pencil text-inverse m-r-10"></i> </a>
                                        </span>
                                        <a class="eliminarCliente" href="#" data-toggle="tooltip" data-original-title="Borrar"> <i class="icon-close text-danger m-r-10"></i> </a>
                                        <span data-toggle="modal" data-target="#modalDetalles">
                                          <a class="detalleClientes" href="#" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye "></i> </a>
                                        </span>
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
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Descripción</th>
                          <th scope="col">Precio</th>
                          <th scope="col">Estado</th>
                          <th scope="col"></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <th scope="row">1</th>
                          <td>Ropero de madera de roble</td>
                          <td>$5,000</td>
                          <td><span class="badge badge-success">Aceptada</span></td>
                          <td><a href="/cotizaciones" data-toggle="tooltip" data-original-title="Ver cotización" type="button" class="btn waves-effect waves-light btn-info"><i class="mdi mdi-eye"></i></a></td>
                        </tr>
                        <tr>
                          <th scope="row">2</th>
                          <td>Puerta de recámara</td>
                          <td>$1,200</td>
                          <td><span class="badge badge-danger">Rechazada</span></td>
                          <td><a href="/cotizaciones" data-toggle="tooltip" data-original-title="Ver cotización" type="button" class="btn waves-effect waves-light btn-info"><i class="mdi mdi-eye"></i></a></td>
                        </tr>
                        <tr>
                          <th scope="row">3</th>
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

    <!-- Modal de agregar cliente -->
    <div id="modalAgregar" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Agregar Cliente</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form action="#" class="">
                      <!-- Datos Personales -->
                      <h6>Datos Personales</h6>
                      <section>
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="nombre">Nombre(s): <span class="danger">*</span> </label>
                                      <input type="text" class="form-control required" id="nombre" name="Nombre">
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="apellidos">Apellidos: <span class="danger">*</span> </label>
                                      <input type="text" class="form-control required" id="apellidos" name="Apellidos">
                                  </div>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group">
                                    <label for="celular">Email: <span class="danger">*</span> </label>
                                    <input type="email" class="form-control required" id="email" name="email">
                                </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="numero_alternativo">Teléfono: <span class="danger">*</span> </label>
                                      <input type="tel" class="form-control required" id="telefono" name="telefono">
                                  </div>
                              </div>
                          </div>
                      </section>
                  </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success waves-effect" data-dismiss="modal"><i class="mdi mdi-content-save"></i> Aceptar</button>
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin modal agregar cliente  -->
		@section('footer')
		@parent
		<script>
    $(document).ready(function() {
         $('#clientes').DataTable({
          dom: 'Bfrtip',
          buttons: [
              'excel', 'pdf', 'print'
          ]
      });
    });

    </script>
	</div>
@endsection
@endsection
@endsection
@endsection
