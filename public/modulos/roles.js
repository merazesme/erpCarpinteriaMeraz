$(document).ready(function() {
    $("body").tooltip({ selector: '[data-toggle="tooltip"]' });
    datos_roles();
});

function datos_roles() {
    $.ajax({
        type: 'GET',
        url: '/roles/data',
        dataType: 'JSON'
    }).done(function(datos) {
        if(datos.roles.length == 0) {
            alerta_temporizador(
                'warning',
                'Sin registros',
                'Actualmente no se tienen registros de roles',
                3000
            );
        } else {
            console.log(datos);
            var modulos = [];
            $('#table_roles').DataTable().clear();
            $('#table_roles').DataTable().destroy();

            datos.roles.forEach(item => {
                var modulos_rol = datos.relacion.filter(item_relacion => {
                    return item_relacion.Roles_idRol == item.id;
                });
                if(modulos_rol.length > 0) modulos.push(modulos_rol);

                var estado = item.Estado == 0
                ? {
                    color: 'color-elegant-blue-green',
                    icono: '<i class="fa fa-toggle-on"></i>',
                    label: 'Clic para desactivar rol'
                }
                : {
                    color: 'text-danger',
                    icono: '<i class="fa fa-toggle-off"></i>',
                    label: 'Clic para activar rol'
                };
                $('#table_roles tbody').append(`
                    <tr role="row">
                        <td class="vertical-align-table">${item.Nombre}</td>
                        <td class="vertical-align-table" id="col_modul_${item.id}"><ul style="list-style:none"></ul></td>
                        <td style="cursor:pointer" class="vertical-align-table color-elegant-orange" onclick="datos_usuarios_per_rol(${item.id})"
                            data-toggle="tooltip" data-placement="top" title="Clic para ver usuarios">
                            <i class="fa fa-info-circle"></i>
                        </td>
                        <td style="cursor:pointer" class="${estado.color} vertical-align-table" data-toggle="tooltip" data-placement="top" onclick="cambiar_estatus(${item.id})"
                            title="${estado.label}" >
                            ${estado.icono}
                        </td>
                        <td style="cursor:pointer" class="vertical-align-table color-elegant-blue" onclick="modal_actualizar_proveedor(${item.id})" 
                            data-toggle="tooltip" data-placement="top" title="Clic para editar">
                            <i class="mdi mdi-lead-pencil"></i>
                        </td>
                    </tr>
                `);
            });
            initialize_data_table('#table_roles');

            modulos.forEach(item => {
                /** Otro forEach porque puede que un rol tenga varios módulos */
                item.forEach(item_relacion => {
                    var index = datos.modulos.findIndex(modulo => {
                        return item_relacion.Modulos_idModulo == modulo.id
                    });
                    $(`#col_modul_${item_relacion.Roles_idRol} ul`).append(`<li style="list-style:none">${datos.modulos[index].Nombre}</li>`)
                });
            });
            
        }
    }).fail(function(err) {
        alerta_temporizador(
            'error',
            `Error: ${err}`,
            'Ha ocurrido un error al extraer los registros, inténtelo más tarde.',
            3000
        );
    }).then(function(datos) {
        /** Aprovechar los datos para llenar los módulos al select */
        $('.select2').remove();
        $('#select_modulos_label').after(`
            <select class="select2 m-b-10 select2-multiple" style="width: 100%;" multiple="multiple" data-placeholder="Elegir"
                    id="rol_modulos" name="rol_modulos">
                <option>Elegir</option>
                <optgroup label="Módulos">
                </optgroup>
            </select>`
        );
        datos.modulos.forEach(item => {
            $('#rol_modulos').append(`<option value="${item.id}">${item.Nombre}</option>`);
        });
        $(".select2").select2();
    });
}
function datos_usuarios_per_rol(id) {
    $.ajax({
        type: 'GET',
        url: '/roles/data/rol/usuario/'+id,
        dataType: 'JSON'
    }).done(function(datos) {
        if(datos.length == 0) {
            alerta_temporizador(
                'warning',
                'Sin registros',
                'El rol seleccionado no tiene usuarios.',
                3000
            );
        } else {
            $('#table_usuarios_per_rol tbody').empty();
            datos.forEach(item => {
                $('#table_usuarios_per_rol tbody').append(`
                    <tr><td>${item.Usuario}</td></tr>
                `);
            });
            $('#modal_usuarios_rol').modal('show');
        }
    }).fail(function(err) {
        alerta_temporizador(
            'error',
            `Error: ${err}`,
            'Ha ocurrido un error al extraer los registros, inténtelo más tarde.',
            3000
        );
    })
}
function agregar_rol() {
    var datos = new FormData(document.querySelector("#rol_form"));
        datos.append('rol_modulos', JSON.stringify($('#rol_modulos').val()));
    Swal.fire({
        onOpen: function () {
            Swal.showLoading()
            $.ajax({
                type: 'POST',
                url: '/roles/agregar',
                data: datos,
                contentType: false,
            	processData: false,
            })
            .done(function(resp) {
                Swal.close()
                if(resp == 'true') {
                    alerta_temporizador(
                        'success',
                        'Roles',
                        'El rol ha sido agregado con éxito.',
                        2500
                    );
                    reset_form('#rol_form');
                    datos_roles();
                } else if(resp == 'session'){
                    alerta_temporizador(
                        'error',
                        'Error',
                        'Ha ocurrido un error con su sesión. Por favor, ingrese de nuevo.',
                        2500
                    );
                } else if(resp == 'error-rol') {
                    alerta_temporizador(
                        'error',
                        'Roles',
                        'Ha ocurrido un error al guardar el rol. Inténtelo más tarde.',
                        2500
                    );
                } else if(resp == 'error-relacion') {
                    alerta_temporizador(
                        'error',
                        'Factura de gasolina',
                        'Ha ocurrido un error al guardar los módulos relacionados al rol. Inténtelo más tarde.',
                        2500
                    );
                }
            })
            .fail(function(err) {
                alerta_temporizador(
                    'error',
                    `Error: ${err}`,
                    'Ha ocurrido un error actualizando el rol. Inténtelo más tarde',
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
                url: '/roles/actualizar/estatus/'+id,
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
                        'El estado del rol ha sido actualizado con éxito.',
                        2500
                    );
                    datos_roles();
                } else if(resp == 'session'){
                    alerta_temporizador(
                        'error',
                        'Error',
                        'Ha ocurrido un error con su sesión. Por favor, ingrese de nuevo.',
                        2500
                    );
                } else if(resp == 'error') {
                    alerta_temporizador(
                        'error',
                        'Roles',
                        'Ha ocurrido un error al actualizar el estado del rol. Inténtelo más tarde.',
                        2500
                    );
                }
            })
            .fail(function(err) {
                alerta_temporizador(
                    'error',
                    `Error: ${err}`,
                    'Ha ocurrido un error actualizando el rol. Inténtelo más tarde',
                    2500
                );
            });
        }
    })
}
function abrir_modal_agregar_rol() {
    reset_form('#rol_form');
    $('#modal_agregar_rol').modal('show');
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
function initialize_data_table(id) {
    $(id).DataTable({
        dom: 'Bfrtip',
        buttons: ['excel', 'pdf', 'print']
    });
}
function reset_form(identifier_form) {
    $(identifier_form)[0].reset();
    $('#rol_modulos').val(null).trigger("change"); 
}