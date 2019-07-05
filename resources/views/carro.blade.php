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
											<button id="genera" type="button" class="btn waves-effect waves-light btn-primary float-right" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-plus"></i> Agregar</button>
                      <h4 class="card-title">Listado de carros</h4>
                      <div class="table-responsive m-t-40">
                          <table id="clientes" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                              <thead>
                                  <tr>
                                    <th>Placas</th>
                                    <th>Marca</th>
																		<th>Modelo</th>
																		<th>Fecha de compra</th>
                                    <th>Asignado a</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                  </tr>
                              </thead>
															<tfoot>
																<tr>
                                  <th>Placas</th>
                                  <th>Marca</th>
                                  <th>Modelo</th>
                                  <th>Fecha de compra</th>
                                  <th>Asignado a</th>
                                  <th>Acciones</th>
                                  <th>Estado</th>
																</tr>
															</tfoot>
                              <tbody>
                                  <tr>
                                      <td>MZT-MERA2</td>
                                      <td>Nissan</td>
                                      <td>Camioneta</td>
                                      <td>Ayer</td>
                                      <td>Toluco Santana</td>
                                      <td><span class="label label-danger"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Inactivo</font></font></span></td>
                                      <td class="text-nowrap">
                                        <a href="#"  data-original-title="Editar" data-toggle="modal" data-target=".bs-example-modal-lg"> <i class="icon-pencil text-inverse m-r-10"></i> </a>
                                        <a href="#" data-toggle="tooltip" data-original-title="Borrar"> <i class="icon-close text-danger m-r-10"></i> </a>
                                        <a href="#" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye "></i> </a>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td>MZT-MERA2</td>
                                      <td>Nissan</td>
                                      <td>Camioneta</td>
                                      <td>Ayer</td>
                                      <td>Toluco Santana</td>
                                      <td><span class="label label-success"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Activo</font></font></span></td>
                                      <td class="text-nowrap">
                                        <a href="#"  data-original-title="Editar" data-toggle="modal" data-target=".bs-example-modal-lg"> <i class="icon-pencil text-inverse m-r-10"></i> </a>
                                        <a href="#" data-toggle="tooltip" data-original-title="Borrar"> <i class="icon-close text-danger m-r-10"></i> </a>
                                        <a href="#" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye "></i> </a>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td>MZT-MERA2</td>
                                      <td>Nissan</td>
                                      <td>Camioneta</td>
                                      <td>Ayer</td>
                                      <td>Toluco Santana</td>
                                      <td><span class="label label-success"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Activo</font></font></span></td>
                                      <td class="text-nowrap">
                                        <a href="#"  data-original-title="Editar" data-toggle="modal" data-target=".bs-example-modal-lg"> <i class="icon-pencil text-inverse m-r-10"></i> </a>
                                        <a href="#" data-toggle="tooltip" data-original-title="Borrar"> <i class="icon-close text-danger m-r-10"></i> </a>
                                        <a href="#" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye "></i> </a>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td>MZT-MERA2</td>
                                      <td>Nissan</td>
                                      <td>Camioneta</td>
                                      <td>Ayer</td>
                                      <td>Toluco Santana</td>
                                      <td><span class="label label-success"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Activo</font></font></span></td>
                                      <td class="text-nowrap">
                                        <a href="#"  data-original-title="Editar" data-toggle="modal" data-target=".bs-example-modal-lg"> <i class="icon-pencil text-inverse m-r-10"></i> </a>
                                        <a href="#" data-toggle="tooltip" data-original-title="Borrar"> <i class="icon-close text-danger m-r-10"></i> </a>
                                        <a href="#" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye "></i> </a>
                                      </td>
                                  </tr>

                              </tbody>
                          </table>
                      </div>
                      <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                          <div class="modal-dialog modal-lg">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <h4 class="modal-title" id="myLargeModalLabel">Formulario de carros</h4>
                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                  </div>
                                  <div class="modal-body">
                                    <div class="container">
                                    <div class="row">
                                        <div class="col-md-6 ">
                                            <div class="form-group">
                                                <label>Placas</label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-6 ">
                                            <div class="form-group">
                                                <label>Marca</label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Modelo</label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Fecha adquisición</label>
                                                <input type="date" class="form-control">
                                            </div>
                                        </div>
                                        <!--/span-->
                                    </div>
                                    <!--/row-->
                                    <div class="row">
                                        <div class="col-md-6">
                                          <div class="form-group">
                                              <label>Asignado a</label>
                                              <select class="form-control custom-select">
                                                  <option>Selecciona un empleado</option>
                                                  <option>Toluco Santana</option>
                                                  <option>Pepe el Toro</option>
                                                  <option>Vicente Fernández</option>
                                              </select>
                                          </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">

                                            <div class="switchery-demo m-b-30 form-group">
                                              <label>Estado</label>
                                              <br>
                                                <input type="checkbox" checked class="js-switch" data-color="#009efb" />
                                            </div>

                                        </div>
                                        <!--/span-->
                                    </div>
                                  </div>
                                  </div>
                                  <div class="modal-footer">
                                      <button type="button" class="btn btn-default waves-effect text-left" data-dismiss="modal">Cancelar</button>
                                      <button type="button" class="btn btn-primary waves-effect text-left" data-dismiss="modal"> <i class="fa fa-check"></i> Guardar</button>
                                  </div>
                              </div>
                              <!-- /.modal-content -->
                          </div>
                          <!-- /.modal-dialog -->
                      </div>
                      <!-- /.modal -->
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
