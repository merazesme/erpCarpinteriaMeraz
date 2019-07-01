@extends('footer')
@extends('breadcrumbs')
@extends('sidebar')
@extends('header')

	<div id="main-wrapper">
		@section('header')
		@parent
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
                      <a  class="btn waves-effect waves-light btn-primary float-right" href="/agregarCliente"> <i class="fa fa-plus"></i> Agregar cliente</a>
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
	                                      <a href="/modificarCliente" data-toggle="tooltip" data-original-title="Editar"> <i class="icon-pencil text-inverse m-r-10"></i></a>
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
                                        <a href="/modificarCliente" data-toggle="tooltip" data-original-title="Editar"> <i class="icon-pencil text-inverse m-r-10"></i> </a>
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
                                        <a href="/modificarCliente" data-toggle="tooltip" data-original-title="Editar"> <i class="icon-pencil text-inverse m-r-10"></i> </a>
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
                                        <a href="/modificarCliente" data-toggle="tooltip" data-original-title="Editar"> <i class="icon-pencil text-inverse m-r-10"></i> </a>
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
