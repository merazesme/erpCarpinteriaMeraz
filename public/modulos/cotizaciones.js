$(".eliminarCotizacion").click(function(e){
    e.preventDefault();
    swal({   
        title: "¿Deseas eliminar la cotización?",   
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
            swal("Eliminado", "La cotización ha sido eliminada con éxito", "success");   
        }
    });
})

$(".select2").select2();

$(".detalleCotizacion").click(function(e){
    e.preventDefault();
})
