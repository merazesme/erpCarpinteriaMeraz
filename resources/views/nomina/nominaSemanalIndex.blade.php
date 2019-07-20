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
                      <h4 class="card-title">Historial nómina semanal</h4>
                      <div class="table-responsive m-t-20" >
                          <table id="myTable" class="table table-bordered table-striped">
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
                                  <tr>
                                      <td>2</td>
                                      <td><i class="fa fa-clock-o"></i> 19/07/2019</td>
                                      <td>Paola Cardenas</td>
                                      <td class="text-nowrap">
                                        <button type="button" class="btn waves-effect waves-light btn-xs btn-info">Excel</button>
                                        <button type="button" class="btn waves-effect waves-light btn-xs btn-info">PDF</button>
                                        <button type="button" class="btn waves-effect waves-light btn-xs btn-info">Printf</button>
                                        <a href="#" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye "></i> </a>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td>3</td>
                                      <td><i class="fa fa-clock-o"></i> 23/07/2019</td>
                                      <td>Paola Cardenas</td>
                                      <td class="text-nowrap">
                                        <button type="button" class="btn waves-effect waves-light btn-xs btn-info">Excel</button>
                                        <button type="button" class="btn waves-effect waves-light btn-xs btn-info">PDF</button>
                                        <button type="button" class="btn waves-effect waves-light btn-xs btn-info">Printf</button>
                                        <a href="#" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye "></i> </a>
                                      </td>
                                  </tr>
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
		<script>
    $(document).ready(function() {
				$('#myTable').DataTable();
    });
    </script>
	</div>
@endsection
@endsection
@endsection
