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
                                    onclick="abrir_modal_agregar_rol()">
                                <i class="fa fa-plus"></i>
                                Agregar rol de usuario
                            </button>
                        </div>
                    </div>

                    <div class="table-responsive m-t-40"    >

                        <table id="table_roles"
                            class="display table table-hover table-striped table-bordered">
                            <thead>
                                <tr role="row" align="center">
                                    <th style="cursor:pointer;" tabindex="0" rowspan="1" colspan="1">
                                        Nombre de rol
                                    </th>
                                    <th data-orderable="false" tabindex="0" rowspan="1" colspan="1">
                                        Módulos pertenecientes
                                    </th>
                                    <th data-orderable="false" tabindex="0" rowspan="1" colspan="1">
                                        
                                    </th>
                                    <th data-orderable="false"  style="cursor:pointer;" tabindex="0" rowspan="1" colspan="1">
                                        
                                    </th>
                                    <th data-orderable="false"  style="cursor:pointer;" tabindex="0" rowspan="1" colspan="1">
                                        
                                    </th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr align="center">
                                    <th rowspan="1" colspan="1">Nombre de rol</th>
                                    <th rowspan="1" colspan="1">Módulos pertenecientes</th>
                                    <th rowspan="1" colspan="1"></th>
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

            <div class="modal fade" id="modal_usuarios_rol" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Usuarios del rol seleccionado</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"> <span aria-hidden="true">&times;</span> </button>
                        </div>
                        <div class="modal-body">
                            <table id="table_usuarios_per_rol"
                                class="display table table-hover table-striped table-bordered w-100">
                                <tbody></tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>

            <div class="modal fade" id="modal_agregar_rol" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Agregar nuevo rol</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"> <span aria-hidden="true">&times;</span> </button>
                        </div>
                        <div class="modal-body">
                            <form action="#" id="rol_form">
                                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

                                <div class="row p-t-10">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label">Nombre de rol</label>
                                            <input type="text" class="form-control" placeholder="Nombre" id="rol_nombre" name="rol_nombre">
                                        </div>
                                    </div>
                                </div>

                                <div class="row p-t-10">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label" id="select_modulos_label">Módulos disponibles</label>
                                        </div>
                                    </div>
                                    <!--/span-->
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="button" id="btn_guardar_rol" class="btn btn-success" data-dismiss="modal">Guardar</button>
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
<script src="{{asset('modulos/roles.js')}}"></script>
</div>
@endsection
@endsection
@endsection
