$(document).ready(function(){
	var banderaEditar=0;
	var idRegistro=0;
	var fecha = fechaValida();
	if (fecha!="") {

		$("#fecha").attr("min", fecha[0]);
	    $("#fecha").attr("max", fecha[1]);
        
	    consultar(fecha[0], fecha[1]);   

	}else{
		Swal.fire({   
            title: "success",   
            text: "No se pudieron obtener las fechas",   
            timer: 1500,  
            type: "error", 
            showConfirmButton: false 
        });
	}
})

function fechaValida(){
	var fechas = "";
	$.ajax({
        type: "GET",
        dataType: "json",
        enctype:"multipart/form-data",
        async:false,
        url: "/consultarUltimoCajaChica",
        success: function (msg) {
            var primerDia = "";
            var ultimoDia = "";

            if (msg.length>0) {
                primerDia = new Date(msg[0].Fecha);
                ultimoDia = new Date(msg[0].Fecha);
            }else{
                primerDia = new Date();
                ultimoDia = new Date();
            }
                primerDia.setDate(primerDia.getDate() + 2);
                while((primerDia.getDay()+1) != 2) {
                 primerDia.setDate(primerDia.getDate() - 1);
                }
                while(ultimoDia.getDay() != 6) {
                 ultimoDia.setDate(ultimoDia.getDate() + 1);
                }
                var mes1 = primerDia.getMonth()+1;
                var dia1 = primerDia.getDate();
                if (parseInt(mes1) < 10) {;
                    mes1 = "0"+mes1;
                }
                if (parseInt(dia1) < 10) {
                    dia1 = "0"+dia1;
                }
                var mes2 = ultimoDia.getMonth()+1;
                var dia2 = ultimoDia.getDate();
                if (parseInt(mes2) < 10) {
                    mes2 = "0"+mes2;
                }
                if (parseInt(dia2) < 10) {
                    dia2 = "0"+dia2;
                }

                primerDia = primerDia.getFullYear() + "-" + mes1 + "-" + dia1;
                ultimoDia = ultimoDia.getFullYear() + "-" + mes2 + "-" + dia2;

                fechas = [primerDia, ultimoDia];
                console.log(fechas);
            
        }, error: function(error) {
        //Error Message
        console.log(error);
         Swal.fire({   
            title: "Error",   
            text: "No se han podido consultar datos de caja chica",   
            timer: 1500,  
            type: "error", 
            showConfirmButton: false 
        });
     }
    });
    return fechas;
}

function validation(children, parent){
    if(children.val().length == 0){
        parent.addClass("error");
    }else{
        parent.removeClass("error");
    }
}

$("#agregarRegistro").click(function(){
	banderaEditar=0;
    limpiarModal();
});

$("#btnGuardar").click(function(){
	var banValidation=false;
    var id = $("#idRegistro").val();

    if($("#fecha").val().length == 0){
        validation($("#fecha"), $("#fecha").parent());
        banValidation=true;
    }
    if($("#concepto").val().length == 0){
        validation($("#concepto"), $("#concepto").parent());
        banValidation=true;
    }
    if($("#cantidad").val().length == 0){
        validation($("#cantidad"), $("#cantidad").parent());
        banValidation=true;
    }

    // Si los campos estan llenos pasa
    if (banValidation==false)
    {
        $("#fecha").parent().removeClass("error");
        $("#concepto").parent().removeClass("error");
        $("#cantidad").parent().removeClass("error");

        datos = new FormData(document.querySelector('#formCajaChica'));
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
            url: '/nuevoCajaChica',
            success: function(msg){
                //Success 
                var fecha = fechaValida();
                consultarHeader(fecha[0], fecha[1]);
                consultar(fecha[0], fecha[1]);
                 Swal.fire({   
                    title: "¡Listo!",   
                    text: "Se ha guardado el registro",   
                    timer: 1500,  
                    type: "success", 
                    showConfirmButton: false 
                });
                $('#modal').modal('hide');
            }, error: function(error) {
                //Error Message
                 Swal.fire({   
                    title: "Error",   
                    text: "No se ha podido guardar el registro",   
                    timer: 1500,  
                    type: "error", 
                    showConfirmButton: false 
                });
                $('#modal').modal('hide');
                return;
            }
        }); 
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
                url: '/editarRegistroCajaChica/'+idRegistro,
                success: function(msg){
                    var fecha = fechaValida();
                    consultarHeader(fecha[0], fecha[1]);
                	consultar(fecha[0], fecha[1]);
                    //Success Message
                     Swal.fire({   
                        title: "¡Listo!",   
                        text: "Se ha modificado el registro",   
                        timer: 1500,  
                        type: "success", 
                        showConfirmButton: false 
                    });
                    $('#modal').modal('hide');
                }, error: function(error) {
                    //Error Message
                     Swal.fire({   
                        title: "Error",   
                        text: "No se ha podido modificar el registro",   
                        timer: 1500,  
                        type: "error", 
                        showConfirmButton: false 
                    });
                    $('#modal').modal('hide');
                }
            });
        }  
    }
});

function datosGeneralesTablas(selector, html, monto){
	var htmlMensajeVacio = `<tr>
								<td colspan="4">No hay registros</td>
							</tr>`;
	$(selector)
                .empty()
                .append(html);  
   
    if (html == "")
    	 $(selector).append(htmlMensajeVacio);

    $(selector).append(`<tr>
							<td colspan="2"><b>Monto:</b></td>
							<td colspan="2"><b>$${monto}</b></td>
						</tr>`);
}

function consultar(fechaInicial, fechaFinal){
	var htmlTablaOficina = "";
	var htmlTablaTrabajadores = "";
	var htmlTablaMandados = "";
	var htmlTablaAdeudo = "";
	var totalOficina=0;
	var totalTrabajadores=0;
	var totalMandados=0;
	var totalAdeudo=0;
	var html ="";
	var options = { weekday: 'short', month: 'long', day: 'numeric' };

    $.ajax({
        type: "GET",
        dataType: "json",
        enctype: "multipart/form-data",
        url: "/consultarAdeudo",
        success: function (msg) {
            for(var i=0; i<msg.length; i++){
                fechaRegistro = new Date(msg[i].Fecha);
                fechaRegistro.setDate(fechaRegistro.getDate() + 1);
                htmlTablaAdeudo+= `<tr>
                    <td><span class="text-muted">${fechaRegistro.toLocaleDateString("es-ES", options)}</td>
                    <td>${msg[i].Concepto}</td>
                    <td>$${msg[i].Total}</td>
                    <td class="text-nowrap">
                        <span data-toggle="tooltip" title="Editar">
                            <a href="#modal" data-toggle="modal" data-whatever="Editar" onclick="montarDatos(${msg[i].id})">
                                <i class="icon-pencil text-primary m-r-10"></i>
                            </a>
                        </span>
                        <span data-toggle="tooltip" title="Eliminar">
                            <a href="#" onclick="eliminarRegistro(${msg[i].id})">
                                <i class="icon-close text-danger"></i>
                            </a>
                        </span>
                    </td>
                </tr>`;

                totalAdeudo+=msg[i].Total;
            }

            datosGeneralesTablas('#bodyTablaAdeudo', htmlTablaAdeudo, totalAdeudo);

        }, error: function(error) {
                //Error Message
                console.log(error);
                Swal.fire({   
                    title: "Error",   
                    text: "Hubo algún fallo con la consulta de configuraciones",   
                    timer: 1500,  
                    type: "error", 
                    showConfirmButton: false 
                });
        }

    });
	$.ajax({
        type: "GET",
        dataType: "json",
        enctype: "multipart/form-data",
        url: "/consultarCajaChica/"+fechaInicial+"/"+fechaFinal,
        success: function (msg) {
            for(var i=0; i < msg.length; i++)
            {
            	fechaRegistro = new Date(msg[i].Fecha);
            	fechaRegistro.setDate(fechaRegistro.getDate() + 1);
            	html = `<tr>
                            <td><span class="text-muted">${fechaRegistro.toLocaleDateString("es-ES", options)}</td>
                            <td>${msg[i].Concepto}</td>
                            <td>$${msg[i].Total}</td>
                            <td class="text-nowrap">
                                <span data-toggle="tooltip" title="Editar">
                                    <a href="#modal" data-toggle="modal" data-whatever="Editar" onclick="montarDatos(${msg[i].id})">
                                        <i class="icon-pencil text-primary m-r-10"></i>
                                    </a>
                                </span>
                                <span data-toggle="tooltip" title="Eliminar">
                                    <a href="#" onclick="eliminarRegistro(${msg[i].id})">
                                        <i class="icon-close text-danger"></i>
                                    </a>
                                </span>
                            </td>
                        </tr>`;

            	switch(msg[i].Tipo){
            		case 1:
            			htmlTablaOficina+=html;
            			totalOficina+=msg[i].Total;
            			break;
            		case 2:
            			htmlTablaTrabajadores+=html;
            			totalTrabajadores+=msg[i].Total;
            			break;
            		case 3:
            			htmlTablaMandados+=html;
            			totalMandados+=msg[i].Total;
            			break;
            	}
            }  
  
            $.ajax({
		        type: "GET",
		        dataType: "json",
		        enctype: "multipart/form-data",
		        url: "/consultarConfiguracionCajaChica",
		        success: function (msg) {
                    var restar = Math.abs(totalOficina + totalTrabajadores + totalMandados - totalAdeudo);
                    var montoFisicamente = msg[0].monto - restar;
		        	$("#totalFisicamente").text("$"+montoFisicamente);
		        	$("#totalCajaChica").text("$"+msg[0].monto);

		        }, error: function(error) {
		                //Error Message
		                console.log(error);
		                Swal.fire({   
		                    title: "Error",   
		                    text: "Hubo algún fallo con la consulta de configuraciones",   
		                    timer: 1500,  
		                    type: "error", 
		                    showConfirmButton: false 
		                });
		        }
		    });

            datosGeneralesTablas('#bodyTablaOficina', htmlTablaOficina, totalOficina);
            datosGeneralesTablas('#bodyTablaTrabajadores', htmlTablaTrabajadores, totalTrabajadores);
            datosGeneralesTablas('#bodyTablaMandados', htmlTablaMandados, totalMandados);

        }, error: function(error) {
                //Error Message
                console.log(error);
                Swal.fire({   
                    title: "Error",   
                    text: "Hubo algún fallo con la consulta de caja chica",   
                    timer: 1500,  
                    type: "error", 
                    showConfirmButton: false 
                });
            }
    });
}

function limpiarModal(){
    $("#tipo").val(1);
    $("#fecha").val("");
    $("#concepto").val("");
    $("#cantidad").val("");            
    $("#idRegistro").val("");
    $("#idUsuario").val("");
}

function montarDatos(id){
    banderaEditar=1;
    idRegistro=id;
    limpiarModal();
    $.ajax({
        type: "GET",
        dataType: "json",
        enctype: "multipart/form-data",
        url: "/montarDatosRegistroCajaChica/"+id,
        success: function (msg) {
            
            //Montar datos
            $("#tipo").val(msg.Tipo);
            $("#fecha").val(msg.Fecha);
            $("#concepto").val(msg.Concepto);
            $("#cantidad").val(msg.Total);            
            $("#idRegistro").val(idRegistro);

        }, error: function(error) {
        	$('#modal').modal('hide');
            Swal.fire({   
                    title: "Error",   
                    text: "No se han podido recuperar los datos del registro",   
                    timer: 1500,  
                    type: "error", 
                    showConfirmButton: false 
                });
        }
    });
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

function eliminarRegistro(id){ 
    inicializarVariableSwal();
    swalWithBootstrapButtons.fire({
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
            url: "/eliminarRegistroCajaChica",
            success: function (msg) {
                var fecha = fechaValida();
                consultarHeader(fecha[0], fecha[1]);
                consultar(fecha[0], fecha[1]);
                //Success Message
                 Swal.fire({   
                    title: "¡Listo!",   
                    text: "Se ha eliminado el registro",   
                    timer: 1500,  
                    type: "success", 
                    showConfirmButton: false 
                });
            }, error: function(error) {
                console.log(error);
                 Swal.fire({   
                    title: "Error",   
                    text: "No se ha podido eliminar el registro",   
                    timer: 1500,  
                    type: "error", 
                    showConfirmButton: false 
                });
            }
        });
      }
    })
}

$("#btnRenovarHoja").click(function(){

    const swalWithBootstrapButtons = Swal.mixin({
      customClass: {
        confirmButton: 'btn btn-info',
        cancelButton: 'btn btn-secondary'
      },
      buttonsStyling: false,
    })

    var fecha = fechaValida();
     console.log(fecha);

    var ultimaFecha = new Date(fecha[1]);
    var fechaActual =  new Date();
    var banderaFecharMayor = 0;

    if (fechaActual.getFullYear() > ultimaFecha.getFullYear()) {
    	banderaFecharMayor = 1;
    }else if ((fechaActual.getMonth()+1) > (ultimaFecha.getMonth()+1)){
    	banderaFecharMayor = 1;
    }else if (fechaActual.getDate() > (ultimaFecha.getDate()+1)) {
    	banderaFecharMayor = 1;
    }else{
    	banderaFecharMayor = 0;
    }

    //si aun no ha terminado la semana no podrá generar una nueva hoja
    if (banderaFecharMayor == 1) {

        var f = new Date();
        f = f.getFullYear() + "-" + (parseInt(f.getMonth())+1) + "-"+ f.getDate();
        // console.log(f);
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
	        	$.ajaxSetup({
		            headers: {
		                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		            }
		        });
		       
	            $.ajax({
	                type: "POST",
	                dataType: "json",
	                data: {Concepto: "Se generó una nueva hoja", Tipo: 5, Fecha: f, idUsuario: 1},
	                enctype:"multipart/form-data",
	                url: "/nuevaHoja",
	                success: function (msg) {
	                	var fecha = fechaValida();
                        console.log(fecha);
						if (fecha!="") {
						    consultar(fecha[0], fecha[1]);   
                            Swal.fire({   
                                title: "Listo",   
                                text: "Se ha renovado la hoja de caja chica",   
                                timer: 1500,  
                                type: "success", 
                                showConfirmButton: false 
                            });
						}else{
							Swal.fire({   
					            title: "Error",   
					            text: "No se han podido consultar datos de caja chica",   
					            timer: 1500,  
					            type: "error", 
					            showConfirmButton: false 
					        });
						}
	                }, error: function(error) {
	                //Error Message
	                 Swal.fire({   
	                    title: "Error",   
	                    text: "No se ha podido generar una hoja nueva",   
	                    timer: 1500,  
	                    type: "error", 
	                    showConfirmButton: false 
	                });
	             }
	            });
	        }
	    })

    }else{
    	
   		Swal.fire({   
	        title: "Acción inválida",   
	        text: "Aún no se puede generar una nueva hoja",   
	        timer: 1500,  
	        type: "warning", 
	        showConfirmButton: false 
	    });
    }
});

$('#modal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient = button.data('whatever') // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  modal.find('.modal-title').text(recipient + ' registro')
})