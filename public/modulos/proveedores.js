$(document).ready(function() {
    type_data();
});    
function datos_proveedor() {
    $.ajax({
        type: 'GET',
        url: 'lista/data'
    }).done(function(datos) {
        if(datos.length == 0) {
            alerta_temporizador(
                'warning',
                'Sin registros',
                'Actualmente no se tienen registros de proveedores',
                3000
            );
        } else {
            $('#table_proveedores').DataTable().clear();
            $('#table_proveedores').DataTable().destroy();
            datos.forEach(item => {
                var estatus = item.estatus == 0
                ? {
                    color: 'color-elegant-blue-green',
                    icono: '<i class="fa fa-toggle-on"></i>',
                    label: 'Clic para desactivar proveedor'
                }
                : {
                    color: 'text-danger',
                    icono: '<i class="fa fa-toggle-off"></i>',
                    label: 'Clic para activar proveedor'
                };
                $('#table_proveedores tbody').append(`
                    <tr role="row">
                        <td>${item.Nombre}</td>
                        <td>${item.RFC}</td>
                        <td>${item.Telefono}</td>
                        <td>${item.Email}</td>
                        <td align="right">$${item.Adeudo}</td>
                        <td style="cursor:pointer" class="color-elegant-blue" onclick="editar_proveedor(${item.id})" data-toggle="tooltip" 
                            data-placement="top" title="Clic para editar">
                            <i class="mdi mdi-lead-pencil"></i>
                        </td>
                        <td style="cursor:pointer" class="${estatus.color}" data-toggle="tooltip" data-placement="top" onclick="cambiar_estatus(${item.id})"
                            title="${estatus.label}" >
                            ${estatus.icono}
                        </td>
                    </tr>
                `);
            });
            $('#table_proveedores').DataTable();
        }
    }).fail(function(err) {
        alerta_temporizador(
            'error',
            'Error',
            'Ha ocurrido un error al extraer los registros, inténtelo más tarde.',
            3000
        );
    })
}
function guardar_proveedor() {
    var datos = new FormData(document.querySelector("#proveedor_form"));
    Swal.fire({
        onOpen: function () {
            Swal.showLoading()
            $.ajax({
                type: 'POST',
                url: '/proveedores/agregar/proveedor',
                data: datos,
                contentType: false,
            	processData: false,
            })
            .done(function(resp) {
                Swal.close()
                if(resp == 'true') {
                    alerta_temporizador(
                        'success',
                        'Proveedor',
                        'El proveedor ha sido agregado con éxito',
                        2500
                    );
                    reset_form('.validation-wizard');
                } else if('session'){
                    alerta_temporizador(
                        'error',
                        'Error',
                        'Ha ocurrido un error con su sesión. Por favor, ingrese de nuevo.',
                        2500
                    );
                } else if('empty') {
                    alerta_temporizador(
                        'error',
                        'Proveedor',
                        'Debe ingresar todos los campos para poder registrar el proveedor.',
                        2500
                    );
                } else if('error') {
                    alerta_temporizador(
                        'error',
                        'Proveedor',
                        'Ha ocurrido un error al guardar el proveedor. Inténtelo más tarde.',
                        2500
                    );
                }
            })
            .fail(function(err) {
                alerta_temporizador(
                    'error',
                    `Error: ${err}`,
                    'Ha ocurrido un error agregando el proveedor. Inténtelo más tarde',
                    2500
                );
            });
        }
    })
}
function cambiar_estatus(id) {
    var datos = new FormData();
        datos.append('_token', token);
    Swal.fire({
        onOpen: function () {
            Swal.showLoading()
            $.ajax({
                type: 'POST',
                url: '/proveedores/actualizar/proveedor/estatus/'+id,
                data: datos,
                contentType: false,
            	processData: false,
            })
            .done(function(resp) {
                Swal.close()
                if(resp == 'true') {
                    alerta_temporizador(
                        'success',
                        'Proveedor',
                        'El estado del proveedor ha sido actualizado con éxito.',
                        2500
                    );
                    datos_proveedor();
                } else if('session'){
                    alerta_temporizador(
                        'error',
                        'Error',
                        'Ha ocurrido un error con su sesión. Por favor, ingrese de nuevo.',
                        2500
                    );
                } else if('error') {
                    alerta_temporizador(
                        'error',
                        'Proveedor',
                        'Ha ocurrido un error al actualizar el estado del proveedor. Inténtelo más tarde.',
                        2500
                    );
                }
            })
            .fail(function(err) {
                alerta_temporizador(
                    'error',
                    `Error: ${err}`,
                    'Ha ocurrido un error actualizando el proveedor. Inténtelo más tarde',
                    2500
                );
            });
        }
    })
}
function alerta_temporizador(tipo, titulo, texto, tiempo) {
    Swal.fire({
        type: tipo,
        title: titulo,
        text: texto,
        showConfirmButton: false,
        timer: tiempo
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
        initialize_validate_form(1);
    } else if(url[url.length - 2] == "editar"){
        /** Cargar los datos de registro específico */
        console.log("Editar")
        $('#btn_guardar').attr('onclick', 'proveedor_actualizar()');
        initialize_validate_form(2);
    } else {
        /** Cargar los datos de los registros en general */
        datos_proveedor();
    }
}
function initialize_validate_form(tipo) {
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
            if(tipo == 1) {
                guardar_proveedor();
            } else {
                actualizar_proveedor();
            }
        }
    });
    $('a[href*="#cancel"]').css({'background' : '#CC0000'});
}
function agregar_proveedor() {
    location.href = "/proveedores/agregar";
}
function editar_proveedor(id) {
    location.href = "/proveedores/editar/"+id;
}