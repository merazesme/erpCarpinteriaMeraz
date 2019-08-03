$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
    verificar_datos();
    detener_preloader();
});
function ajax_post (url, datos, callback) {
	$.ajax({
        type: 'POST',
        url: url,
        data: datos,
        cache: false,
        contentType: false,
        dataType: false,
        enctype: 'multipart/form-data',
		processData: false,
		beforeSend: function() {
			iniciar_preloader();
		},
	})
	.done(callback)
    .fail(function() {
        console.log("Error");
    })
    .always(function() {
        detener_preloader();
    });
}
function verificar_datos() {
    if(localStorage.getItem('login_recuerdame')) {
        var login_recuerdame = JSON.parse(localStorage.getItem('login_recuerdame'));
        $('input[name=login_usuario]') .val(login_recuerdame.usuario);
        $('input[name=login_password]').val(login_recuerdame.password);
        $('#login_recuerdame').prop('checked', true);
    }
}
function myAlert(texto, clase) {
    $(".alert p").html(texto);
    $(".alert")  .addClass(clase)
                 .show();
    setTimeout(function () {$(".alert").fadeOut();}, 3500);
}
function detener_preloader() {
    $(".preloader").fadeOut();
}
function iniciar_preloader() {
    $(".preloader").fadeIn();
}
function iniciar_sesion() {
    var datos = new FormData(document.querySelector("#login_form"));
    ajax_post('/login/ingresar', datos, function(resultado) {
        // console.log(resultado);
        // return;
        if(resultado == 'true') {
            if($('#login_recuerdame').prop('checked')) {
                var login_recuerdame = {
                    usuario:  $('input[name=login_usuario]').val(),
                    password: $('input[name=login_password]').val()
                }
                localStorage.setItem('login_recuerdame', JSON.stringify(login_recuerdame));
            } else {
                if(localStorage.getItem('login_recuerdame')) {
                    localStorage.removeItem('login_recuerdame');
                }
            }
            location.href = '/';
        } else if(resultado == 'false' || resultado == 'inactivo') {
            $('input[name=login_usuario]').addClass('form-material-error-login');
            $('input[name=login_password]').addClass('form-material-error-login');
            myAlert('Las credenciales no coinciden', 'alert-danger')
        }
    });
}