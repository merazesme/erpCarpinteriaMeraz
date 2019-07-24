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
			                        <form action="#" class="validation-wizard wizard-circle">
			                            <!-- Datos Generales -->
			                            <h6>Datos Generales</h6>
			                            <section>
			                                <div class="row">
			                                    <div class="col-md-12">
			                                        <div class="form-group">
			                                            <label for="nombre">Cliente: <span class="danger">*</span></label>
			                                            <select class="select2 form-control custom-select" style="width: 100%; height:36px;">
						                                    <option>Selecciona un cliente</option>
					                                        <option value="AK">Alaska</option>
					                                        <option value="HI">Hawaii</option>
					                                        <option value="CA">California</option>
					                                        <option value="NV">Nevada</option>
					                                        <option value="OR">Oregon</option>
					                                        <option value="WA">Washington</option>
						                                </select>
													</div>
			                                    </div>
			                                </div>
			                                <div class="row">
			                                    <div class="col-md-12">
			                                        <div class="form-group">
														<label for="descripcion">Descripción: <span class="danger">*</span> </label>
														<textarea class="form-control required" id="descripcion" name="descripcion"></textarea>
													</div>
			                                    </div>
			                                </div>
			                            </section>
			                            <!-- Datos Productos -->
			                            <h6>Productos</h6>
			                            <section>
			                            	<div class="row">
			                            		<div class="col-lg-6">
			                            			<div class="form-group">
			                                            <label for="producto">Producto: <span class="danger">*</span></label>
			                                            <select class="select2 form-control custom-select" style="width: 100%; height:36px;">
						                                    <option>Selecciona un producto</option>
					                                        <option value="AK">Alaska</option>
					                                        <option value="HI">Hawaii</option>
					                                        <option value="CA">California</option>
					                                        <option value="NV">Nevada</option>
					                                        <option value="OR">Oregon</option>
					                                        <option value="WA">Washington</option>
						                                </select>
													</div>
			                            		</div>
			                            		<div class="col-lg-6">
			                            			<div class="form-group">
			                                            <label for="producto">Cantidad: <span class="danger">*</span></label>
						                                <input type="number" class="form-control required" id="cantidad" name="cantidad" min="1">
													</div>
			                            		</div>
			                            	</div>
			                            	<div class="row">
			                                    <div class="col-md-12">
			                                        <div class="form-group">
														<label for="descripcion">Descripción: <span class="danger">*</span> </label>
														<textarea class="form-control required" id="descripcion" name="descripcion"></textarea>
													</div>
			                                    </div>
			                                </div>
			                                <div class="row">
			                                    <div class="col-md-12">
			                                    	<button class="float-right btn waves-effect waves-light btn-info" type="button">Agregar Producto</button>
		                                    	</div>
			                                </div>
			                                <hr>
			                            	<div class="row mt-5">
			                            		<div class="col-lg-12">
			                            			<h4>Productos</h4>
			                            			<table class="table table-hover">
								                      <thead>
								                        <tr>
								                          <th scope="col">Producto</th>
								                          <th scope="col">Descripción</th>
								                          <th scope="col">Material</th>
								                          <th scope="col">Subtotal</th>
								                          <th scope="col">IVA</th>
								                          <th scope="col">Total</th>
								                          <th scope="col"></th>
								                        </tr>
								                      </thead>
								                      <tbody>
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
		@section('footer')
		@parent
	</div>
@endsection
@endsection
@endsection
@endsection
