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
                                    onclick="#">
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
                                    <th></th>
                                </tr>
                            </tfoot>
                            <tbody>
                            </tbody>
                        </table>

                    </div>
                </div>
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
