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
                        <div class="col">
                            <h4 class="card-title">{{$modulo}}</h4>
                        </div>
                        <div class="col d-inline-flex">
                            <button type="button" class="btn btn-primary waves-effect waves-light ml-auto"
                                    onclick="abrir_modal_agregar_factura()" style="display: inline-block">
                                <i class="fa fa-plus"></i>
                                Agregar factura sobrante
                            </button>
                            <button type="button" class="btn btn-outline-primary waves-effect waves-light ml-auto"
                                    onclick="abrir_modal_pagar_factura()" style="display: inline-block">
                                <i class="fa fa-plus"></i>
                                Pagar factura(s) sobrante
                            </button>
                        </div>
                    </div>

                    {{-- Pestañas para seleccionar vista --}}
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item"> 
                            <a class="nav-link active" id="factura_tab" data-toggle="tab" href="#tab_factura" role="tab" aria-controls="tab_factura" aria-expanded="true">
                                <span class="hidden-xs-down"><i class="fa fa-book"></i></span> 
                                <span class="hidden-xs-down">Facturas sobrantes</span>
                            </a> 
                        </li>

                        <li class="nav-item"> 
                            <a class="nav-link" id="cheque_tab" data-toggle="tab" href="#tab_cheque" role="tab" aria-controls="tab_cheque" aria-expanded="true">
                                <span class="hidden-xs-down"><i class="fa fa-money"></i></span> 
                                <span class="hidden-xs-down">Pagos</span>
                            </a> 
                        </li>
                    </ul>

                    {{-- Pestañas de cada opción (sub-vistas) --}}
                    <div class="tab-content tabcontent-border">

                        <div class="tab-pane fade show active" id="tab_factura" role="tabpanel">
                            <div class="table-responsive m-t-40">

                                <table id="table_facturas"
                                    class="display table table-hover table-striped table-bordered">
                                    <thead>
                                        <tr role="row" align="center">
                                            <th style="cursor:pointer;" tabindex="0" rowspan="1" colspan="1">
                                                Fecha
                                            </th>
                                            <th style="cursor:pointer;" tabindex="0" rowspan="1" colspan="1">
                                                Folio factura
                                            </th>
                                            <th data-orderable="false" tabindex="0" rowspan="1" colspan="1">
                                                Concepto
                                            </th>
                                            <th data-orderable="false" tabindex="0" rowspan="1" colspan="1">
                                                Total
                                            </th>
                                            <th data-orderable="false" tabindex="0" rowspan="1" colspan="1">
                                                Folio pago
                                            </th>
                                            <th data-orderable="false" tabindex="0" rowspan="1" colspan="1">
                                                Estado
                                            </th>
                                            <th data-orderable="false"></th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr align="center">
                                            <th rowspan="1" colspan="1">Fecha</th>
                                            <th rowspan="1" colspan="1">Folio factura</th>
                                            <th rowspan="1" colspan="1">Concepto</th>
                                            <th rowspan="1" colspan="1">Total</th>
                                            <th rowspan="1" colspan="1">Folio pago</th>
                                            <th rowspan="1" colspan="1">Estado</th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    </tbody>
                                </table>
        
                            </div>
                        </div>
                        
                        <div class="tab-pane fade" id="tab_cheque" role="tabpanel">
                            <div class="table-responsive">
                                <table style="display: table" id="table_pagos"
                                    class="display table table-hover table-striped table-bordered w-100">
                                    <thead>
                                        <tr role="row">
                                            <th tabindex="0" rowspan="1" colspan="1">
                                                Fecha
                                            </th>
                                            <th tabindex="0" rowspan="1" colspan="1">
                                                Folio
                                            </th>
                                            <th tabindex="0" rowspan="1" colspan="1">
                                                Método de pago
                                            </th>
                                            <th tabindex="0" rowspan="1" colspan="1">
                                                Total
                                            </th>
                                            <th tabindex="0" rowspan="1" colspan="1" data-orderable="false">
                                                Lista de facturas pagadas
                                            </th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th rowspan="1" colspan="1">Fecha</th>
                                            <th rowspan="1" colspan="1">Folio</th>
                                            <th rowspan="1" colspan="1">Método de pago</th>
                                            <th rowspan="1" colspan="1">Total</th>
                                            <th rowspan="1" colspan="1">Lista de facturas pagadas</th>
                                            <th></th>
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

            <div class="modal fade" id="modal_factura_sobrante" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Agregar factura sobrante</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"> <span aria-hidden="true">&times;</span> </button>
                        </div>
                        <div class="modal-body">
                            <form action="#" id="factura_form">
                                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                <div class="row p-t-10">
                                    <div class="col-6" align="center">
                                        <label class="control-label">Fecha de factura</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            <input type="text" class="form-control" id="mdate" name="mdate" placeholder="DD/MM/AAAA">
                                        </div>
                                    </div>
                                    
                                    <div class="col-6" align="center">
                                        <label class="control-label">Folio factura</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-hashtag"></i></span>
                                            <input type="number" id="factura_folio" name="factura_folio" class="form-control" placeholder="000">
                                            {{-- <input type="text" class="form-control" id="mdate" name="mdate" placeholder="DD/MM/AAAA"> --}}
                                        </div>
                                    </div>
                                </div>

                                <div class="row p-t-10">
                                    <div class="col-6" align="center">
                                        <label class="control-label">Tipo de concepto</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa fa-handshake-o"></i></span>
                                            <input type="text" id="factura_concepto" name="factura_concepto" class="form-control" placeholder="Material x">
                                        </div>
                                    </div>

                                    <div class="col-6" align="center">
                                        <label class="control-label">Total (con iva)</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-money"></i></span>
                                            <input type="number" id="factura_total" name="factura_total" class="form-control" placeholder="Sin valor">
                                        </div>
                                    </div>
                                </div>

                                <div class="row m-b-10" style="max-height: 200px;">
                                    <div class="col">
                                        <label for="factura_archivo">Archivo de la factura (PNG|JPG)</label>
                                        <input type="file" id="factura_archivo" name="factura_archivo" class="dropify" data-max-file-size="4M">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="button" onclick="guardar_factura_sobrante()" class="btn btn-success" data-dismiss="modal">Guardar</button>
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
                            <h4 class="modal-title">Pagar factura(s)</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"> <span aria-hidden="true">&times;</span> </button>
                        </div>
                        <div class="modal-body">
                            <form action="#" id="pagar_factura_form">
                                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                <div class="row p-t-10">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="control-label">Número de folio</label>
                                            <input type="text" class="form-control" placeholder="#####" id="factura_pago_folio" name="factura_pago_folio">
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="control-label">Método de pago</label>
                                            <select class="form-control" style="width: 100%;" data-placeholder="Elegir"
                                                    id="factura_pago_metodo" name="factura_pago_metodo">
                                                <option value="1">Cheque</option>
                                                <option value="2">Transferencia</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row p-t-10">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label" id="select_facturas_label">Seleccione la(s) factura(s) a pagar</label>
                                            <select class="select2 m-b-10 select2-multiple" style="width: 100%;" multiple="multiple" data-placeholder="Elegir"
                                                    id="factura_pago_facturas" name="factura_pago_facturas">
                                                <optgroup label="Pendientes por pagar">
                                                </optgroup>
                                            </select>
                                        </div>
                                    </div>
                                    <!--/span-->
                                </div>

                                <div class="row m-b-10" style="max-height: 200px;">
                                    <div class="col">
                                        <label for="factura_archivo">Archivo del pago de la factura (PNG|JPG)</label>
                                        <input type="file" id="factura_pago_archivo" name="factura_pago_archivo" class="dropify" data-max-file-size="4M">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="button" onclick="guardar_pagar_factura()" class="btn btn-success" data-dismiss="modal">Guardar</button>
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

<link rel="stylesheet" href="{{asset('plugins/dropify/dist/css/dropify.min.css')}}">
<script src="{{asset('plugins/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('plugins/dropify/dist/js/dropify.min.js')}}"></script>

<script src="{{asset('plugins/sweetalert/sweetalert_2/sweetalert2.all.min.js')}}"></script>
<script src="{{asset('plugins/sweetalert/sweetalert_2/sweetalert2.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('plugins/sweetalert/sweetalert_2/sweetalert2.min.css')}}">

<script src="{{asset('modulos/facturas_sobrantes.js')}}"></script>

</div>
@endsection
@endsection
@endsection
