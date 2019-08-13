$(document).ready(function() {
    $("body").tooltip({ selector: '[data-toggle="tooltip"]' });
    // console.log("puto el que lo lea");
    /** Cargar los datos de los registros en general */
    datosCotizaciones();
});
//sweet alert
function mensaje(titulo, msg, tipo){
    Swal.fire({
        type: tipo,
        title: titulo,
        text: msg,
        timer: 1500,
        showConfirmButton: false
    });
}
//

var todos = [];
function datosCotizaciones(){
    $.ajax({
        type: "GET",
        dataType: "json",
        enctype: "multipart/form-data",
        url: base_url+'/cotizaciones/getCotizaciones',
        success: function (msg) {
            var data = JSON.parse(msg)
            console.log(data);
            var html = "";
            if(data.length > 0){
                $("#cotizaciones").DataTable().destroy();
                const month = ["Ene", "Feb", "Mar","Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"];

                data.forEach(item =>{
                    if(item.Estado == 0){
                        todos.push(item.id);
                        var estado = `<span class="badge badge-success">Aceptada</span>`;
                        var mensaje = "En taller"
                        if(item.Estado == 0){
                            estado = `<span class="badge badge-danger">Rechazada</span>`
                            mensaje = "Cambiar estado a Aceptado"
                        } else if(item.Estado == 2){
                            estado = `<span class="badge badge-warning">En taller</span>`
                            mensaje = "Cambiar estado a Terminado"
                        }else if(item.Estado == 3){
                            estado = `<span class="badge badge-secondary">Por confirmar</span>`
                            mensaje = "Cambiar estado"
                        }else if(item.Estado == 4){
                            estado = `<span class="badge badge-info">Terminado</span>`
                        }

                        var cambiarEstado = `<a class="cambiarEstado" estado="${item.Estado}" href="#" data-toggle="tooltip" data-original-title="${mensaje}"><i class="text-success icon-note m-r-10"></i></a>`
                        if(item.Estado == 4){
                            cambiarEstado="";
                        }

                        let fecha_inicio = '<i class="mdi mdi-minus"></i>'
                        let fecha_fin = '<i class="mdi mdi-minus"></i>'
                        if(item.fecha_inicio){
                            let fecha = new Date(item.fecha_inicio)
                            fecha_inicio = fecha.getDate() + "/" + month[fecha.getMonth()] + "/" + fecha.getFullYear()
                        }

                        if(item.fecha_fin){
                            let fecha = new Date(item.fecha_fin)
                            fecha_fin = fecha.getDate() + "/" + month[fecha.getMonth()] + "/" + fecha.getFullYear()
                        }

                        if(item.Apellidos == null){
                            item.Apellidos = "";
                        }

                        var url_documento = `<a class="documentoCotizacion" href="${base_url+"/documentos/cotizaciones/"+item.Documento}" download="${item.Documento}" data-toggle="tooltip" data-original-title="Descargar Documento"><i class="icon-doc"></i></a>`
                        if(item.Documento == null){
                            url_documento = "";
                        }

                        html += `
                        <tr id="${item.id}">
                            <td>${fecha_inicio}</td>
                            <td>${fecha_fin}</td>
                            <td>${item.Descripcion}</td>
                            <td>${estado}</td>
                            <td>${item.Nombre +" "+ item.Apellidos}</td>
                            <td class="text-nowrap" id="${item.id}">
                                <a class="correoIndividual" href="#" data-toggle="tooltip" data-original-title="Mandar encuesta de calidad"><i class="icon-envelope-letter m-r-10"></i></a>
                                ${url_documento}
                            </td>
                        </tr>`
                    }
                });
                $("#cotizaciones tbody").empty().append(html);
            }

            $("#cotizaciones").DataTable({
              dom: 'Bfrtip',
              buttons: ['excel', 'pdf', 'print']
            });

        }
    });
}

$("body").on("click", ".correoIndividual", function(e){
    e.preventDefault();
    if(todos.length > 0){
        var datos = new FormData();
        datos.append("usuarios", JSON.stringify([$(this).parent().attr("id")]));
        datos.append("_token", token);
        console.log($(this).parent().attr("id"));

        Swal.fire({
            onOpen: function () {
                Swal.showLoading()
                $.ajax({
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    cache: false,
                    data: datos,
                    dataType: false,
                    enctype: 'multipart/form-data',
                    url: base_url+'/crm/correoCalidad/',
                })
                .done(function(msg) {
                    console.log(msg);
                    Swal.close()
                    data = JSON.parse(msg);
                    console.log(data);
                    if(data == 0){
                        mensaje("Correo enviado", "Se ha enviado el correo correctamente.", "success");
                    }else if(data == 1){
                        mensaje("CRM", "Ha ocurrido un error al enviar la cotización, inténtelo más tarde.", "error");
                    }else if(data == 2){
                        mensaje("CRM", "Ha ocurrido un error al obtener la encuesta, inténtelo más tarde.", "error");
                    }
                })
                .fail(function(err) {
                    mensaje("CRM", "Ha ocurrido un error, inténtelo más tarde.", "error");
                });
            }
        })
    }
})

function correos(){
    console.log("a");
    if(todos.length > 0){
        var datos = new FormData();
        datos.append("usuarios", JSON.stringify(todos));
        datos.append("_token", token);
        console.log(todos.length);
        console.log(todos);

        Swal.fire({
            onOpen: function () {
                Swal.showLoading()
                $.ajax({
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    cache: false,
                    data: datos,
                    dataType: false,
                    enctype: 'multipart/form-data',
                    url: base_url+'/crm/correoCalidad/',
                })
                .done(function(msg) {
                    console.log(msg);
                    Swal.close()
                    data = JSON.parse(msg);
                    console.log(data);
                    if(data == 0){
                        mensaje("Correo enviado", "Se ha enviado el correo correctamente.", "success");
                    }else if(data == 1){
                        mensaje("CRM", "Ha ocurrido un error al enviar la cotización, inténtelo más tarde.", "error");
                    }else if(data == 2){
                        mensaje("CRM", "Ha ocurrido un error al obtener la encuesta, inténtelo más tarde.", "error");
                    }
                })
                .fail(function(err) {
                    mensaje("CRM", "Ha ocurrido un error, inténtelo más tarde.", "error");
                });
            }
        })
    }
}
