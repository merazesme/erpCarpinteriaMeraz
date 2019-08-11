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
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
													<th>Trabajador</th>
                          <th>Mañana</th>
													<th>Tarde</th>
													<th>Hora extra</th>
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
		@section('footer')
		@parent
		<script src="{{asset('modulos/asistencias.js')}}"></script>
	</div>
@endsection
@endsection
@endsection
