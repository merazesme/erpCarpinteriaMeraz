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
			                            <!-- Datos Personales -->
			                            <h6>Datos Personales</h6>
			                            <section>
			                                <div class="row">
			                                    <div class="col-md-6">
			                                        <div class="form-group">
			                                            <label for="nombre">Nombre(s): <span class="danger">*</span> </label>
			                                            <input type="text" class="form-control required" id="nombre" name="Nombre">
																							</div>
			                                    </div>
			                                    <div class="col-md-6">
			                                        <div class="form-group">
			                                            <label for="apellidos">Apellidos: <span class="danger">*</span> </label>
			                                            <input type="text" class="form-control required" id="apellidos" name="Apellidos">
																							</div>
			                                    </div>
			                                </div>
			                                <div class="row">
			                                    <div class="col-md-6">
			                                        <div class="form-group">
															<label for="celular">Email: <span class="danger">*</span> </label>
															<input type="email" class="form-control required" id="email" name="email">
													</div>
			                                    </div>
			                                    <div class="col-md-6">
			                                        <div class="form-group">
			                                            <label for="numero_alternativo">Teléfono: <span class="danger">*</span> </label>
			                                            <input type="tel" class="form-control required" id="telefono" name="telefono">
													</div>
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
