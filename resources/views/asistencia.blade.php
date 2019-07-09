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
		                      <h4 class="card-title">Asistencia</h4>
		                      <h6 class="card-subtitle">Lista de trabajadores</h6>
							  					<div class="table-responsive m-t-40">
                          <table id="trabajadores" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                              <thead>
                                  <tr>
																		<th>Trabajador</th>
										                <th>Mañana</th>
																		<th>Tarde</th>
																		<th>Hora extra</th>
                                  </tr>
                              </thead>
                              <tfoot>
                                  <tr>
																		<th>Trabajador</th>
                                    <th>Mañana</th>
																		<th>Tarde</th>
																		<th>Hora extra</th>
                                  </tr>
                              </tfoot>
                              <tbody>
                                 	<tr>
		                                <td>Adriana Hernández</td>
		                                <td><input type="checkbox" checked class="js-switch" data-color="#009efb" /></td>
																		<td><input type="checkbox" checked class="js-switch" data-color="#009efb" /></td>
																		<td>Adriana Hernández</td>
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
		-----------------------------------------------------------------------
		<script>
    jQuery(document).ready(function() {
        // Switchery
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        $('.js-switch').each(function() {
            new Switchery($(this)[0], $(this).data());
        });
        // For select 2
        $(".select2").select2();
        $('.selectpicker').selectpicker();
        //Bootstrap-TouchSpin
        $(".vertical-spin").TouchSpin({
            verticalbuttons: true,
            verticalupclass: 'ti-plus',
            verticaldownclass: 'ti-minus'
        });
        var vspinTrue = $(".vertical-spin").TouchSpin({
            verticalbuttons: true
        });
        if (vspinTrue) {
            $('.vertical-spin').prev('.bootstrap-touchspin-prefix').remove();
        }
        $("input[name='tch1']").TouchSpin({
            min: 0,
            max: 100,
            step: 0.1,
            decimals: 2,
            boostat: 5,
            maxboostedstep: 10,
            postfix: '%'
        });
        $("input[name='tch2']").TouchSpin({
            min: -1000000000,
            max: 1000000000,
            stepinterval: 50,
            maxboostedstep: 10000000,
            prefix: '$'
        });
        $("input[name='tch3']").TouchSpin();
        $("input[name='tch3_22']").TouchSpin({
            initval: 40
        });
        $("input[name='tch5']").TouchSpin({
            prefix: "pre",
            postfix: "post"
        });
        // For multiselect
        $('#pre-selected-options').multiSelect();
        $('#optgroup').multiSelect({
            selectableOptgroup: true
        });
        $('#public-methods').multiSelect();
        $('#select-all').click(function() {
            $('#public-methods').multiSelect('select_all');
            return false;
        });
        $('#deselect-all').click(function() {
            $('#public-methods').multiSelect('deselect_all');
            return false;
        });
        $('#refresh').on('click', function() {
            $('#public-methods').multiSelect('refresh');
            return false;
        });
        $('#add-option').on('click', function() {
            $('#public-methods').multiSelect('addOption', {
                value: 42,
                text: 'test 42',
                index: 0
            });
            return false;
        });
        $(".ajax").select2({
            ajax: {
                url: "https://api.github.com/search/repositories",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term, // search term
                        page: params.page
                    };
                },
                processResults: function(data, params) {
                    // parse the results into the format expected by Select2
                    // since we are using custom formatting functions we do not need to
                    // alter the remote JSON data, except to indicate that infinite
                    // scrolling can be used
                    params.page = params.page || 1;
                    return {
                        results: data.items,
                        pagination: {
                            more: (params.page * 30) < data.total_count
                        }
                    };
                },
                cache: true
            },
            escapeMarkup: function(markup) {
                return markup;
            }, // let our custom formatter work
            minimumInputLength: 1,
            templateResult: formatRepo, // omitted for brevity, see the source of this page
            templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
        });
    });
    </script>
	</div>
@endsection
@endsection
@endsection
