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
                            <h4 class="card-title">Facturas de gasolina</h4>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <button type="button" class="btn waves-effect waves-light btn-block btn-primary"
                                    onclick="abrir_modal_agregar_factura()">
                                <i class="fa fa-plus"></i>
                                Agregar factura
                            </button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-8">
                            <div class="table-responsive">
                                <table id="table_proveedores"
                                    class="display nowrap table table-hover table-striped table-bordered dataTable"
                                    cellspacing="0" width="100%" role="grid" aria-describedby="table_proveedores_info">
                                    <thead>
                                        <tr role="row">
                                            <th class="sorting_asc" tabindex="0" rowspan="1" colspan="1" 
                                            style="width: 151px;">
                                                Fecha
                                            </th>
                                            <th class="sorting" tabindex="0" rowspan="1" colspan="1"
                                                style="width: 226px;">
                                                Litros
                                            </th>
                                            <th class="sorting" tabindex="0" rowspan="1" colspan="1"
                                                style="width: 52px;">
                                                # cheque
                                            </th>
                                            <th class="sorting" tabindex="0" rowspan="1" colspan="1"
                                                style="width: 101px;">
                                                Total
                                            </th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th rowspan="1" colspan="1">Fecha</th>
                                            <th rowspan="1" colspan="1">Litros</th>
                                            <th rowspan="1" colspan="1"># cheque</th>
                                            <th rowspan="1" colspan="1">Total</th>
                                        </tr>
                                    </tfoot>
                                    <tbody style="cursor: pointer;">
                                        <tr role="row" class="odd" data-toggle="tooltip" data-placement="top" 
                                            title="Clic para editar 1" onclick="ver_factura(1)">
                                            <td>DD/MM/AAAA</td>
                                            <td>000 lts</td>
                                            <td>#####</td>
                                            <td>$0000.00</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 hide" id="gasolina_vista_previa">
                            <i class="mdi mdi-close-box float-right" style="cursor: pointer" onclick="cerrar_vista_previa()"></i>
                            <h5 align="center"><strong> Vista previa</strong></h5>
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTXZGTJ2qiKr-gp14DRCyyxO-FzPa7wtndG5qqH5MFPykGBzdVIJQ" 
                                 alt="imagen" class="img-responsive img-fluid img-thumbnail">
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modal_agregar_factura" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Agregar factura</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"> <span aria-hidden="true">&times;</span> </button>
                        </div>
                        <div class="modal-body">
                            <form>                            
                                <div class="row p-t-10">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Fecha de factura</label>
                                            <input type="text" class="form-control" id="mdate">
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Litros</label>
                                            <input type="number" id="lastName" class="form-control" placeholder="000">
                                        </div>
                                    </div>
                                    <!--/span-->
                                </div>

                                <div class="row p-t-10">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Número de cheque</label>
                                            <input type="number" id="firstName" class="form-control" placeholder="00000">
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Total</label>
                                            <input type="text" data-mask="$ 999,999.99" id="lastName" class="form-control" placeholder="$0000.00 MXN">
                                        </div>
                                    </div>
                                    <!--/span-->
                                </div>
                                
                                <div class="row" style="max-height: 200px;">
                                    <div class="col-lg-6 col-md-6">
                                        <label for="">Imagen de la factura</label>
                                        <input type="file" id="input-file-max-fs" class="dropify" data-max-file-size="2M" />
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="button" onclick="agregar_factura()" class="btn btn-success" data-dismiss="modal">Guardar</button>
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
<script src="{{asset('js/mask.js')}}"></script>
<link rel="stylesheet" href="{{asset('plugins/dropify/dist/css/dropify.min.css')}}">
<script src="{{asset('plugins/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('plugins/dropify/dist/js/dropify.min.js')}}"></script>
<script>
    /** Script for initialize DataTable and ToolTips */
    $('#table_proveedores').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
    $("body").tooltip({ selector: '[data-toggle="tooltip"]' });
</script>
<script>
    /** Scripts */
    function agregar_proveedor() {
        location.href = "/proveedores/agregar";
    }
    function editar_proveedor(id) {
        location.href = "/proveedores/editar/"+id;
    }
    function ver_factura(id) {
        $('#gasolina_vista_previa').removeClass('hide').addClass('show');
    }
    function cerrar_vista_previa() {
        $('#gasolina_vista_previa').removeClass('show').addClass('hide');
    }
    function abrir_modal_agregar_factura() {
        $('#modal_agregar_factura').modal('show');
    }
    function agregar_factura() {
        swal("¡Éxito!", "Registro guardado con éxito", "success");
    }
    function abrir_modal_cambiar_proveedor_gasolina() {

    }

    jQuery('.mydatepicker, #mdate').datepicker();
    // Basic
    $('.dropify').dropify();


    

</script>
</div>
@endsection
@endsection
@endsection
@endsection