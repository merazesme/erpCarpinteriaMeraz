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
                      <!-- <h6 class="card-subtitle">Lista de Clientes</h6> -->
											<a id="regresar"  href="{{ URL::previous() }}" role="button" class="btn waves-effect waves-light btn-primary float-right"><i class="fa fa-mail-reply"></i> Regresar</a>
                      <h4 class="card-title">{{ $modulo }}</h4>
											<br><br>
											<span class="text-center">
												<h5 id="semanas"></h5>
												<h5 id="rango-semana"></h5>
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
				<script>
		    $(document).ready(function() {
						var numSemana = <?php echo $semana ?>;
						console.log(numSemana)

						$('#semanas').text(`Semana ${numSemana} del año`);
						var meses = ["enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"];
						/* Obtiene el primer y ultimo dia de la semana (objetos) numero 'x' de año
								https://es.stackoverflow.com/questions/7003/c%C3%B3mo-puedo-obtener-el-primer-y-ultimo-d%C3%ADa-de-una-semana-concreta-en-javascript
								https://momentjs.com/docs/#/displaying/as-object/
						*/
						var f_i = moment().isoWeek(numSemana).startOf("isoweek").toObject();
						var f_f = moment().isoWeek(numSemana).endOf("isoweek").toObject();
						//console.log( moment().isoWeek(numSemana).startOf("isoweek").format())
						var fechai = moment(f_i).toObject();
						var fechaf = moment(f_f).toObject();

						$('#rango-semana').text(`${fechai.date} de ${meses[fechai.months]} de ${fechai.years} al ${fechaf.date} de ${meses[fechai.months]} de ${fechaf.years}`);
						var nomina = [];
						$.ajax({
					    type: "GET",
					    dataType: "json",
					    url: base_url+'/nomina/nominaSemanal/detalleNomina/'+numSemana,
					    success: function (data) {
									console.log(data)
					        if(data['Error'])
					          swal("Error", "Ha ocurrido un error, inténtelo más tarde.", "error");
					        else {
											toastSuccess("Datos de nómina cargados exitosamente.");
					            nomina = data;
					            muestra();
										}
					    }, error: function(error) {
					        toastError();
					    }
					  });

						// Funcion que hace los calculos y genera las filas de la tabla
						function muestra() {
							var tamanio = nomina['detalleNomina'].length;
							var detalle = nomina['detalleNomina'];
							var html =
							 `<table id="demo-foo-accordion" class="table m-b-0 toggle-arrow-tiny">
									<thead>
											<tr>
													<th data-toggle="true" data-sort-ignore="true"> Nombre  </th>
													<th data-hide="phone"> Percepciones </th>
													<th data-hide="phone"> Deducciones </th>
													<th data-hide="phone"> Neto a pagar </th>
													<th data-hide="phone" class="text-center"> Acciones </th>
											</tr>
									</thead>
									<tbody>`;
							for(var x=0; x<tamanio; x++) {
								var conceptos = detalle[x].conceptos;
								var tamanioc =  detalle[x].conceptos.length;
								var deduccion = 0, percepcion = 0;
									for (var i = 0; i <tamanioc; i++) {
										if(conceptos[i].Tipo == 0)
											deduccion += conceptos[i].Monto;
										else
											percepcion += conceptos[i].Monto;
									}
									html += `<tr>
															<td>${detalle[x].Nombre} ${detalle[x].Apellidos}</td>
															<td>$${deduccion}</td>
															<td>$${percepcion}</td>
															<td>$${detalle[x].Cantidad}</td>
															<td class="text-center">
																	<span data-toggle="modal" data-target=".bs-example-modal-lg" data-body="pendientealv" data-posicion="${x}" class="modal-show">
																			<a data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye "></i> </a>
																	</span>
															</td>
													 </tr>`;
							}
							html += `<tbody>
									</table>`;
							$( ".tabla" ).append(html);
						}
		    });
		    </script>
		@stop
@endsection
@endsection
@endsection
