$(document).ready(function() {
    $("body").tooltip({ selector: '[data-toggle="tooltip"]' });
    $(".select2").select2();
    $('.mydatepicker, #mdate').datepicker();
    $('.dropify').dropify();
    initialize_data_table('#table_gasolina');

    datos_gasolina_factura();
});    
function datos_gasolina_factura() {
    $.ajax({
        type: 'GET',
        url: 'gasolina/data'
    }).done(function(datos) {
        console.table(datos);
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
                $('#table_gasolina tbody').append(`
                    <tr role="row">
                        <td>${item.Nombre}</td>
                        <td>${item.RFC}</td>
                        <td>${item.Telefono}</td>
                        <td>${item.Email}</td>
                        <td align="right">$${item.Adeudo}</td>
                        <td style="cursor:pointer" class="color-elegant-blue" onclick="enlace_editar_proveedor(${item.id})" data-toggle="tooltip" 
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
            initialize_data_table('#table_proveedores');
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
function alerta_temporizador(tipo, titulo, texto, tiempo) {
    Swal.fire({
        type: tipo,
        title: titulo,
        text: texto,
        showConfirmButton: false,
        timer: tiempo
    });
}
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