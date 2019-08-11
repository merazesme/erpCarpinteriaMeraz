$(document).ready(function() {
    $("body").tooltip({ selector: '[data-toggle="tooltip"]' });
    iniciarDataTable('#table_carros');
    $('#carro_trabajador').select2();
    datosCarros();
});

let arrayCarros       = [];
let arrayTrabajadores = [];

function datosCarros() {
    $.ajax({
        type: 'GET',
        url: 'carro/data',
        dataType: 'JSON'
    }).done(function(datos) {
        if(datos.length == 0) {
            alertaTemporizador(
                'warning',
                'Sin registros',
                'Actualmente no se tienen registros de carros',
                3000
            );
        } else {
            arrayCarros = datos;
            limpiarDataTable('#table_carros');
            crearTablaCarros(arrayCarros);
        }
    }).fail(function(err) {
        alertaTemporizador(
            'error',
            `Error: ${err}`,
            'Ha ocurrido un error al extraer los registros, inténtelo más tarde.',
            3000
        );
    }).always(datosTrabajadores());
}
function datosTrabajadores() {
    $.ajax({
        type: 'GET',
        url: 'carro/dataTrabajadores',
        dataType: 'JSON'
    }).done(function(datos) {
        if(datos.length !== 0) {
            arrayTrabajadores = datos;
            crearOpcionesTrabajadores(arrayTrabajadores);
        }
    });
}
function abrirModalAgregarCarro(id) {
    if(id) {
        $('#agregar_registro').attr('onclick', `editarCarro(${id})`);
        /** Buscar el registro */
        const carro      = arrayCarros.find(item => item.id === id);
        const trabajador = arrayTrabajadores.find(item => item.id === carro.idTrabajador);

        console.log(trabajador);

        $('#carro_marca') .val(carro.Marca);
        $('#carro_modelo').val(carro.Modelo);
        $('#carro_placas').val(carro.placa);
        if(trabajador) $('#carro_trabajador').select2('val', [trabajador.id]);
        else           $('#carro_trabajador').select2('val', ['']);
    } else {
        $('#agregar_registro').attr('onclick', `agregarCarro()`);
        $('#carro_trabajador').select2('val', ['']);
    }
    $('#modal_agregar_carro').modal('show');
}
function iniciarDataTable(id) {
    $(id).DataTable({
        dom: 'Bfrtip',
        buttons: ['excel', 'pdf', 'print']
    });
}
function limpiarDataTable(id) {
    $(id).DataTable().clear();
    $(id).DataTable().destroy();
}
function crearTablaCarros(datos) {
    datos.forEach(item => {
        var estatus = item.Estado == 0
        ? {
            color: 'color-elegant-blue-green',
            icono: '<i class="fa fa-toggle-on"></i>',
            label: 'Clic para desactivar carro'
        }
        : {
            color: 'text-danger',
            icono: '<i class="fa fa-toggle-off"></i>',
            label: 'Clic para activar carro'
        };
        var trTrabajador;
        if(item.idTrabajador)
            trTrabajador = `<td id="trabajador_${item.idTrabajador}"></td>`;
        else
            trTrabajador = `<td><em>Sin trabajador asignado</em></td>`;
        $('#table_carros tbody').append(`
            <tr role="row">
                <td>#${item.placa}</td>
                <td>${item.Marca}</td>
                <td>${item.Modelo}</td>
                ${trTrabajador}
                <td style="cursor:pointer" class="color-elegant-blue" onclick="abrirModalAgregarCarro(${item.id})" 
                    data-toggle="tooltip" data-placement="top" title="Clic para editar">
                    <i class="mdi mdi-lead-pencil"></i>
                </td>
                <td style="cursor:pointer" class="${estatus.color}" data-toggle="tooltip" data-placement="top" onclick="cambiarEstatus(${item.id})"
                    title="${estatus.label}" >
                    ${estatus.icono}
                </td>
            </tr>
        `);
    });
}
function crearOpcionesTrabajadores(datos) {
    datos.forEach(item => {
        item.Nombre    = item.Nombre    || "";
        item.Apellidos = item.Apellidos || "";
        if(($(`#carro_trabajador option[value=${item.id}]`)).length <= 0){
            /** Agregar opción */
            $('#carro_trabajador optgroup').append(`
                <option value="${item.id}">${item.Nombre} ${item.Apellidos}</option>
            `);
        }
        $(`#trabajador_${item.id}`).html(item.Nombre + item.Apellidos);
    });
    iniciarDataTable('#table_carros');
}
function agregarCarro() {
    var datos = new FormData(document.querySelector("#carro_form"));
    Swal.fire({
        onOpen: function () {
            Swal.showLoading()
            $.ajax({
                type: 'POST',
                url: '/carro/agregar',
                data: datos,
                contentType: false,
            	processData: false,
            })
            .done(function(resp) {
                Swal.close()
                if(resp == 'true') {
                    alertaTemporizador(
                        'success',
                        'Carros',
                        'El carro ha sido agregado con éxito',
                        2500
                    );
                    datosCarros();
                    resetForm();
                } else if(resp == 'session'){
                    alertaTemporizador(
                        'error',
                        'Error',
                        'Ha ocurrido un error con su sesión. Por favor, ingrese de nuevo.',
                        2500
                    );
                } else if(resp == 'empty') {
                    alertaTemporizador(
                        'error',
                        'Carros',
                        'Debe ingresar todos los campos obligatorios (*) para poder registrar el carro.',
                        2500
                    );
                } else if(resp == 'error') {
                    alertaTemporizador(
                        'error',
                        'Carros',
                        'Ha ocurrido un error al guardar el carro. Inténtelo más tarde.',
                        2500
                    );
                }
            })
            .fail(function(err) {
                alertaTemporizador(
                    'error',
                    `Error: ${err}`,
                    'Ha ocurrido un error agregando el carro. Inténtelo más tarde',
                    2500
                );
            });
        }
    })
}
function editarCarro(id) {
    var datos = new FormData(document.querySelector("#carro_form"));
    Swal.fire({
        onOpen: function () {
            Swal.showLoading()
            $.ajax({
                type: 'POST',
                url: '/carro/actualizar/'+id,
                data: datos,
                contentType: false,
            	processData: false,
            })
            .done(function(resp) {
                Swal.close()
                if(resp == 'true') {
                    alertaTemporizador(
                        'success',
                        'Carros',
                        'El carro ha sido actualizado con éxito',
                        2500
                    );
                    /** Actualizar el registro en el arreglo */
                    const indice = arrayCarros.findIndex(item => item.id == id);
                    arrayCarros[indice].Marca  = $('#carro_marca').val();
                    arrayCarros[indice].Modelo = $('#carro_modelo').val();
                    arrayCarros[indice].placa  = $('#carro_placas').val();
                    if($('#carro_trabajador').val() == "") arrayCarros[indice].idTrabajador = null;
                    else arrayCarros[indice].idTrabajador = parseInt($('#carro_trabajador').val(), 10);
                    resetForm();
                    reiniciarDatos();
                } else if(resp == 'session'){
                    alertaTemporizador(
                        'error',
                        'Error',
                        'Ha ocurrido un error con su sesión. Por favor, ingrese de nuevo.',
                        2500
                    );
                } else if(resp == 'empty') {
                    alertaTemporizador(
                        'error',
                        'Carros',
                        'Debe ingresar todos los campos obligatorios (*) para poder actualizar el carro.',
                        2500
                    );
                } else if(resp == 'error') {
                    alertaTemporizador(
                        'error',
                        'Carros',
                        'Ha ocurrido un error al actualizar el carro. Inténtelo más tarde.',
                        2500
                    );
                }
            })
            .fail(function(err) {
                alertaTemporizador(
                    'error',
                    `Error: ${err}`,
                    'Ha ocurrido un error actualizando el carro. Inténtelo más tarde',
                    2500
                );
            });
        }
    })
}
function cambiarEstatus(id) {
    var datos = new FormData();
        datos.append('_token', token);
    Swal.fire({
        onOpen: function () {
            Swal.showLoading()
            $.ajax({
                type: 'POST',
                url: '/carro/actualizar/estatus/'+id,
                data: datos,
                contentType: false,
            	processData: false,
            })
            .done(function(resp) {
                Swal.close()
                if(resp == 'true') {
                    alertaTemporizador(
                        'success',
                        'Carros',
                        'El estado del carro ha sido actualizado con éxito.',
                        2500
                    );
                    /** Actualizar el registro en el arreglo */
                    const indice = arrayCarros.findIndex(item => item.id == id);
                    arrayCarros[indice].Estado = arrayCarros[indice].Estado == 0 ? 1 : 0;
                    reiniciarDatos();
                } else if(resp == 'session'){
                    alertaTemporizador(
                        'error',
                        'Error',
                        'Ha ocurrido un error con su sesión. Por favor, ingrese de nuevo.',
                        2500
                    );
                } else if(resp == 'error') {
                    alertaTemporizador(
                        'error',
                        'Carros',
                        'Ha ocurrido un error al actualizar el estado del carro. Inténtelo más tarde.',
                        2500
                    );
                }
            })
            .fail(function(err) {
                alertaTemporizador(
                    'error',
                    `Error: ${err}`,
                    'Ha ocurrido un error actualizando el carro. Inténtelo más tarde',
                    2500
                );
            });
        }
    })
}
function resetForm() {
    $('#carro_form')[0].reset();
    $('#carro_trabajador').select2('val', ['']);
}
function reiniciarDatos() {
    /** Tabla de carros */
    limpiarDataTable('#table_carros');
    crearTablaCarros(arrayCarros);
    /** Trabajadores */
    crearOpcionesTrabajadores(arrayTrabajadores);
}
function alertaTemporizador(tipo, titulo, texto, tiempo) {
    Swal.fire({
        type: tipo,
        title: titulo,
        text: texto,
        showConfirmButton: false,
        timer: tiempo
    });
}