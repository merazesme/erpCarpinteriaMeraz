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
				<div class="card">
					<!-- Validation wizard -->
	        <div class="row" id="validation">
	            <div class="col-12">
	                <div class="card wizard-content">
	                    <div class="card-body">
	                        <form id="formularioTrabajador" name="formularioTrabajador" class="validation-wizard wizard-circle">
														<input type="text" class="form-control d-none" id="token" name="_token" value="{{csrf_token()}}">
														<input type="text" class="form-control d-none" id="id_contrato" name="id_contrato">
	                            <!-- Datos Personales -->
	                            <h6>Datos Personales</h6>
	                            <section>
	                                <div class="row">
	                                    <div class="col-md-6">
	                                        <div class="form-group">
	                                            <label for="nombre">Nombre(s): <span class="danger">*</span> </label>
	                                            <input type="text" class="form-control required" id="nombre" name="nombre">
																					</div>
	                                    </div>
	                                    <div class="col-md-6">
	                                        <div class="form-group">
	                                            <label for="apellidos">Apellidos: <span class="danger">*</span> </label>
	                                            <input type="text" class="form-control required" id="apellidos" name="apellidos">
																					</div>
	                                    </div>
	                                </div>
	                                <div class="row">
	                                    <div class="col-md-6">
	                                        <div class="form-group">
																							<label for="celular">Celular: <span class="danger">*</span> </label>
																							<input type="tel" class="form-control required input-number" id="celular" name="celular">
																					</div>
	                                    </div>
	                                    <div class="col-md-6">
	                                        <div class="form-group">
	                                            <label for="numero_alternativo">Número alternativo: <span class="danger">*</span> </label>
	                                            <input type="tel" class="form-control required input-number" id="numero_alternativo" name="numero_alternativo">
																					</div>
	                                    </div>
	                                </div>
	                                <div class="row">
	                                    <div class="col-md-6">
	                                        <div class="form-group">
																						<label for="domicilio">Domicilio: <span class="danger">*</span> </label>
																						<input type="text" class="form-control required" id="domicilio" name="domicilio">
	                                        </div>
	                                    </div>
	                                    <div class="col-md-6">
	                                        <div class="form-group">
																							<label for="estado_civil">Estado Civil: <span class="danger">*</span> </label>
																							<select class="custom-select form-control required" id="estado_civil" name="estado_civil">
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
																							<input type="date" class="form-control required" id="fecha_nacimiento" name="fecha_nacimiento">
	                                        </div>
	                                    </div>
	                                    <div class="col-md-6">
																					<div class="form-group">
																							<label for="lugar_nacimiento">Lugar de Nacimiento: <span class="danger">*</span> </label>
																							<input type="text" class="form-control required" id="lugar_nacimiento" name="lugar_nacimiento">
																					</div>
	                                    </div>
																	</div>
																	<div class="row">
	                                    <div class="col-md-6">
																					<div class="form-group">
																							<label for="nacionalidad">Nacionalidad: <span class="danger">*</span> </label>
																							<input type="text" class="form-control required" id="nacionalidad" name="nacionalidad">
																					</div>
	                                    </div>
																			<div class="col-md-6">
																	        <div class="form-group">
																							<label for="escolaridad">Escolaridad: <span class="danger">*</span> </label>
																							<select class="custom-select form-control required" id="escolaridad" name="escolaridad">
																									<option value=""></option>
																									<option value="Primaria">Primaria</option>
																									<option value="Secundaria">Secundaria</option>
																									<option value="Educación Técnica">Educación Técnica</option>
																									<option value="Bachillerato">Bachillerato</option>
																									<option value="Licenciatura">Licenciatura</option>
																									<option value="Posgrado">Posgrado</option>
																									<option value="Sin estudios">Sin estudios</option>
																									<option value="Otro">Otro</option>
																							</select>
																	        </div>
																	    </div>
																	</div>
																	<div class="row">
																    <div class="col-md-6">
																        <div class="form-group">
																						<label for="apodo">Apodo: <span class="danger">*</span> </label>
																						<input type="text" class="form-control required" id="apodo" name="apodo">
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
																						<input type="text" class="form-control required input-number" id="NSS" name="NSS">
																        </div>
																    </div>
																    <div class="col-md-6">
																        <div class="form-group">
																            <label for="infonavit">Infonavit: <span class="danger">*</span> </label>
																            <input type="text" class="form-control required input-number" id="infonavit" name="infonavit">
																        </div>
																    </div>
																	</div>
																	<div class="row">
																		<div class="col-md-6">
																				<div class="form-group">
																						<label for="numero_credencial">Número de Credencial: <span class="danger">*</span> </label>
																						<input type="text" class="form-control required input-number" id="numero_credencial" name="numero_credencial">
																				</div>
																		</div>
																	</div>
	                            </section>
															<!-- Contrato -->
	                            <h6>Contrato</h6>
															<section>
																<br>
																<div class="row">
																	<label class="col-md-6">Tipo de contrato: <span class="danger">*</span> </label>
																			<div class="col-md-9">
																					<div class="radio-list">
																							<label class="custom-control custom-radio">
																									<input type="radio" id="tipo_temporal" name="tipo" value="Temporal" class="custom-control-input" onclick="tipoTrabajador(1)">
																									<span class="custom-control-indicator"></span>
																									<span class="custom-control-description">Temporal</span>
																							</label>
																							<label class="custom-control custom-radio">
																									<input type="radio" id="tipo_base" name="tipo" value="Base" class="custom-control-input" onclick="tipoTrabajador(2)">
																									<span class="custom-control-indicator"></span>
																									<span class="custom-control-description">Base</span>
																							</label>
																					</div>
																			</div>
																	</div>
																	<div class="row" id="fechas" name="fechas">
	                                    <!-- SE AGREGAN EN TRABAJADORES.JS -->
																	</div>
																	<div class="row">
																		<div class="col-md-6">
																        <div class="form-group">
																						<label for="puesto">Puesto: <span class="danger">*</span> </label>
																						<input type="text" class="form-control required" id="puesto" name="puesto">
																        </div>
																    </div>
																    <div class="col-md-6">
																        <div class="form-group">
																						<label for="sueldo">Sueldo: <span class="danger">*</span> </label>
																						<div class="input-group">
		                                            <span class="input-group-addon">$</span>
		                                            <span class="input-group-addon">0.00</span>
																								<input type="text" class="form-control required" id="sueldo" name="sueldo">
                                        		</div>
																        </div>
																    </div>
																	</div>
																	<div class="row">
																		<div class="col-md-4">
																        <div class="form-group">
																						<label for="hora_extra">Hora extra: <span class="danger">*</span> </label>
																						<div class="input-group">
		                                            <span class="input-group-addon">$</span>
		                                            <span class="input-group-addon">0.00</span>
		                                            <input type="text" class="form-control required" id="hora_extra" name="hora_extra">
                                        		</div>
																        </div>
																    </div>
																    <div class="col-md-4">
																        <div class="form-group">
																						<label for="bono_asistencia">Bono asistencia: <span class="danger">*</span> </label>
																						<div class="input-group">
		                                            <span class="input-group-addon">$</span>
		                                            <span class="input-group-addon">0.00</span>
																								<input type="text" class="form-control required" id="bono_asistencia" name="bono_asistencia">
                                        		</div>
																        </div>
																    </div>
																		<div class="col-md-4">
																        <div class="form-group">
																						<label for="bono_extra">Bono extra: <span class="danger">*</span> </label>
																						<div class="input-group">
		                                            <span class="input-group-addon">$</span>
		                                            <span class="input-group-addon">0.00</span>
																								<input type="text" class="form-control required" id="bono_extra" name="bono_extra">
                                        		</div>
																        </div>
																    </div>
																	</div>
																	<div class="row">
																    <div class="col-md-6">
																        <div class="form-group">
																						<label for="firma">Firma trabajador: <span class="danger">*</span> </label>
																						<input type="password" class="form-control required input-number" id="firma" name="firma">
																						<p id="validarFirma" style="color:red;">Es necesario que el trabajador ingrese una firma de 6 números.</p>
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
		<script src="{{asset('modulos/trabajadores.js')}}"></script>
	</div>
@endsection
@endsection
@endsection
