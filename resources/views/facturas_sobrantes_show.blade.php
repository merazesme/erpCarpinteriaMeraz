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
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-6">
                            <h4 class="card-title">Lista de facturas sobrantes</h4>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6 d-inline-flex">
                            <button type="button" class="btn waves-effect waves-light btn-block btn-primary ml-auto"
                                    onclick="abrir_modal_agregar_factura_sobrante()">
                                <i class="fa fa-plus"></i>
                                Agregar factura
                            </button>
                        </div>
                    </div>

                    <div class="table-responsive m-t-40" style="height:auto;">

                        <table id="table_facturas_sobrantes"
                            class="display nowrap table table-hover table-striped table-bordered dataTable"
                            cellspacing="0" width="100%" role="grid" aria-describedby="table_facturas_sobrantes_info"
                            style="width: 100%;">
                            <thead>
                                <tr role="row">
                                    <th class="sorting" tabindex="0" rowspan="1" colspan="1">
                                        Folio
                                    </th>
                                    <th class="sorting_asc" tabindex="0" rowspan="1" colspan="1" >
                                        Concepto
                                    </th>
                                    <th class="sorting" tabindex="0" rowspan="1" colspan="1">
                                        Total
                                    </th>
                                    <th class="sorting" tabindex="0" rowspan="1" colspan="1">
                                        Estado
                                    </th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th rowspan="1" colspan="1">Folio</th>
                                    <th rowspan="1" colspan="1">Concepto</th>
                                    <th rowspan="1" colspan="1">Total</th>
                                    <th rowspan="1" colspan="1">Estado</th>
                                </tr>
                            </tfoot>
                            <tbody style="cursor: pointer;">
                                <tr role="row" class="odd" data-toggle="tooltip" data-placement="top" 
                                    title="Clic para editar 1" onclick="abrir_modal_actualizar_factura_sobrante(1)">
                                    <td>####</td>
                                    <td>Material x</td>
                                    <td>$0000.00 MXN</td>
                                    <td><span class="w-100 badge badge-pill badge-danger">Sin pagar</span></td>
                                </tr>
                                <tr role="row" class="odd" data-toggle="tooltip" data-placement="top" 
                                    title="Clic para editar 2" onclick="abrir_modal_actualizar_factura_sobrante(2)">
                                    <td>####</td>
                                    <td>Material x</td>
                                    <td>$0000.00 MXN</td>
                                    <td><span class="w-100 badge badge-pill badge-danger">Sin pagar</span></td>
                                </tr>
                                <tr role="row" class="odd" data-toggle="tooltip" data-placement="top" 
                                    title="Clic para editar 3" onclick="abrir_modal_actualizar_factura_sobrante(3)">
                                    <td>####</td>
                                    <td>Material x</td>
                                    <td>$0000.00 MXN</td>
                                    <td><span class="w-100 badge badge-pill badge-success">Pagado</span></td>
                                </tr>
                                <tr role="row" class="odd" data-toggle="tooltip" data-placement="top" 
                                    title="Clic para editar 4" onclick="abrir_modal_actualizar_factura_sobrante(4)">
                                    <td>####</td>
                                    <td>Material x</td>
                                    <td>$0000.00 MXN</td>
                                    <td><span class="w-100 badge badge-pill badge-danger">Sin pagar</span></td>
                                </tr>
                            </tbody>
                        </table>
                        
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modal_agregar_factura_sobrante" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title"></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"> <span aria-hidden="true">&times;</span> </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                                         
                                <div class="row p-t-10">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Número de folio</label>
                                            <input type="number" id="lastName" class="form-control" placeholder="000">
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Tipo de concepto</label>
                                            <input type="text" id="lastName" class="form-control" placeholder="Material x">
                                        </div>
                                    </div>
                                    <!--/span-->
                                </div>

                                <div class="row p-t-10">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Subtotal (sin IVA)</label>
                                            <input type="number" id="firstName" class="form-control" placeholder="$000.00">
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Total (con IVA del xx%)</label>
                                            <input type="numer" id="lastName" class="form-control" placeholder="Sin valor" value="$000.00 MXN" disabled>
                                        </div>
                                    </div>
                                    <!--/span-->
                                </div>
                                <div class="row p-t-10" id="opcion_chequear_factura">
                                    
                                    <!--/span-->
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="button" id="guardar_factura" class="btn btn-success" data-dismiss="modal">Guardar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>

        </div>
    </div>
</div>
@section('footer')
@parent
<script>
    /** Script for initialize DataTable and ToolTips */
    $('#table_facturas_sobrantes').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
    $("body").tooltip({ selector: '[data-toggle="tooltip"]' });
</script>
<script>
    /** Scripts */
    function abrir_modal_agregar_factura_sobrante() {
        $('#guardar_factura').attr('onclick', 'agregar_factura_sobrante()');
        $('.modal-title').text('Agregar factura');
        $('#modal_agregar_factura_sobrante').modal('show');
        $('#opcion_chequear_factura').empty();
    }
    function abrir_modal_actualizar_factura_sobrante(id) {
        $('#guardar_factura').attr('onclick', 'actualizar_factura_sobrante()');
        $('.modal-title').text('Actualizar factura');
        $('#modal_agregar_factura_sobrante').modal('show');
        $('#opcion_chequear_factura').html(`
            <div class="col-md-6">
                <div class="form-group">
                    <input type="checkbox" class="check" id="minimal-checkbox-1">
                    <label for="minimal-checkbox-1">Factura pagada</label>
                </div>
            </div>
        `);
    }

    function agregar_factura_sobrante() {
        swal("¡Éxito!", "Factura guardada con éxito", "success");
    }
    function actualizar_factura_sobrante() {
        swal("¡Éxito!", "Factura actualizada con éxito", "success");
    }
</script>
</div>
@endsection
@endsection
@endsection