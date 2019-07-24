@extends('footer')
@extends('sidebar')
@extends('header')

@section('header')
@parent
<div class="preloader">
    <div class="loader">
        <div class="loader__figure"></div>
        <p class="loader__label">Carpintería Meraz</p>
    </div>
</div>
<div id="main-wrapper">
    @section('sidebar')
    @parent
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row ">
                <div class="col-lg-10 col-md-10 col-sm-9 col-xs-9"></div>
                <div class="col-lg-2 col-md-2 col-sm-3 col-xs-3">
                    <button type="button" onclick="regresar()" class="btn btn-dark ">
                        <i class="mdi mdi-arrow-left"></i>
                        Regresar
                    </button>

                </div>
            </div>

            <div class="row" id="validation">
                <div class="col-12">
                    <div class="card wizard-content">
                        <div class="card-body">
                            <h4 class="card-title">{{$modulo}}</h4>
                            <form action="#" id="proveedor_form" class="validation-wizard wizard-circle">
                                <!-- Step 1 -->
                                <h6>Identificación</h6>
                                <section>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="proveedor_concepto">Tipo de concepto <span class="danger">*</span> </label>
                                                <input type="text" class="form-control required" id="proveedor_concepto" name="proveedor_concepto" placeholder="Material X">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="proveedor_rfc">RFC: <span class="danger">*</span> </label>
                                                <input type="text" class="form-control required" id="proveedor_rfc" name="proveedor_rfc" placeholder="XXX-XXX-XXX-XXX">
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <!-- Step 2 -->
                                <h6>Contacto</h6>
                                <section>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="proveedor_correo">Correo electrónico <span class="danger">*</span> </label>
                                                <input type="text" class="form-control required" id="proveedor_correo" name="proveedor_correo" placeholder="ejemplo@correo.com">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="proveedor_telefono">Teléfono: <span class="danger">*</span> </label>
                                                <input type="text" class="form-control required" id="proveedor_telefono" name="proveedor_telefono" placeholder="xxx-xxx-xxx">
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
<script src="{{asset('plugins/sweetalert/sweetalert_2/sweetalert2.all.min.js')}}"></script>
<script src="{{asset('plugins/sweetalert/sweetalert_2/sweetalert2.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('plugins/sweetalert/sweetalert_2/sweetalert2.min.css')}}">

<script src="{{asset('js/mask.js')}}"></script>
<script>
    /** Scripts */
    function proveedor_guardar() {
        Swal.fire({
            type: 'success',
            title: 'Éxito',
            text: 'Registro guardado con éxito',
            showConfirmButton: false,
            timer: 1500
        });
    }
    function proveedor_actualizar() {
        swal("¡Éxito!", "Registro actualizado con éxito", "success");
    }
    function cancelar_registro() {
        $('#form_proveedor')[0].reset();
    }
    function regresar() {
        location.href = "/proveedores/lista";
    }
    function reset_form(identifier_form) {
        $(identifier_form).steps("reset");
        $(identifier_form)[0].reset();
    }

    function type_data() {
        var url = (location.href).split("/");
        if(url[url.length - 1] == "agregar") {
            console.log("Agregar")
            $('#btn_guardar').attr('onclick', 'proveedor_guardar()');
        } else {
            /** Cargar los datos de registro específico */
            console.log("Editar")
            $('#btn_guardar').attr('onclick', 'proveedor_actualizar()');
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
                cancel  : "Cancelar",
                finish  : "Finalizar",
                previous: "Anterior"
            }
            , onStepChanging: function (event, currentIndex, newIndex) {
                return currentIndex > newIndex || !(3 === newIndex && Number($("#age-2").val()) < 18) && (currentIndex < newIndex && (form.find(".body:eq(" + newIndex + ") label.error").remove(), form.find(".body:eq(" + newIndex + ") .error").removeClass("error")), form.validate().settings.ignore = ":disabled,:hidden", form.valid())
            }
            , onFinishing: function (event, currentIndex) {
                return form.validate().settings.ignore = ":disabled", form.valid()
            }
            , onFinished: function (event, currentIndex) {
                reset_form('.validation-wizard');
                proveedor_guardar();
            }
        });
        $('a[href*="#cancel"]').css({'background' : '#CC0000'});
    }

    $(document).ready(function() {
        type_data();
        initialize_validate_form();
    });    
</script>
</div>
@endsection
@endsection
@endsection
