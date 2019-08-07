@extends('footer')
@extends('sidebar')
@extends('header')

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
                      <!-- <h6 class="card-subtitle">Lista de Clientes</h6> -->
											<a id="regresar"  href="{{ URL::previous() }}" role="button" class="btn waves-effect waves-light btn-primary float-right"><i class="fa fa-mail-reply"></i> Regresar</a>
                      <h4 class="card-title">{{ $modulo }}</h4>
											<br><br>
											<span class="text-center">
												<h5 id="anio"></h5>
											</span>
											<span class="text-center" id="errorSemana">

											</span>
                      <div class="table-responsive m-t-40 tabla">

                      </div>
                  </div>
              </div>
          </div>
        </div>
			</div>
		</div>


		@section('footer')
		@parent
			@section('java')
				<script src="{{asset('plugins/toast-master/js/jquery.toast.js')}}"></script>
				<script src="{{asset('js/toastr2.js')}}"></script>
				<script type="text/javascript">
					var anio = <?php echo "'".$anios."'" ?>;
          var tipo = 'vacacional';
				</script>
				<script src="{{asset('modulos/nomina/nomina_vacacional_detalle.js')}}"></script>
        <script src="{{asset('modulos/nomina/nomina_index.js')}}"></script>
		@stop
@endsection
@endsection
@endsection
