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
              <!-- Table -->
              <div class="card-body">
                        <h4 class="card-title">Movimientos</h4>
                        <h6 class="card-subtitle">Exportar datos a copia, CSV, Excel, PDF & impresión</h6>
                        <!-- <a style="float:right; margin: -58px  0   22px   860px;" class="btn waves-effect waves-light btn-primary" href="/agregar_material"><i class="fa fa-plus"></i>  Agregar material</a> -->
                        <!-- <a style="float:right; margin: -58px  0   22px   860px;" class="btn waves-effect waves-light btn-primary" href="#modal_agregar_material" data-toggle="modal"><i class="fa fa-plus"></i>  Agregar material</a> -->
                        <div class="table-responsive m-t-40">
                            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                      <th>Factura</th>
                                      <th>Procedencia</th>
                                      <th>Movimiento</th>
                                      <th>#Depósito</th>
                                      <th>#Cheque</th>
                                      <th>Fecha</th>
                                      <th>Subtotal</th>
                                      <th>IVA</th>
                                      <th>Total</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                      <th>Factura</th>
                                      <th>Procedencia</th>
                                      <th>Movimiento</th>
                                      <th>#Depósito</th>
                                      <th>#Cheque</th>
                                      <th>Fecha</th>
                                      <th>Subtotal</th>
                                      <th>IVA</th>
                                      <th>Total</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <tr>
                                        <td>Tiger Nixon</td>
                                        <td>De alla</td>
                                        <td>System Architect</td>
                                        <td>61</td>
                                        <td>61</td>
                                        <td>28/06/2019</td>
                                        <td>61</td>
                                        <td>16</td>
                                        <td>214</td>
                                    </tr>
                                    <tr>
                                        <td>Tiger Nixon</td>
                                        <td>De alla</td>
                                        <td>System Architect</td>
                                        <td>61</td>
                                        <td>61</td>
                                        <td>28/06/2019</td>
                                        <td>61</td>
                                        <td>16</td>
                                        <td>214</td>
                                    </tr>
                                    <tr>
                                        <td>Tiger Nixon</td>
                                        <td>De alla</td>
                                        <td>System Architect</td>
                                        <td>61</td>
                                        <td>61</td>
                                        <td>28/06/2019</td>
                                        <td>61</td>
                                        <td>16</td>
                                        <td>214</td>
                                    </tr>
                                    <tr>
                                        <td>Tiger Nixon</td>
                                        <td>De alla</td>
                                        <td>System Architect</td>
                                        <td>61</td>
                                        <td>61</td>
                                        <td>28/06/2019</td>
                                        <td>61</td>
                                        <td>16</td>
                                        <td>214</td>
                                    </tr>
                                    <tr>
                                        <td>Tiger Nixon</td>
                                        <td>De alla</td>
                                        <td>System Architect</td>
                                        <td>61</td>
                                        <td>61</td>
                                        <td>28/06/2019</td>
                                        <td>61</td>
                                        <td>16</td>
                                        <td>214</td>
                                    </tr>
                                    <tr>
                                        <td>Tiger Nixon</td>
                                        <td>De alla</td>
                                        <td>System Architect</td>
                                        <td>61</td>
                                        <td>61</td>
                                        <td>28/06/2019</td>
                                        <td>61</td>
                                        <td>16</td>
                                        <td>214</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
              <!-- Table -->
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
    $('#example23').DataTable({
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
@endsection
