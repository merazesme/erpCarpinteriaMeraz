@extends('footer')
@extends('sidebar')
@extends('header')	

	<div id="main-wrapper">
		@section('header')
		@parent
		@section('sidebar')	
		@parent
		<div class="page-wrapper">
			<div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-9">
                                        <h3 class="card-title">Caja chica</h3>
                                        <h6 class="card-subtitle">Movimientos de caja chica</h6>
                                    </div>
                                    <div class="col-lg-3">
                                        <button type="button" class="btn waves-effect waves-light btn-block btn-primary" href="#modalAgregarRegistroCajaChica" data-toggle="modal"><i class="fa fa-plus"></i>Agregar registro</button>
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 2%">
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-lg-7">
                                                        <h4 class="card-title">Fisicamente</h4>
                                                        <h6 class="card-subtitle">Gastos internos de oficina</h6>
                                                    </div>
                                                    <div class="col-lg-5">
                                                        <h2 class="card-title">$3674.50</h2>
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
                                                        <h4 class="card-title">Total </h4>
                                                        <h6 class="card-subtitle">Dinero que hay en caja chica</h6>
                                                    </div>
                                                    <div class="col-lg-5">
                                                        <h2 class="card-title text-info">$4000.00</h2>
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
                                                <h4 class="card-title">Oficina</h4>
                                                <h6 class="card-subtitle">Gastos internos de oficina</h6>
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Fecha</th>
                                                                <th>Concepto</th>
                                                                <th>Cantidad</th>
                                                                <th>Acciones</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
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
                                                <h4 class="card-title">Trabajadores</h4>
                                                <h6 class="card-subtitle">Prestamos de caja chica a trabajadores</h6>
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Fecha</th>
                                                                <th>Nombre</th>
                                                                <th>Cantidad</th>
                                                                <th>Acciones</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
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
                                                <h4 class="card-title">Mandados</h4>
                                                <h6 class="card-subtitle">Gastos de compras de improvisto</h6>
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Fecha</th>
                                                                <th>Movimiento</th>
                                                                <th>Cantidad</th>
                                                                <th>Acciones</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
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
                                                <h4 class="card-title">Adeudo de nomina</h4>
                                                <h6 class="card-subtitle">Adeudo a trabajadores por falta de feria al pagar</h6>
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Fecha</th>
                                                                <th>Nombre</th>
                                                                <th>Cantidad</th>
                                                                <th>Acciones</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
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
                                </div>
                                <div class="to-do-widget m-t-20">
                                    <!-- .modal for add task -->
                                    <div class="modal fade" id="modalModificarRegistro" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Modificar</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"> <span aria-hidden="true">&times;</span> </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form>
                                                        <div class="form-group">
                                                            <label>Fecha</label>
                                                            <input class="form-control" type="date" placeholder="Selecione una fecha" id="example-date-input">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Nombre o concepto</label>
                                                            <input class="form-control" type="text" placeholder="Ingrese un nombre de concepto" id="example-text-input">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Cantidad</label>
                                                            <input class="form-control" type="number" placeholder="Ingrese la cantidad" id="example-number-input">
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i>Cerrar</button>
                                                    <button type="button" class="btn btn-success" data-dismiss="modal"><i class="fa fa-save"></i>Guardar</button>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <!-- /.modal -->
                                     <div class="modal fade" id="modalAgregarRegistroCajaChica" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Agregar registro</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"> <span aria-hidden="true">&times;</span> </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form>
                                                         <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-lg-8">
                                                                    <label>Seleccione movimiento</label>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <select class="custom-select b-0">
                                                                        <option selected="">Oficina</option>
                                                                        <option value="1">Trabajadores</option>
                                                                        <option value="2">Mandados</option>
                                                                        <option value="3">Adeudo</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Fecha</label>
                                                            <input class="form-control" type="date" placeholder="Selecione una fecha" id="example-date-input">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Nombre o concepto</label>
                                                            <input class="form-control" type="text" placeholder="Ingrese un nombre de concepto" id="example-text-input">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Cantidad</label>
                                                            <input class="form-control" type="number" placeholder="Ingrese la cantidad" id="example-number-input">
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i>Cerrar</button>
                                                    <button type="button" class="btn btn-success" data-dismiss="modal"><i class="fa fa-save"></i>Guardar</button>
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
	</div>
@endsection
@endsection
@endsection