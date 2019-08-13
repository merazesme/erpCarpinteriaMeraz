$(document).ready(function() {
    $("body").tooltip({ selector: '[data-toggle="tooltip"]' });
    $(".select2").select2();
    $('.mydatepicker, #mdate').datepicker();
    $('.dropify').dropify();
    initialize_data_table('#table_facturas');

    datos_facturas_sobrantes();
    datos_facturas_cheques();
});
function datos_facturas_sobrantes() {
    $.ajax({
        type: 'GET',
        url: '/facturas_sobrantes/data',
        dataType: 'JSON'
    }).done(function(datos) {
        if(datos.length == 0) {
            alerta_temporizador(
                'warning',
                'Sin registros',
                'Actualmente no se tienen registros de facturas sobrantes',
                3000
            );
        } else {
            $('.select2').remove();
            $('#select_facturas_label').after(`
                <select class="select2 m-b-10 select2-multiple" style="width: 100%;" multiple="multiple" data-placeholder="Elegir"
                        id="factura_pago_facturas" name="factura_pago_facturas">
                    <option>Elegir</option>
                    <optgroup label="Pendientes por pagar">
                    </optgroup>
                </select>`
            );
            $(".select2").select2();
            var band = false;
            $('#table_facturas').DataTable().clear();
            $('#table_facturas').DataTable().destroy();
            datos.forEach(item => {
                if(item.Estado == 0) {
                    if(!band) band = true;
                    $('#factura_pago_facturas optgroup').append(`
                        <option value="${item.id}">Factura #${item.Folio_factura}</option>
                    `);
                }

                var td = item.Estado == 0
                ?`<td class="vertical-align-table" align="right" id="col_folio${item.Folio_factura}"><span class="sin_cheque badge badge-warning w-100">Sin cheque</span></td>
                  <td class="vertical-align-table"><span class="badge badge-danger w-100">Sin pagar</span></td>`
                :`<td class="vertical-align-table" align="right" id="col_folio${item.Folio_factura}"></td>
                  <td class="vertical-align-table"><span class="badge badge-success w-100">Pagado</span></td>`;

                if (item.Documento === null || item.Documento === undefined) {
                    item.Documento = 'error';
                }
                $('#table_facturas tbody').append(`
                    <tr role="row">
                        <td class="vertical-align-table">${moment(item.Fecha).format('DD/MM/YYYY')}</td>
                        <td class="vertical-align-table"># ${item.Folio_factura}</td>
                        <td class="vertical-align-table">${item.Concepto}</td>
                        <td class="vertical-align-table">$${item.Total}</td>
                        ${td}
                        <td data-toggle="tooltip" data-placement="top" title="Ver imagen">
                            <i class="fa fa-file-image-o color-elegant-orange"
                               onclick="alerta_imagen('${item.Folio_factura}', '${item.Documento}')"></i>
                        </td>
                    </tr>
                `);
            });
            if(!band) {
                $('#factura_pago_facturas optgroup').attr('label', 'Sin facturas sobrantes por pagar');
            }
            initialize_data_table('#table_facturas');
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
function datos_facturas_cheques() {
    $.ajax({
        type: 'GET',
        url: '/facturas_sobrantes/data/pagos',
        dataType: 'JSON'
    }).done(function(datos) {
        if(datos.length !== 0) {
            $('#table_pagos').DataTable().clear();
            $('#table_pagos').DataTable().destroy();
            var folios_pagos = [];
            datos.forEach(item => {
                folios_pagos.push(item.Folio_pago)
            });
            folios_pagos = folios_pagos.unique();

            /** Crear la lista */
            folios_pagos.forEach(item_folio_pago => {
                var lista_facturas = '', fecha, band = true;

                datos.forEach(item_registros => {
                    if(band) fecha = moment(item_registros.Fecha).format('DD/MM/YYYY');
                    if(item_folio_pago == item_registros.Folio_pago) {
                        lista_facturas += `<li>Folio_factura: #${item_registros.Folio_factura}</li>`
                    }
                    band = false;
                });
                const cantidad_pago = datos.find(item => item.Folio_pago === item_folio_pago);
                const metodo_pago   = (cantidad_pago) ? (cantidad_pago.Folio_pago == 1) ? 'Cheque' : 'Transferencia' : '<em>Error</em>';

                if (cantidad_pago.Documento === null || cantidad_pago.Documento === undefined) {
                    cantidad_pago.Documento = 'error';
                }

                $('#table_pagos tbody').append(`
                    <tr role="row">
                        <td class="vertical-align-table">${fecha}</td>
                        <td class="vertical-align-table"># ${item_folio_pago}</td>
                        <td class="vertical-align-table">${metodo_pago}</td>
                        <td class="vertical-align-table">$${cantidad_pago.Cantidad}</td>
                        <td class="vertical-align-table"><ul style="list-style:none">${lista_facturas}</ul></td>
                        <td data-toggle="tooltip" data-placement="top" title="Ver imagen">
                            <i class="fa fa-file-image-o color-elegant-orange"
                               onclick="alerta_imagen('${item_folio_pago}', '${cantidad_pago.Documento}')"></i>
                        </td>
                    </tr>
                `);
            });
            initialize_data_table('#table_pagos');
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
            $(`#col_folio${item.Folio_factura}`).html(`# ${item.Folio_pago}`);
        });
    })
}
function guardar_factura_sobrante() {
    var datos = new FormData(document.querySelector("#factura_form"));
    datos.append('mdate', moment($('mdate').val()).format('YYYY/MM/DD'));
    Swal.fire({
        onOpen: function () {
            Swal.showLoading()
            $.ajax({
                type: 'POST',
                url: '/facturas_sobrantes/agregar',
                data: datos,
                contentType: false,
            	processData: false,
            })
            .done(function(resp) {
                Swal.close()
                if(resp == 'true') {
                    alerta_temporizador(
                        'success',
                        'Factura sobrante',
                        'La factura ha sido agregada con éxito',
                        2500
                    );
                    datos_facturas_sobrantes();
                    datos_facturas_cheques();
                    
                    reset_form('#factura_form', '#factura_archivo');
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
                        'Factura sobrante',
                        'Debe ingresar todos los campos para poder agregar la factura.',
                        2500
                    );
                } else if(resp == 'error') {
                    alerta_temporizador(
                        'error',
                        'Factura sobrante',
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
function guardar_pagar_factura() {
    var datos = new FormData(document.querySelector("#pagar_factura_form"));
    datos.append('fecha', moment().format('YYYY/MM/DD'));
    datos.append('factura_pago_facturas', JSON.stringify($('#factura_pago_facturas').val()));
    Swal.fire({
        onOpen: function () {
            Swal.showLoading()
            $.ajax({
                type: 'POST',
                url: '/facturas_sobrantes/agregar/pago',
                data: datos,
                contentType: false,
            	processData: false,
            })
            .done(function(resp) {
                Swal.close()
                if(resp == 'true') {
                    alerta_temporizador(
                        'success',
                        'Factura sobrante',
                        'La factura ha sido agregada con éxito',
                        2500
                    );
                    datos_facturas_sobrantes();
                    datos_facturas_cheques();
                    
                    reset_form('#pagar_factura_form'); // Falta agregar la imagen
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
                        'Factura sobrante',
                        'Debe ingresar todos los campos para poder agregar la factura.',
                        2500
                    );
                } else if(resp == 'error-pago') {
                    alerta_temporizador(
                        'error',
                        'Factura sobrante',
                        'Ha ocurrido un error al guardar el pago. Inténtelo más tarde.',
                        2500
                    );
                } else if(resp == 'error-relacion') {
                    alerta_temporizador(
                        'error',
                        'Factura sobrante',
                        'Ha ocurrido un error al guardar los tickets relacionados a la factura. Inténtelo más tarde.',
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
        imageUrl = url_images+'/modulos/facturas_sobrantes/'+imageUrl;
    }
    title = `Folio_factura #${title}`;

    Swal.fire({
        title,
        imageUrl,
        imageWidth: 250,
        imageHeight: 450,
        imageAlt: title,
        animation: true,
        showConfirmButton: false
    })
}
function abrir_modal_agregar_factura() {
    $('#modal_factura_sobrante').modal('show');
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
function reset_form(identifier_form, identifier_image) {
    $(identifier_form)[0].reset();
    $('#factura_pago_facturas').val(null).trigger("change"); 
    
    if(identifier_image) {
        let drEvent = $(identifier_image).dropify().data('dropify');
        drEvent.resetPreview();
        drEvent.clearElement();
    }
}