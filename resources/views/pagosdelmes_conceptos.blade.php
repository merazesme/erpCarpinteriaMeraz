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
				<div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-9">
                                <h4 class="card-title">Conceptos</h4>
                                <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF &amp; Print</h6>
                            </div>
                            <div class="col-lg-3">
                                <button type="button" class="btn waves-effect waves-light btn-block btn-primary" href="#modalConceptoPagodelMes" data-toggle="modal"><i class="fa fa-plus"></i>Agregar concepto</button>
                            </div>
                        </div>
                        
                        <div class="table-responsive m-t-40">
                            <table id="example23" class="display nowrap table table-hover table-striped table-bordered dataTable" cellspacing="0" width="100%" role="grid" aria-describedby="example23_info" style="width: 100%;">
                                <thead>
                                    <tr role="row"><th class="sorting_asc" tabindex="0" aria-controls="example23" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 151px;">Fecha</th><th class="sorting" tabindex="0" aria-controls="example23" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 226px;">Concepto</th><th class="sorting" tabindex="0" aria-controls="example23" rowspan="1" colspan="1" aria-label="Age: activate to sort column ascending" style="width: 52px;">Estatus</th><th class="sorting" tabindex="0" aria-controls="example23" rowspan="1" colspan="1" aria-label="Start date: activate to sort column ascending" style="width: 101px;">Acciones</th></tr>
                                </thead>
                                <tfoot>
                                    <tr><th rowspan="1" colspan="1">Fecha</th><th rowspan="1" colspan="1">Concepto</th><th rowspan="1" colspan="1">Estatus</th><th rowspan="1" colspan="1">Acciones</th></tr>
                                </tfoot>
                                <tbody>
                                <tr role="row" class="odd">
                                        <td>2008/11/28</td>
                                        <td class="sorting_1">Airi Satou</td>
                                        <td>$1500.00</td>
                                        <td class="text-nowrap">
                                            <a href="#modalConceptoPagodelMes" data-toggle="modal"> 
                                            	<i class="icon-pencil text-primary m-r-10"></i> 
                                            </a>
                                            <a href="#" data-toggle="modal" data-target="#eliminar" id="sa-warning"> 
                                            	<i class="icon-close text-danger"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="to-do-widget m-t-20">
                        <!-- .modal for add task -->
                        <div class="modal fade" id="modalConceptoPagodelMes" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Agregar concepto</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"> <span aria-hidden="true">&times;</span> </button>
                                    </div>
                                    <div class="modal-body">
                                        <form>
                                            <div class="form-group">
                                                <label>Fecha de vencimento</label>
                                                <input class="form-control" type="date" placeholder="Selecione una fecha" id="example-date-input">
                                            </div>
                                            <div class="form-group">
                                                <label>Nombre del concepto</label>
                                                <input class="form-control" type="text" placeholder="Ingrese un nombre de concepto" id="example-text-input">
                                            </div>
                                            <div class="form-group">
                                                <label>Cantidad</label>
                                                <input class="form-control" type="number" placeholder="Ingrese la cantidad" id="example-number-input">
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                        <button type="button" class="btn btn-success" data-dismiss="modal">Guardar</button>
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
	@section('footer')
	@parent
	<!-- This is data table -->
    <script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <!-- start - This is for export functionality only -->
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    <!-- end - This is for export functionality only -->
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
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="{{asset('plugins/styleswitcher/jQuery.style.switcher.js')}}"></script>
	</div>
@endsection
@endsection
@endsection
@endsection