function validation(children, parent){
    if(children.val().length == 0){
        parent.addClass("error");
    }else{
        parent.removeClass("error");
    }
}

$("#ivaConfig").on('input',function(e){
    validation($(this), $(this).parent())
});

$("#cajaConfig").on('input',function(e){
    validation($(this), $(this).parent())
});

$("#entrada_LV").on('input',function(e){
    validation($(this), $(this).parent())
});

$("#salida_LV").on('input',function(e){
    validation($(this), $(this).parent())
});

$("#entrada_LV_T").on('input',function(e){
    validation($(this), $(this).parent())
});

$("#salida_LV_T").on('input',function(e){
    validation($(this), $(this).parent())
});

$("#entrada_S").on('input',function(e){
    validation($(this), $(this).parent())
});

$("#salida_S").on('input',function(e){
    validation($(this), $(this).parent())
});

$("#entrada_E").on('input',function(e){
    validation($(this), $(this).parent())
});

$("#salida_E").on('input',function(e){
    validation($(this), $(this).parent())
});

$("#entrada_ES").on('input',function(e){
    validation($(this), $(this).parent())
});

$("#salida_ES").on('input',function(e){
    validation($(this), $(this).parent())
});

function actualizarGeneral(){
    var banValidation=false;
    if($("#ivaConfig").val().length == 0){
        validation($("#ivaConfig"), $("#ivaConfig").parent());
        banValidation=true;
    }

    if($("#cajaConfig").val().length == 0){
        validation($("#cajaConfig"), $("#cajaConfig").parent());
        banValidation=true;
    }

    if(!banValidation){
        var datos = new FormData(document.querySelector('#formGeneral'));
        datos.append("idUsuario", "1");

        $.ajax({
            type: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            data: datos,
            dataType: false,
            enctype: 'multipart/form-data',
            url: base_url+"/configuraciones/actualizarGeneral",
            success: function(msg){
                var data = JSON.parse(msg)
                if(data == 0){
                    $('#modalConfiguracion').modal('hide')
                    swal("Actuzalizar", "Se han actualizado los datos con éxito", "success");
                    datosGeneral();
                }else{
                    swal("Actuzalizar", "Ha ocurrido un error, inténtelo más tarde.", "error");
                }
            }, error: function(error) {
                console.log(error);
                swal("Actuzalizar", "Ha ocurrido un error, inténtelo más tarde.", "error");
            }
        });
    }
}

$('.clockpicker-bottom').clockpicker({
    autoclose: true,
    placement: 'bottom',
    align: 'left',
}).find('input').change(function() {
    validation($(this), $(this).parent())
});

$('.clockpicker-top').clockpicker({
    autoclose: true,
    placement: 'top',
    align: 'left',
}).find('input').change(function() {
    validation($(this), $(this).parent())
});

function actualizarHorario(){
    var banValidation=false;

    if($("#entrada_LV").val().length == 0){
        validation($("#entrada_LV"), $("#entrada_LV").parent());
        banValidation=true;
    }

    if($("#salida_LV").val().length == 0){
        validation($("#salida_LV"), $("#salida_LV").parent());
        banValidation=true;
    }

    if($("#entrada_LV_T").val().length == 0){
        validation($("#entrada_LV_T"), $("#entrada_LV_T").parent());
        banValidation=true;
    }

    if($("#salida_LV_T").val().length == 0){
        validation($("#salida_LV_T"), $("#salida_LV_T").parent());
        banValidation=true;
    }

    if($("#entrada_S").val().length == 0){
        validation($("#entrada_S"), $("#entrada_S").parent());
        banValidation=true;
    }

    if($("#salida_S").val().length == 0){
        validation($("#salida_S"), $("#salida_S").parent());
        banValidation=true;
    }

    if($("#entrada_E").val().length == 0){
        validation($("#entrada_E"), $("#entrada_E").parent());
        banValidation=true;
    }

    if($("#salida_E").val().length == 0){
        validation($("#salida_E"), $("#salida_E").parent());
        banValidation=true;
    }

    if($("#entrada_ES").val().length == 0){
        validation($("#entrada_ES"), $("#entrada_ES").parent());
        banValidation=true;
    }

    if($("#salida_ES").val().length == 0){
        validation($("#salida_ES"), $("#salida_ES").parent());
        banValidation=true;
    }

    if(!banValidation){
        var datos = new FormData(document.querySelector('#formHorario'));
        datos.append("idUsuario", "1");


        $.ajax({
            type: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            data: datos,
            dataType: false,
            enctype: 'multipart/form-data',
            url: base_url+"/configuraciones/actualizarHorario",
            success: function(msg){
                var data = JSON.parse(msg)
                if(data == 0){
                    $('#modalConfiguracionHorario').modal('hide')
                    swal("Actuzalizar", "Se han actualizado los datos con éxito", "success");
                    datosHorarios();
                }else{
                    console.log(msg);
                    swal("Actuzalizar", "Ha ocurrido un error, inténtelo más tarde.", "error");
                }
            }, error: function(error) {
                console.log(error);
                swal("Actuzalizar", "Ha ocurrido un error, inténtelo más tarde.", "error");
            }
        });
    }
}

function datosGeneral(){
    $.ajax({
		type: "GET",
		dataType: "json",
		enctype: "multipart/form-data",
		url: base_url+'/configuraciones/datos/1',
		success: function (msg) {
            var data = JSON.parse(msg)
            $("#iva_data").empty().append(data[0].IVA+"%");
            var caja_chica = parseFloat(data[0].Minimo_caja_chica).toFixed(2);
            $("#caja_chica_data").empty().append("$"+caja_chica);

            //modal
            $("#ivaConfig").val(data[0].IVA);
            $("#cajaConfig").val(data[0].Minimo_caja_chica);
		}
	});
}

function datosHorarios(){
    $.ajax({
		type: "GET",
		dataType: "json",
		enctype: "multipart/form-data",
		url: base_url+'/configuraciones/datos/2',
		success: function (msg) {
            var data = JSON.parse(msg)
            console.log(data);

            if(data[0].Hora_entrada != null){
                data[0].Hora_entrada = data[0].Hora_entrada.split(":");
                data[0].Hora_entrada =data[0].Hora_entrada[0]+":"+data[0].Hora_entrada[1]
                $("#entrada_LV").val(data[0].Hora_entrada);
                $("#entradaLV_data").empty().append(data[0].Hora_entrada);
            }


            if(data[0].Hora_salida != null){
                data[0].Hora_salida = data[0].Hora_salida.split(":");
                data[0].Hora_salida =data[0].Hora_salida[0]+":"+data[0].Hora_salida[1]
                $("#salida_LV").val(data[0].Hora_salida);
                $("#salidaLV_data").empty().append(data[0].Hora_salida);
            }

            if(data[0].Hora_entrada_t != null){
                data[0].Hora_entrada_t = data[0].Hora_entrada_t.split(":");
                data[0].Hora_entrada_t =data[0].Hora_entrada_t[0]+":"+data[0].Hora_entrada_t[1]
                $("#entrada_LV_T").val(data[0].Hora_entrada_t);
                $("#entradaLV_T_data").empty().append(data[0].Hora_entrada_t);
            }


            if(data[0].Hora_salida_t != null){
                data[0].Hora_salida_t = data[0].Hora_salida_t.split(":");
                data[0].Hora_salida_t =data[0].Hora_salida_t[0]+":"+data[0].Hora_salida_t[1]
                $("#salida_LV_T").val(data[0].Hora_salida_t);
                $("#salidaLV_T_data").empty().append(data[0].Hora_salida_t);
            }

            if(data[0].Hora_entrada_Sab != null){
                data[0].Hora_entrada_Sab = data[0].Hora_entrada_Sab.split(":");
                data[0].Hora_entrada_Sab =data[0].Hora_entrada_Sab[0]+":"+data[0].Hora_entrada_Sab[1]
                $("#entrada_S").val(data[0].Hora_entrada_Sab);
                $("#entradaS_data").empty().append(data[0].Hora_entrada_Sab);
            }

            if(data[0].Hora_salida_Sab != null){
                data[0].Hora_salida_Sab = data[0].Hora_salida_Sab.split(":");
                data[0].Hora_salida_Sab =data[0].Hora_salida_Sab[0]+":"+data[0].Hora_salida_Sab[1]
                $("#salida_S").val(data[0].Hora_salida_Sab);
                $("#salidaS_data").empty().append(data[0].Hora_salida_Sab);
            }

            if(data[0].Hora_entrada_extra != null){
                data[0].Hora_entrada_extra = data[0].Hora_entrada_extra.split(":");
                data[0].Hora_entrada_extra =data[0].Hora_entrada_extra[0]+":"+data[0].Hora_entrada_extra[1]
                $("#entrada_E").val(data[0].Hora_entrada_extra);
                $("#entradaE_data").empty().append(data[0].Hora_entrada_extra);
            }

            if(data[0].Hora_salida_extra != null){
                data[0].Hora_salida_extra = data[0].Hora_salida_extra.split(":");
                data[0].Hora_salida_extra =data[0].Hora_salida_extra[0]+":"+data[0].Hora_salida_extra[1]
                $("#salida_E").val(data[0].Hora_salida_extra);
                $("#salidaE_data").empty().append(data[0].Hora_salida_extra);
            }

            if(data[0].Hora_entradaLV_Sab != null){
                data[0].Hora_entradaLV_Sab = data[0].Hora_entradaLV_Sab.split(":");
                data[0].Hora_entradaLV_Sab =data[0].Hora_entradaLV_Sab[0]+":"+data[0].Hora_entradaLV_Sab[1]
                $("#entrada_ES").val(data[0].Hora_entradaLV_Sab);
                $("#entradaES_data").empty().append(data[0].Hora_entradaLV_Sab);
            }

            if(data[0].Hora_salidaLV_Sab != null){
                data[0].Hora_salidaLV_Sab = data[0].Hora_salidaLV_Sab.split(":");
                data[0].Hora_salidaLV_Sab =data[0].Hora_salidaLV_Sab[0]+":"+data[0].Hora_salidaLV_Sab[1]
                $("#salida_ES").val(data[0].Hora_salidaLV_Sab);
                $("#salidaES_data").empty().append(data[0].Hora_salidaLV_Sab);
            }

            if(data[0].Hora_entrada_obra != null){
                data[0].Hora_entrada_obra = data[0].Hora_entrada_obra.split(":");
                data[0].Hora_entrada_obra = data[0].Hora_entrada_obra[0]+":"+data[0].Hora_entrada_obra[1]
                $("#entrada_obra").val(data[0].Hora_entrada_obra);
                $("#entrada_obra_data").empty().append(data[0].Hora_entrada_obra);
            }

            if(data[0].Hora_salida_obra != null){
                data[0].Hora_salida_obra = data[0].Hora_salida_obra.split(":");
                data[0].Hora_salida_obra = data[0].Hora_salida_obra[0]+":"+data[0].Hora_salida_obra[1]
                $("#salida_obra").val(data[0].Hora_salida_obra);
                $("#salida_obra_data").empty().append(data[0].Hora_salida_obra);
            }
		}
	});
}

$(document).ready(function () {
	datosGeneral();
    datosHorarios();
});
