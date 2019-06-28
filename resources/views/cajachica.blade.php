@extends('footer')
@extends('breadcrumbs')
@extends('sidebar')
@extends('header')	

	<div id="main-wrapper">
		@section('header')
		@parent
		@section('sidebar')	
		@parent
		<div class="page-wrapper">
			<div class="container-fluid">
				@section('breadcrumbs')	
				@parent
				<div class="row">
					<div class="col-lg-6">
						<div class="card">
                            <div class="card-body">
                            	<div class="row">
                            		<div class="col-lg-7">
                            			<h4 class="card-title">Fisicamente en caja chica</h4>
                                		<h6 class="card-subtitle">Gastos internos de oficina</h6>
                            		</div>
                            		<div class="col-lg-5">
                            			<h1 class="card-title">$3674.50</h1>
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
		                                <h4 class="card-title"><b>Total </b></h4>
		                                <h6 class="card-subtitle"><b>Dinero que hay en caja chica</b></h6>
	                        		</div>
	                        		<div class="col-lg-5">
	                        			<h1 class="card-title text-info"><b>$4000.00</b></h1>
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
		                                            <a href="#modalModificarRegistro" data-toggle="modal"> 
		                                            	<i class="icon-pencil text-primary m-r-10"></i> 
		                                            </a>
		                                            <a href="#" data-toggle="modal" data-target="#eliminar" id="sa-warning"> 
		                                            	<i class="icon-close text-danger"></i>
		                                            </a>
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
		                                            <a href="#modalModificarRegistro" data-toggle="modal"> 
		                                            	<i class="icon-pencil text-primary m-r-10"></i> 
		                                            </a>
		                                            <a href="#" data-toggle="modal" data-target="#eliminar" id="sa-warning"> 
		                                            	<i class="icon-close text-danger"></i>
		                                            </a>
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
		                                            <a href="#modalModificarRegistro" data-toggle="modal"> 
		                                            	<i class="icon-pencil text-primary m-r-10"></i> 
		                                            </a>
		                                            <a href="#" data-toggle="modal" data-target="#eliminar" id="sa-warning"> 
		                                            	<i class="icon-close text-danger"></i>
		                                            </a>
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
		                                            <a href="#modalModificarRegistro" data-toggle="modal"> 
		                                            	<i class="icon-pencil text-primary m-r-10"></i> 
		                                            </a>
		                                            <a href="#" data-toggle="modal" data-target="#eliminar" id="sa-warning"> 
		                                            	<i class="icon-close text-danger"></i>
		                                            </a>
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
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    <button type="button" class="btn btn-success" data-dismiss="modal">Guardar</button>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->
                </div>
			</div>
		</div>
		@section('footer')
		@parent
	</div>
@endsection
@endsection
@endsection
@endsection