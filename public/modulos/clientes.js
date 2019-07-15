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


$(".eliminarCliente").click(function(e){
    e.preventDefault();
    swal({
        title: "¿Deseas eliminar el cliente?",
        // text: "No podrás recuperarlo",
        type: "error",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Eliminar",
        cancelButtonText: "Cancelar",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm){
        if (isConfirm) {
            swal("Eliminado", "El cliente ha sido eliminado con éxito", "success");
        }
    });
})

$(".detalleClientes").click(function(e){
    e.preventDefault();
    console.log($(this).attr("cliente"));

    //
})

$(".modificarCliente").click(function(e){
    // e.preventDefault();
})

function nuevoCliente (){
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
        datos.append("_token", token);
        $.ajax({
            type: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            data: datos,
            dataType: false,
            enctype: 'multipart/form-data',
            url: base_url+'/nuevoCliente',
            success: function(msg){
                console.log(msg);
                if(msg == 0){
                    $('#modalAgregar').modal('hide')
                    swal("Nuevo Cliente", "El cliente ha sido agregado con éxito", "success");
                }else{
                    swal("Nuevo Cliente", "Ha ocurrido un error, inténtelo más tarde.", "error");
                }
            }, error: function(error) {
                swal("Nuevo Cliente", "Ha ocurrido un error, inténtelo más tarde.", "error");
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
