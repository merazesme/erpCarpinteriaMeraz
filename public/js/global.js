function cerrar_sesion() {
    $.ajax({
        type: 'GET',
        url: '/login/salir'
    }).done(function(resp) {
        if(resp === 'true') {
            location.href = '/login'
        }  
    })
}
