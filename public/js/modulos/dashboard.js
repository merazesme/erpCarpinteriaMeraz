$(document).ready(function () {
    //variables globales
    var banderaCita=0;
    var idCitaModificar=0;

    //mandar fecha al filtro de citas
    var week = saberSemana();
    $("#filtroCita").val(week);

    //cargar datos necesarios
    // listarCitas();  
    cambioFiltroCita();
    cargarClientes();

})

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

function cambioFiltroCita()
{
    var week = $("#filtroCita").val();
    var numWeek = week.split("-W");
    listarCitas((numWeek[1])-1);
}

$("#filtroCita").on("change", function () {
    cambioFiltroCita();
});

function listarCitas($week){
    //Inicio: Cargar todas las citas
    $.ajax({
        type: "GET",
        dataType: "json",
        enctype: "multipart/form-data",
        url: "/consultarCitas/"+$week,
        success: function (msg) {
            console.log(msg.length);
            var html = "";
            var fecha = "";
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
                    fecha = new Date(msg[i].Fecha);
                    var estado ="";
                    if(msg[i].Estado == 0)
                        estado=''; 
                    else if(msg[i].Estado == 1)
                        estado='<span class="label label-rounded label-success">Asistió</span>'; 
                    else if(msg[i].Estado == 2)
                        estado='<span class="label label-rounded label-danger">Cancelada</span>';

                    html += `
                    <div class="d-flex flex-row comment-row">
                        <div class="p-2">
                            <span class="round">
                                <img src="{{asset('images/users/1.jpg')}}" alt="user" width="50">
                            </span>
                        </div>
                        <div class="comment-text w-100">
                            <input type="hidden" class="idCita" value="${msg[i].id}"></input>
                            <h5>${msg[i].Nombre + " " + msg[i].Apellidos}</h5>
                            <p class="m-b-5">${msg[i].Comentario}</p>
                            <div class="comment-footer"> 
                                <span class="text-muted pull-right">${fecha.toLocaleDateString("es-ES", options)}</span> 
                                ${estado}
                                <span class="action-icons">
                                    <button class="btnEditarCita" onclick="montarDatosCita(${msg[i].id})" data-toggle="modal" data-target="#modalCita" data-whatever="Editar" style="background: transparent; border: none !important;">
                                        <span data-toggle="tooltip" data-original-title="Editar">
                                            <a href="javascript:void(0)"><i class="ti-pencil-alt"></i></a>
                                        </span>
                                    </button>
                                    <span data-toggle="tooltip" data-original-title="Asistió">
                                        <a href="javascript:void(0)"><i class="ti-check"></i></a>
                                    </span>
                                    <span data-toggle="tooltip" data-original-title="Cancelar">
                                        <a href="javascript:void(0)"><i class="ti-close"></i></a>
                                    </span>
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
            console.log(msg);
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
    console.log(banderaCita);
    $.ajax({
        type: "GET",
        dataType: "json",
        enctype: "multipart/form-data",
        url: "/montarDatosCita/"+id,
        success: function (msg) {
            console.log(msg);

            // Montar cliente en select
            var nombreCompleto;
            if (msg.cliente.Apellidos == null) 
                nombreCompleto=msg.cliente.Nombre;
            else
                nombreCompleto=msg.cliente.Nombre + " " + msg.cliente.Apellidos;

            $("#selectClientes option[value="+"'"+msg.Clientes_id+"'"+"]").attr("selected",true);
            $("#select2-selectClientes-container").text(nombreCompleto);

            //Montar descripcion
            $("#comentario").text(msg.Comentario);

            //Montar fecha
            var dt = msg.Fecha.split(' ');
            var fecha = dt[0] + "T" + dt[1];
            $("#fechaCita").val(fecha);
            
              
        }, error: function(error) {
            console.log("error");
            console.log(error);
            return;
        }
    });
}

function limpiarModalCitas(){

    $("#selectClientes option[value=0]").attr("selected",true);
    $("#select2-selectClientes-container").text("Selecciona un cliente");

    //Montar descripcion
    $("#comentario").text("");

    //Montar fecha
    $("#fechaCita").val("");
}

$("#btnNuevaCita").click(function() {
    banderaCita=0;
    console.log(banderaCita);
    limpiarModalCitas();
});

$("#btnGuardarCita").click(function() {

    // Si los campos estan vacios
    if($(".cliente").val()=="" || $(".comentario").val()=="" || 
        $(".fecha").val()=="" || $(".estatus").val()=="" || $(".idUsuario").val()=="")
    {
        console.log("nada");
    }else
    {
        datos = new FormData(document.querySelector('#citas'));

        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        if (banderaCita==0) {
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
                swal({   
                    title: "¡Listo!",   
                    text: "Se ha guardado el registro de la cita",   
                    timer: 1500,  
                    type: "success", 
                    showConfirmButton: false 
                });
            }, error: function(error) {
                //Error Message
                swal({   
                    title: "Error",   
                    text: "No se ha podido registrar la cita",   
                    timer: 1500,  
                    type: "error", 
                    showConfirmButton: false 
                });
                return;
            }
        });
        }else if(banderaCita==1){
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
                    swal({   
                        title: "¡Listo!",   
                        text: "Se ha modificado la cita",   
                        timer: 1500,  
                        type: "success", 
                        showConfirmButton: false 
                    });
                }, error: function(error) {
                    //Error Message
                    swal({   
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
});

$('#modalCita').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient = button.data('whatever') // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  modal.find('.modal-title').text(recipient + ' cita')
  console.log(recipient);
  if (recipient=="Añadir")
  {
    $("#estatusCita").hide();
    $("#estatusCita").val(0);
  }else if(recipient=="Editar"){
    $("#estatusCita").show();
  }
})
