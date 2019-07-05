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
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <h4 class="card-title">Facturas de gasolina</h4>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 d-inline-flex">
                            <div class="col-lg-6 col-md-6 col-sm-6 ml-auto">
                                <button type="button" class="btn waves-effect waves-light btn-block btn-primary"
                                        onclick="abrir_modal_agregar_factura()">
                                    <i class="fa fa-plus"></i>
                                    Agregar ticket
                                </button>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6 ml-auto">
                                <button type="button" class="btn waves-effect waves-light btn-block btn-outline-primary"
                                        onclick="abrir_modal_pagar_factura()">
                                    <i class="fa fa-plus"></i>
                                    Pagar ticket(s)
                                </button>
                            </div>

                        </div>
                    </div>

                    <div class="row m-t-15">
                        <div class="col-lg-12 col-md-12 col-sm-12" id="gasolina_contenedor_tabla">
                            <div class="table-responsive">
                                <table id="table_proveedores"
                                    class="display nowrap table table-hover table-striped table-bordered dataTable"
                                    cellspacing="0" width="100%" role="grid" aria-describedby="table_proveedores_info">
                                    <thead>
                                        <tr role="row">
                                            <th class="sorting_asc" tabindex="0" rowspan="1" colspan="1">
                                                Fecha
                                            </th>
                                            <th class="sorting" tabindex="0" rowspan="1" colspan="1">
                                                Litros
                                            </th>
                                            <th class="sorting" tabindex="0" rowspan="1" colspan="1">
                                                # cheque
                                            </th>
                                            <th class="sorting" tabindex="0" rowspan="1" colspan="1">
                                                Estado
                                            </th>
                                            <th class="sorting" tabindex="0" rowspan="1" colspan="1">
                                                Total
                                            </th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th rowspan="1" colspan="1">Fecha</th>
                                            <th rowspan="1" colspan="1">Litros</th>
                                            <th rowspan="1" colspan="1"># cheque</th>
                                            <th rowspan="1" colspan="1">Estado</th>
                                            <th rowspan="1" colspan="1">Total</th>
                                        </tr>
                                    </tfoot>
                                    <tbody style="cursor: pointer;">
                                        <tr role="row" class="odd" data-toggle="tooltip" data-placement="top"
                                            title="Clic para editar 1" onclick="ver_factura(1)">
                                            <td>DD/MM/AAAA</td>
                                            <td>000 lts</td>
                                            <td>#####</td>
                                            <td><span class="w-100 badge badge-pill badge-success">Pagado</span></td>
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
                            <h4 class="modal-title">Agregar ticket</h4>
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
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label">Total</label>
                                            <input type="text" data-mask="$ 999,999.99" id="lastName" class="form-control" placeholder="$0000.00 MXN">
                                        </div>
                                    </div>
                                    <!--/span-->
                                </div>

                                <div class="row" style="max-height: 200px;">
                                    <div class="col-lg-6 col-md-6 col-sm-6">
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

            <div class="modal fade" id="modal_pagar_factura" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Pagar ticket(s)</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"> <span aria-hidden="true">&times;</span> </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="row p-t-10">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label">Número de cheque</label>
                                            <input type="text" class="form-control" placeholder="#####">
                                        </div>
                                    </div>
                                </div>

                                <div class="row p-t-10">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label">Seleccione los ticket(s) a pagar</label>
                                            <select class="select2 m-b-10 select2-multiple" style="width: 100%;" multiple="multiple" data-placeholder="Elegir">
                                                <option>Select</option>
                                                <optgroup label="Pendientes por pagar">
                                                    <option value="AK">Primer pago</option>
                                                    <option value="HI">Segundo pago</option>
                                                </optgroup>
                                            </select>
                                        </div>
                                    </div>
                                    <!--/span-->
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="button" onclick="pagar_factura()" class="btn btn-success" data-dismiss="modal">Guardar</button>
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
    $(".select2").select2();
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
        $('#gasolina_contenedor_tabla')
            .removeClass('col-lg-12 col-md-12 col-sm-12')
            .addClass('col-lg-8 col-md-8 col-sm-8');
        $('#gasolina_vista_previa').removeClass('hide').addClass('show');
    }
    function cerrar_vista_previa() {
        $('#gasolina_contenedor_tabla')
            .removeClass('col-lg-8 col-md-8 col-sm-8')
            .addClass('col-lg-12 col-md-12 col-sm-12');
        $('#gasolina_vista_previa').removeClass('show').addClass('hide');
    }
    function abrir_modal_agregar_factura() {
        $('#modal_agregar_factura').modal('show');
    }
    function agregar_factura() {
        swal("¡Éxito!", "Registro guardado con éxito", "success");
    }
    function abrir_modal_pagar_factura() {
        $('#modal_pagar_factura').modal('show');
    }
    function pagar_factura() {
        swal("¡Éxito!", "Facturas pagadas con éxito", "success");
    }

    jQuery('.mydatepicker, #mdate').datepicker();
    // Basic
    $('.dropify').dropify();




</script>
</div>
@endsection
@endsection
@endsection
