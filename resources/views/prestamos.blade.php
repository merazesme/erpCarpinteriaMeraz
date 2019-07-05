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
		                      <h4 class="card-title">Prestamos</h4>
		                      <h6 class="card-subtitle">Lista de prestamos</h6>
							  <a style="float:right; margin: -58px  0   22px   860px;" class="btn waves-effect waves-light btn-primary" href="#agregarPrestamo" data-toggle="modal"> <i class="fa fa-plus"></i> Agregar prestamo</a>
		                      <div class="table-responsive m-t-40">
		                          <table id="trabajadores" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
		                              <thead>
		                                  <tr>
											<th>Trabajador</th>
			                                <th>Monto</th>
											<th>Resta</th>
											<th>Fecha</th>
											<th>Acciones</th>
		                                  </tr>
		                              </thead>
		                              <tfoot>
		                                  <tr>
											<th>Trabajador</th>
		                                    <th>Monto</th>
		                                    <th>Resta</th>
										    <th>Fecha</th>
											<th>Acciones</th>
		                                  </tr>
		                              </tfoot>
		                              <tbody>
		                                  <tr>
			                                <td>Adriana Hernández</td>
			                                <td>$5000.00</td>
											<td>$1350.00</td>
			                                <td>28/12/2019</td>
											<td class="text-nowrap">
												<a href="#" data-toggle="modal" data-original-title="Ver detalles"> <i class="icon-eye text-inverse m-r-10"></i> </a>
				                                <a href="#modalAbonar" data-toggle="modal" data-original-title="Abonar"> <i class="ti-money text-inverse m-r-10"></i> </a>
				                                <a data-toggle="modal" data-original-title="Liquidar" id="sa-success"> <i class="ti-check text-danger m-r-10"></i> </a>
			                                </td>
		                                  </tr>
		                              </tbody>
		                          </table>
		                      </div>
		                  </div>
		              </div>
		          </div>
		      	</div>
				<!-- MODAL NUEVO PRESTAMO -->
				<div class="modal fade" id="agregarPrestamo" tabindex="-1" role="dialog" aria-labelledby="agregarPrestamo">
	          		<div class="modal-dialog" role="document">
		              <div class="modal-content">
		                  <div class="modal-header">
		                      <h4 class="modal-title" id="exampleModalLabel1">Nuevo prestamo</h4>
		                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		                  </div>
	                  <div class="modal-body">
	                      <form>
							<div class="form-group">
									<label for="trabajador">Trabajador: <span class="danger">*</span> </label>
									<select class="select2 form-control custom-select" style="width: 100%; height:36px;">
											<option>Select</option>
											<optgroup label="Base">
													<option value="AK">Adriana Hernández</option>
													<option value="HI">Jesús Vizcarra</option>
											</optgroup>
											<optgroup label="Temporal">
													<option value="CA">Fabiola Paez</option>
													<option value="NV">Itzel Rendón</option>
													<option value="OR">Esmeralda Meraz</option>
											</optgroup>
									</select>
							</div>
							<div class="row">
									<div class="col-md-6">
											<div class="form-group">
													<label for="concepto" class="control-label">Concepto:</label>
													<input type="text" class="form-control" id="concepto">
											</div>
									</div>
									<div class="col-md-6">
											<div class="form-group">
												<label for="monto" class="control-label">Monto:</label>
												<input type="text" class="form-control" id="monto">
											</div>
									</div>
							</div>
							<div class="form-group">
                                <label>Descripción:</label>
                                <textarea class="form-control" rows="2"></textarea>
                            </div>
														<div class="form-group">
                                <label>Contraseña(trabajador):</label>
                                <input type="password" class="form-control" value="password">
                            </div>
	                      </form>
	                  </div>
	                  <div class="modal-footer">
	                      <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
	                      <button type="button" class="btn btn-info">Guardar</button>
	                  </div>
	              </div>
	          </div>
	      </div>
	      <!-- /.MODAL AGREGAR -->
				<!-- MODAL ABONAR -->
				<div class="modal fade" id="modalAbonar" tabindex="-1" role="dialog" aria-labelledby="abonar">
	          <div class="modal-dialog" role="document">
	              <div class="modal-content">
	                  <div class="modal-header">
	                      <h4 class="modal-title" id="exampleModalLabel1">Nuevo abono</h4>
	                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                  </div>
	                  <div class="modal-body">
	                      <form>
							<div class="row">
									<div class="col-md-6">
											<div class="form-group">
												<label for="monto" class="control-label">Monto:</label>
												<input type="text" class="form-control" id="monto">
											</div>
									</div>
									<div class="col-md-6">
											<div class="form-group">
													<label for="comentario" class="control-label">Comentario:</label>
													<input type="text" class="form-control" id="comentario">
											</div>
									</div>
							</div>
							<div class="form-group">
                                <label>Contraseña(trabajador):</label>
                                <input type="password" class="form-control" value="password">
                            </div>
	                      </form>
	                  </div>
	                  <div class="modal-footer">
	                      <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
	                      <button type="button" class="btn btn-info">Guardar</button>
	                  </div>
	              </div>
	          </div>
	      </div>
	      <!-- /.MODAL ABONAR -->
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
    $('#trabajadores').DataTable({
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
