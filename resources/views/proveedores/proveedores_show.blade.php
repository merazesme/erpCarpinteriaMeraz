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
                            class="display nowrap table table-hover table-striped table-bordered dataTable"
                            cellspacing="0" width="100%" role="grid" aria-describedby="table_proveedores_info"
                            style="width: 100%;">
                            <thead>
                                <tr role="row">
                                    <th class="sorting_asc" tabindex="0" rowspan="1" colspan="1">
                                        Concepto
                                    </th>
                                    <th class="sorting" tabindex="0" rowspan="1" colspan="1">
                                        RFC
                                    </th>
                                    <th class="sorting" tabindex="0" rowspan="1" colspan="1">
                                        Teléfono
                                    </th>
                                    <th class="sorting" tabindex="0" rowspan="1" colspan="1">
                                        Correo electrónico
                                    </th>
                                    <th class="sorting" tabindex="0" rowspan="1" colspan="1">
                                        Adeudo
                                    </th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th rowspan="1" colspan="1">Concepto</th>
                                    <th rowspan="1" colspan="1">RFC</th>
                                    <th rowspan="1" colspan="1">Teléfono</th>
                                    <th rowspan="1" colspan="1">Correo electrónico</th>
                                    <th rowspan="1" colspan="1">Adeudo</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </tfoot>
                            <tbody style="cursor: pointer;">
                                <tr role="row">
                                    <td>Material x</td>
                                    <td>xxxx-xxxx-xxxx-xxxx</td>
                                    <td>669-000-000</td>
                                    <td>correo.electronico@email.com</td>
                                    <td>$000.00</td>
                                    <td class="odd"onclick="editar_proveedor(1)" data-toggle="tooltip" 
                                        data-placement="top" title="Clic para editar 1">
                                        <i class="mdi mdi-lead-pencil"></i>
                                    </td>
                                    <td data-toggle="tooltip" data-placement="top" onclick="delete_proveedor(1)"
                                        title="Clic para eliminar 1" >
                                        <i class="mdi mdi-delete-forever"></i>
                                    </td>
                                </tr>
                                <tr role="row">
                                    <td>Material x</td>
                                    <td>xxxx-xxxx-xxxx-xxxx</td>
                                    <td>669-000-000</td>
                                    <td>correo.electronico@email.com</td>
                                    <td>$000.00</td>
                                    <td class="odd"onclick="editar_proveedor(2)" data-toggle="tooltip" 
                                        data-placement="top" title="Clic para editar 2">
                                        <i class="mdi mdi-lead-pencil"></i>
                                    </td>
                                    <td data-toggle="tooltip" data-placement="top" onclick="delete_proveedor(2)"
                                        title="Clic para eliminar 2" >
                                        <i class="mdi mdi-delete-forever"></i>
                                    </td>
                                </tr>
                                <tr role="row">
                                    <td>Material x</td>
                                    <td>xxxx-xxxx-xxxx-xxxx</td>
                                    <td>669-000-000</td>
                                    <td>correo.electronico@email.com</td>
                                    <td>$000.00</td>
                                    <td class="odd"onclick="editar_proveedor(3)" data-toggle="tooltip" 
                                        data-placement="top" title="Clic para editar 3">
                                        <i class="mdi mdi-lead-pencil"></i>
                                    </td>
                                    <td data-toggle="tooltip" data-placement="top" onclick="delete_proveedor(3)"
                                        title="Clic para eliminar 3" >
                                        <i class="mdi mdi-delete-forever"></i>
                                    </td>
                                </tr>
                                <tr role="row">
                                    <td>Material x</td>
                                    <td>xxxx-xxxx-xxxx-xxxx</td>
                                    <td>669-000-000</td>
                                    <td>correo.electronico@email.com</td>
                                    <td>$000.00</td>
                                    <td class="odd"onclick="editar_proveedor(4)" data-toggle="tooltip" 
                                        data-placement="top" title="Clic para editar 4">
                                        <i class="mdi mdi-lead-pencil"></i>
                                    </td>
                                    <td data-toggle="tooltip" data-placement="top" onclick="delete_proveedor(4)"
                                        title="Clic para eliminar 4" >
                                        <i class="mdi mdi-delete-forever"></i>
                                    </td>
                                </tr>
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
<script>
    /** Scripts */
    function agregar_proveedor() {
        location.href = "/proveedores/agregar";
    }
    function editar_proveedor(id) {
        location.href = "/proveedores/editar/"+id;
    }
    function delete_proveedor(id) {
        promise_alert("Proveedor", `¿Seguro que desea eliminar al proveedor ${id}?`, "warning");
    }
    function normal_alert(title, text, type) {
        swal(title, text, type);
    }
    function promise_alert(title, text, type) {
        swal("Click on either the button or outside the modal.")
        .then((value) => {
            swal(`The returned value is: ${value}`);
        });
    }

</script>
</div>
@endsection
@endsection
@endsection
