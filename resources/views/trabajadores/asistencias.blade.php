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
					<div class="col-12">
		        <div class="card">
	            <div class="card-body">
								<input type="text" class="form-control d-none" id="token" name="_token" value="{{csrf_token()}}">
								<button type="button" class="btn waves-effect waves-light btn-primary float-right" id="btnGuardar">Guardar cambios</button>
                <h4 class="card-title">Asistencia</h4>
                <h6 class="card-subtitle">Lista de trabajadores</h6>
								<div id="fecha" name="fecha"></div>
		  					<div class="table-responsive m-t-40">
                <table id="asistenciaTrabajadores" name="asistenciaTrabajadores" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
													<th>Trabajador</th>
					                <th>Mañana</th>
													<th>Tarde</th>
													<th>Hora extra</th>
													<th>Acciones</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
													<th>Trabajador</th>
                          <th>Mañana</th>
													<th>Tarde</th>
													<th>Hora extra</th>
													<th>Acciones</th>
                        </tr>
                    </tfoot>
                    <tbody>
											<!-- Se agrega en asistencias.js -->
                		</tbody>
            		</table>
              	</div>
              </div>
            </div>
          </div>
      	</div>
			</div>
		</div>

		<!-- MODAL AGREGAR HORAS -->
		<div id="modalHoras" name="modalHoras" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title">Agregar horas</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          </div>
          <div class="modal-body">
            <form>
							<div class="row">
									<div class="form-group col-lg-6">
											<label>Llegada:</label>
											<div class="input-group clockpicker-bottom">
														<input type="text" class="form-control" value="00:00" id="hora_llegadaMañana" name="hora_llegadaMañana"> <span class="input-group-addon"> <span class="fa fa-clock-o"></span> </span>
											 </div>
									</div>
									<div class="form-group col-lg-6">
											<label>Salida:</label>
											<div class="input-group clockpicker-bottom">
														<input type="text" class="form-control" value="00:00" id="hora_llegadaTarde" name="hora_llegadaTarde"> <span class="input-group-addon"> <span class="fa fa-clock-o"></span> </span>
											 </div>
									</div>
							</div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-danger waves-effect waves-light">Save changes</button>
          </div>
        </div>
      </div>
    </div>
		<!-- /.MODAL AGREGAR HORAS -->
		@section('footer')
		@parent
		<script src="{{asset('modulos/asistencias.js')}}"></script>
	</div>
@endsection
@endsection
@endsection
