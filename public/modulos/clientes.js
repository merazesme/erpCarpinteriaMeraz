function validation(children, parent){
    if(children.val().length == 0){
        parent.addClass("error");
    }else{
        parent.removeClass("error");
    }
}

function isValidEmailAddress(emailAddress) {
    var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
    return pattern.test(emailAddress);
}

$("body").on("click", ".eliminarCliente", function(e){
    e.preventDefault();
    var id = $(this).parent().attr("data-cliente");
    var estado = $(this).attr("estado");
    console.log("estado;"+estado);
    var estadoN = 1;
    var titulo = "¿Deseas eliminar el cliente?",
        type = "error",
        confirmButtonColor = "#DD6B55",
        confirmButtonText = "Eliminar";
    if(estado == 1){
        estadoN = 0;
        titulo = "¿Deseas activar el cliente?"
        type = "success"
        confirmButtonText = "Activar"
        confirmButtonColor = "#068F66"
    }
    if(id != undefined){
        console.log($(this).parent().attr("data-cliente"));
        swal({
            title: titulo,
            type: type,
            showCancelButton: true,
            confirmButtonColor: confirmButtonColor,
            confirmButtonText: confirmButtonText,
            cancelButtonText: "Cancelar",
            closeOnConfirm: false,
            closeOnCancel: true
        }, function(isConfirm){
            if (isConfirm) {
                var datos = new FormData();
                datos.append("idUsuario", "1");
                datos.append("Estado", estadoN);
                datos.append("_token", token);
                $.ajax({
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    cache: false,
                    data: datos,
                    dataType: false,
                    enctype: 'multipart/form-data',
                    url: base_url+'/clientes/eliminar/'+id,
                    success: function(msg){
                        var data = JSON.parse(msg)
                        if(data == 0){
                            swal("Eliminado", "El estado del cliente ha sido actuzalizado con éxito", "success");
                            tablaClientes();
                        }else{
                            swal("Error", "Ha ocurrido un error, inténtelo más tarde.", "error");
                        }
                    }, error: function(error) {
                        swal("Error", "Ha ocurrido un error, inténtelo más tarde.", "error");
                    }
                });
            }

        });
    }
})

$("body").on("click", ".detalleClientes", function(e){
    e.preventDefault();
    console.log($(this).parent().parent().attr("data-cliente"));
    //
})

$("body").on("click",".modificarCliente", function(e){
    var id = $(this).parent().attr("data-cliente");
    console.log(id);
    e.preventDefault();
    $.ajax({
		type: "GET",
		dataType: "json",
		enctype: "multipart/form-data",
		url: base_url+'/clientes/especifico/'+id,
		success: function (msg) {
            var data = JSON.parse(msg)
			console.log(data);
            $("#txtNombre").val(data.Nombre);
            $("#txtTelefono").val(data.Telefono);
            $("#txtEmail").val(data.Email);
            $("#txtApellidos").val(data.Apellidos);
            $("#agregarTitulo").html("Modificar Cliente");
            $("#actionAgregar").attr("onclick", "nuevoCliente("+id+")");
            $('#modalAgregar').modal('show')
		}
	});
})

function agregarCliente(){
    $("#agregarTitulo").html("Agregar Cliente");
    $('#modalAgregar').modal('show')
    $("#actionAgregar").attr("onclick", "nuevoCliente()");
}

function nuevoCliente(id){
    var banValidation=false;
    if($("#txtNombre").val().length == 0){
        validation($("#txtNombre"), $("#txtNombre").parent());
        banValidation=true;
    }

    if($("#txtApellidos").val().length == 0){
        validation($("#txtApellidos"), $("#txtApellidos").parent());
        banValidation=true;
    }

    if($("#txtEmail").val().length == 0){
        validation($("#txtEmail"), $("#txtEmail").parent());
        banValidation=true;
        $("#txtEmail-error").hide();
    }

    if($("#txtEmail").val().length > 0 && !isValidEmailAddress($("#txtEmail").val())){
        banValidation=true;
        $("#txtEmail-error").show();
    }else{
        $("#txtEmail-error").hide();
    }

    if($("#txtTelefono").val().length == 0){
        validation($("#txtTelefono"), $("#txtTelefono").parent());
        banValidation=true;
    }

    if($("#txtTelefono").val().length > 0 && !$("#txtTelefono").val().match(/^\d+$/)) {
        banValidation=true;
        $("#txtTelefono-error").show();
    }else{
        $("#txtTelefono-error").hide();
    }

    if(!banValidation){
        $("#txtEmail-error").hide();
        $("#txtTelefono-error").hide();
        var datos = new FormData(document.querySelector('#frmCliente'));
        datos.append("idUsuario", "1");
        //datos.append("_token", token);
        console.log(id);
        var url = base_url+'/clientes/agregar';
        var mensaje = "El cliente ha sido agregado con éxito";
        var titulo = "Nuevo Cliente";
        if(id != undefined){
            url = base_url+'/clientes/modificar/'+id;
            mensaje = "El cliente ha sido actualizado con éxito";
            titulo = "Actualizar Cliente";
        }else{
            datos.append("Estado", 0);
        }

        $.ajax({
            type: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            data: datos,
            dataType: false,
            enctype: 'multipart/form-data',
            url: url,
            success: function(msg){
                var data = JSON.parse(msg)
                if(data == 0){
                    $('#modalAgregar').modal('hide')
                    swal(titulo, mensaje, "success");
                    tablaClientes();
                }else{
                    swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
                }
            }, error: function(error) {
                swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
            }
        });
    }
}

$('#modalAgregar').on('hidden.bs.modal', function (e) {
    $("#txtEmail-error").hide();
    $("#txtTelefono-error").hide();
    $("#frmCliente")[0].reset();
    $("#txtNombre").parent().removeClass("error");
    $("#txtApellidos").parent().removeClass("error");
    $("#txtEmail").parent().removeClass("error");
    $("#txtTelefono").parent().removeClass("error");
})

$("#txtNombre").on('input',function(e){
    validation($(this), $(this).parent())
});

$("#txtApellidos").on('input',function(e){
    validation($(this), $(this).parent())
});

$("#txtEmail").on('input',function(e){
    validation($(this), $(this).parent())
});

$("#txtTelefono").on('input',function(e){
    validation($(this), $(this).parent())
});

function tablaClientes(){
    $.ajax({
		type: "GET",
		dataType: "json",
		enctype: "multipart/form-data",
		url: base_url+'/clientes/lista/',
		success: function (msg) {
            var data = JSON.parse(msg)
			console.log(data);
            $("#clientes").DataTable().clear();
			$("#clientes").DataTable().destroy();

            $("#clientesInactivos").DataTable().clear();
			$("#clientesInactivos").DataTable().destroy();
            var htmlActivo="", htmlInactivo="";
            for (var i = 0; i < data.length; i++) {
                var localhtml = "";
                localhtml=
                `<tr>
                    <td>${data[i].Nombre} ${data[i].Apellidos}</td>
                    <td><a href="mailto:${data[i].Email}">${data[i].Email}</a></td>
                    <td><a href="tel:${data[i].Telefono}">${data[i].Telefono}</a></td>
                    <td class="text-nowrap" data-cliente="${data[i].id}">
                        <a href="#" class="modificarCliente"><i class="icon-pencil text-inverse m-r-10"></i></a>`;

                if(data[i].Estado == 1){
                    htmlInactivo += localhtml +
                        `<a class="eliminarCliente" estado="${data[i].Estado}" href="#" data-toggle="tooltip" data-original-title="Activar"> <i class="icon-check text-success m-r-10"></i> </a>
                         <span data-toggle="modal" data-target="#modalDetalles">
                            <a class="detalleClientes" href="#" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye "></i> </a>
                        </span>
                    </td>
                </tr>`;
                }else{
                    htmlActivo += localhtml +
                        `<a class="eliminarCliente" estado="${data[i].Estado}" href="#" data-toggle="tooltip" data-original-title="Desactivar"> <i class="icon-close text-danger m-r-10"></i> </a>
                         <span data-toggle="modal" data-target="#modalDetalles">
                            <a class="detalleClientes" href="#" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye "></i> </a>
                        </span>
                    </td>
                </tr>`;
                }
            }
            $("#clientes tbody").empty().append(htmlActivo);
            $("#clientes").DataTable({
              dom: 'Bfrtip',
              buttons: ['excel', 'pdf', 'print']
            });

            $("#clientesInactivos tbody").empty().append(htmlInactivo);
            $("#clientesInactivos").DataTable({
              dom: 'Bfrtip',
              buttons: ['excel', 'pdf', 'print']
            });
		}
	});
}

$(document).ready(function () {
	tablaClientes();

    $("body").tooltip({ selector: '[data-toggle="tooltip"]' });
});
