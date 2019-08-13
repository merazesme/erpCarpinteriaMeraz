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
                        <div class="col-lg-9">
                            <h4 class="card-title">{{$modulo}}</h4>
                        </div>
                        <div class="d-inline-flex">
                            <button type="button" class="btn btn-primary waves-effect waves-light ml-auto"
                                    onclick="abrirModalAgregarCarro()">
                                <i class="fa fa-plus"></i>
                                Agregar vehículo
                            </button>
                        </div>
                    </div>

                    <div class="table-responsive m-t-40"    >

                        <table id="table_carros"
                            class="display table table-hover table-striped table-bordered">
                            <thead>
                                <tr role="row" align="center">
                                    <th style="cursor:pointer;" tabindex="0" rowspan="1" colspan="1">
                                        Placas
                                    </th>
                                    <th data-orderable="false" tabindex="0" rowspan="1" colspan="1">
                                        Marca
                                    </th>
                                    <th data-orderable="false" tabindex="0" rowspan="1" colspan="1">
                                        Modelo
                                    </th>
                                    <th style="cursor:pointer;" tabindex="0" rowspan="1" colspan="1">
                                        Asignado a
                                    </th>
                                    <th data-orderable="false"></th>
                                    <th data-orderable="false"></th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr align="center">
                                    <th rowspan="1" colspan="1">Placas</th>
                                    <th rowspan="1" colspan="1">Marca</th>
                                    <th rowspan="1" colspan="1">Modelo</th>
                                    <th rowspan="1" colspan="1">Asignado a</th>
                                    <th rowspan="1" colspan="1"></th>
                                    <th rowspan="1" colspan="1"></th>
                                </tr>
                            </tfoot>
                            <tbody>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

            <div class="modal fade" id="modal_agregar_carro" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Agregar carro</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"> <span aria-hidden="true">&times;</span> </button>
                        </div>
                        <div class="modal-body">
                            <form action="#" id="carro_form">
                                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                <div class="row p-t-10">
                                    <div class="col-6" align="center">
                                        <label class="control-label">Marca</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-circle-o"></i></span>
                                            <input type="text" id="carro_marca" name="carro_marca" class="form-control" placeholder="Marca de auto">
                                        </div>
                                    </div>
                                    
                                    <div class="col-6" align="center">
                                        <label class="control-label">Modelo</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-car"></i></span>
                                            <input type="text" id="carro_modelo" name="carro_modelo" class="form-control" placeholder="Modelo de auto">
                                        </div>
                                    </div>
                                </div>

                                <div class="row p-t-10">
                                    <div class="col-6" align="center">
                                        <label class="control-label">Placas</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-hashtag"></i></span>
                                            <input type="text" id="carro_placas" name="carro_placas" class="form-control" placeholder="Placas del carro">
                                        </div>
                                    </div>
                                    
                                    <div class="col-6" align="center">
                                        <label class="control-label">Trabajador asignado</label>
                                        <div class="input-group">
                                            <span class="input-group-addon" id="select_auto_span"><i class="fa fa-user-o"></i></span>
                                            <select class="select2 form-control custom-select" style="width: 100%;" id="carro_trabajador" name="carro_trabajador">
                                                <option value="">Trabajador</option>
                                                <optgroup label="Disponibles">
                                                </optgroup>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="button" id="agregar_registro" class="btn btn-success" data-dismiss="modal">Guardar</button>
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
<script src="{{asset('plugins/sweetalert/sweetalert_2/sweetalert2.all.min.js')}}"></script>
<script src="{{asset('plugins/sweetalert/sweetalert_2/sweetalert2.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('plugins/sweetalert/sweetalert_2/sweetalert2.min.css')}}">
<script src="{{asset('modulos/carros.js')}}"></script>
</div>
@endsection
@endsection
@endsection
