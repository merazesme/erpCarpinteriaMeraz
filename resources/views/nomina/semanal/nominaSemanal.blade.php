@extends('footer')
@extends('sidebar')
@extends('header')
@extends('nomina/semanal/modal')

@section('header')
@parent

<style media="screen">
	.deshabilitado {
		border: none;
    background-color: white;
	}
	.form-control:disabled {
		background-color: white;
	}
	.errorPrestamo {
		border-color: red !important;
	}
</style>
	<div id="main-wrapper">
		@section('sidebar')
		@parent
		<div class="page-wrapper">
			<div class="container-fluid">
				<div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
								<h4 class="card-title">{{ $modulo }}</h4>
								<br>
								<!-- Nav tabs -->
								<ul class="nav nav-tabs" role="tablist">
										<li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home" role="tab"><span class="hidden-sm-up"><i class="ti-notepad"></i></span> <span class="hidden-xs-down">Semanal</span></a> </li>
										<li class="nav-item" id="historial"> <a class="nav-link" data-toggle="tab" href="#profile" role="tab"><span class="hidden-sm-up"><i class="ti-layers"></i></span> <span class="hidden-xs-down">Historial</span></a> </li>
								</ul>
								<!-- Tab panes -->
								<div class="tab-content tabcontent-border">
										<div class="tab-pane active" id="home" role="tabpanel">
											<div class="p-20">
												<div class="text-center" id="btnGenerar">

												</div>
												<br>
												<span id="guardar">

												</span>
												<span class="text-center">
													<h5 id="semanas"></h5>
													<h5 id="rango-semana"></h5>
												</span>
												<div class="table-responsive m-t-40 tabla" >

												</div>
											</div>
										</div>
										<div class="tab-pane  p-20" id="profile" role="tabpanel">
											<div class="table-responsive m-t-20 tablaHistorial">

											</div>
										</div>
								</div>
              </div>
            </div>
          </div>
      	</div>
			</div>
		</div>

		<!-- Se importa el modal -->
		@section('modal')
		@parent
		@stop

		@section('footer')
		@parent
			@section('java')
		<script src="{{asset('plugins/toast-master/js/jquery.toast.js')}}"></script>
		<script src="{{asset('js/toastr2.js')}}"></script>
		<script src="{{asset('plugins/sweetalert/sweetalert_2/sweetalert2.all.min.js')}}"></script>
		<script type="text/javascript">
				// Funcion que regresa la semana del año de la fecha actual
				Date.prototype.getWeekNumber = function () {
						var d = new Date(+this);  //Creamos un nuevo Date con la fecha de "this".
						d.setHours(0, 0, 0, 0);   //Nos aseguramos de limpiar la hora.
						d.setDate(d.getDate() + 4 - (d.getDay() || 7)); // Recorremos los días para asegurarnos de estar "dentro de la semana"
						//Finalmente, calculamos redondeando y ajustando por la naturaleza de los números en JS:
						return Math.ceil((((d - new Date(d.getFullYear(), 0, 1)) / 8.64e7) + 1) / 7);
				};
				var numSemana = new Date().getWeekNumber(); // Resultado
				// var numSemana = 30; // Resultado
				//var numSemana = 30; // Resultado
				var tipo = 'semanal';
		</script>
		<script src="{{asset('modulos/nomina/nomina_semanal_index.js')}}"></script>
		<script src="{{asset('modulos/nomina/nomina_semanal.js')}}"></script>
		<script src="{{asset('modulos/nomina/nomina_index.js')}}"></script>
	@stop
@endsection
@endsection
@endsection
