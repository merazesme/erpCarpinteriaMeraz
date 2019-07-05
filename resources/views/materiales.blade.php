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
          <!-- -->
          <div class="row">
              <div class="card">

                    <!-- Table -->
				<div class="card-body">
					<h4 class="card-title">Materiales</h4>
					<h6 class="card-subtitle">Exportar datos a copia, CSV, Excel, PDF & impresión</h6>
					<!-- <a style="float:right; margin: -58px  0   22px   860px;" class="btn waves-effect waves-light btn-primary" href="/agregar_material"><i class="fa fa-plus"></i>  Agregar material</a> -->
					<a style="float:right; margin: -58px  0   22px   860px;" class="btn waves-effect waves-light btn-primary" href="#modal_agregar_material" data-toggle="modal"><i class="fa fa-plus"></i>  Agregar material</a>
					<div class="table-responsive m-t-40">
						<table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>Nombre</th>
									<th>Concepto</th>
									<th>Existencia</th>
									<th>Estado</th>
									<th>Acciones</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>Nombre</th>
									<th>Concepto</th>
									<th>Existencia</th>
									<th>Estado</th>
									<th>Acciones</th>
								</tr>
							</tfoot>
							<tbody>
								<tr>
								    <td>Tiger Nixon</td>
									<td>System Architect</td>
									<td>61</td>
									<td><span class="label label-danger"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Inactivo</font></font></span></td>
									<td class="text-nowrap">
	                                  <a href="#" data-toggle="tooltip" data-original-title="Editar"> <i class="icon-pencil text-inverse m-r-10"></i> </a>
	                                  <a href="#" data-toggle="tooltip" data-original-title="Borrar"> <i class="icon-close text-danger m-r-10"></i> </a>
	                                  <a href="#" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye "></i> </a>
									</td>
								</tr>
								<tr>
								    <td>Tiger Nixon</td>
									<td>System Architect</td>
									<td>61</td>
									<td><span class="label label-success"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Activo</font></font></span></td>
									<td class="text-nowrap">
	                                  <a href="#" data-toggle="tooltip" data-original-title="Editar"> <i class="icon-pencil text-inverse m-r-10"></i> </a>
	                                  <a href="#" data-toggle="tooltip" data-original-title="Borrar"> <i class="icon-close text-danger m-r-10"></i> </a>
	                                  <a href="#" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye "></i> </a>
									</td>
								</tr>
								<tr>
								    <td>Tiger Nixon</td>
									<td>System Architect</td>
									<td>61</td>
									<td><span class="label label-success"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Activo</font></font></span></td>
									<td class="text-nowrap">
	                                  <a href="#" data-toggle="tooltip" data-original-title="Editar"> <i class="icon-pencil text-inverse m-r-10"></i> </a>
	                                  <a href="#" data-toggle="tooltip" data-original-title="Borrar"> <i class="icon-close text-danger m-r-10"></i> </a>
	                                  <a href="#" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye "></i> </a>
									</td>
								</tr>
								<tr>
								    <td>Tiger Nixon</td>
									<td>System Architect</td>
									<td>61</td>
									<td><span class="label label-danger"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Inactivo</font></font></span></td>
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
										<!-- Table -->

										<!-- Modal -->
						<div id="modal_agregar_material" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Agregar material</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body">
                                    <form>
                                        <div class="form-group">
                                            <label for="recipient-name" class="control-label">Nombre</label>
                                            <input type="text" class="form-control" id="recipient-name">
                                        </div>
																				<div class="form-group">
                                            <label for="recipient-name" class="control-label">Tipo</label>
																						<select class="form-control">
                                            <option><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Herramientas</font></font></option>
                                            <option><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Madera</font></font></option>
                                            <option><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Etc</font></font></option>
                                        </select>
                                        </div>
																				<div class="form-group">
                                            <label for="recipient-name" class="control-label">Cantidad</label>
                                            <input type="text" class="form-control" id="recipient-name">
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-danger waves-effect waves-light">Save changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
					<!-- Modal -->

              </div>
          </div>
          <!--  -->
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
