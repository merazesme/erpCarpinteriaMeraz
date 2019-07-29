@extends('footer')
@extends('sidebar')
@extends('header')

@section('header')
@parent
<div class="preloader">
    <div class="loader">
        <div class="loader__figure"></div>
        <p class="loader__label">Carpintería Meraz</p>
    </div>
</div>
<div id="main-wrapper">
    @section('sidebar')
    @parent
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h4 class="card-title">{{$modulo}}</h4>
                        </div>
                        <div class="col d-inline-flex">
                            <button type="button" class="btn btn-primary waves-effect waves-light ml-auto"
                                    onclick="abrir_modal_agregar_ticket()" style="display: inline-block">
                                <i class="fa fa-plus"></i>
                                Agregar ticket
                            </button>
                            <button type="button" class="btn btn-outline-primary waves-effect waves-light ml-auto"
                                    onclick="abrir_modal_pagar_factura()" style="display: inline-block">
                                <i class="fa fa-plus"></i>
                                Pagar ticket(s)
                            </button>
                        </div>
                    </div>
                    
                    {{-- Pestañas para seleccionar vista --}}
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item"> 
                            <a class="nav-link active" id="factura_tab" data-toggle="tab" href="#tab_factura" role="tab" aria-controls="tab_factura" aria-expanded="true">
                                <span class="hidden-xs-down"><i class="fa fa-book"></i></span> 
                                <span class="hidden-xs-down">Facturas</span>
                            </a> 
                        </li>

                        <li class="nav-item"> 
                            <a class="nav-link" id="cheque_tab" data-toggle="tab" href="#tab_cheque" role="tab" aria-controls="tab_cheque" aria-expanded="true">
                                <span class="hidden-xs-down"><i class="fa fa-automobile"></i></span> 
                                <span class="hidden-xs-down">Cheques</span>
                            </a> 
                        </li>
                    </ul>

                    {{-- Pestañas de cada opción (sub-vistas) --}}
                    <div class="tab-content tabcontent-border">

                        <div class="tab-pane fade show active" id="tab_factura" role="tabpanel">
                            <div class="table-responsive">
                                <table style="display: table" id="table_gasolina"
                                    class="display table table-hover table-striped table-bordered">
                                    <thead>
                                        <tr role="row">
                                            <th tabindex="0" rowspan="1" colspan="1">
                                                Fecha
                                            </th>
                                            <th tabindex="0" rowspan="1" colspan="1">
                                                # ticket
                                            </th>
                                            <th tabindex="0" rowspan="1" colspan="1">
                                                Litros
                                            </th>
                                            <th tabindex="0" rowspan="1" colspan="1">
                                                Total
                                            </th>
                                            <th tabindex="0" rowspan="1" colspan="1">
                                                Auto
                                            </th>
                                            <th tabindex="0" rowspan="1" colspan="1" data-orderable="false">
                                                # folio
                                            </th>
                                            <th tabindex="0" rowspan="1" colspan="1">
                                                Estado
                                            </th>
                                            <th tabindex="0" rowspan="1" colspan="1" width="5%" data-orderable="false">

                                            </th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th rowspan="1" colspan="1">Fecha</th>
                                            <th rowspan="1" colspan="1">Ticket</th>
                                            <th rowspan="1" colspan="1">Litros</th>
                                            <th rowspan="1" colspan="1">Total</th>
                                            <th rowspan="1" colspan="1">Auto</th>
                                            <th rowspan="1" colspan="1"># folio</th>
                                            <th rowspan="1" colspan="1">Estado</th>
                                            <th rowspan="1" colspan="1"></th>
                                        </tr>
                                    </tfoot>
                                    <tbody style="cursor: pointer;">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <div class="tab-pane fade" id="tab_cheque" role="tabpanel">
                            <div class="table-responsive">
                                <table style="display: table" id="table_cheques"
                                    class="display table table-hover table-striped table-bordered w-100">
                                    <thead>
                                        <tr role="row">
                                            <th tabindex="0" rowspan="1" colspan="1">
                                                Fecha
                                            </th>
                                            <th tabindex="0" rowspan="1" colspan="1">
                                                Folio
                                            </th>
                                            <th tabindex="0" rowspan="1" colspan="1" data-orderable="false">
                                                Lista de número de ticket pagados
                                            </th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th rowspan="1" colspan="1">Fecha</th>
                                            <th rowspan="1" colspan="1">Folio</th>
                                            <th rowspan="1" colspan="1">Lista de número de ticket pagados</th>
                                        </tr>
                                    </tfoot>
                                    <tbody style="cursor: pointer;">
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            <div class="modal fade" id="modal_agregar_ticket" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Agregar ticket</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"> <span aria-hidden="true">&times;</span> </button>
                        </div>
                        <div class="modal-body">
                            <form action="#" id="gasolina_form">
                                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                <div class="row p-t-10">
                                    <div class="col-2"></div>
                                    <div class="col-4" align="center">
                                        <label class="control-label">Fecha de factura</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            <input type="text" class="form-control" id="mdate" name="mdate" placeholder="DD/MM/AAAA">
                                        </div>
                                    </div>
                                    
                                    <div class="col-4" align="center">
                                        <label class="control-label"># ticket</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-hashtag"></i></span>
                                            <input type="number" id="gasolina_ticket" name="gasolina_ticket" class="form-control" placeholder="000">
                                        </div>
                                    </div>
                                    <div class="col-2"></div>
                                </div>

                                <div class="row p-t-10">
                                    <div class="col-4" align="center">
                                        <label class="control-label">Carro</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-automobile"></i></span>
                                            <select class="select2 form-control custom-select" style="width: 100%;" id="gasolina_auto" name="gasolina_auto">
                                                <option>Select</option>
                                                <optgroup label="Autos">
                                                </optgroup>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4" align="center">
                                        <label class="control-label">Litros</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">L</span>
                                            <input type="number" id="gasolina_litros" name="gasolina_litros" class="form-control" placeholder="000">
                                        </div>
                                    </div>
                                    <div class="col-4" align="center">
                                        <label class="control-label">Total</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-usd"></i></span>
                                            <input type="text" id="gasolina_total" name="gasolina_total" class="form-control" placeholder="0000.00">
                                        </div>
                                    </div>
                                </div>

                                <div class="row m-b-10" style="max-height: 200px;">
                                    <div class="col">
                                        <label for="gasolina_archivo">Archivo de la factura (PNG|JPG)</label>
                                        <input type="file" id="gasolina_archivo" name="gasolina_archivo" class="dropify" data-max-file-size="4M">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="button" onclick="guardar_factura_gasolina()" class="btn btn-success" data-dismiss="modal">Guardar</button>
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
                                            <label class="control-label">Número de folio</label>
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
<script>
    const url_images = "{{asset('images')}}";
</script>
<script src="{{asset('js/mask.js')}}"></script>
<link rel="stylesheet" href="{{asset('plugins/dropify/dist/css/dropify.min.css')}}">
<script src="{{asset('plugins/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('plugins/dropify/dist/js/dropify.min.js')}}"></script>

<script src="{{asset('plugins/sweetalert/sweetalert_2/sweetalert2.all.min.js')}}"></script>
<script src="{{asset('plugins/sweetalert/sweetalert_2/sweetalert2.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('plugins/sweetalert/sweetalert_2/sweetalert2.min.css')}}">

<script src="{{asset('modulos/gasolina.js')}}"></script>
</div>
@endsection
@endsection
@endsection
