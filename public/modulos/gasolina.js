$(document).ready(function() {
    $("body").tooltip({ selector: '[data-toggle="tooltip"]' });
    $(".select2").select2();
    $('.mydatepicker, #mdate').datepicker();
    $('.dropify').dropify();
    initialize_data_table('#table_gasolina');

    datos_gasolina_factura();
    datos_gasolina_cheques();
    datos_autos();
});    
function datos_gasolina_factura() {
    $.ajax({
        type: 'GET',
        url: 'gasolina/data',
        dataType: 'JSON'
    }).done(function(datos) {
        // console.table(datos);
        if(datos.length == 0) {
            alerta_temporizador(
                'warning',
                'Sin registros',
                'Actualmente no se tienen registros de facturas de gasolina',
                3000
            );
        } else {
            $('#table_gasolina').DataTable().clear();
            $('#table_gasolina').DataTable().destroy();
            datos.forEach(item => {
                var td = item.Estado == 1
                ?`<td class="vertical-align-table" align="right" id="col_folio${item.Ticket}"><span class="badge badge-warning w-100">Sin cheque</span></td>
                  <td class="vertical-align-table"><span class="badge badge-danger w-100">Sin pagar</span></td>`
                :`<td class="vertical-align-table" align="right" id="col_folio${item.Ticket}"></td>
                  <td class="vertical-align-table"><span class="badge badge-success w-100">Pagado</span></td>`;

                if (item.Documento === null || item.Documento === undefined) {
                    item.Documento = 'error';
                }
                $('#table_gasolina tbody').append(`
                    <tr role="row">
                        <td class="vertical-align-table">${moment(item.Fecha).format('DD/MM/YYYY')}</td>
                        <td class="vertical-align-table"># ${item.Ticket}</td>
                        <td class="vertical-align-table">${item.Litros}</td>
                        <td class="vertical-align-table">$${item.Total}</td>
                        <td class="vertical-align-table">${item.Marca}: ${item.Modelo}</td>
                        ${td}
                        <td data-toggle="tooltip" data-placement="top" title="Ver imagen">
                            <i class="fa fa-file-image-o color-elegant-orange"
                               onclick="alerta_imagen('${item.Ticket}', '${item.Documento}')"></i>
                        </td>
                    </tr>
                `);
            });
            initialize_data_table('#table_gasolina');
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
function datos_gasolina_cheques() {
    $.ajax({
        type: 'GET',
        url: 'gasolina/data/cheques',
        dataType: 'JSON'
    }).done(function(datos) {
        // console.table(datos);
        if(datos.length !== 0) {
            $('#table_cheques').DataTable().clear();
            $('#table_cheques').DataTable().destroy();
            var folios_pagos = [];
            datos.forEach(item => {
                folios_pagos.push(item.Folio_pago)
            });
            folios_pagos = folios_pagos.unique();
            // console.table(folios_pagos);

            /** Crear la lista */
            folios_pagos.forEach(item_folio_pago => {
                var lista_tickets = '', fecha, band = true;

                datos.forEach(item_registros => {
                    if(band) fecha = moment(item_registros.Fecha).format('DD/MM/YYYY');
                    if(item_folio_pago == item_registros.Folio_pago) {
                        lista_tickets += `<li>Ticket: #${item_registros.Ticket}</li>`
                    }
                    band = false;
                });
                $('#table_cheques tbody').append(`
                    <tr role="row">
                        <td class="vertical-align-table">${fecha}</td>
                        <td class="vertical-align-table"># ${item_folio_pago}</td>
                        <td class="vertical-align-table"><ul style="list-style:none">${lista_tickets}</ul></td>
                    </tr>
                `);
            });
            initialize_data_table('#table_cheques');
        }
    }).fail(function(err) {
        alerta_temporizador(
            'error',
            `Error: ${err}`,
            'Ha ocurrido un error al extraer los registros, inténtelo más tarde.',
            3000
        );
    }).then(function(datos) {
        /** Aprovechar los datos para colocar el número de ticket en la tabla de factura */
        datos.forEach(item => {
            $(`#col_folio${item.Ticket}`).html(`# ${item.Folio_pago}`);
        });
    })
}
function datos_autos() {
    $.ajax({
        type: 'GET',
        url: 'carros/data',
        dataType: 'JSON'
    }).done(function(datos) {
        // console.table(datos);
        if(datos.length !== 0) {
            $('#gasolina_auto optgroup').empty();
            datos.forEach(auto => {
                $('#gasolina_auto optgroup').append(`<option value="${auto.id}">${auto.Marca}: ${auto.Modelo}</option>`);
            });
        }
    })
}
function guardar_factura_gasolina() {
    var datos = new FormData(document.querySelector("#gasolina_form"));
    datos.append('mdate', moment($('mdate').val()).format('YYYY/MM/DD'));
    Swal.fire({
        onOpen: function () {
            Swal.showLoading()
            $.ajax({
                type: 'POST',
                url: '/proveedores/agregar/factura/gasolina',
                data: datos,
                contentType: false,
            	processData: false,
            })
            .done(function(resp) {
                console.log(resp);
                Swal.close()
                if(resp == 'true') {
                    alerta_temporizador(
                        'success',
                        'Factura de gasolina',
                        'La factura ha sido agregada con éxito',
                        2500
                    );
                    datos_gasolina_factura();
                    datos_gasolina_cheques();
                } else if(resp == 'session'){
                    alerta_temporizador(
                        'error',
                        'Error',
                        'Ha ocurrido un error con su sesión. Por favor, ingrese de nuevo.',
                        2500
                    );
                } else if(resp == 'empty') {
                    alerta_temporizador(
                        'error',
                        'Factura de gasolina',
                        'Debe ingresar todos los campos para poder agregar la factura.',
                        2500
                    );
                } else if(resp == 'error') {
                    alerta_temporizador(
                        'error',
                        'Factura de gasolina',
                        'Ha ocurrido un error al guardar el proveedor. Inténtelo más tarde.',
                        2500
                    );
                }
            })
            .fail(function(err) {
                alerta_temporizador(
                    'error',
                    `Error: ${err}`,
                    'Ha ocurrido un error agregando la factura. Inténtelo más tarde',
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
function alerta_imagen(title, imageUrl) {
    if(imageUrl == 'error') {
        imageUrl = url_images+'/error/no_image_available.jpg';
    } else {
        imageUrl = url_images+'/modulos/proveedor/gasolina/'+imageUrl+'.jpg';
    }
    title = `Ticket #${title}`;

    Swal.fire({
        title,
        imageUrl,
        imageWidth: 250,
        imageHeight: 380,
        imageAlt: title,
        animation: true
    })
}
// alerta_imagen('1', 'error')
function abrir_modal_agregar_ticket() {
    $('#modal_agregar_ticket').modal('show');
}
function abrir_modal_pagar_factura() {
    $('#modal_pagar_factura').modal('show');
}
function initialize_data_table(id) {
    $(id).DataTable({
        dom: 'Bfrtip',
        buttons: ['excel', 'pdf', 'print']
    });
}
Array.prototype.unique=function(a){
	return function(){return this.filter(a)}}(function(a,b,c){return c.indexOf(a,b+1)<0
});