@extends('footer')
@extends('sidebar')
@extends('header')

@section('header')
@parent
	<div id="main-wrapper">
        <style type="text/css">
            .scroll{
              display: block;
              width: 100%;
              height: 552px;
              overflow-x: auto;
            }
        </style>
		@section('sidebar')
		@parent
		<div class="page-wrapper">
			<div class="container-fluid">
				 <!-- ============================================================== -->
                <!-- Citas y pendientes -->
                <!-- ============================================================== -->
				<div class="row">
                    <div class="col-lg-6">
                        <div class="card scroll">
                            <div class="card-body">
                                <h4 class="card-title"><span class="lstick"></span>Citas</h4>
                                <div class="d-flex row">
                                    <div class="col-lg-8">
                                        <input class="form-control" type="week" id="filtroCita">
                                    </div>
                                    <div class="ml-auto col-lg-4">
                                        <button class="pull-right btn btn-circle btn-success" id="btnNuevaCita" data-toggle="modal" data-target="#modalCita" data-whatever="Añadir"><i class="ti-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- ============================================================== -->
                            <!-- Comment widgets -->
                            <!-- ============================================================== -->
                            <div class="comment-widgets" id="contenedorCitas">
                                
                            </div>
                        </div>
                    </div>
                     <div class="col-lg-6">
                        <div class="card scroll">
                            <div class="card-body">
                                <h4 class="card-title"><span class="lstick"></span>Pendientes</h4>
                                <div class="d-flex row">
                                    <div class="col-lg-8">
                                        <button type="button" id="btnEliminarPendientes" class="btn waves-effect waves-light btn-block btn-primary" href="#modalAgregarRegistroCajaChica" data-toggle="modal"><i></i>Eliminar pendientes realizados</button>
                                    </div>
                                    <div class="ml-auto col-lg-4">
                                        <button class="pull-right btn btn-circle btn-success" data-toggle="modal" data-target="#modalPendientes" data-whatever="Añadir" id="btnNuevoPendiente" onclick="limpiarModalPendientes()"><i class="ti-plus"></i></button>
                                    </div>
                                </div>
                                <!-- ============================================================== -->
                                <!-- To do list widgets -->
                                <!-- ============================================================== -->
                                <div class="to-do-widget m-t-20">
                                    <ul class="list-task todo-list list-group m-b-0" data-role="tasklist">
                                        <div id="contenedorPendientes">

                                        </div>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- Projects of the month -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div>
                                        <h4 class="card-title"><span class="lstick"></span>Proyectos del mes</h4></div>
                                    <div class="ml-auto">
                                        <select class="custom-select b-0" id="filtroMesCotizaciones">
                                            
                                        </select>
                                    </div>
                                </div>
                                <div class="table-responsive m-t-20 no-wrap">
                                    <table class="table vm no-th-brd pro-of-month">
                                        <thead>
                                            <tr>
                                                <th>Cliente</th>
                                                <th>Proyecto</th>
                                                <th>Prioridad</th>
                                                <th>Costo</th>
                                            </tr>
                                        </thead>
                                        <tbody id="contenedorCotizacionesDashboard">
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- Activity widget find scss into widget folder-->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-lg-12 col-xlg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex no-block row">
                                    <div class="col-lg-7">
                                         <h4 class="card-title"><span class="lstick"></span>Ingresos y egresos</h4>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="btn-group ml-auto m-t-10">
                                            <input class="form-control" type="date" id="filtroDiaReportedelDia">
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="btn-group ml-auto m-t-10">
                                            <select class="custom-select pull-right" id="selectReporteDia">
                                               <option value="1">Todo</option>
                                                <option value="2">Ingresos</option>
                                                <option value="3">Egresos</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            <div class="activity-box">
                                <div class="card-body" id="contenedorReporteDia">
                                    <!-- Activity item-->
                                    <div class="date-devider" id="tituloIngresos"><span>Ingresos</span></div>
                                    <div id="contenedorReporteDiaIngresos">
                                        
                                    </div>
                                    <div class="date-devider"  id="tituloEgresos"><span>Egresos</span></div>
                                    <div id="contenedorReporteDiaEgresos">
                                        
                                    </div>
                                    <!-- Activity item-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
			</div>
            <!-- .modal CITAS for add task -->
            <div class="modal fade" id="modalCita" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title"></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                        </div>
                        <div class="modal-body">
                            <form id="citas">
                                <div class="form-group">
                                    <label for="cliente">Cliente</label>
                                    <select class="select2 form-control custom-select cliente required" style="width: 100%; height:36px;" id="selectClientes" name="cliente">
                                    </select>
                                    <label id="txtCliente-error" class="text-danger" for="cliente" style="display: none;">Seleccione un cliente.</label>
                                </div>
                                <div class="form-group">
                                    <label for="comentario">Descripción</label>
                                    <textarea class="form-control required comentario" id="comentario" name="comentario" aria-required="true" spellcheck="false" placeholder="Detalles de la cita"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Asigar fecha y hora</label>
                                    <input class="form-control fecha" name="fecha" type="datetime-local" placeholder="Seleccione una fecha y hora" id="fechaCita">
                                    <label id="txtFecha-error" class="text-danger" for="fecha" style="display: none;">Horario ocupado.</label>
                                </div>
                                <div class="form-group" id="estatusCita">
                                    <label>Estado</label>
                                    <select class="custom-select col-12" name="estatus" id="selectEstadoCitas">
                                        <option value="0">Escoga...</option>
                                        <option value="1">Asistió</option>
                                        <option value="2">Cancelado</option>
                                    </select>
                                     <label id="txtEstatus-error" class="text-danger" for="estatus" style="display: none;">Acción inválida, verifique las fechas.</label>
                                </div>
                                <div class="form-group">
                                    <!-- ID del usuario que ingreso al sistema -->
                                    <input class="idUsuario" type="hidden" value="1" name="idUsuario">
                                </div>
                                <div class="form-group">
                                    <!-- ID de la cita-->
                                    <input class="idCitaModal" type="hidden" name="idCitaModal">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="button" id="btnGuardarCita" class="btn btn-success">Guardar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
            <!-- .modal for add task -->
            <div class="modal fade" id="modalPendientes" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Añadir pendiente</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                        </div>
                        <div class="modal-body">
                            <form id="pendientes">
                                <div class="form-group">
                                    <label>Nombre del pendiente</label>
                                    <textarea type="text" class="form-control" name="descripcionPendiente" id="descripcionPendiente" placeholder="Describa el pendiente"></textarea> 
                                </div>
                                <div class="form-group">
                                    <!-- ID del usuario que ingreso al sistema -->
                                    <input class="estatusPendiente" type="hidden" value="1" name="estatusPendiente">
                                </div>
                                <div class="form-group">
                                    <!-- ID del usuario que ingreso al sistema -->
                                    <input class="idUsuario" type="hidden" value="1" name="idUsuario">
                                </div>
                                <div class="form-group">
                                    <!-- ID del pendiente-->
                                    <input class="idPendienteModal" type="hidden" name="idPendienteModal">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-success" id="btnGuardarPendiente">Guardar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
		</div>
	</div>
    @section('footer')
    
    @parent
    <script src="{{asset('plugins/sweetalert/sweetalert_2/sweetalert2.all.min.js')}}"></script>
    <link rel="stylesheet" href="{{asset('plugins/sweetalert/sweetalert_2/sweetalert2.min.css')}}">
@endsection
@endsection
@endsection
