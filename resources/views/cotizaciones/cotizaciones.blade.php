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
		                      <a  class="btn waves-effect waves-light btn-primary float-right" href="/cotizaciones/nueva"> <i class="fa fa-plus"></i> Generar cotización</a>
		                      <h4 class="card-title">Lista de Cotizaciones</h4>
		                      <div class="table-responsive m-t-40">
		                          <table id="cotizaciones" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
		                              <thead>
		                                  <tr>
											  <th>Fechas</th>
		                                      <th>Descripción</th>
		                                      <th>Estado</th>
		                                      <th>Cliente</th>
											  <th>Precio</th>
											  <th>Prioridad</th>
											  <th></th>
		                                  </tr>
		                              </thead>
		                              <tfoot>
		                                  <tr>
											  <th>Fechas</th>
		                                      <th>Descripción</th>
		                                      <th>Estado</th>
		                                      <th>Cliente</th>
		                                      <th>Precio</th>
											  <th>Prioridad</th>
											  <th></th>
		                                  </tr>
		                              </tfoot>
		                              <tbody>
		                                  <tr>
											  <td>03-Agosto-19</td>
		                                      <td>Ropero de madera de roble</td>
		                                      <td><span class="badge badge-success">Aceptada</span></td>
		                                      <td>Itzel Rendón</td>
		                                      <td>$xx,xxx.xx</td>
											  <td><span class="badge badge-pill badge-primary">Alta</span></td>
											  <td class="text-nowrap">
			                                      <a href="/modificarCotizacion" data-toggle="tooltip" data-original-title="Editar"> <i class="icon-pencil text-inverse m-r-10"></i></a>
			                                      <a class="eliminarCotizacion" href="#" data-toggle="tooltip" data-original-title="Borrar"> <i class="icon-close text-danger m-r-10"></i> </a>
			                                      <span data-toggle="modal" data-target="#modalCotizacion">
		                                          	<a class="detalleCotizacion" href="#" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye m-r-10"></i> </a>
		                                         </span>
												 <a class="cambiarEstado" href="#" data-toggle="tooltip" data-original-title="Cambiar Estado"> <i class="text-primary icon-note"></i> </a>
		                                  	  </td>
		                                  </tr>
		                                   <tr>
											  <td>03-Agosto-19</td>
		                                      <td>Puerta de recámara</td>
		                                      <td><span class="badge badge-danger">Rechazada</span></td>
		                                      <td>Itzel Rendón</td>
		                                      <td>$xx,xxx.xx</td>
											  <td><span class="badge badge-pill badge-info">Media</span></td>
		                                      <td class="text-nowrap">
		                                        <a href="/modificarCotizacion" data-toggle="tooltip" data-original-title="Editar"> <i class="icon-pencil text-inverse m-r-10"></i> </a>
												<a class="eliminarCotizacion" href="#" data-toggle="tooltip" data-original-title="Borrar"> <i class="icon-close text-danger m-r-10"></i> </a>
		                                        <span data-toggle="modal" data-target="#modalCotizacion">
		                                          <a class="detalleCotizacion" href="#" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye m-r-10"></i> </a>
		                                        </span>
												<a class="cambiarEstado" href="#" data-toggle="tooltip" data-original-title="Cambiar Estado"> <i class="text-primary icon-note"></i> </a>
		                                      </td>
		                                  </tr>
		                                   <tr>
											  <td>03-Agosto-19</td>
		                                      <td>Escritorio largo de 1.20 mts</td>
		                                      <td><span class="badge badge-warning">En taller</span></td>
		                                      <td>Itzel Rendón</td>
		                                      <td>$xx,xxx.xx</td>
											  <td><span class="badge badge-pill badge-inverse">Baja</span></td>
		                                      <td class="text-nowrap">
		                                        <a href="/modificarCotizacion" data-toggle="tooltip" data-original-title="Editar"> <i class="icon-pencil text-inverse m-r-10"></i> </a>
		                                        <a class="eliminarCotizacion" href="#" data-toggle="tooltip" data-original-title="Borrar"> <i class="icon-close text-danger m-r-10"></i> </a>
		                                        <span data-toggle="modal" data-target="#modalCotizacion">
		                                          <a class="detalleCotizacion" href="#" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye m-r-10"></i></a>
		                                        </span>
												<a class="cambiarEstado" href="#" data-toggle="tooltip" data-original-title="Cambiar Estado"> <i class="text-primary icon-note"></i> </a>
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
	    <!-- Modal de info extra -->
	    <div id="modalCotizacion" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	        <div class="modal-dialog modal-lg">
	            <div class="modal-content">
	                <div class="modal-header">
	                    <h4 class="modal-title" id="myModalLabel">Detalles de la cotización</h4>
	                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	                </div>
	                <div class="modal-body">
	                    <h4>Cotizacion</h4>
						<table class="table table-hover" id="tablaDetalleCotizacion">
	                      <thead>
	                        <tr>
							  <th scope="col">Cantidad</th>
	                          <th scope="col">Producto</th>
	                          <th scope="col">Descripción</th>
	                          <th scope="col">Material</th>
	                          <th scope="col">Subtotal</th>
	                          <th scope="col">IVA</th>
	                          <th scope="col">Total</th>
	                        </tr>
	                      </thead>
	                      <tbody>
	                        <tr>
							  <td>1</td>
	                          <td>Ropero de madera de roble</td>
	                          <td>Pintura obscura, decorado...</td>
	                          <td>
	                            <ul>
	                              <li>Madera</li>
	                              <li>Clavos</li>
	                              <li>Pegamento</li>
	                            </ul>
	                          </td>
	                          <td>$4,900</td>
	                          <td>$1,600</td>
	                          <td>$6,500</td>
	                        </tr>
	                        <tr>
							  <td>1</td>
	                          <td>Ropero de madera de roble</td>
	                          <td>Pintura obscura, decorado...</td>
	                          <td>
	                            <ul>
	                              <li>Madera</li>
	                              <li>Clavos</li>
	                              <li>Pegamento</li>
	                            </ul>
	                          </td>
	                          <td>$4,900</td>
	                          <td>$1,600</td>
	                          <td>$6,500</td>
	                        </tr>
	                        <tr>
							  <td>1</td>
	                          <td>Ropero de madera de roble</td>
	                          <td>Pintura obscura, decorado...</td>
	                          <td>
	                            <ul>
	                              <li>Madera</li>
	                              <li>Clavos</li>
	                              <li>Pegamento</li>
	                            </ul>
	                          </td>
	                          <td>$4,900</td>
	                          <td>$1,600</td>
	                          <td>$6,500</td>
	                        </tr>
	                      </tbody>
	                    </table>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Aceptar</button>
	                </div>
	            </div>
	        </div>
	    </div>
	    <!-- Fin modal info extra  -->
	</div>
		@section('footer')
		@parent
@endsection
@endsection
@endsection
