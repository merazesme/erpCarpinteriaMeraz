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
				<div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <h4 class="card-title">Pagos del mes</h4>
                                <h6 class="card-subtitle">Export data to Excel, PDF &amp; Print</h6>
                            </div>
                            <div class="col-lg-3">
                                <button type="button" class="btn waves-effect waves-light btn-block btn-secondary" href="" id="btnRenovarHoja"><i class="fa fa-file-text-o"></i> Generar nuevo</button>
                            </div>
                            <div class="col-lg-3">
                                <button type="button" id="btnAgregarConcepto" class="btn waves-effect waves-light btn-block btn-primary" href="#modalConceptoPagodelMes" data-toggle="modal" data-whatever="Agregar"><i class="fa fa-plus"></i> Agregar concepto</button>
                            </div>
                        </div>
                        <div class="table-responsive m-t-40">

                            <table id="example23" class="display nowrap table table-hover table-striped table-bordered dataTable" cellspacing="0" width="100%" role="grid" aria-describedby="example23_info" style="width: 100%;">
                                <thead>
                                    <tr role="row"><th class="sorting_asc" tabindex="0" aria-controls="example23" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 151px;">Fecha</th><th class="sorting" tabindex="0" aria-controls="example23" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 226px;">Concepto</th><th class="sorting" tabindex="0" aria-controls="example23" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" style="width: 111px;">Cantidad</th><th class="sorting" tabindex="0" aria-controls="example23" rowspan="1" colspan="1" aria-label="Age: activate to sort column ascending" style="width: 52px;">Estatus</th><th class="sorting" tabindex="0" aria-controls="example23" rowspan="1" colspan="1" aria-label="Start date: activate to sort column ascending" style="width: 101px;">Acciones</th></tr>
                                </thead>
                                <tfoot>
                                    <tr><th rowspan="1" colspan="1">Fecha</th><th rowspan="1" colspan="1">Concepto</th><th rowspan="1" colspan="1">Cantidad</th><th rowspan="1" colspan="1">Estatus</th><th rowspan="1" colspan="1">Acciones</th></tr>
                                </tfoot>
                                <tbody id="contenedorConceptosPago">
                                <tr role="row" class="odd">
                                        <td>2008/11/28</td>
                                        <td class="sorting_1">Airi Satou</td>
                                        <td>$1500.00</td>
                                        <td><span class="badge badge-success">Pagado</span></td>
                                        <td class="text-nowrap">
                                            <a href="#modalConceptoPagodelMes" data-toggle="modal" data-whatever="Editar">
                                                <i class="icon-pencil text-primary m-r-10"></i>
                                            </a>
                                            <a href="#modalAdjuntarPagodelMes" data-toggle="modal">
                                            	<i class="icon-check text-success m-r-10"></i>
                                            </a>
                                            <a href="#" data-toggle="modal" id="sa-warning">
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
                        <div class="modal fade" id="modalAdjuntarPagodelMes" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Adjuntar comprobante de pago</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"> <span aria-hidden="true">&times;</span> </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="pagoConcepto">
                                            <fieldset>
                                                <div  class="form-group">
                                                    <label for="pagoconcepto_archivo">Seleccione el archivo</label>
                                                     <input type="file" id="pagoconcepto_archivo" name="pagoconcepto_archivo" class="dropify" data-max-file-size="4M">
                                                     <label id="txtArchivo-error" class="text-danger" for="pagoconcepto_archivo" style="display: none;">Seleccione un archivo.</label>
                                                     <input type="hidden" class="idRegistro">
                                                </div>
			                                </fieldset>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                        <button type="button" id="btnSubirPagoConcepto" class="btn btn-success">Guardar</button>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->
                        <!-- .modal for add task -->
                        <div class="modal fade" id="modalConceptoPagodelMes" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title"></h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"> <span aria-hidden="true">&times;</span> </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="formConceptosPago">
                                            <div class="form-group">
                                                <label>Fecha de vencimento</label>
                                                <input class="form-control" type="date" placeholder="Selecione una fecha" id="fechaVencimiento" name="fechaVencimiento">
                                            </div>
                                            <div class="form-group">
                                                <label>Nombre del concepto</label>
                                                <input class="form-control" type="text" placeholder="Ingrese un nombre de concepto" id="nombreConcepto" name="nombreConcepto">
                                            </div>
                                            <div class="form-group">
                                                <label>Cantidad</label>
                                                <input class="form-control" type="number" placeholder="Ingrese la cantidad" id="cantidadPago" name="cantidadPago">
                                            </div>
                                            <div class="form-group">
                                                <label>Observación</label>
                                                <textarea class="form-control" type="text" placeholder="Ingrese alguna observación" id="observacionPago" name="observacionPago"></textarea>
                                            </div>
                                            <input class="form-control" type="hidden" id="idConceptoModal" name="idConceptoModal">

                                            <!-- AQUI VA EL ID DEL USUARIO -->
                                            <input class="form-control" type="hidden" id="idUsuario" name="idUsuario" value="1">
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                        <button type="button" class="btn btn-success" id="btnGuardarConceptoPago">Guardar</button>
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
            'excel', 'pdf', 'print'
        ]
    });
    const url_images = "{{asset('images')}}";
    </script>
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="{{asset('plugins/styleswitcher/jQuery.style.switcher.js')}}"></script>
    <link rel="stylesheet" href="{{asset('plugins/dropify/dist/css/dropify.min.css')}}">
    <script src="{{asset('plugins/dropify/dist/js/dropify.min.js')}}"></script>
    <script src="{{asset('plugins/sweetalert/sweetalert_2/sweetalert2.all.min.js')}}"></script>
    <link rel="stylesheet" href="{{asset('plugins/sweetalert/sweetalert_2/sweetalert2.min.css')}}">
    
	</div>
@endsection
@endsection
@endsection
