$(document).ready(function () {
    //variables globales
    var banderaCita=0;
    var idCitaModificar=0;
    var banderaPendiente=0;
    var idPendienteModificar=0;

    //mandar fecha al filtro de citas
    var week = saberSemana();
    $("#filtroCita").val(week);

    var fecha = new Date();
    var mes = (fecha.getMonth()+1);
    var dia = fecha.getDate();
    if (mes>=0 && mes<=9) {
        mes = "0"+mes;
    }
    if (dia>=0 && dia<=9) {
        dia = "0"+dia;
    }

    fecha = fecha.getFullYear() + "-" + mes + "-" + dia + "T" + fecha.getHours() + ":" + fecha.getMinutes();
    $("#fechaCita").attr("min", fecha);

    //Modulo: Citas  
    cambioFiltroCita();
    cargarClientes();

    //Modulo: Pendientes
    listarPendientes();

    //Modulo carpeta del mes
    var fechaSinHora = new Date();
    fechaSinHora = fechaSinHora.getFullYear() + "-" + mes + "-" + dia;
    $("#filtroDiaReportedelDia").val(fechaSinHora);
    filtarDiaReporteDia(fechaSinHora);

    //Modulo cotizaciones
    llenarFiltroCotizaciones();
    var fechaCotizaciones = new Date();
    var mesActual = fechaCotizaciones.getMonth();
    $('#filtroMesCotizaciones option[value="'+mesActual+'"]').attr("selected", true);
    mostrarCotizaciones();

})

// *********************************** INICIO MODULO: CITAS **********************************
function validation(children, parent){
    if(children.val().length == 0){
        parent.addClass("error");
    }else{
        parent.removeClass("error");
    }
}

function saberSemana(){
    var a = new Date().getFullYear();
    var fecha=new Date(a,0,1);
    var fecha2=new Date();
    var tiempopasado=fecha2-fecha;
    var semana=Math.floor(tiempopasado/1000/60/60/24/7)+1;
    if(semana==0){semana=52}    
    var anio = fecha2.getFullYear();
    return anio+"-W"+semana;
}

function cambioFiltroCita(){
    var week = $("#filtroCita").val();
    var numWeek = week.split("-W");
    listarCitas((numWeek[1])-1);
}

$("#filtroCita").on("change", function () {
    cambioFiltroCita();
});

function eliminarCita(id){
     SwalWithBootstrapButtons = Swal.mixin({
      customClass: {
        confirmButton: 'btn btn-danger',
        cancelButton: 'btn btn-secondary'
      },
      buttonsStyling: false,
    })

    SwalWithBootstrapButtons.fire({
      title: '¿Eliminar registro?',
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
            url: "/eliminarCita",
            success: function (msg) {
                var week = $("#filtroCita").val();
                var numWeek = week.split("-W");
                listarCitas((numWeek[1])-1);
                    Swal.fire({   
                        title: "¡Listo!",   
                        text: "Se ha eliminado la cita",   
                        timer: 1500,  
                        type: "success", 
                        showConfirmButton: false 
                    });
            }, error: function(error) {
                //Error Message
                console.log(error);
                Swal.fire({   
                        title: "Error",   
                        text: "No se ha podido eliminar la cita",   
                        timer: 1500,  
                        type: "error", 
                        showConfirmButton: false 
                    });
            }
        });
      }
  })
}
function listarCitas($week){
    //Inicio: Cargar todas las citas
    $.ajax({
        type: "GET",
        dataType: "json",
        enctype: "multipart/form-data",
        url: "/consultarCitas/"+$week,
        success: function (msg) {
            var html = "";
            var fecha = "";
            var hora = ""; 
            var estado ="";
            var nombreCliente="";
            var options = { weekday: 'short', month: 'long', day: 'numeric' };

            if (msg.length==0) {
                html += `
                    <div style="width:100%; height:100%; text-align: center;">
                        <h4 style="display: inline-block; vertical-align: middle; line-height:normal;">No hay citas esta semana</h4>
                    </div>
                    `;
            }else{
                for (var i = 0; i < msg.length; i++) 
                {
                    if (msg[i].Apellidos!=null) 
                        nombreCliente= msg[i].Nombre + " " + msg[i].Apellidos;
                    else
                       nombreCliente= msg[i].Nombre;

                    fecha = new Date(msg[i].Fecha);
                    if (fecha.getMinutes()=="0") {
                        hora = fecha.getHours()+":00";
                    }
                    else if(fecha.getMinutes()>=1 && fecha.getMinutes()<=9) {
                        hora = fecha.getHours()+":0"+fecha.getMinutes();
                    }
                    else{
                        hora = fecha.getHours()+":"+fecha.getMinutes();
                    }
                    if(msg[i].Estado == 0)
                        estado=''; 
                    else if(msg[i].Estado == 1)
                        estado='<span class="label label-rounded label-success">Asistió</span>'; 
                    else if(msg[i].Estado == 2)
                        estado='<span class="label label-rounded label-danger">Cancelada</span>';

                    html += `
                    <div class="d-flex flex-row comment-row">
                        <div class="comment-text w-100">
                            <input type="hidden" class="idCita" value="${msg[i].id}"></input>
                            <h5>${nombreCliente}</h5>
                            <p class="m-b-5">${msg[i].Comentario}</p>
                            <div class="comment-footer"> 
                                <span class="text-muted pull-right">${fecha.toLocaleDateString("es-ES", options)+" - "+hora}</span> 
                                ${estado}
                                <span class="action-icons">
                                    <button class="btnEditarCita" onclick="montarDatosCita(${msg[i].id})" data-toggle="modal" data-target="#modalCita" data-whatever="Editar" style="background: transparent; border: none !important;">
                                        <span data-toggle="tooltip" data-original-title="Editar">
                                            <a href="javascript:void(0)"><i class="ti-pencil-alt"></i></a>
                                        </span>
                                    </button>
                                    <button class="btnEliminarCita" onclick="eliminarCita(${msg[i].id})" style="background: transparent; border: none !important;">
                                        <span data-toggle="tooltip" data-original-title="Eliminar">
                                            <a href="javascript:void(0)"><i class="ti-close"></i></a>
                                        </span>
                                    </button>
                                </span> 
                            </div>
                        </div>
                    </div>
                    `;
                }
            }

            $("#contenedorCitas")
                .empty()
                .append(html); 
        }
    });
}

function cargarClientes() {
    //Inicio: Cargar todos los clientes
    $.ajax({
        type: "GET",
        dataType: "json",
        enctype: "multipart/form-data",
        url: "/consultarClientes",
        success: function (msg) {
            var html = "";
            var nombreCliente = "";
            html += `
            <option value="0">Selecciona un cliente</option>
            `;
            for (var i = 0; i < msg.length; i++) {

                if (msg[i].Apellidos!=null) 
                    nombreCliente= msg[i].Nombre + " " + msg[i].Apellidos;
                else
                   nombreCliente= msg[i].Nombre;

                html += `
                <option value="${msg[i].id}">${nombreCliente}</option>
                `;
            }

            $("#selectClientes")
                .empty()
                .append(html);   
        }
    });
}

function montarDatosCita(id){
    banderaCita=1;
    idCitaModificar=id;
    limpiarModalCitas();
    $.ajax({
        type: "GET",
        dataType: "json",
        enctype: "multipart/form-data",
        url: "/montarDatosCita/"+id,
        success: function (msg) {
            // Montar cliente en select
            var nombreCompleto;
            if (msg.cliente.Apellidos == null) 
                nombreCompleto=msg.cliente.Nombre;
            else
                nombreCompleto=msg.cliente.Nombre + " " + msg.cliente.Apellidos;

            $("#selectClientes").val(msg.Clientes_id);
            $("#select2-selectClientes-container").text(nombreCompleto);

            //Montar descripcion
            $("#comentario").val(msg.Comentario);

            //Montar fecha
            var dt = msg.Fecha.split(' ');
            var fecha = dt[0] + "T" + dt[1];
            $("#fechaCita").val(fecha);

            //Montar estado
            $("#selectEstadoCitas").val(msg.Estado);
            //Montar id de la cita
            $(".idCitaModal").val(idCitaModificar);
        }, error: function(error) {
            console.log("error");
            console.log(error);
            return;
        }
    });
}

function obtenerCitaPorFecha(fecha){
    var resp = [];
    $.ajax({
        type: "GET",
        dataType: "json",
        enctype: "multipart/form-data",
        url: "/consultaCitaFecha/"+fecha,
        success: function (msg) {
            resp = msg;
              
        }, error: function(error) {
            console.log("error");
            console.log(error);
            return;
        }
    });
}

function limpiarModalCitas(){

    $('#selectClientes').val(0);

    //Montar descripcion
    $("#comentario").val("");

    //Montar fecha
    $("#fechaCita").val("");
    
    //Montar estado
    $("#selectEstadoCitas").val(0);

    $("#txtFecha-error").hide();

    $("#txtEstatus-error").hide();
}

$("#btnNuevaCita").click(function() {
    banderaCita=0;
    limpiarModalCitas();
});

$("#btnGuardarCita").click(function() {
    var citaFecha = false;

    var banValidation=false;
    if($(".cliente").val()<1){
        banValidation=true;
        $("#txtCliente-error").show();
    }else{
        $("#txtCliente-error").hide();
    }

    if($(".comentario").val().length == 0){
        validation($(".comentario"), $(".comentario").parent());
        banValidation=true;
    }

    if($(".fecha").val().length == 0){
        validation($(".fecha"), $(".fecha").parent());
        banValidation=true;
    }
    // Si los campos estan llenos pasa
    if (banValidation==false)
    {
        var fechaSeparada = $(".fecha").val();
        fechaSeparada = fechaSeparada.split("T");
        var fecha = fechaSeparada[0]+" "+fechaSeparada[1]+":00"; 

        $.ajax({
            type: "GET",
            dataType: "json",
            enctype: "multipart/form-data",
            url: "/consultaCitaFecha/"+fecha,
            success: function (msg) 
            {

                datos = new FormData(document.querySelector('#citas'));
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var idCitaModal = $(".idCitaModal").val();

                /* Si no encuentra citas diferentes con esa fecha se guarda
                   como nueva cita */
                if (msg.length==0 && banderaCita==0)
                {
                    $(".fecha").parent().removeClass("error");
                    $("#txtFecha-error").hide();

                    $.ajax({
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    cache: false,
                    data: datos,
                    dataType: false,
                    enctype: 'multipart/form-data',
                    url: '/nuevaCita',
                    success: function(msg){
                        cambioFiltroCita();
                        //Success Message
                        Swal.fire({   
                            title: "¡Listo!",   
                            text: "Se ha guardado el registro de la cita",   
                            timer: 1500,  
                            type: "success", 
                            showConfirmButton: false 
                        });
                        $("#txtCliente-error").hide();
                        $(".fecha").parent().removeClass("error");
                        $(".comentario").parent().removeClass("error");
                        $('#modalCita').modal('hide');
                    }, error: function(error) {
                        //Error Message
                        Swal.fire({   
                            title: "Error",   
                            text: "No se ha podido registrar la cita",   
                            timer: 1500,  
                            type: "error", 
                            showConfirmButton: false 
                        });
                        return;
                    }
                    });
                
                //Editar cita no encuentra una cita diferente con la misma hora
                }else if((msg.length == 0 && banderaCita==1) || (msg.length==1 && idCitaModal==msg[0].id && banderaCita==1))
                {
                    var fechaSeleccionada = new Date($(".fecha").val());
                    var fechaActual = new Date();

                    /* Validar al momento de cambiar el estado de la cita
                    si la fecha seleccionada no ha pasado no es posible cambiar el estado a "asistió" */
                    if (fechaSeleccionada.getTime() > fechaActual.getTime() && $("#selectEstadoCitas").val() == 1) {
                        $("#txtEstatus-error").show();
                         validation($(".fecha"), $(".fecha").parent());
                    }else{
                        $("#txtEstatus-error").hide();
                        $(".fecha").parent().removeClass("error");
                        $.ajax({
                            type: 'POST',
                            processData: false,
                            contentType: false,
                            cache: false,
                            data: datos,
                            dataType: false,
                            enctype: 'multipart/form-data',
                            url: '/editarCita/'+idCitaModificar,
                            success: function(msg){
                                cambioFiltroCita();
                                //Success Message
                                Swal.fire({   
                                    title: "¡Listo!",   
                                    text: "Se ha modificado la cita",   
                                    timer: 1500,  
                                    type: "success", 
                                    showConfirmButton: false 
                                });
                                $('#modalCita').modal('hide');
                            }, error: function(error) {
                                //Error Message
                                Swal.fire({   
                                    title: "Error",   
                                    text: "No se ha podido modificar la cita",   
                                    timer: 1500,  
                                    type: "error", 
                                    showConfirmButton: false 
                                });
                                return;
                            }
                        });
                    }
                } 
                else{
                    validation($(".fecha"), $(".fecha").parent());
                    $("#txtFecha-error").show();
                }
                  
            }, error: function(error) {
                console.log("error");
                console.log(error);
                return;
            }
        });
    }
});

$('#modalCita').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient = button.data('whatever') // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  modal.find('.modal-title').text(recipient + ' cita')
  if (recipient=="Añadir")
  {
    $("#estatusCita").hide();
    $("#estatusCita").val(0);
  }else if(recipient=="Editar"){
    $("#estatusCita").show();
  }
})

//*********************************** FIN MODULO: CITAS ***********************************

//*********************************** INICIA MODULO: PENDIENTES ***********************************
$("#btnNuevoPendiente").click(function() {
    banderaPendiente=0;
    limpiarModalPendientes();
});

 $("#btnEliminarPendientes").click(function() {
    $.ajax({
        type: "GET",
        dataType: "json",
        enctype: "multipart/form-data",
        url: "/eliminarPendientes",
        success: function (msg) {
            if (msg==1) {
                listarPendientes();
                Swal.fire({   
                    title: "¡Listo!",   
                    text: "Se han eliminado todos los pendientes terminados",   
                    timer: 1500,  
                    type: "success", 
                    showConfirmButton: false 
                });
            }else{
                Swal.fire({   
                    title: "Acción inválida",   
                    text: "No se ha terminado ningún pendiente",   
                    timer: 1500,  
                    type: "warning", 
                    showConfirmButton: false 
                });
            }
        }, error: function(error) {
            //Error Message
            console.log(error);
            Swal.fire({   
                    title: "Error",   
                    text: "Se ha podido ejecutar la acción",   
                    timer: 1500,  
                    type: "error", 
                    showConfirmButton: false 
                });
        }
    });
});

function actEstatusPendiente(id){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'POST',
        data: {id: id},
        url: '/actualizarEstatusPendiente',
        success: function(msg){
            //Success Message
            console.log(msg);
            listarPendientes();
        }, error: function(error) {
            //Error Message
            console.log(error);
        }
    });
}

function listarPendientes(){
    //Inicio: Cargar todas las citas
    $.ajax({
        type: "GET",
        dataType: "json",
        enctype: "multipart/form-data",
        url: "/consultarPendientes/",
        success: function (msg) {
            var html = "";

            if (msg.length==0) {
                html += `
                    <div style="width:100%; height:100%; text-align: center;">
                        <h4 style="display: inline-block; vertical-align: middle; line-height:normal;">No hay pendientes</h4>
                    </div>
                    `;
            }else{
                var inputCheckBox = "";
                for (var i = 0; i < msg.length; i++) 
                {
                if (msg[i].Estado == 0) 
                    inputCheckBox = `<input type="checkbox" id="pendienteNo.${msg[i].id}"  onclick="actEstatusPendiente(${msg[i].id})" name="inputCheckboxesSchedule" checked>`;
                else
                    inputCheckBox = `<input type="checkbox" id="pendienteNo.${msg[i].id}"  onclick="actEstatusPendiente(${msg[i].id})" name="inputCheckboxesSchedule">`;

                    html += `
                        <li class="list-group-item" data-role="task" >
                            <div class="checkbox checkbox-info m-b-10 row">
                                <div class="col-lg-11">
                                    ${inputCheckBox}
                                    <label for="pendienteNo.${msg[i].id}" class=""> 
                                        <span>${msg[i].Descripcion}</span>
                                    </label>
                                </div>
                                <div class="col-lg-1">
                                    <span class="action-icons">
                                        <button class="btnEditarPendiente" onclick="montarDatosPendiente(${msg[i].id})" data-toggle="modal" data-target="#modalPendientes" data-whatever="Editar" style="background: transparent; border: none !important;">
                                            <span data-toggle="tooltip" data-original-title="Editar">
                                                <a href="javascript:void(0)"><i class="ti-pencil-alt"></i></a>
                                            </span>
                                        </button>
                                    </span> 
                                </div>
                            </div>
                            <input type="hidden" class="idPendiente" value="${msg[i].id}"></input>
                        </li>
                    `;
                }
            }

            $("#contenedorPendientes")
                .empty()
                .append(html); 
        }
    });
}

function montarDatosPendiente(id){
    limpiarModalPendientes();
    banderaPendiente=1;
    idPendienteModificar=id;
    $.ajax({
        type: "GET",
        dataType: "json",
        enctype: "multipart/form-data",
        url: "/montarDatosPendiente/"+id,
        success: function (msg) {

            //Montar descripcion
            $("#descripcionPendiente").val(msg.Descripcion);

        }, error: function(error) {
            console.log("error");
            console.log(error);
            return;
        }
    });
}
$("#btnGuardarPendiente").click(function() {
    var banValidation=false;

    if($("#descripcionPendiente").val().length == 0){
        validation($("#descripcionPendiente"), $("#descripcionPendiente").parent());
        banValidation=true;
    }
    // Si los campos estan llenos pasa
    if (banValidation==false)
    {
        $("#descripcionPendiente").parent().removeClass("error");
        datos = new FormData(document.querySelector('#pendientes'));
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        if (banderaPendiente==0)
        {
            
            $.ajax({
            type: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            data: datos,
            dataType: false,
            enctype: 'multipart/form-data',
            url: '/nuevoPendiente',
            success: function(msg){
                listarPendientes();
                //Success Message
                swal.fire({   
                    title: "¡Listo!",   
                    text: "Se ha guardado el registro del pendiente",   
                    timer: 1500,  
                    type: "success", 
                    showConfirmButton: false 
                });
                $("#descripcionPendiente").parent().removeClass("error");
                $('#modalPendientes').modal('hide');
            }, error: function(error) {
                //Error Message
                swal.fire({   
                    title: "Error",   
                    text: "No se ha podido registrar el pendiente",   
                    timer: 1500,  
                    type: "error", 
                    showConfirmButton: false 
                });
                return;
            }
        });
        
        //Editar pendiente
        }else if(banderaPendiente==1)
        {
            $.ajax({
                type: 'POST',
                processData: false,
                contentType: false,
                cache: false,
                data: datos,
                dataType: false,
                enctype: 'multipart/form-data',
                url: '/editarPendiente/'+idPendienteModificar,
                success: function(msg){
                    listarPendientes();
                    //Success Message
                    swal.fire({   
                        title: "¡Listo!",   
                        text: "Se ha modificado el pendiente",   
                        timer: 1500,  
                        type: "success", 
                        showConfirmButton: false 
                    });
                    $("#descripcionPendiente").parent().removeClass("error");
                    $('#modalPendientes').modal('hide');
                }, error: function(error) {
                    //Error Message
                    swal.fire({   
                        title: "Error",   
                        text: "No se ha podido modificar el pendiente",   
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
 function limpiarModalPendientes(){
    $("#descripcionPendiente").parent().removeClass("error");
    $("#descripcionPendiente").val("");
 }
$('#modalPendientes').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient = button.data('whatever') // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  modal.find('.modal-title').text(recipient + ' pendiente')
})
//*********************************** FIN MODULO: PENDIENTES ***********************************

//*********************************** INICIA MODULO: REPORTE DEL DIA ***********************************

function filtarDiaReporteDia(dia){
    var todos = [];

    // PAGO COTIZACIONES
    $.ajax({
        type: "GET",
        dataType: "json",
        enctype: "multipart/form-data",
        async: false,
        url: "/consultarPagoCotizaciones/"+dia,
        success: function (msg) {
            todos.push(msg);
        }, error: function(error) {
            console.log("error");
            console.log(error);
            return;
        }
    });

    // PAGO COMPRAS
    $.ajax({
        type: "GET",
        dataType: "json",
        enctype: "multipart/form-data",
        async: false,
        url: "/consultarPagoCompras/"+dia,
        success: function (msg) {
            todos.push(msg);
        }, error: function(error) {
            console.log("error");
            console.log(error);
            return;
        }
    });

    // PAGO GASOLINA
    $.ajax({
        type: "GET",
        dataType: "json",
        enctype: "multipart/form-data",
        async: false,
        url: "/consultarPagoGasolina/"+dia,
        success: function (msg) {
            todos.push(msg);
        }, error: function(error) {
            console.log("error");
            console.log(error);
            return;
        }
    });


    // FACTURAS SOBRANTES
    $.ajax({
        type: "GET",
        dataType: "json",
        enctype: "multipart/form-data",
        async: false,
        url: "/consultarFacturasSobrantes/"+dia,
        success: function (msg) {
            todos.push(msg);
        }, error: function(error) {
            console.log("error");
            console.log(error);
            return;
        }
    });

    var htmlIngresos = ``;
    var htmlEgresos = ``;

    //Ingresos: Cotizaciones
    for(var x=0; x<todos[0].length; x++){
        var nombreCompleto = "";
        if (todos[0][x].Apellidos == null) {
            nombreCompleto = todos[0][x].nombre;
        }else{
            nombreCompleto = todos[0][x].nombre + todos[0][x].apellidos;
        }

        var tipoPago = "";
        if (todos[0][x].Tipo_pago == 1)
            tipoPago = "Cheque";
        else if(todos[0][x].Tipo_pago == 2)
            tipoPago = "Transferencia";
        else if(todos[0][x].Tipo_pago == 3)
            tipoPago = "Contado";

        htmlIngresos += `<div class="activity-item">
                            <div class="m-t-10">
                                <h5 class="m-b-5 font-medium">${nombreCompleto}<span class="text-muted font-14 m-l-10">| ${tipoPago}: $${todos[0][x].cantidad}</span></h5>
                                <h6 class="text-muted">${todos[0][x].descripcion}; Recibo no. ${todos[0][x].Num_pago}</h6>
                            </div>
                        </div>`;
    }

    if (htmlIngresos == "") {
        htmlIngresos = `<div style="width:100%; height:100%; text-align: center;">
                            <h5 style="display: inline-block; vertical-align: middle; line-height:normal;">No hay ingresos en esta fecha</h5>
                        </div>`;
    }

    //Egresos: Compras
    for(var x=0; x<todos[1].length; x++){
        var detallePagoCompra = [];
        $.ajax({
            type: "GET",
            dataType: "json",
            enctype: "multipart/form-data",
            async: false,
            url: "/consultarDetallePagoCompras/"+todos[1][x].id,
            success: function (msg) {
                detallePagoCompra.push(msg);
                console.log(detallePagoCompra);
                var notas = "";
                if (detallePagoCompra[0].length > 1) {
                    for(var z = 0; z<detallePagoCompra[0].length; z++){

                        if (z+1 == detallePagoCompra[0].length) {
                            notas += detallePagoCompra[0][z].notaCompras + ".";
                        }else{
                             notas += detallePagoCompra[0][z].notaCompras + ", ";
                        }

                    }
                }else{
                    notas += detallePagoCompra[0][z].notaCompras;
                }

                var tipoPago = "";
                if (todos[1][x].Tipo_Pago == 1)
                    tipoPago = "Cheque";
                else if(todos[1][x].Tipo_Pago == 2)
                    tipoPago = "Transferencia";

                htmlEgresos += `<div class="activity-item">
                                    <div class="m-t-10">
                                        <h5 class="m-b-5 font-medium">${detallePagoCompra[0][0].nombreProveedores}<span class="text-muted font-14 m-l-10">| ${tipoPago}: $${todos[1][x].Total}</span></h5>
                                        <h6 class="text-muted">Pago de la factura: ${detallePagoCompra[0][0].facturaCompras}; Notas correspondientes: ${notas}</h6>
                                    </div>
                                </div>`;

            }, error: function(error) {
                console.log("error");
                console.log(error);
                return;
            }
        });
    }

    //Egresos: Gasolina
    for(var x=0; x<todos[2].length; x++){
        var detallePagoGasolina = [];
        $.ajax({
            type: "GET",
            dataType: "json",
            enctype: "multipart/form-data",
            async: false,
            url: "/consultarDetallePagoGasolina/"+todos[2][x].id,
            success: function (msg) {
                detallePagoGasolina.push(msg);
                console.log(detallePagoGasolina);
                var tickets = "";

                if (detallePagoGasolina[0].length > 1) {
                    for(var z = 0; z<detallePagoGasolina[0].length; z++){
                        if (z+1 == detallePagoGasolina[0].length) {
                            tickets += detallePagoGasolina[0][z].Ticket + ".";
                        }else{
                             tickets += detallePagoGasolina[0][z].Ticket + ", ";
                        }
                    }
                }else{
                    tickets += detallePagoGasolina[0][z].Ticket;
                }

                var tipoPago = "";
                if (todos[2][x].Metodo_pago == 1)
                    tipoPago = "Cheque";
                else if(todos[2][x].Metodo_pago == 2)
                    tipoPago = "Transferencia";

                htmlEgresos += `<div class="activity-item">
                                    <div class="m-t-10">
                                        <h5 class="m-b-5 font-medium">Pago de tickets de gasolina<span class="text-muted font-14 m-l-10">| ${tipoPago}: $${todos[2][x].Cantidad}</span></h5>
                                        <h6 class="text-muted">Pago de la factura: ${todos[2][x].Folio_pago}; Tickets correspondientes: ${tickets}</h6>
                                    </div>
                                </div>`;

            }
        });
    }

    //Egresos: Facturas sobrantes
    for(var x=0; x<todos[3].length; x++){
        var detallePagoFacturasSobrantes = [];
        $.ajax({
            type: "GET",
            dataType: "json",
            enctype: "multipart/form-data",
            async: false,
            url: "/consultarDetallePagoFactutasrSobrantes/"+todos[3][x].id,
            success: function (msg) {
                detallePagoFacturasSobrantes.push(msg);
                console.log(detallePagoFacturasSobrantes);
                var facturas = "";

                if (detallePagoFacturasSobrantes[0].length > 1) {
                    for(var z = 0; z<detallePagoFacturasSobrantes[0].length; z++){
                        if (z+1 == detallePagoFacturasSobrantes[0].length) {
                            facturas += detallePagoFacturasSobrantes[0][z].concepto + ": "+ detallePagoFacturasSobrantes[0][z].folio_factura + ".";
                        }else{
                             facturas += detallePagoFacturasSobrantes[0][z].concepto + ": "+ detallePagoFacturasSobrantes[0][z].folio_factura + ", ";
                        }
                    }
                }else{
                    facturas += ddetallePagoFacturasSobrantes[0][z].concepto + ": "+ detallePagoFacturasSobrantes[0][z].folio_factura;
                }

                var tipoPago = "";
                if (todos[3][x].Metodo_pago == 1)
                    tipoPago = "Cheque";
                else if(todos[3][x].Metodo_pago == 2)
                    tipoPago = "Transferencia";

                htmlEgresos += `<div class="activity-item">
                                    <div class="m-t-10">
                                        <h5 class="m-b-5 font-medium">Pago de facturas sobrantes<span class="text-muted font-14 m-l-10">| ${tipoPago}: $${todos[3][x].Cantidad}</span></h5>
                                        <h6 class="text-muted">Pago de la factura: ${todos[3][x].Folio_pago}; Facturas correspondientes: ${facturas}</h6>
                                    </div>
                                </div>`;

            }
        });
    }

    if (htmlEgresos == "") {
        htmlEgresos = `<div style="width:100%; height:100%; text-align: center;">
                            <h5 style="display: inline-block; vertical-align: middle; line-height:normal;">No hay egresos en esta fecha</h5>
                        </div>`;
    }


    $("#contenedorReporteDiaIngresos")
    .empty()
    .append(htmlIngresos);

    $("#contenedorReporteDiaEgresos")
    .empty()
    .append(htmlEgresos);
}

$("#filtroDiaReportedelDia").on("change", function () {
    var dia = $("#filtroDiaReportedelDia").val();
    filtarDiaReporteDia(dia);
});

$("#selectReporteDia").on("change", function(){
    var option = $("#selectReporteDia").val();

    if (option == 1) {
        $("#tituloIngresos").show();
        $("#contenedorReporteDiaIngresos").show();
        $("#tituloEgresos").show();
        $("#contenedorReporteDiaEgresos").show();
    } else if(option == 2){
        $("#tituloIngresos").show();
        $("#contenedorReporteDiaIngresos").show();
        $("#tituloEgresos").hide();
        $("#contenedorReporteDiaEgresos").hide();
    }else if(option == 3){
         $("#tituloIngresos").hide();
        $("#contenedorReporteDiaIngresos").hide();
        $("#tituloEgresos").show();
        $("#contenedorReporteDiaEgresos").show();
    }
})

//*********************************** FIN MODULO: REPORTE DEL DIA ***********************************

//*********************************** INICIO MODULO: COTIZACIONES ***********************************

$("#filtroMesCotizaciones").on("change", function(){
    mostrarCotizaciones();
});

function llenarFiltroCotizaciones(){
    var fechaActual = new Date();
    var mesActual = fechaActual.getMonth();
    var meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
    var htmlFiltroMeses = "";
    for (var i = 0; i<=mesActual; i++) {
        htmlFiltroMeses += `<option class="opcionesMesCotizacion" value="${i}">${meses[i]}</option>`;
    }

    $("#filtroMesCotizaciones")
    .empty()
    .append(htmlFiltroMeses);

}

function mostrarCotizaciones(){
    var mes = $("#filtroMesCotizaciones option:selected" ).val();
    mes = parseInt(mes) + 1;
    var htmlCotizacionesDashboard = "";
    $.ajax({
        type: "GET",
        dataType: "json",
        enctype: "multipart/form-data",
        url: "/consultarCotizacionesDashboard",
        success: function (msg) {
            for(var x=0; x<msg.length; x++){

                var fechaInicio = new Date(msg[x].fecha_inicio);
                var fechaFin = new Date(msg[x].fecha_fin);

                var mesFechaInicio = parseInt(fechaInicio.getMonth()) + 1;
                var mesFechaFin = fechaFin.getMonth()+1;

                if(mesFechaInicio == 12)
                    mesFechaInicio = 1;

                if (mes>=mesFechaInicio && mes<=mesFechaFin) 
                {
                    var nombreCompleto = "";
                    if (msg[x].Apellidos == null) {
                        nombreCompleto = msg[x].Nombre;

                    }else{
                        nombreCompleto = msg[x].Nombre + " " + msg[x].Apellidos;
                    }

                    var prioridad = "";
                    if (msg[x].Prioridad == 1)
                        prioridad = `<span class="badge badge-inverse">Baja</span>`;
                    else if (msg[x].Prioridad == 2)
                        prioridad = `<span class="badge badge-info">Media</span>`;
                    else if (msg[x].Prioridad == 3)
                        prioridad = `<span class="badge badge-primary">Alta</span>`;

                    htmlCotizacionesDashboard += `<tr>
                                                    <td>
                                                        <h5>${nombreCompleto}</h5></td>
                                                    <td>${msg[x].Descripcion}</td>
                                                    <td>${prioridad}</td>
                                                    <td>$${msg[x].Costo}</td>
                                                  </tr>`;
                    }
                }

                if (htmlCotizacionesDashboard == "") {
                    htmlCotizacionesDashboard = `<tr>
                                                    <td colspan="4">
                                                        <h5>No hay cotizaciones este mes.</h5></td>
                                                  </tr>`;
            }

            $("#contenedorCotizacionesDashboard")
                    .empty()
                    .append(htmlCotizacionesDashboard);

        }, error: function(error) {
            console.log(error);
            htmlCotizacionesDashboard = `<div style="width:100%; height:100%; text-align: center;">
                                            <h4 style="display: inline-block; vertical-align: middle; line-height:normal;">No se han podido cargar los datos</h4>
                                        </div>`;
            return;
        }
    });

}

//*********************************** FIN MODULO: COTIZACIONES ***********************************