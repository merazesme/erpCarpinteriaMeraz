@extends('footer')
@extends('sidebar')
@extends('header')

	<div id="main-wrapper">
		@section('header')
		@parent
		@section('sidebar')
		@parent
		<div class="page-wrapper">
			<div class="container-fluid">
				<div class="row">
          <div class="col-12">
              <div class="card">
                  <div class="card-body">
											<button id="genera" type="button" class="btn waves-effect waves-light btn-primary float-right"><i class="fa fa-plus"></i> Generar vacaciones 2019</button>
                      <h4 class="card-title">Listado de vacaciones</h4>
                      <div class="table-responsive m-t-40" id="tabla">
                          <table id="clientes" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                              <thead>
                                  <tr>
                                    <th>Nombre</th>
                                    <th>Sueldo Base</th>
																		<th>Vacaciones 3 días</th>
																		<th>25% Prima</th>
                                    <th>Bono Extra</th>
                                    <th>Infonavit</th>
                                    <th>Total</th>


                                  </tr>
                              </thead>
															<tfoot>
																<tr>
																	<th>Totales</th>
																	<th>76565</th>
																	<th>78678</th>
																	<th>786786</th>
																	<th>89797</th>
																	<th>67576</th>
																	<th>8676</th>
																</tr>
															</tfoot>
                              <tbody>
                                  <tr>
                                      <td>Itzel Rendón</td>
                                      <td>123</td>
                                      <td>123</td>
                                      <td>123</td>
                                      <td>123</td>
                                      <td>123</td>
                                      <td>123</td>
                                  </tr>
                                  <tr>
                                      <td>Itzel Rendón</td>
                                      <td>123</td>
                                      <td>123</td>
                                      <td>123</td>
                                      <td>123</td>
                                      <td>123</td>
                                      <td>123</td>
                                  </tr>
                                  <tr>
                                      <td>Itzel Rendón</td>
                                      <td>123</td>
                                      <td>123</td>
                                      <td>123</td>
                                      <td>123</td>
                                      <td>123</td>
                                      <td>123</td>
                                  </tr>
                                  <tr>
                                      <td>Itzel Rendón</td>
                                      <td>123</td>
                                      <td>123</td>
                                      <td>123</td>
                                      <td>123</td>
                                      <td>123</td>
                                      <td>123</td>
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
				$('#genera').on('click', function() {
						$('#tabla').show();
				});
				$('#tabla').hide();
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
