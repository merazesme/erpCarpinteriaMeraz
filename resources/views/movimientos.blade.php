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
              <!-- Table -->
              <div class="card-body">
                        <h4 class="card-title">Movimientos</h4>
                        <h6 class="card-subtitle">Exportar datos a copia, CSV, Excel, PDF & impresión</h6>
                        <select class="custom-select b-0">
                            <option selected=""><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Facturas</font></font></option>
                            <option value="1"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Cheques</font></font></option>
                            <option value="2"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Transferencias</font></font></option>
                            <option value="3"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Depósitos</font></font></option>
                        </select>
												<select class="custom-select b-0">
                            <option selected=""><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Enero</font></font></option>
                            <option value="1"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Febrero</font></font></option>
                            <option value="2"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Marzo</font></font></option>
                            <option value="3"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Abril</font></font></option>
                        </select>
                        <div class="table-responsive m-t-40">
                            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                      <th>Procedencia</th>
                                      <th>Fecha</th>
                                      <th>Factura</th>
                                      <th>Subtotal</th>
                                      <th>IVA</th>
                                      <th>Total</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                      <th>Procedencia</th>
                                      <th>Fecha</th>
                                      <th>Factura</th>
                                      <th>Subtotal</th>
                                      <th>IVA</th>
                                      <th>Total</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <tr>
                                        <td>Tiger Nixon</td>
                                        <td>02/07/2019</td>
                                        <td>System Architect</td>
                                        <td>61</td>
                                        <td>13</td>
                                        <td>13123</td>
                                    </tr>
                                    <tr>
                                        <td>Tiger Nixon</td>
                                        <td>02/07/2019</td>
                                        <td>System Architect</td>
                                        <td>61</td>
                                        <td>13</td>
                                        <td>13123</td>
                                    </tr>
                                    <tr>
                                        <td>Tiger Nixon</td>
                                        <td>02/07/2019</td>
                                        <td>System Architect</td>
                                        <td>61</td>
                                        <td>13</td>
                                        <td>13123</td>
                                    </tr>
                                    <tr>
                                        <td>Tiger Nixon</td>
                                        <td>02/07/2019</td>
                                        <td>System Architect</td>
                                        <td>61</td>
                                        <td>13</td>
                                        <td>13123</td>
                                    </tr>
                                    <tr>
                                        <td>Tiger Nixon</td>
                                        <td>02/07/2019</td>
                                        <td>System Architect</td>
                                        <td>61</td>
                                        <td>13</td>
                                        <td>13123</td>
                                    </tr>
                                    <tr>
                                        <td>Tiger Nixon</td>
                                        <td>02/07/2019</td>
                                        <td>System Architect</td>
                                        <td>61</td>
                                        <td>13</td>
                                        <td>13123</td>
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
