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
})

$(".modificarCliente").click(function(e){
    // e.preventDefault();
})

