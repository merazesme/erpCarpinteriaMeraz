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
          <div class="col-md-12">
              <div class="card">
                  <div class="card-body p-b-0">
                      <a class="btn waves-effect waves-light btn-primary float-right" href="/trabajadores/agregar"> <i class="fa fa-plus"></i> Agregar trabajador</a>
                      <h4 class="card-title">Lista de trabajadores</h4>
                      <!-- Nav tabs -->
                      <ul class="nav nav-tabs" role="tablist">
                          <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Activos</span></a> </li>
                          <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#profile" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Inactivos</span></a> </li>
                      </ul>
                      <!-- Tab panes -->
                      <div class="tab-content tabcontent-border">
                          <div class="tab-pane active" id="home" role="tabpanel">
                              <div class="p-20">
                                  <div class="table-responsive">
                                      <table id="trabajadoresActivos" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                          <thead>
                                              <tr>
                                                  <th>Nombre</th>
                                                  <th>Puesto</th>
                                                  <th>Fecha de liquidación</th>
                                                  <th>Acciones</th>
                                              </tr>
                                          </thead>
                                          <tfoot>
                                              <tr>
                                                  <th>Nombre</th>
                                                  <th>Puesto</th>
                                                  <th>Fecha de liquidación</th>
                                                  <th>Acciones</th>
                                              </tr>
                                          </tfoot>
                                          <tbody>
                                              <tr>
                                                  <td>Toluco el loco</td>
                                                  <td>Repartidor</td>
                                                  <td>28/12/2019</td>
                                                  <td class="text-nowrap">
                                                    <a href="#" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye text-inverse m-r-10"></i> </a>
                                                    <a href="#" data-toggle="tooltip" data-original-title="Editar"> <i class="icon-pencil text-inverse m-r-10"></i> </a>
                                                    <a href="#" data-toggle="tooltip" data-original-title="Liquidar"> <i class="mdi mdi-file-check text-inverse m-r-10"></i> </a>
                                                    <a href="#" data-toggle="tooltip" data-original-title="Celular"> <i class="icon-phone text-inverse em-r-10"></i> </a>
                                                  </td>
                                                  <!-- <a href="tel:018007271622" style="transition-duration: 0.3s; touch-action: manipulation;"><span style="font-family: Lato; font-size: 14px;"><b>01 800 727 1622</b></span></a> -->
                                              </tr>
                                          </tbody>
                                      </table>
                                  </div>
                              </div>
                          </div>
                          <div class="tab-pane" id="profile" role="tabpanel">
                              <div class="p-20">
                                    <div class="table-responsive">
                                        <table id="trabajadoresInactivos" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Nombre</th>
                                                    <th>Puesto</th>
                                                    <th>Fecha de liquidación</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>Nombre</th>
                                                    <th>Puesto</th>
                                                    <th>Fecha de liquidación</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                <tr>
                                                    <td>Adriana Hernández</td>
                                                    <td>Jefa de Producción</td>
                                                    <td>28/12/2019</td>
                                                    <td class="text-nowrap">
                                                      <a href="#" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye text-inverse m-r-10"></i> </a>
                                                      <a href="#" data-toggle="tooltip" data-original-title="Editar"> <i class="icon-pencil text-inverse m-r-10"></i> </a>
                                                      <a href="#" data-toggle="tooltip" data-original-title="Contratar"> <i class="mdi mdi-file-document text-inverse m-r-10"></i> </a>
                                                      <a href="#" data-toggle="tooltip" data-original-title="Celular"> <i class="icon-phone text-inverse em-r-10"></i> </a>
                                                    </td>
                                                    <!-- <a href="tel:018007271622" style="transition-duration: 0.3s; touch-action: manipulation;"><span style="font-family: Lato; font-size: 14px;"><b>01 800 727 1622</b></span></a> -->
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
    $('#trabajadoresActivos').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
    $('#trabajadoresInactivos').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
    </script>
	</div>
@endsection
@endsection
@endsection
