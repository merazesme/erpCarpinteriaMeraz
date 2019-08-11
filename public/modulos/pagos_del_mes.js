$(document).ready(function () {
    $('.dropify').dropify();
    var banderaConceptoPago=0;
    var banderaEditar=0;
    var idConcepto=0;
    estadoVencido();
    listarPagos();
    const swalWithBootstrapButtons="";
    
})

function validation(children, parent){
    if(children.val().length == 0){
        parent.addClass("error");
    }else{
        parent.removeClass("error");
    }
}

function inicializarVariableSwal(){
    swalWithBootstrapButtons = Swal.mixin({
      customClass: {
        confirmButton: 'btn btn-danger',
        cancelButton: 'btn btn-secondary'
      },
      buttonsStyling: false,
    })
}

function eliminarConcepto(id){ 
    inicializarVariableSwal();
    swalWithBootstrapButtons.fire({
      title: '¿Eliminar concepto?',
      text: "No será posible revertirlo",
      type: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Eliminar',
      cancelButtonText: 'Cancelar',
      reverseButtons: true
    }).then((result) => {
      if (result.value) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            data: {id: id},
            url: "/eliminarConcepto/",
            success: function (msg) {
                listarPagos();
                //Success Message
                 Swal.fire({   
                    title: "¡Listo!",   
                    text: "Se ha eliminado el concepto",   
                    timer: 1500,  
                    type: "success", 
                    showConfirmButton: false 
                });
            }, error: function(error) {
                console.log(error);
                 Swal.fire({   
                    title: "Error",   
                    text: "No se ha podido eliminar el concepto",   
                    timer: 1500,  
                    type: "error", 
                    showConfirmButton: false 
                });
            }
        });
      }
    })
}

function estadoVencido(){
    $.ajax({
        type: "GET",
        dataType: "json",
        enctype: "multipart/form-data",
        url: "/consultarUltimo/",
        success: function (msg) {
            for(var i=0; i < msg.length; i++)
            {
                var fechaConcepto = new Date(msg[i].Fecha);
                var fechaActual = new Date();
                // si la fecha de pago ya pasó, cambiar el estado del concepto a vencido
                if (fechaConcepto.getTime()<fechaActual.getTime() && msg[i].Estado == 1) {
                    $.ajax({
                        type: "GET",
                        dataType: "json",
                        enctype: "multipart/form-data",
                        url: "/estadoVencido/"+msg[i].id,
                        success: function (msg) {
                            console.log(msg);
                            listarPagos();
                        }, error: function(error) {
                            console.log("error");
                            console.log(error);
                            return;
                        }
                    });
                }
            }          
        }
    });
}

function listarPagos(){
    //Inicio: Cargar todos los pagos
    $.ajax({
        type: "GET",
        dataType: "json",
        enctype: "multipart/form-data",
        url: "/consultarUltimo/",
        success: function (msg) {
            var html = "";
            var estado ="";
            var fecha="";
            var dia="";
            var mes="";
            var documento="";

            if (msg.length==0) {
                html += `
                    <div style="width:100%; height:100%; text-align: center;">
                        <h4 style="display: inline-block; vertical-align: middle; line-height:normal;">No hay pagos pendientes este mes</h4>
                    </div>
                    `;
            }else{
                for (var i = 0; i < msg.length; i++) 
                {
                    if(msg[i].Estado == 0)
                        i++; 
                    if(msg[i].Estado == 1)
                        estado='<span class="badge badge-secondary">Pendiente</span>'; 
                    if(msg[i].Estado == 2)
                        estado='<span class="badge badge-success">Pagado</span>';
                    if(msg[i].Estado == 3)
                        estado='<span class="badge badge-danger">Vencido</span>';

                    fecha = (msg[i].Fecha).split("-");
                    fechaT = fecha[2] + "-" + fecha[1] + "-" + fecha[0];

                    if (msg[i].Documento != null) 
                    {
                        documento = `<span  data-toggle="tooltip" data-original-title="Ver comprobante">
                                        <a href="#" onclick="alerta_imagen('${msg[i].Concepto}', '${msg[i].Documento}')">
                                            <i class="icon-doc text-secondary"></i>
                                         </a>
                                     </span>`;
                    }
                    else{
                        documento = ``;
                    }

                    html += `
                        <tr role="row" class="odd">
                            <td>${fechaT}</td>
                            <td class="sorting_1">${msg[i].Concepto}</td>
                            <td>$${msg[i].Cantidad}</td>
                            <td>${estado}</td>
                            <td class="text-nowrap">
                                <span  data-toggle="tooltip" data-original-title="Editar">
                                    <a href="#modalConceptoPagodelMes" onclick="montarDatos(${msg[i].id})" data-toggle="modal" data-whatever="Editar">
                                        <i class="icon-pencil text-primary m-r-10"></i>
                                    </a>
                                </span>
                                <span  data-toggle="tooltip" data-original-title="Subir comprobante">
                                    <a onclick="montarIdModalSubirArchivo(${msg[i].id})">
                                        <i class="icon-check text-success m-r-10"></i>
                                    </a>
                                </span>
                                <span  data-toggle="tooltip" data-original-title="Eliminar">
                                    <a href="#" data-toggle="modal" onclick="eliminarConcepto(${msg[i].id})">
                                        <i class="icon-close text-danger"></i>
                                    </a>
                                </span>
                                ${documento}
                            </td>
                        </tr>
                    `;
                }
            }

            $("#contenedorConceptosPago")
                .empty()
                .append(html); 
        }
    });
}

function alerta_imagen(title, imageUrl) {
    if(imageUrl == '') {
        imageUrl = url_images+'/error/no_image_available.jpg';
    } else {
        imageUrl = url_images+'/modulos/pagosdelmes/'+imageUrl;
    }
    title = `Comprobante de pago: ${title}`;

    Swal.fire({
        title,
        imageUrl,
        imageWidth: 250,
        imageHeight: 380,
        imageAlt: title,
        animation: true
    })
}

$("#btnGuardarConceptoPago").click(function(){
    var banValidation=false;

    if($("#fechaVencimiento").val().length == 0){
        validation($("#fechaVencimiento"), $("#fechaVencimiento").parent());
        banValidation=true;
    }
    
    if($("#nombreConcepto").val().length == 0){
        validation($("#nombreConcepto"), $("#nombreConcepto").parent());
        banValidation=true;
    }
    
    if($("#cantidadPago").val().length == 0){
        validation($("#cantidadPago"), $("#cantidadPago").parent());
        banValidation=true;
    }

    // Si los campos estan llenos pasa
    if (banValidation==false)
    {
        $("#descripcionPendiente").parent().removeClass("error");
        $("#nombreConcepto").parent().removeClass("error");
        $("#cantidadPago").parent().removeClass("error");

        datos = new FormData(document.querySelector('#formConceptosPago'));
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        if (banderaEditar==0)
        {
            $.ajax({
            type: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            data: datos,
            dataType: false,
            enctype: 'multipart/form-data',
            url: '/nuevoConcepto',
            success: function(msg){
                listarPagos();
                //Success Message
                 Swal.fire({   
                    title: "¡Listo!",   
                    text: "Se ha guardado el concepto",   
                    timer: 1500,  
                    type: "success", 
                    showConfirmButton: false 
                });
                $('#modalConceptoPagodelMes').modal('hide');
            }, error: function(error) {
                //Error Message
                 Swal.fire({   
                    title: "Error",   
                    text: "No se ha podido registrar el concepto",   
                    timer: 1500,  
                    type: "error", 
                    showConfirmButton: false 
                });
                return;
            }
        });
        
        //Editar pendiente
        }else if(banderaEditar==1)
        {
            $.ajax({
                type: 'POST',
                processData: false,
                contentType: false,
                cache: false,
                data: datos,
                dataType: false,
                enctype: 'multipart/form-data',
                url: '/editarConcepto/'+idConcepto,
                success: function(msg){
                    listarPagos();
                    //Success Message
                     Swal.fire({   
                        title: "¡Listo!",   
                        text: "Se ha modificado el concepto",   
                        timer: 1500,  
                        type: "success", 
                        showConfirmButton: false 
                    });
                    $('#modalConceptoPagodelMes').modal('hide');
                }, error: function(error) {
                    //Error Message
                     Swal.fire({   
                        title: "Error",   
                        text: "No se ha podido modificar el concepto",   
                        timer: 1500,  
                        type: "error", 
                        showConfirmButton: false 
                    });
                    return;
                }
            });
        }  
    }
});

$("#btnAgregarConcepto").click(function(){
    banderaEditar=0;
    limpiarModal();
    $.ajax({
        type: "GET",
        dataType: "json",
        enctype: "multipart/form-data",
        url: "/consultarUltimo/",
        success: function (msg) {
            
            var date = new Date(msg[0].Fecha);
            var primerDia = new Date(date.getFullYear(), date.getMonth(), 1);
            var ultimoDia = new Date(date.getFullYear(), date.getMonth() + 1, 0);

            var mes = primerDia.getMonth()+1;
            if (parseInt(mes) < 10) {
                console.log("entra");
                mes = "0"+mes;
            }

            primerDia = primerDia.getFullYear() + "-" + mes + "-" + "0" + primerDia.getDate();
            ultimoDia = ultimoDia.getFullYear() + "-" + mes + "-" + ultimoDia.getDate();
            
            console.log("primerDia: "+primerDia+", ultimoDia: "+ultimoDia);
            $("#fechaVencimiento").attr("min", primerDia);
            $("#fechaVencimiento").attr("max", ultimoDia);
        }
    });
    
})
function limpiarModal(){
    $("#fechaVencimiento").val("");
    $("#nombreConcepto").val("");
    $("#cantidadPago").val("");
    $("#observacionPago").val("");            
    $(".idConceptoModal").val("");
}

function montarDatos(id){
    banderaEditar=1;
    idConcepto=id;
    limpiarModal();
    $.ajax({
        type: "GET",
        dataType: "json",
        enctype: "multipart/form-data",
        url: "/montarDatosConcepto/"+id,
        success: function (msg) {
            
            //Montar datos
            $("#fechaVencimiento").val(msg.Fecha);
            $("#nombreConcepto").val(msg.Concepto);
            $("#cantidadPago").val(msg.Cantidad);
            $("#observacionPago").val(msg.Observacion);            

            $(".idConceptoModal").val(idConcepto);
        }, error: function(error) {
            console.log("error");
            return;
        }
    });
}

$("#btnRenovarHoja").click(function(){
    const swalWithBootstrapButtons = Swal.mixin({
      customClass: {
        confirmButton: 'btn btn-info',
        cancelButton: 'btn btn-secondary'
      },
      buttonsStyling: false,
    })

    $.ajax({
        type: "GET",
        dataType: "json",
        enctype:"multipart/form-data",
        url: "/consultarUltimo/",
        success: function (msg) {
            var estado ="";
            var banderaConceptoNoPagado=0;
            for(var i=0; i < msg.length; i++)
            {
                // si no se ha pagado el concepto no se puede renovar la hoja
                if (msg[i].Estado != '2' && msg[i].Documento == null) {
                    banderaConceptoNoPagado=1;
                    break;
                }
            }
            if (banderaConceptoNoPagado == 0) 
            {
                swalWithBootstrapButtons.fire({
                  title: '¿Generar nueva hoja?',
                  text: "",
                  type: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Generar',
                  cancelButtonText: 'Cancelar',
                  reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            type: "GET",
                            dataType: "json",
                            enctype: "multipart/form-data",
                            url: "/consultarUltimo/",
                            success: function (msg) {
                                var datos = msg;
                                console.log(datos);
                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
                                });
                                for (var i=0; i<datos.length; i++) {

                                    //Modificar la fecha de los datos al mes nuevo

                                    var fecha = (msg[i].Fecha).split("-");
                                    var mesConsulta = parseInt(fecha[1]);
                                    //si aun no llega al final del año se le puede sumar 1 al mes
                                    if (mesConsulta<12) {
                                        var mes = mesConsulta+1;
                                        datos[i].Fecha = fecha[0] + "-" + mes + "-" + fecha[2];
                                    }//si ya llego al final del mes se le debe de sumar 1 al año y poner en 1 el mes
                                    else if (mesConsulta==12){
                                        var anio = parseInt(fecha[0])+1;
                                        datos[i].Fecha = anio + "-" + '01' + "-" + fecha[2];
                                    }
                                    
                                    //El id del usuario logeado va aqui!!!!
                                    datos[i].idUsuario = 1;
                                    var banderaNuevaHoja=0;
                                    $.ajax({
                                        data: datos[i],
                                        type: "POST",
                                        url: '/renovarHojaPagos',
                                        success: function(msg){
                                            //Success Message
                                            
                                        }, error: function(error) {
                                            //Error Message
                                            banderaNuevaHoja=1;
                                        }
                                    });
                                }
                                if (banderaNuevaHoja!=1) 
                                {
                                    listarPagos();
                                     Swal.fire({   
                                        title: "¡Listo!",   
                                        text: "Se ha renovado la hoja de pagos mensuales",   
                                        timer: 1500,  
                                        type: "success", 
                                        showConfirmButton: false 
                                    });
                                }else
                                {
                                     Swal.fire({   
                                        title: "Error",   
                                        text: "No se ha podido renovar la hoja de pagos mensuales",   
                                        timer: 1500,  
                                        type: "error", 
                                        showConfirmButton: false 
                                    });
                                }
                            }
                        });
                    }
                })
            }else
            {
                 Swal.fire({   
                    title: "Movimiento invalido",   
                    text: "No se puede renovar la hoja de pagos mensuales si no se han saldado todos los conceptos",
                    type: "error", 
                    showConfirmButton: true 
                });
            }            
        }
    });
});

function montarIdModalSubirArchivo(id){
    $('#modalAdjuntarPagodelMes').modal('show');
    $(".idRegistro").val(id);   
    var drEvent = $('#pagoconcepto_archivo').dropify();
    drEvent = drEvent.data('dropify');
    drEvent.resetPreview();
    drEvent.clearElement();
}

$("#btnSubirPagoConcepto").click(function(){
    var banValidation=false;
    var id = $(".idRegistro").val();

    if($("#pagoconcepto_archivo").val().length == 0){
        $("#txtArchivo-error").show();
        banValidation=true;
    }

    // Si los campos estan llenos pasa
    if (banValidation==false)
    {
        console.log("proceso de guardado");
        $("#txtArchivo-error").hide();

        archivo = new FormData(document.querySelector('#pagoConcepto'));
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            data: archivo,
            dataType: false,
            enctype: 'multipart/form-data',
            url: '/subirArchivo/'+id,
            success: function(msg){
                //Success Message
                listarPagos();
                 Swal.fire({   
                    title: "¡Listo!",   
                    text: "Se ha guardado el comprobante de pago",   
                    timer: 1500,  
                    type: "success", 
                    showConfirmButton: false 
                });
                $('#modalAdjuntarPagodelMes').modal('hide');
            }, error: function(error) {
                //Error Message
                 Swal.fire({   
                    title: "Error",   
                    text: "No se ha podido guardar el comprobante de pago",   
                    timer: 1500,  
                    type: "error", 
                    showConfirmButton: false 
                });
                $('#modalAdjuntarPagodelMes').modal('hide');
                return;
            }
        }); 
    }
});


$('#modalConceptoPagodelMes').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient = button.data('whatever') // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  modal.find('.modal-title').text(recipient + ' concepto de pago')
})