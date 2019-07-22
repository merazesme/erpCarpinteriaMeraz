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
	                        <form action="#" id="formularioTrabajador" class="validation-wizard wizard-circle">
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
																							<input type="tel" class="form-control required" id="celular" name="celular">
																					</div>
	                                    </div>
	                                    <div class="col-md-6">
	                                        <div class="form-group">
	                                            <label for="numero_alternativo">Número alternativo: <span class="danger">*</span> </label>
	                                            <input type="tel" class="form-control required" id="numero_alternativo" name="numero_alternativo">
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
							                                </select>
					                                </div>
	                                    </div>
																	</div>
																	<div class="row">
																    <div class="col-md-6">
																        <div class="form-group">
																						<label for="escolaridad">Escolaridad: </label>
																						<input type="text" class="form-control" id="escolaridad" name="escolaridad">
																        </div>
																    </div>
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
																						<input type="text" class="form-control required" id="NSS" name="NSS">
																        </div>
																    </div>
																    <div class="col-md-6">
																        <div class="form-group">
																            <label for="infonavit">Infonavit: <span class="danger">*</span> </label>
																            <input type="text" class="form-control required" id="infonavit" name="infonavit">
																        </div>
																    </div>
																	</div>
																	<div class="row">
																		<div class="col-md-6">
																				<div class="form-group">
																						<label for="numero_credencial">Número de Credencial: <span class="danger">*</span> </label>
																						<input type="text" class="form-control required" id="numero_credencial" name="numero_credencial">
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
																									<input id="temporal" name="temporal" type="radio" checked="" class="custom-control-input">
																									<span class="custom-control-indicator"></span>
																									<span class="custom-control-description">Temporal</span>
																							</label>
																							<label class="custom-control custom-radio">
																									<input id="base" name="base" type="radio" class="custom-control-input">
																									<span class="custom-control-indicator"></span>
																									<span class="custom-control-description">Base</span>
																							</label>
																					</div>
																			</div>
																	</div>
																	<div class="row">
	                                    <div class="col-md-6">
	                                        <div class="form-group">
																							<label for="fecha_inicio">Fecha de inicio: <span class="danger">*</span> </label>
																							<input type="date" class="form-control required" id="fecha_inicio" name="Fecha_inicio">
	                                        </div>
	                                    </div>
																			<div class="col-md-6">
	                                        <div class="form-group">
																							<label for="fecha_final">Fecha final: <span class="danger">*</span> </label>
																							<input type="date" class="form-control required" id="fecha_final" name="Fecha_final">
	                                        </div>
	                                    </div>
																	</div>
																	<div class="row">
																    <div class="col-md-6">
																        <div class="form-group">
																						<label for="sueldo">Sueldo: <span class="danger">*</span> </label>
																						<input type="text" class="form-control required" id="sueldo" name="Sueldo">
																        </div>
																    </div>
																	</div>
	                            </section>
															<div class="modal-footer">
							                    <button type="button" id="agregarTrabajador" class="btn btn-info waves-effect">Aceptar</button>
							                </div>
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
		<script>
    jQuery(document).ready(function() {
        // Switchery
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        $('.js-switch').each(function() {
            new Switchery($(this)[0], $(this).data());
        });
        // For select 2
        $(".select2").select2();
        $('.selectpicker').selectpicker();
        //Bootstrap-TouchSpin
        $(".vertical-spin").TouchSpin({
            verticalbuttons: true,
            verticalupclass: 'ti-plus',
            verticaldownclass: 'ti-minus'
        });
        var vspinTrue = $(".vertical-spin").TouchSpin({
            verticalbuttons: true
        });
        if (vspinTrue) {
            $('.vertical-spin').prev('.bootstrap-touchspin-prefix').remove();
        }
        $("input[name='tch1']").TouchSpin({
            min: 0,
            max: 100,
            step: 0.1,
            decimals: 2,
            boostat: 5,
            maxboostedstep: 10,
            postfix: '%'
        });
        $("input[name='tch2']").TouchSpin({
            min: -1000000000,
            max: 1000000000,
            stepinterval: 50,
            maxboostedstep: 10000000,
            prefix: '$'
        });
        $("input[name='tch3']").TouchSpin();
        $("input[name='tch3_22']").TouchSpin({
            initval: 40
        });
        $("input[name='tch5']").TouchSpin({
            prefix: "pre",
            postfix: "post"
        });
    });
    </script>
	</div>
@endsection
@endsection
@endsection
