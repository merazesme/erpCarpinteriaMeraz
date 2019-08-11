@extends('footer')
@extends('breadcrumbs')
@extends('sidebar')
@extends('header')

@section('header')
@parent
	<div id="main-wrapper">
		@section('sidebar')
		@parent
		<div class="page-wrapper">
			<div class="container-fluid">
				@section('breadcrumbs')
				@parent
				<div class="card">
					<!-- Validation wizard -->
			        <div class="row" id="validation">
			            <div class="col-12">
			                <div class="card wizard-content">
			                    <div class="card-body">
									<div class="row">
										<div class="col-lg-12">
											<button type="button" name="button" class="btn btn-primary float-right" onclick="generarDoc()">Generar doc</button>
										</div>
									</div>
			                        <form action="#" class="validation-wizard wizard-circle">
			                            <!-- Datos Generales -->
			                            <h6>Datos Generales</h6>
			                            <section>
											<div class="row">
												<div class="col-md-6">
  												  <div class="form-group" id="divSelectCliente">
  													  <label for="selectCliente">Cliente: <span class="danger">*</span></label>
  													  <select class="select2 form-control custom-select" name="selectCliente" id="selectCliente">
  														  <option>Selecciona un cliente</option>
  													  </select>
  												  </div>
  											  </div>
											  <div class="col-md-6">
												  <div class="form-group">
													 <label for="selectPrioridad">Prioridad:<span class="danger">*</span></label>
													 <select class="custom-select form-control required" id="selectPrioridad" name="selectPrioridad" aria-required="true">
	                                                    <option value="">Selecciona una prioridad</option>
	                                                    <option value="3">Alta</option>
	                                                    <option value="2">Media</option>
	                                                    <option value="1">Baja</option>
	                                                 </select>
												  </div>
											  </div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<label for="fechaInicio">Fecha de inicio:</label>
													<input type="date" class="form-control required" id="fechaInicio" name="fechaInicio">
												</div>
												<div class="col-md-6">
													<label for="fechaFin">Fecha de terminación:</label>
													<input type="date" class="form-control required" id="fechaFin" name="fechaFin">
												</div>
											</div>
			                                <div class="row">
			                                    <div class="col-md-11">
			                                        <div class="form-group">
			                                            <label for="selectRecomendado">Recomendación:</label>
			                                            <select class="select2 form-control custom-select" name="selectRecomendado" id="selectRecomendado">
						                                    <option>Selecciona la persona que recomendó</option>
						                                </select>
													</div>
			                                    </div>
												<div class="col-md-1 d-flex">
													<button type="button" id="btnNuevoRecomendado" class="btn btn-success align-self-center"
													data-toggle="tooltip" data-original-title="Agregar nueva persona de recomendación"
													onclick="modalAccionRecomanedado('agregar')">
														<i class="fa fa-plus"></i>
													</button>
												</div>
			                                </div>
			                                <div class="row">
											   <div class="col-md-12">
												   <div class="form-group">
													   <label for="descripcion">Descripción: <span class="danger">*</span> </label>
													   <textarea rows="5" class="form-control required" id="descripcion" name="descripcion" aria-required="true"></textarea>
												   </div>
											   </div>
			                                </div>
			                            </section>
			                            <!-- Datos Productos -->
			                            <h6>Productos</h6>
			                            <section>
			                            	<div class="form-row">
			                            		<div class="col-md-9">
			                            			<div class="form-group">
			                                            <label for="selectProductos">Producto:</label>
			                                            <select class="select2 form-control custom-select" style="width:90%;" name="selectProductos" id="selectProductos">
						                                    <option>Selecciona un producto</option>
						                                </select>
														<button type="button" id="btnNuevoProducto" class="btn btn-success"
															data-toggle="tooltip" data-original-title="Agregar nuevo producto"
															onclick="modalAccionProducto('agregar')">
															<i class="fa fa-plus"></i>
														</button>
													</div>
			                            		</div>

			                            		<div class="col-md-3">
			                            			<div class="form-group">
			                                            <label for="producto">Cantidad:</label>
						                                <input type="number" class="form-control" id="cantidad" name="cantidad" min="1">
													</div>
			                            		</div>
			                            	</div>
			                            	<div class="row">
			                                    <div class="col-md-12">
			                                        <div class="form-group">
														<label for="descripcion">Descripción:</label>
														<textarea rows="5" class="form-control" id="descripcionP" name="descripcionP"></textarea>
													</div>
			                                    </div>
			                                </div>
			                                <div class="row">
			                                    <div class="col-md-12">
			                                    	<button class="float-right btn waves-effect waves-light btn-info" type="button" id="btnAgregarProducto" onclick="agregarProductoCotizacion()">Agregar Producto</button>
		                                    	</div>
			                                </div>
			                                <hr>
			                            	<div class="row mt-5">
			                            		<div class="col-lg-12">
													<div class="row">
														<div class="col-lg-6">
															<h3>Productos</h3>
														</div>
														<div class="col-lg-6">
															<h3 id="costoTotal" class="float-right text-success">$0.00</h3>
														</div>
													</div>
			                            			<table class="table table-hover" id="tablaProductos">
								                      <thead>
								                        <tr>
															<th scope="col">Cantidad</th>
															<th scope="col">Producto</th>
															<th scope="col">Descripción</th>
															<th scope="col">Materia Prima</th>
															<th scope="col">Subtotal</th>
															<th scope="col">IVA</th>
															<th scope="col">Total</th>
															<th scope="col" style="width: 10%;"></th>
								                        </tr>
								                      </thead>
								                      <tbody>
														<tr>
														  <td colspan="8">
															  No hay productos en la cotización...
														  </td>
														</tr>

														<!-- <tr>
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
															<td>
																<a href="#" data-toggle="tooltip" data-original-title="Editar"> <i class="icon-pencil text-inverse m-r-10"></i> </a>
																<a class="#" href="#" data-toggle="tooltip" data-original-title="Borrar"> <i class="icon-close text-danger m-r-10"></i> </a>
															</td>
														</tr>
														<tr>
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
															<td>
																<a href="#" data-toggle="tooltip" data-original-title="Editar"> <i class="icon-pencil text-inverse m-r-10"></i> </a>
																<a class="#" href="#" data-toggle="tooltip" data-original-title="Borrar"> <i class="icon-close text-danger m-r-10"></i> </a>
															</td>
														</tr>
														<tr>
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
															<td>
																<a href="#" data-toggle="tooltip" data-original-title="Editar"> <i class="icon-pencil text-inverse m-r-10"></i> </a>
																<a class="#" href="#" data-toggle="tooltip" data-original-title="Borrar"> <i class="icon-close text-danger m-r-10"></i> </a>
															</td>
														</tr> -->
								                      </tbody>
								                    </table>
			                            		</div>
			                            	</div>

			                            </section>
			                        </form>
			                    </div>
			                </div>
			            </div>
			        </div>
				</div>
			</div>
		</div>
		<!-- /.modal añadir recomendado -->
		 <div class="modal fade" id="modalRecomendado" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title-producto">Agregar nueva persona que recomendó</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"> <span aria-hidden="true">&times;</span> </button>
					</div>
					<div class="modal-body">
						<form name="formRecomendado" id="formRecomendado">
							@csrf
							<div class="form-group">
								<label>Nombre:</label>
								<input class="form-control" type="text" id="nombreReco" name="nombreReco">
							</div>
							<div class="form-group">
								<label>Porcentaje:</label>
								<input class="form-control" type="number" id="porcentajeReco" value="1" name="porcentajeReco"  min="1" max="100">
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
						<button type="button" id="botonModalRecomendado" class="btn btn-success" onclick="nuevoRecomendado()"><i class="fa fa-save"></i> Aceptar</button>
					</div>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		 </div>

		 <!-- /.modal añadir producto -->
 		 <div class="modal fade" id="modalProducto" tabindex="-1" role="dialog" aria-hidden="true">
 			<div class="modal-dialog" role="document">
 				<div class="modal-content">
 					<div class="modal-header">
 						<h4 class="modal-title">Agregar nuevo producto</h4>
 						<button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"> <span aria-hidden="true">&times;</span> </button>
 					</div>
 					<div class="modal-body">
 						<form name="formProducto" id="formProducto">
 							@csrf
 							<div class="form-group">
 								<label>Descripción:</label>
								<textarea rows="5" class="form-control" id="descripcionProducto" name="descripcionProducto"></textarea>
 							</div>
							<div class="row">
								<div class="form-group col-md-4">
									<label>Subtotal:</label>
									<input class="form-control" type="number" id="subtotalProducto" name="subtotalProducto"  min="1">
								</div>
								<div class="form-group col-md-4">
									<label>IVA:</label>
									<p class="text-muted" id="ivaProducto">$0.00</p>
								</div>
								<div class="form-group col-md-4">
									<label>Total:</label>
									<p class="text-muted" id="totalProducto">$0.00</p>
								</div>
							</div>
							<div class="row">
								<div class="form-group col-md-12">
									<h5>Materia Prima</h5>
									<select class="select2 form-control custom-select" multiple="multiple" name="selectMateriaPrima" id="selectMateriaPrima" style="width:100%;">
										<option value="1">Materia 1</option>
										<option value="2">Materia 2</option>
										<option value="3">Materia 3</option>
										<option value="4">Materia 4</option>
									</select>
								</div>
							</div>
 						</form>
 					</div>
 					<div class="modal-footer">
 						<button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
 						<button type="button" id="botonModalProducto" class="btn btn-success" onclick="nuevoProducto()"><i class="fa fa-save"></i> Aceptar</button>
 					</div>
 				</div>
 				<!-- /.modal-content -->
 			</div>
 			<!-- /.modal-dialog -->
 		 </div>

	</div>

	@section('footer')
	@parent

@endsection
@endsection
@endsection
@endsection
