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
                        <div class="col-lg-9">
                            <h4 class="card-title">{{$modulo}}</h4>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6 d-inline-flex">
                            <button type="button" class="btn waves-effect waves-light btn-block btn-primary ml-auto"
                                    onclick="agregar_proveedor()">
                                <i class="fa fa-plus"></i>
                                Agregar proveedor
                            </button>
                        </div>
                    </div>

                    <div class="table-responsive m-t-40" style="height:auto;">

                        <table id="table_proveedores"
                            class="display table table-hover table-striped table-bordered"
                            cellspacing="0" width="100%" role="grid" aria-describedby="table_proveedores_info">
                            <thead>
                                <tr role="row" align="center">
                                    <th style="cursor:pointer;" class="sorting_asc" tabindex="0" rowspan="1" colspan="1">
                                        Concepto
                                    </ths>
                                    <th style="cursor:pointer;" class="sorting" tabindex="0" rowspan="1" colspan="1">
                                        RFC
                                    </th>
                                    <th style="cursor:pointer;" class="sorting" tabindex="0" rowspan="1" colspan="1">
                                        Teléfono
                                    </th>
                                    <th style="cursor:pointer;" class="sorting" tabindex="0" rowspan="1" colspan="1">
                                        Correo electrónico
                                    </th>
                                    <th style="cursor:pointer;" class="sorting" tabindex="0" rowspan="1" colspan="1">
                                        Adeudo
                                    </th>
                                    <th data-orderable="false"></th>
                                    <th data-orderable="false"></th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr align="center">
                                    <th rowspan="1" colspan="1">Concepto</th>
                                    <th rowspan="1" colspan="1">RFC</th>
                                    <th rowspan="1" colspan="1">Teléfono</th>
                                    <th rowspan="1" colspan="1">Correo electrónico</th>
                                    <th rowspan="1" colspan="1">Adeudo</th>
                                    <th></th>
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
<script>
    /** Script for initialize DataTable and ToolTips */
    $('#table_proveedores').DataTable({
        dom: 'Bfrtip',
        buttons: ['excel', 'pdf', 'print']
    });
    $("body").tooltip({ selector: '[data-toggle="tooltip"]' });
</script>
<script src="{{asset('modulos/proveedores.js')}}"></script>
<script>
    // /** Scripts */
    // function agregar_proveedor() {
    //     location.href = "/proveedores/agregar";
    // }
    // function editar_proveedor(id) {
    //     location.href = "/proveedores/editar/"+id;
    // }
    // function delete_proveedor(id) {
    //     promise_alert("Proveedor", `¿Seguro que desea eliminar al proveedor ${id}?`, "warning");
    // }
    // function normal_alert(title, text, type) {
    //     swal(title, text, type);
    // }

</script>
</div>
@endsection
@endsection
@endsection
