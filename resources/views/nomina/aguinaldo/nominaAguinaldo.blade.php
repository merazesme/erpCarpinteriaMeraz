@extends('footer')
@extends('sidebar')
@extends('header')

@section('header')
@parent
<link href="{{asset('plugins/toast-master/css/jquery.toast.css')}}" rel="stylesheet">

<style media="screen">
	.hola {
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
								<h4 class="card-title">{{ $modulo }}</h4>
								<br>
								<ul class="nav nav-tabs customtab2" role="tablist">
										<li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home7" role="tab"><span class="hidden-sm-up"><i class="ti-notepad"></i></span> <span class="hidden-xs-down">Aguinaldo</span></a> </li>
										<li class="nav-item" id="historial"> <a class="nav-link" data-toggle="tab" href="#profile7" role="tab"><span class="hidden-sm-up"><i class="ti-layers"></i></span> <span class="hidden-xs-down">Historial</span></a> </li>
								</ul>
									<!-- Tab panes -->
									<div class="tab-content">
										<div class="tab-pane active" id="home7" role="tabpanel">
											<div class="p-20">
												<div class="text-center" id="btnGenerar">

												</div>
												<br>
												<span id="guardar">

												</span>
												<span class="text-center">
													<h5 id="anio-aguinaldo"></h5>
												</span>
												<div class="table-responsive m-t-40 tabla" >

												</div>
											</div>
										</div>
										<div class="tab-pane   p-20" id="profile7" role="tabpanel">
											<div class="table-responsive m-t-20 tablaHistorial">
                        <!--<table id="myTable" class="table table-bordered table-striped">
                          <thead>
                              <tr>
                                <th>No. de nomina</th>
                                <th>Fecha</th>
																<th>Elaborada por</th>
                                <th>Acciones</th>
                              </tr>
                          </thead>
													<tfoot>
														<tr>
                              <th>No. de nomina</th>
                              <th>Fecha</th>
                              <th>Elaborada por</th>
                              <th>Acciones</th>
														</tr>
                          </tfoot>
                          <tbody>
                            <tr>
                              <td>1</td>
                              <td><i class="fa fa-clock-o"></i> 12/07/2019</td>
                              <td>Paola Cardenas</td>
                              <td class="text-nowrap">
                                <button type="button" class="btn waves-effect waves-light btn-xs btn-info">Excel</button>
                                <button type="button" class="btn waves-effect waves-light btn-xs btn-info">PDF</button>
                                <button type="button" class="btn waves-effect waves-light btn-xs btn-info">Printf</button>
                                <a href="#" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye "></i> </a>
                              </td>
                            </tr>

                          </tbody>
                        </table>-->
                      </div>
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
			@section('java')
		<script src="{{asset('plugins/toast-master/js/jquery.toast.js')}}"></script>
		<script src="{{asset('js/toastr2.js')}}"></script>
		<script type="text/javascript">
			var tipo = 'aguinaldo';
			var anio = new Date().getFullYear();
		  //var anio = '2020';
		</script>
		<script src="{{asset('modulos/nomina/nomina_aguinaldo.js')}}"></script>
		<script src="{{asset('modulos/nomina/nomina_index.js')}}"></script>
	@stop
@endsection
@endsection
@endsection
