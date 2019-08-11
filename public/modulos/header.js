$(document).ready(function(){
    var fecha = fechaValidaHeader();
    console.log(fecha);
    if (fecha!="") {
        consultarHeader(fecha[0], fecha[1]);   
    }
})

function fechaValidaHeader(){
    var fechas = "";
    $.ajax({
        type: "GET",
        dataType: "json",
        enctype:"multipart/form-data",
        async:false,
        url: "/consultarUltimoCajaChicaHeader",
        success: function (msg) {
            var primerDia = new Date(msg[0].Fecha);
            var ultimoDia = new Date(msg[0].Fecha);

            while(primerDia.getDay() != 1) {
             primerDia.setDate(primerDia.getDate() - 1);
            }
            while(ultimoDia.getDay() != 6) {
             ultimoDia.setDate(ultimoDia.getDate() + 1);
            }
            var mes1 = primerDia.getMonth()+1;
            var dia1 = primerDia.getDate();
            if (parseInt(mes1) < 10) {
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

        }, error: function(error) {
        //Error Message
        console.log(error);
     }
    });
    return fechas;
}

function consultarHeader(fechaInicial, fechaFinal){
	var totalOficina=0;
	var totalTrabajadores=0;
	var totalMandados=0;
	var totalAdeudo=0;
	$.ajax({
        type: "GET",
        dataType: "json",
        enctype: "multipart/form-data",
        url: "/consultarCajaChicaHeader/"+fechaInicial+"/"+fechaFinal,
        success: function (msg) {
            for(var i=0; i < msg.length; i++)
            {
            	switch(msg[i].Tipo){
            		case 1:
            			totalOficina+=msg[i].Total;
            			break;
            		case 2:
            			totalTrabajadores+=msg[i].Total;
            			break;
            		case 3:
            			totalMandados+=msg[i].Total;
            			break;
            		case 4:
            			totalAdeudo+=msg[i].Total;
            			break;
            	}
                $("#oficinaMiniCJ").text("$"+totalOficina);
                $("#trabajadoresMiniCJ").text("$"+totalTrabajadores);
                $("#mandadosMiniCJ").text("$"+totalMandados);
                $("#debeMiniCJ").text("$"+totalAdeudo);
            }    
            $.ajax({
		        type: "GET",
		        dataType: "json",
		        enctype: "multipart/form-data",
		        url: "/consultarConfiguracionCajaChicaHeader",
		        success: function (msg) {
		            var montoFisicamente = msg[0].monto - (totalOficina + totalTrabajadores + totalMandados - totalAdeudo);
		        	$("#cajachicaMiniCJ").text("$"+montoFisicamente);
		        	$("#totalMiniCJ").text("$"+msg[0].monto);

		        }, error: function(error) {
		                //Error Message
		                console.log(error);
		        }
		    });

        }, error: function(error) {
                //Error Message
                console.log(error);
        }
    });
}