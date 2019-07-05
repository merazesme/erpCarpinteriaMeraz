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
                            <h4 class="card-title">Lista de proveedores</h4>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 d-inline-flex">
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
                                    <th class="sorting_asc" tabindex="0" rowspan="1" colspan="1"
                                    style="width: 151px;">
                                        Concepto
                                    </th>
                                    <th class="sorting" tabindex="0" rowspan="1" colspan="1"
                                        style="width: 226px;">
                                        RFC
                                    </th>
                                    <th class="sorting" tabindex="0" rowspan="1" colspan="1"
                                        style="width: 52px;">
                                        Teléfono
                                    </th>
                                    <th class="sorting" tabindex="0" rowspan="1" colspan="1"
                                        style="width: 101px;">
                                        Correo electrónico
                                    </th>
                                    <th class="sorting" tabindex="0" rowspan="1" colspan="1"
                                        style="width: 101px;">
                                        Adeudo
                                    </th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th rowspan="1" colspan="1">Concepto</th>
                                    <th rowspan="1" colspan="1">RFC</th>
                                    <th rowspan="1" colspan="1">Teléfono</th>
                                    <th rowspan="1" colspan="1">Correo electrónico</th>
                                    <th rowspan="1" colspan="1">Adeudo</th>
                                </tr>
                            </tfoot>
                            <tbody style="cursor: pointer;">
                                <tr role="row" class="odd" data-toggle="tooltip" data-placement="top"
                                    title="Clic para editar 1" onclick="editar_proveedor(1)">
                                    <td>Material x</td>
                                    <td>xxxx-xxxx-xxxx-xxxx</td>
                                    <td>669-000-000</td>
                                    <td>correo.electronico@email.com</td>
                                    <td>$000.00 MXN</td>
                                </tr>
                                <tr role="row" class="odd" data-toggle="tooltip" data-placement="top"
                                    title="Clic para editar 2" onclick="editar_proveedor(2)">
                                    <td>Material x</td>
                                    <td>xxxx-xxxx-xxxx-xxxx</td>
                                    <td>669-000-000</td>
                                    <td>correo.electronico@email.com</td>
                                    <td>$000.00 MXN</td>
                                </tr>
                                <tr role="row" class="odd" data-toggle="tooltip" data-placement="top"
                                    title="Clic para editar 3" onclick="editar_proveedor(3)">
                                    <td>Material x</td>
                                    <td>xxxx-xxxx-xxxx-xxxx</td>
                                    <td>669-000-000</td>
                                    <td>correo.electronico@email.com</td>
                                    <td>$000.00 MXN</td>
                                </tr>
                                <tr role="row" class="odd" data-toggle="tooltip" data-placement="top"
                                    title="Clic para editar 4" onclick="editar_proveedor(4)">
                                    <td>Material x</td>
                                    <td>xxxx-xxxx-xxxx-xxxx</td>
                                    <td>669-000-000</td>
                                    <td>correo.electronico@email.com</td>
                                    <td>$000.00 MXN</td>
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

</script>
</div>
@endsection
@endsection
@endsection
