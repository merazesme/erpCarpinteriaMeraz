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
                    icono: '<i class="fa fa-toggle-on" data-toggle="tooltip" data-placement="top" title="Clic para desactivar rol"></i>',
                }
                : {
                    color: 'text-danger',
                    icono: '<i class="fa fa-toggle-off" data-toggle="tooltip" data-placement="top" title="Clic para activar rol"></i>',
                };
                $('#table_roles tbody').append(`
                    <tr role="row">
                        <td class="vertical-align-table">${item.Nombre}</td>
                        <td class="vertical-align-table" id="col_modul_${item.id}"><ul style="list-style:none"></ul></td>
                        <td style="cursor:pointer" class="vertical-align-table color-elegant-orange" onclick="datos_usuarios_per_rol(${item.id})">
                            <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Clic para ver usuarios"></i>
                        </td>
                        <td style="cursor:pointer" class="${estado.color} vertical-align-table" onclick="cambiar_estatus(${item.id})">
                            ${estado.icono}
                        </td>
                        <td style="cursor:pointer" class="vertical-align-table color-elegant-blue" onclick="abrir_modal_agregar_rol(${item.id})" >
                            <i class="mdi mdi-lead-pencil" data-toggle="tooltip" data-placement="top" title="Clic para editar"></i>
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
function datos_rol_especifico(id) {

    Swal.fire({
        onOpen: function () {
            Swal.showLoading()
            $.ajax({
                type: 'GET',
                url: '/roles/data/especifico/'+id,
                dataType: 'JSON'
            }).done(function(datos) {
                Swal.close()
                var band = false;
                var modulos = [];
                datos.forEach(item => {
                    if(!band) {
                        band = true;
                        $('#rol_nombre').val(item.nombre_rol);
                    }
                    if(item.hasOwnProperty('id')) {
                        modulos.push(item.id);
                    }
                });
                $('#rol_modulos').select2('val', [modulos]);
            }).fail(function(err) {
                alerta_temporizador(
                    'error',
                    `Error: ${err}`,
                    'Ha ocurrido un error al extraer la información, inténtelo más tarde.',
                    3000
                );
            });
        }
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
function actualizar_rol(id) {
    var datos = new FormData(document.querySelector("#rol_form"));
        datos.append('rol_modulos', JSON.stringify($('#rol_modulos').val()));
    Swal.fire({
        onOpen: function () {
            Swal.showLoading()
            $.ajax({
                type: 'POST',
                url: '/roles/actualizar/'+id,
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
                        'El rol ha sido actualizado con éxito.',
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
                        'Ha ocurrido un error al actualizar el rol. Inténtelo más tarde.',
                        2500
                    );
                } else if(resp == 'error-relacion') {
                    alerta_temporizador(
                        'error',
                        'Factura de gasolina',
                        'Ha ocurrido un error al actualizar los módulos relacionados al rol. Inténtelo más tarde.',
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
function abrir_modal_agregar_rol(id) {
    if(id) {
        $('#modal_agregar_rol .modal-title').html('Actualizar rol');
        $('#btn_guardar_rol').attr('onclick', `actualizar_rol(${id})`);
        datos_rol_especifico(id);
    } else {
        $('#modal_agregar_rol .modal-title').html('Agregar un nuevo rol');
        $('#btn_guardar_rol').attr('onclick', 'agregar_rol()');
    }
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