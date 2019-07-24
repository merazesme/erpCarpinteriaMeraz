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
																							<!-- <select id="lugar_nacimiento" name="lugar_nacimiento" class="select2 form-control custom-select select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
																									<option>Select</option>
																									<optgroup label="México">
																											<option value="Sinaloa">Sinaloa</option>
																											<option value="HI">Hawaii</option>
																									</optgroup>
																									<optgroup label="Pacific Time Zone">
																											<option value="CA">California</option>
																											<option value="NV">Nevada</option>
																											<option value="OR">Oregon</option>
																											<option value="WA">Washington</option>
																									</optgroup>
																							</select> -->
																					</div>
	                                    </div>
																	</div>
																	<div class="row">
																    <div class="col-md-6">
																        <div class="form-group">
																						<label for="escolaridad">Escolaridad: </label>
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
																									<input id="tipo" name="tipo" value="Temporal" type="radio" checked="" class="custom-control-input">
																									<span class="custom-control-indicator"></span>
																									<span class="custom-control-description">Temporal</span>
																							</label>
																							<label class="custom-control custom-radio">
																									<input id="tipo" name="tipo" value="Base" type="radio" class="custom-control-input">
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
																							<input type="date" class="form-control required" id="fecha_inicio" name="fecha_inicio">
	                                        </div>
	                                    </div>
																			<div class="col-md-6">
	                                        <div class="form-group">
																							<label for="fecha_final">Fecha final: <span class="danger">*</span> </label>
																							<input type="date" class="form-control required" id="fecha_final" name="fecha_final">
	                                        </div>
	                                    </div>
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
																						<input type="password" class="form-control required" id="firma" name="firma">
																						<p id="validarFirma" style="color:red;">Es necesario que el trabajador ingrese una firma de mínimo 8 caracteres.</p>
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
		<script>
		    /** Scripts */
		    function trabajador_actualizar() {
		        swal("¡Éxito!", "Registro actualizado con éxito", "success");
		    }

		    function cancelar_registro() {
		        $('#formularioTrabajador')[0].reset();
		    }

		    function regresar() {
		        location.href = "/trabajadores/lista";
		    }

		    function reset_form(identifier_form) {
		        $(identifier_form).steps("reset");
		        $(identifier_form)[0].reset();
		    }

		    function type_data() {
		        var url = (location.href).split("/");
		        if(url[url.length - 1] == "agregar") {
		            console.log("Agregar");
		            $('#btn_guardar').attr('onclick', 'agregarTrabajador()');
		        } else {
		            /** Cargar los datos de registro específico */
		            console.log("Editar");
		            $('#btn_guardar').attr('onclick', 'trabajador_actualizar()');
		        }
		    }

		    function initialize_validate_form() {
		        $(".validation-wizard").steps({
		            headerTag: "h6"
		            , bodyTag: "section"
		            , transitionEffect: "fade"
		            , titleTemplate: '<span class="step">#index#</span> #title#'
		            , enableCancelButton: true
		            , onCanceled: function (event) {
		                reset_form('.validation-wizard');
		            }
		            , labels: {
		                cancel: "Cancelar",
		                finish: "Finalizar",
		                previous: "Anterior"
		            }
		            , onStepChanging: function (event, currentIndex, newIndex) {
		                return currentIndex > newIndex || !(3 === newIndex && Number($("#age-2").val()) < 18) && (currentIndex < newIndex && (form.find(".body:eq(" + newIndex + ") label.error").remove(), form.find(".body:eq(" + newIndex + ") .error").removeClass("error")), form.validate().settings.ignore = ":disabled,:hidden", form.valid())
		            }
		            , onFinishing: function (event, currentIndex) {
		                return form.validate().settings.ignore = ":disabled", form.valid()
		            }
		            , onFinished: function (event, currentIndex) {
										// $("input[name=firma]").change(function(){
										// console.log("Valor: " + $("#firma").val().length);
										if($("#firma").val().length > 7){
											$('#validarFirma').hide();
											agregarTrabajador();
										}
										else{
											$('#validarFirma').show();
										}
										// });
		            }
		        });
		        $('a[href*="#cancel"]').css({'background' : '#CC0000'});
		    }

		    $(document).ready(function() {
		        type_data();
		        initialize_validate_form();

						// SOLO NÚMEROS
				    $('.input-number').on('input', function () {
				      this.value = this.value.replace(/[^0-9]/g,'');
				    });

						$('#validarFirma').hide();
		    });
		</script>
	</div>
@endsection
@endsection
@endsection
