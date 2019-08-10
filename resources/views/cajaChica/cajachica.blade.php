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
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h4 class="card-title">Caja chica</h4>
                                        <h6 class="card-subtitle">Movimientos de caja chica</h6>
                                    </div>
                                    <div class="col-lg-3">
                                        <button type="button" id="btnRenovarHoja" class="btn waves-effect waves-light btn-block btn-secondary" href=""><i class="fa fa fa-file-text-o"></i> Generar nuevo</button>
                                    </div>
                                    <div class="col-lg-3">
                                        <button type="button" id="agregarRegistro" class="btn waves-effect waves-light btn-block btn-primary" href="#modal" data-toggle="modal" data-whatever="Agregar"><i class="fa fa-plus"></i> Agregar registro</button>
                                    </div>
                                </div>
                                <hr>
                                <div class="row" style="margin-top: 2%">
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-lg-7">
                                                        <h5 class="card-title">Fisicamente</h5>
                                                        <h6 class="card-subtitle">Gastos internos de oficina</h6>
                                                    </div>
                                                    <div class="col-lg-5">
                                                        <h2 class="card-title" id="totalFisicamente">$3674.50</h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-lg-7">
                                                        <h5 class="card-title">Total </h5>
                                                        <h6 class="card-subtitle">Dinero que hay en caja chica</h6>
                                                    </div>
                                                    <div class="col-lg-5">
                                                        <h2 class="card-title text-info" id="totalCajaChica">$4000.00</h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">Oficina</h5>
                                                <h6 class="card-subtitle">Gastos internos de oficina</h6>
                                                <div class="table-responsive">
                                                    <table class="table" id="tablaOficina">
                                                        <thead>
                                                            <tr>
                                                                <th>Fecha</th>
                                                                <th>Concepto</th>
                                                                <th>Cantidad</th>
                                                                <th>Acciones</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="bodyTablaOficina">
                                                            <tr>
                                                                <td><span class="text-muted"><i class="fa fa-clock-o"></i> Oct 16, 2017</td>
                                                                <td>Articulos de papeleria</td>
                                                                <td>$60.00</td>
                                                                <td class="text-nowrap">
                                                                    <span data-toggle="tooltip" title="Editar">
                                                                        <a href="#modalModificarRegistro" data-toggle="modal">
                                                                            <i class="icon-pencil text-primary m-r-10"></i>
                                                                        </a>
                                                                    </span>
                                                                    <span data-toggle="tooltip" title="Eliminar">
                                                                        <a href="#" data-toggle="modal" data-target="#eliminar" id="sa-warning">
                                                                            <i class="icon-close text-danger"></i>
                                                                        </a>
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2"><b>Monto: </b></td>
                                                                <td colspan="2"><b>$60.00</b></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">Trabajadores</h5>
                                                <h6 class="card-subtitle">Prestamos de caja chica a trabajadores</h6>
                                                <div class="table-responsive">
                                                    <table class="table" id="tablaTrabajadores">
                                                        <thead>
                                                            <tr>
                                                                <th>Fecha</th>
                                                                <th>Nombre</th>
                                                                <th>Cantidad</th>
                                                                <th>Acciones</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="bodyTablaTrabajadores">
                                                            <tr>
                                                                <td><span class="text-muted"><i class="fa fa-clock-o"></i> Oct 16, 2017</td>
                                                                <td>Adan Santana</td>
                                                                <td>$100.00</td>
                                                                <td class="text-nowrap">
                                                                    <span data-toggle="tooltip" title="Editar">
                                                                        <a href="#modalModificarRegistro" data-toggle="modal">
                                                                            <i class="icon-pencil text-primary m-r-10"></i>
                                                                        </a>
                                                                    </span>
                                                                    <span data-toggle="tooltip" title="Eliminar">
                                                                        <a href="#" data-toggle="modal" data-target="#eliminar" id="sa-warning">
                                                                            <i class="icon-close text-danger"></i>
                                                                        </a>
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2"><b>Monto: </b></td>
                                                                <td colspan="2"><b>$100.00</b></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">Mandados</h5>
                                                <h6 class="card-subtitle">Gastos de compras de improvisto</h6>
                                                <div class="table-responsive">
                                                    <table class="table" id="tablaMandados">
                                                        <thead>
                                                            <tr>
                                                                <th>Fecha</th>
                                                                <th>Movimiento</th>
                                                                <th>Cantidad</th>
                                                                <th>Acciones</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="bodyTablaMandados">
                                                            <tr>
                                                                <td><span class="text-muted"><i class="fa fa-clock-o"></i> Oct 16, 2017</td>
                                                                <td>Dinero de la semana para mandados</td>
                                                                <td>$200.00</td>
                                                                <td class="text-nowrap">
                                                                    <span data-toggle="tooltip" title="Editar">
                                                                        <a href="#modalModificarRegistro" data-toggle="modal">
                                                                            <i class="icon-pencil text-primary m-r-10"></i>
                                                                        </a>
                                                                    </span>
                                                                    <span data-toggle="tooltip" title="Eliminar">
                                                                        <a href="#" data-toggle="modal" data-target="#eliminar" id="sa-warning">
                                                                            <i class="icon-close text-danger"></i>
                                                                        </a>
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2"><b>Monto: </b></td>
                                                                <td colspan="2"><b>$200.00</b></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">Adeudo de nomina</h5>
                                                <h6 class="card-subtitle">Adeudo a trabajadores por falta de feria al pagar</h6>
                                                <div class="table-responsive">
                                                    <table class="table" id="tablaAdeudo">
                                                        <thead>
                                                            <tr>
                                                                <th>Fecha</th>
                                                                <th>Nombre</th>
                                                                <th>Cantidad</th>
                                                                <th>Acciones</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="bodyTablaAdeudo">
                                                            <tr>
                                                                <td><span class="text-muted"><i class="fa fa-clock-o"></i> Oct 16, 2017</td>
                                                                <td>Adan Santana</td>
                                                                <td>$34.50</td>
                                                                <td class="text-nowrap">
                                                                    <span data-toggle="tooltip" title="Editar">
                                                                        <a href="#modalModificarRegistro" data-toggle="modal">
                                                                            <i class="icon-pencil text-primary m-r-10"></i>
                                                                        </a>
                                                                    </span>
                                                                    <span data-toggle="tooltip" title="Eliminar">
                                                                        <a href="#" data-toggle="modal" data-target="#eliminar" id="sa-warning">
                                                                            <i class="icon-close text-danger"></i>
                                                                        </a>
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2"><b>Monto: </b></td>
                                                                <td colspan="2"><b>$34.50</b></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"></h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"> <span aria-hidden="true">&times;</span> </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="formCajaChica">
                                                         <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-lg-8">
                                                                    <label>Seleccione movimiento</label>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <select id="tipo" name="tipo" class="custom-select b-0">
                                                                        <option value="1">Oficina</option>
                                                                        <option value="2">Trabajadores</option>
                                                                        <option value="3">Mandados</option>
                                                                        <option value="4">Adeudo</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Fecha</label>
                                                            <input class="form-control" type="date" placeholder="Selecione una fecha" id="fecha" name="fecha">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Nombre o concepto</label>
                                                            <input class="form-control" type="text" placeholder="Ingrese un nombre de concepto" id="concepto" name="concepto">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Cantidad</label>
                                                            <input class="form-control" type="number" placeholder="Ingrese la cantidad" id="cantidad" name="cantidad">
                                                        </div>
                                                        <!-- AQUI VA EL ID DEL USUARIO -->
                                                        <input type="hidden" name="idUsuario" value="1">
                                                        <input type="hidden" name="idRegistro" value="1">
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i>Cerrar</button>
                                                    <button type="button" id="btnGuardar" class="btn btn-success"><i class="fa fa-save"></i>Guardar</button>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        @section('footer')
        @parent

        <script src="{{asset('plugins/sweetalert/sweetalert_2/sweetalert2.all.min.js')}}"></script>
        <link rel="stylesheet" href="{{asset('plugins/sweetalert/sweetalert_2/sweetalert2.min.css')}}">
    </div>
@endsection
@endsection
@endsection
