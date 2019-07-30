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
                                    <div class="col-lg-9">
                                        <h3 class="card-title">Configuraciones</h3>
                                        <h6 class="card-subtitle">Configuraciones generales</h6>
                                    </div>
                                </div>

                                <ul class="nav nav-tabs" role="tablist">
                                     <li class="nav-item">
                                         <a class="nav-link active" data-toggle="tab" href="#general" role="tab">
                                             <span class="hidden-sm-up">
                                                 <i class="icon-settings"></i>
                                             </span>
                                             <span class="hidden-xs-down">General</span>
                                         </a>
                                     </li>
                                     <li class="nav-item">
                                         <a class="nav-link" data-toggle="tab" href="#horarios" role="tab">
                                             <span class="hidden-sm-up">
                                                 <i class="icon-clock"></i>
                                             </span>
                                             <span class="hidden-xs-down">Horarios</span>
                                         </a>
                                     </li>
                                </ul>

                                <div class="tab-content tabcontent-border">
                                    <div class="tab-pane active" id="general" role="tabpanel">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <button type="button" class="btn waves-effect mt-2 mr-2 waves-light btn-primary float-right" href="#modalConfiguracion" data-toggle="modal"><i class="fa fa-edit"></i> Actualizar datos</button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-7">
                                                                <h4 class="card-title">IVA</h4>
                                                                <h6 class="card-subtitle">Porcentaje del IVA</h6>
                                                            </div>
                                                            <div class="col-lg-5">
                                                                <h2 class="card-title text-info" id="iva_data">##%</h2>
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
                                                                <h4 class="card-title">Caja chica </h4>
                                                                <h6 class="card-subtitle">Dinero mínimo en caja chica</h6>
                                                            </div>
                                                            <div class="col-lg-5">
                                                                <h2 class="card-title text-info" id="caja_chica_data">$###.##</h2>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                     <div class="tab-pane" id="horarios" role="tabpanel">
                                         <div class="row">
                                             <div class="col-lg-12">
                                                 <button type="button" class="btn waves-effect mt-2 mr-2 waves-light btn-primary float-right" href="#modalConfiguracionHorario" data-toggle="modal"><i class="fa fa-edit"></i> Actualizar horarios</button>
                                             </div>
                                         </div>
                                         <div class="row">
                                             <div class="col-lg-6">
                                                 <div class="card">
                                                     <div class="card-body">
                                                         <div class="row">
                                                             <div class="col-lg-7">
                                                                 <h4 class="card-title">Entrada </h4>
                                                                 <h6 class="card-subtitle">Hora de entrada de Lunes a Viernes</h6>
                                                             </div>
                                                             <div class="col-lg-5">
                                                                 <h2 class="card-title text-info" id="entradaLV_data">##:##</h2>
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
                                                                 <h4 class="card-title">Salida</h4>
                                                                 <h6 class="card-subtitle">Hora de salida de Lunes a Viernes</h6>
                                                             </div>
                                                             <div class="col-lg-5">
                                                                 <h2 class="card-title text-info" id="salidaLV_data">##:##</h2>
                                                             </div>
                                                         </div>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>

                                         <div class="row mt-4">
                                             <div class="col-lg-6">
                                                 <div class="card">
                                                     <div class="card-body">
                                                         <div class="row">
                                                             <div class="col-lg-7">
                                                                 <h4 class="card-title">Entrada del Sábado </h4>
                                                                 <h6 class="card-subtitle">Hora de entrada del Sábado</h6>
                                                             </div>
                                                             <div class="col-lg-5">
                                                                 <h2 class="card-title text-info" id="entradaS_data">##:##</h2>
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
                                                                 <h4 class="card-title">Salida del Sábado</h4>
                                                                 <h6 class="card-subtitle">Hora de salida  del Sábado</h6>
                                                             </div>
                                                             <div class="col-lg-5">
                                                                 <h2 class="card-title text-info" id="salidaS_data">##:##</h2>
                                                             </div>
                                                         </div>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>

                                         <div class="row mt-4">
                                             <div class="col-lg-6">
                                                 <div class="card">
                                                     <div class="card-body">
                                                         <div class="row">
                                                             <div class="col-lg-7">
                                                                 <h4 class="card-title">Entrada de la Hora Extra</h4>
                                                                 <h6 class="card-subtitle">Hora de entrada de la Hora Extra</h6>
                                                             </div>
                                                             <div class="col-lg-5">
                                                                 <h2 class="card-title text-info" id="entradaE_data">##:##</h2>
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
                                                                 <h4 class="card-title">Salida de la Hora Extra</h4>
                                                                 <h6 class="card-subtitle">Hora de salida de la Hora Extra</h6>
                                                             </div>
                                                             <div class="col-lg-5">
                                                                 <h2 class="card-title text-info" id="salidaE_data">##:##</h2>
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
                                                         <div class="row">
                                                             <div class="col-lg-7">
                                                                 <h4 class="card-title">Entrada de Obra </h4>
                                                                 <h6 class="card-subtitle">Hora de entrada de Lunes a viernes de la obra</h6>
                                                             </div>
                                                             <div class="col-lg-5">
                                                                 <h2 class="card-title text-info" id="entrada_obra_data">##:##</h2>
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
                                                                 <h4 class="card-title">Salida de Obra</h4>
                                                                 <h6 class="card-subtitle">Hora de salida de Lunes a Viernes de la obra</h6>
                                                             </div>
                                                             <div class="col-lg-5">
                                                                 <h2 class="card-title text-info" id="salida_obra_data">##:##</h2>
                                                             </div>
                                                         </div>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>

                                     </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- /.modal General -->
         <div class="modal fade" id="modalConfiguracion" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Actualizar registro</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"> <span aria-hidden="true">&times;</span> </button>
                    </div>
                    <div class="modal-body">
                        <form name="formGeneral" id="formGeneral">
                            @csrf
                            <div class="form-group">
                                <label>IVA (%):</label>
                                <input class="form-control" type="number" id="ivaConfig" name="ivaConfig" min="1">
                            </div>
                            <div class="form-group">
                                <label>Mínimo de caja chica:</label>
                                <input class="form-control" type="number" id="cajaConfig" name="cajaConfig"  min="1">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
                        <button type="button" class="btn btn-success" onclick="actualizarGeneral()"><i class="fa fa-save"></i> Aceptar</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
         </div>

         <!-- /.modal Horario-->
          <div class="modal fade" id="modalConfiguracionHorario" role="dialog" aria-hidden="true">
             <div class="modal-dialog" role="document">
                 <div class="modal-content">
                     <div class="modal-header">
                         <h4 class="modal-title">Actualizar horarios</h4>
                         <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"> <span aria-hidden="true">&times;</span> </button>
                     </div>
                     <div class="modal-body">
                         <form id="formHorario" name="formHorario">
                             @csrf
                             <h4>Horario de Lunes a Viernes</h4>
                             <div class="row">
                                 <div class="form-group col-lg-6">
                                     <label>Entrada:</label>
                                     <div class="input-group clockpicker-bottom">
                                           <input type="text" class="form-control" value="00:00" id="entrada_LV" name="entrada_LV"> <span class="input-group-addon"> <span class="fa fa-clock-o"></span> </span>
                                      </div>
                                 </div>
                                 <div class="form-group col-lg-6">
                                     <label>Salida:</label>
                                     <div class="input-group clockpicker-bottom">
                                           <input type="text" class="form-control" value="00:00" id="salida_LV" name="salida_LV"> <span class="input-group-addon"> <span class="fa fa-clock-o"></span> </span>
                                      </div>
                                 </div>
                             </div>

                             <h4>Horario del Sábado</h4>
                             <div class="row">
                                 <div class="form-group col-lg-6">
                                     <label>Entrada:</label>
                                     <div class="input-group clockpicker-top">
                                           <input type="text" class="form-control" value="00:00" id="entrada_S" name="entrada_S"> <span class="input-group-addon"> <span class="fa fa-clock-o"></span> </span>
                                      </div>
                                 </div>
                                 <div class="form-group col-lg-6">
                                     <label>Salida:</label>
                                     <div class="input-group clockpicker-top">
                                           <input type="text" class="form-control" value="00:00" id="salida_S" name="salida_S"> <span class="input-group-addon"> <span class="fa fa-clock-o"></span> </span>
                                      </div>
                                 </div>
                             </div>

                             <h4>Hora Extra</h4>
                             <div class="row">
                                 <div class="form-group col-lg-6">
                                     <label>Entrada:</label>
                                     <div class="input-group clockpicker-top">
                                           <input type="text" class="form-control" value="00:00" id="entrada_E" name="entrada_E"> <span class="input-group-addon"> <span class="fa fa-clock-o"></span> </span>
                                      </div>
                                 </div>
                                 <div class="form-group col-lg-6">
                                     <label>Salida:</label>
                                     <div class="input-group clockpicker-top">
                                           <input type="text" class="form-control" value="00:00" id="salida_E" name="salida_E"> <span class="input-group-addon"> <span class="fa fa-clock-o"></span> </span>
                                      </div>
                                 </div>
                             </div>

                             <h4>Hora de Obra</h4>
                             <div class="row">
                                 <div class="form-group col-lg-6">
                                     <label>Entrada:</label>
                                     <div class="input-group clockpicker-top">
                                           <input type="text" class="form-control" value="00:00" id="entrada_obra" name="entrada_obra"> <span class="input-group-addon"> <span class="fa fa-clock-o"></span> </span>
                                      </div>
                                 </div>
                                 <div class="form-group col-lg-6">
                                     <label>Salida:</label>
                                     <div class="input-group clockpicker-top">
                                           <input type="text" class="form-control" value="00:00" id="salida_obra" name="salida_obra"> <span class="input-group-addon"> <span class="fa fa-clock-o"></span> </span>
                                      </div>
                                 </div>
                             </div>
                         </form>
                     </div>
                     <div class="modal-footer">
                         <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
                         <button type="button" class="btn btn-success" onclick="actualizarHorario()"><i class="fa fa-save"></i> Aceptar</button>
                     </div>
                 </div>
                 <!-- /.modal-content -->
             </div>
             <!-- /.modal-dialog -->
          </div>


        @section('footer')
        @parent
    </div>
@endsection
@endsection
@endsection
