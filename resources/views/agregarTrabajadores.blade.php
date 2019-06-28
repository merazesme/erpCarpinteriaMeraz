@extends('footer')
@extends('breadcrumbs')
@extends('sidebar')
@extends('header')

	<div id="main-wrapper">
		@section('header')
		@parent
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
																							<label for="celular">Celular: <span class="danger">*</span> </label>
																							<input type="tel" class="form-control required" id="celular" name="Celular">
																					</div>
	                                    </div>
	                                    <div class="col-md-6">
	                                        <div class="form-group">
	                                            <label for="numero_alternativo">Número alternativo: <span class="danger">*</span> </label>
	                                            <input type="tel" class="form-control required" id="numero_alternativo" name="Numero_alternativo">
																					</div>
	                                    </div>
	                                </div>
	                                <div class="row">
	                                    <div class="col-md-6">
	                                        <div class="form-group">
																						<label for="domicilio">Domicilio: <span class="danger">*</span> </label>
																						<input type="text" class="form-control required" id="domicilio" name="Domicilio">
	                                        </div>
	                                    </div>
	                                    <div class="col-md-6">
	                                        <div class="form-group">
																							<label for="estado_civil">Estado Civil: <span class="danger">*</span> </label>
																							<select class="custom-select form-control required" id="estado_civil" name="Estado_civil">
																									<option value=""></option>
																									<option value="Soltero">Soltero(a)</option>
																									<option value="Casado">Casado(a)</option>
																							</select>
																					</div>
	                                    </div>
	                                </div>
																	<div class="row">
	                                    <div class="col-md-6">
	                                        <div class="form-group">
																							<label for="fecha_nacimiento">Fecha de Nacimiento: <span class="danger">*</span> </label>
																							<input type="date" class="form-control required" id="fecha_nacimiento" name="Fecha_nacimiento">
	                                        </div>
	                                    </div>
	                                    <div class="col-md-6">
	                                        <div class="form-group">
	                                            <label for="lugar_nacimiento">Lugar de Nacimiento: <span class="danger">*</span> </label>
																							<select class="select2 form-control custom-select" style="width: 100%; height:36px;">
							                                    <option>Select</option>
							                                    <optgroup label="Alaskan/Hawaiian Time Zone">
							                                        <option value="AK">Alaska</option>
							                                        <option value="HI">Hawaii</option>
							                                    </optgroup>
							                                    <optgroup label="Pacific Time Zone">
							                                        <option value="CA">California</option>
							                                        <option value="NV">Nevada</option>
							                                        <option value="OR">Oregon</option>
							                                        <option value="WA">Washington</option>
							                                    </optgroup>
							                                    <optgroup label="Mountain Time Zone">
							                                        <option value="AZ">Arizona</option>
							                                        <option value="CO">Colorado</option>
							                                        <option value="ID">Idaho</option>
							                                        <option value="MT">Montana</option>
							                                        <option value="NE">Nebraska</option>
							                                        <option value="NM">New Mexico</option>
							                                        <option value="ND">North Dakota</option>
							                                        <option value="UT">Utah</option>
							                                        <option value="WY">Wyoming</option>
							                                    </optgroup>
							                                    <optgroup label="Central Time Zone">
							                                        <option value="AL">Alabama</option>
							                                        <option value="AR">Arkansas</option>
							                                        <option value="IL">Illinois</option>
							                                        <option value="IA">Iowa</option>
							                                        <option value="KS">Kansas</option>
							                                        <option value="KY">Kentucky</option>
							                                        <option value="LA">Louisiana</option>
							                                        <option value="MN">Minnesota</option>
							                                        <option value="MS">Mississippi</option>
							                                        <option value="MO">Missouri</option>
							                                        <option value="OK">Oklahoma</option>
							                                        <option value="SD">South Dakota</option>
							                                        <option value="TX">Texas</option>
							                                        <option value="TN">Tennessee</option>
							                                        <option value="WI">Wisconsin</option>
							                                    </optgroup>
							                                    <optgroup label="Eastern Time Zone">
							                                        <option value="CT">Connecticut</option>
							                                        <option value="DE">Delaware</option>
							                                        <option value="FL">Florida</option>
							                                        <option value="GA">Georgia</option>
							                                        <option value="IN">Indiana</option>
							                                        <option value="ME">Maine</option>
							                                        <option value="MD">Maryland</option>
							                                        <option value="MA">Massachusetts</option>
							                                        <option value="MI">Michigan</option>
							                                        <option value="NH">New Hampshire</option>
							                                        <option value="NJ">New Jersey</option>
							                                        <option value="NY">New York</option>
							                                        <option value="NC">North Carolina</option>
							                                        <option value="OH">Ohio</option>
							                                        <option value="PA">Pennsylvania</option>
							                                        <option value="RI">Rhode Island</option>
							                                        <option value="SC">South Carolina</option>
							                                        <option value="VT">Vermont</option>
							                                        <option value="VA">Virginia</option>
							                                        <option value="WV">West Virginia</option>
							                                    </optgroup>
							                                </select>
					                                </div>
	                                    </div>
																	</div>
																	<div class="row">
																    <div class="col-md-6">
																        <div class="form-group">
																						<label for="escolaridad">Escolaridad: </label>
																						<input type="text" class="form-control" id="escolaridad" name="Escolaridad">
																        </div>
																    </div>
																    <div class="col-md-6">
																        <div class="form-group">
																						<label for="apodo">Apodo: <span class="danger">*</span> </label>
																						<input type="text" class="form-control required" id="apodo" name="Apodo">
																        </div>
																    </div>
																	</div>
	                            </section>
	                            <!-- Datos Fiscales -->
	                            <h6>Datos Fiscales</h6>
	                            <section>
																	<div class="row">
																    <div class="col-md-6">
																        <div class="form-group">
																						<label for="nss">NSS: <span class="danger">*</span> </label>
																						<input type="text" class="form-control required" id="nss" name="NSS">
																        </div>
																    </div>
																    <div class="col-md-6">
																        <div class="form-group">
																            <label for="infonavit">Infonavit: <span class="danger">*</span> </label>
																            <input type="text" class="form-control required" id="infonavit" name="Infonavit">
																        </div>
																    </div>
																	</div>
																	<div class="row">
																		<div class="col-md-6">
																				<div class="form-group">
																						<label for="numero_credencial">Número de Credencial: <span class="danger">*</span> </label>
																						<input type="text" class="form-control required" id="numero_credencial" name="Numero_credencial">
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
