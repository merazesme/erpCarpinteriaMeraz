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
	                                      <a href="/modificarCliente" data-toggle="tooltip" data-original-title="Editar"> <i class="icon-pencil text-inverse m-r-10"></i> </a>
	                                      <a href="#" data-toggle="tooltip" data-original-title="Borrar"> <i class="icon-close text-danger m-r-10"></i> </a>
	                                      <a href="#" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye "></i> </a>
	                                  	</td>
                                  </tr>
                                   <tr>
                                      <td>Itzel Rendón</td>
                                      <td>itzel@gmail.com</td>
                                      <td><a href="tel:669 986 8966">669 986 8966</a></td>
                                      <td class="text-nowrap">
                                        <a href="/modificarCliente" data-toggle="tooltip" data-original-title="Editar"> <i class="icon-pencil text-inverse m-r-10"></i> </a>
                                        <a href="#" data-toggle="tooltip" data-original-title="Borrar"> <i class="icon-close text-danger m-r-10"></i> </a>
                                        <a href="#" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye "></i> </a>
                                      </td>
                                  </tr>
                                   <tr>
                                      <td>Itzel Rendón</td>
                                      <td>itzel@gmail.com</td>
                                      <td><a href="tel:669 986 8966">669 986 8966</a></td>
                                      <td class="text-nowrap">
                                        <a href="/modificarCliente" data-toggle="tooltip" data-original-title="Editar"> <i class="icon-pencil text-inverse m-r-10"></i> </a>
                                        <a href="#" data-toggle="tooltip" data-original-title="Borrar"> <i class="icon-close text-danger m-r-10"></i> </a>
                                        <a href="#" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye "></i> </a>
                                      </td>
                                  </tr>
                                   <tr>
                                      <td>Itzel Rendón</td>
                                      <td>itzel@gmail.com</td>
                                      <td><a href="tel:669 986 8966">669 986 8966</a></td>
                                      <td class="text-nowrap">
                                        <a href="/modificarCliente" data-toggle="tooltip" data-original-title="Editar"> <i class="icon-pencil text-inverse m-r-10"></i> </a>
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
		@section('footer')
		@parent
		<script>
    $(document).ready(function() {
        $('#myTable').DataTable();
        $(document).ready(function() {
            var table = $('#example').DataTable({
                "columnDefs": [{
                    "visible": false,
                    "targets": 2
                }],
                "order": [
                    [2, 'asc']
                ],
                "displayLength": 25,
                "drawCallback": function(settings) {
                    var api = this.api();
                    var rows = api.rows({
                        page: 'current'
                    }).nodes();
                    var last = null;
                    api.column(2, {
                        page: 'current'
                    }).data().each(function(group, i) {
                        if (last !== group) {
                            $(rows).eq(i).before('<tr class="group"><td colspan="5">' + group + '</td></tr>');
                            last = group;
                        }
                    });
                }
            });
            // Order by the grouping
            $('#example tbody').on('click', 'tr.group', function() {
                var currentOrder = table.order()[0];
                if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
                    table.order([2, 'desc']).draw();
                } else {
                    table.order([2, 'asc']).draw();
                }
            });
        });
    });
    $('#clientes').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'excel', 'pdf', 'print'
        ]
    });
    </script>
	</div>
@endsection
@endsection
@endsection
@endsection
