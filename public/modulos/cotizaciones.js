$(document).ready(function() {
    $("body").tooltip({ selector: '[data-toggle="tooltip"]' });

    var url = (location.href).split("/");
    if(url[url.length - 1] == "agregar") {
        initialize_validate_form(1, null);
    } else if(url[url.length - 2] == "editar"){
        /** Cargar los datos de registro específico */
        initialize_validate_form(2, url[url.length - 1]);
        datos_proveedor_especifico(url[url.length - 1]);
    } else {
        /** Cargar los datos de los registros en general */
        datos_proveedor();
    }
});


$(".eliminarCotizacion").click(function(e){
    e.preventDefault();
    swal({
        title: "¿Deseas eliminar la cotización?",
        // text: "No podrás recuperarlo",
        type: "error",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Eliminar",
        cancelButtonText: "Cancelar",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm){
        if (isConfirm) {
            swal("Eliminado", "La cotización ha sido eliminada con éxito", "success");
        }
    });
})

$(".select2").select2();

$(".detalleCotizacion").click(function(e){
    e.preventDefault();
})


function initialize_validate_form(tipo, id) {
    finish = tipo == 1 ? 'Guardar' : 'Actualizar';
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
            previous: "Anterior",
            finish
        }
        , onStepChanging: function (event, currentIndex, newIndex) {
            return currentIndex > newIndex || !(3 === newIndex && Number($("#age-2").val()) < 18) && (currentIndex < newIndex && (form.find(".body:eq(" + newIndex + ") label.error").remove(), form.find(".body:eq(" + newIndex + ") .error").removeClass("error")), form.validate().settings.ignore = ":disabled,:hidden", form.valid())
        }
        , onFinishing: function (event, currentIndex) {
            return form.validate().settings.ignore = ":disabled", form.valid()
        }
        , onFinished: function (event, currentIndex) {
            if(tipo == 1) {
                guardar_proveedor();
            } else {
                actualizar_proveedor(id);
            }
        }
    });
    delete finish;
    $('a[href*="#cancel"]').css({'background' : '#CC0000'});
}
