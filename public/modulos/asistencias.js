  $(document).ready(function () {
    // ACTIVAR TITULOS
    $("body").tooltip({ selector: '[data-toggle="tooltip"]' });
  });

  (function () {
    // FECHA
    var f = new Date();
    var fecha = (f.getFullYear() + "/" + (f.getMonth() +1) + "/" + f.getDate());
    $("#fecha").append(`<h5>`+fecha+`</h5>`);

    var idsTodos = [];
    var idsMañana = [];
    var idsTarde = [];
    var idsHoraExtra = [];
    var idsTodosFINAL = [];
    var a = "";
    var diferenciaMañana = 0;
    var diferenciaTarde = 0;
    var diferenciaHoraExtra = 0;

    // LLENAR TABLA ASISTENCIA
    $.ajax({
        type: 'GET',
        dataType: "json",
    		enctype: "multipart/form-data",
        url: base_url+'/trabajadores/asistencias/tabla',
        success: function(msg){
          // console.log(msg);
          if(msg['error'] == "Ocurrio un error"){
            console.log("Ha ocurrido un error, inténtelo más tarde.");
          }
          else{
            // LLENAR TABLA TRABAJADORES
            var trabajadores = msg['trabajadores'];
            $("#asistenciaTrabajadores").DataTable().clear();
            $("#asistenciaTrabajadores").DataTable().destroy();
            var html="";
            var tam = trabajadores.length;
            for (var i = 0; i < tam; i++) {
              html+=
                `<tr>
                  <td>${trabajadores[i].Nombre} ${trabajadores[i].Apellidos}</td>
                  <td>
                    <div class="switch">
                      <label>
                        <input type="checkbox" id="m-${trabajadores[i].id_trabajador}" name="m-${trabajadores[i].id_trabajador}"><span class="lever switch-col-teal"></span>
                        <a class="horaLlegadaMañana" data-target="#verDetallesTrabajador" data-toggle="tooltip" data-original-title="Llegada"> <i class="mdi mdi-timer text-inverse m-r-10"></i> </a>
                      </label>
                    </div>
                  </td>
                  <td>
                    <div class="switch">
                      <label>
                        <input type="checkbox" id="t-${trabajadores[i].id_trabajador}" name="t-${trabajadores[i].id_trabajador}"><span class="lever switch-col-teal"></span>
                        <a class="horaLlegadaTarde" data-target="#verDetallesTrabajador" data-toggle="tooltip" data-original-title="Llegada"> <i class="mdi mdi-timer text-inverse m-r-10"></i> </a>
                      </label>
                    </div>
                  </td>
                  <td>
                    <div class="switch">
                      <label>
                        <input type="checkbox" id="h-${trabajadores[i].id_trabajador}" name="h-${trabajadores[i].id_trabajador}"><span class="lever switch-col-teal"></span>
                      </label>
                    </div>
                  </td>
                </tr>`;
            }
            $("#asistenciaTrabajadores tbody").empty().append(html);
            $('#asistenciaTrabajadores').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });

            // LLENAR CHECKBOX ASISTENCIA TRABAJADORES
            var asistencia = msg['asistencia'];
            var tam = asistencia.length;
            for (var i = 0; i < tam; i++) {
              var checkMañana = "#m-"+asistencia[i].id_trabajador;
              var checkTarde = "#t-"+asistencia[i].id_trabajador;
              var checkHoraExtra = "#h-"+asistencia[i].id_trabajador;
              // COMPARAR ASISTENCIA MAÑANA
              if(asistencia[i].Hora_entrada >= 1){
                idsMañana.push(""+asistencia[i].id_trabajador);
                idsTodos.push(""+asistencia[i].id_trabajador);
                $(checkMañana).prop("checked", true);
              }
              // COMPARAR ASISTENCIA TARDE
              if(asistencia[i].Hora_salida >= 1){
                idsTarde.push(""+asistencia[i].id_trabajador);
                idsTodos.push(""+asistencia[i].id_trabajador);
                $(checkTarde).prop("checked", true);
              }
              // COMPARAR ASITENCIA HORA EXTRA
              if(asistencia[i].Hora_extra >= 1){
                idsHoraExtra.push(""+asistencia[i].id_trabajador);
                idsTodos.push(""+asistencia[i].id_trabajador);
                $(checkHoraExtra).prop("checked", true);
              }
            }
            console.log("idsMañana: " + idsMañana);
            console.log("idsTarde: " + idsTarde);
            console.log("idsHoraExtra: " + idsHoraExtra);
            console.log("idsTodos: " + idsTodos);
          }
        }
    });

    $.ajax({
        type: 'GET',
        processData: false,
        contentType: false,
        cache: false,
        dataType: false,
        enctype: 'multipart/form-data',
        url: base_url+'/trabajadores/asistencias/horarios',
        success: function(msg){
          // console.log(msg);
          data = msg;

          // CALCULAR LAS HORAS QUE SE DEBEN DE TRABAJAR
          // MAÑANA
          diferenciaMañana = 0;
          diferenciaMañana = diferenciaHoras(data[0].Hora_entrada, data[0].Hora_salida);

          // TARDE
          diferenciaTarde = 0;
          diferenciaTarde = diferenciaHoras(data[0].Hora_entrada_t, data[0].Hora_salida_t);

          // HORA EXTRA
          diferenciaHoraExtra = 0;
          diferenciaHoraExtra = diferenciaHoras(data[0].Hora_entrada_extra, data[0].Hora_salida_extra);

        }, error: function(error) {
            console.log("Error");
        }
    });

    $('body').on('change', "input[type=checkbox]", function(e){
      if ($(this).is(':checked') ) {
        var checkbox = $(this).prop("id");
        a = true;
      }
      else{
        var checkbox = $(this).prop("id");
        a = false;
      }

      var p = checkbox.split('-');
      var letra = p[0];
      var id = p[1];
      var checkboxTarde = "#t-"+p[1];
      var checkboxHoraExtra = "#h-"+p[1];

      // MAÑANA
      if(letra == "m" && a == true){
        var tam = idsMañana.length;
        if(tam == 0){
          idsMañana.push(id);
          idsTodos.push(id);
        }
        else{
          for (var x = 0; x < tam; x++) {
            if(idsMañana.indexOf(id) === -1){
              idsMañana.push(id);
              idsTodos.push(id);
            }
          }
        }
      }
      else if(letra == "m" && a == false){
        var i = idsMañana.indexOf(id);
        if ( i !== -1 ) {
          idsMañana.splice(i, 1);
        }
        var o = idsTodos.indexOf(id);
        if ( o !== -1 ) {
          idsTodos.splice(o, 1);
        }
      }

      // TARDE
      if(letra == "t" && a == true){
        var tam = idsTarde.length;
        if(tam == 0){
          idsTarde.push(id);
          idsTodos.push(id);
        }
        else{
          for (var x = 0; x < tam; x++) {
            if(idsTarde.indexOf(id) === -1){
              idsTarde.push(id);
              idsTodos.push(id);
            }
          }
        }
      }
      else if(letra == "t" && a == false){
        var i = idsTarde.indexOf(id);
        if ( i !== -1 ) {
          idsTarde.splice(i, 1);
        }
        var o = idsTodos.indexOf(id);
        if ( o !== -1 ) {
          idsTodos.splice(o, 1);
        }
      }

      // HORA EXTRA
      if(letra == "h" && a == true){
        var tam = idsHoraExtra.length;
        if(tam == 0){
          idsHoraExtra.push(id);
          idsTodos.push(id);
        }
        else{
          for (var x = 0; x < tam; x++) {
            if(idsHoraExtra.indexOf(id) === -1){
              idsHoraExtra.push(id);
              idsTodos.push(id);
            }
          }
        }
      }
      else if(letra == "h" && a == false){
        var i = idsHoraExtra.indexOf(id);
        if ( i !== -1 ) {
          idsHoraExtra.splice(i, 1);
        }
        var o = idsTodos.indexOf(id);
        if ( o !== -1 ) {
          idsTodos.splice(o, 1);
        }
      }

      console.log("idsMañana: " + idsMañana);
      console.log("idsTarde: " + idsTarde);
      console.log("idsHoraExtra: " + idsHoraExtra);
      console.log("idsTodos: " + idsTodos);

    });

  $("#btnGuardar").click(function(){
    console.log("idsMañana: " + idsMañana);
    console.log("idsTarde: " + idsTarde);
    console.log("idsHoraExtra: " + idsHoraExtra);
    console.log("idsTodos: " + idsTodos);
    for (var i = 0; i < idsTodos.length; i++) {
      if(idsTodosFINAL.indexOf(idsTodos[i]) === -1){
        idsTodosFINAL.push(idsTodos[i]);
      }
    }
    console.log("LA QUE SE MANDA: " + idsTodosFINAL);
    if(idsMañana.length != 0 || idsTarde.length != 0 || idsHoraExtra.length != 0){
      var datos = [];
      datos[1] = 1;
      $.ajax({
          type: 'POST',
          data:
          { '_token': token,
            'idsTodos': idsTodosFINAL,
            'idsMañana': idsMañana,
            'idsTarde':idsTarde,
            'idsHoraExtra': idsHoraExtra,
            'tamañoMañana': idsMañana.length,
            'tamañoTarde': idsTarde.length,
            'tamañoHoraExtra': idsHoraExtra.length,
            'diferenciaMañana': diferenciaMañana,
            'diferenciaTarde': diferenciaTarde,
            'diferenciaHoraExtra': diferenciaHoraExtra,
            'idUsuario': 1
          },
          url: base_url+'/trabajadores/asistencias/guardarAsistencia',
          success: function(msg){
            // console.log(msg);
            if(msg['success'] == "Se agrego exitosamente"){
              alerta("¡Éxito!", "Asistencia guardada con éxito.", "success");
            }
            else if(msg['error'] == "Ocurrio un error"){
              swal("Asistencia trabajadores", "Ha ocurrido un error, inténtelo más tarde.", "error");
            }
          }, error: function(error) {
              swal("Asistencia trabajadores", "Ha ocurrido un error, inténtelo más tarde.", "error");
          }
      });
    }
  });
  })();

  function alerta(title, mensaje, type){
    swal({
      title: title,
      text: mensaje,
      type: type,
      closeOnConfirm: false
    }, function(isConfirm){
      if (isConfirm) {
        location.href = "/trabajadores/asistencias";
      }
    });
  }

  function diferenciaHoras(hora_entrada, hora_salida){
    // DIFERENCIA HORAS DE ASISTENCIA
    var hora1 = hora_salida.split(":"),
    hora2 = hora_entrada.split(":"),
    t1 = new Date(),
    t2 = new Date();

    t1.setHours(hora1[0], hora1[1], hora1[2]);
    t2.setHours(hora2[0], hora2[1], hora2[2]);
    t1.setHours(t1.getHours() - t2.getHours(), t1.getMinutes() - t2.getMinutes(), t1.getSeconds() - t2.getSeconds());
    var diferencia = t1.getHours();

    // var diferenciaCompleta = "La diferencia es de: " + (t1.getHours() ? t1.getHours() + (t1.getHours() > 1 ? " horas" : " hora") : "")
    // + (t1.getMinutes() ? ", " + t1.getMinutes() + (t1.getMinutes() > 1 ? " minutos" : " minuto") : "")
    // + (t1.getSeconds() ? (t1.getHours() || t1.getMinutes() ? " y " : "") + t1.getSeconds() + (t1.getSeconds() > 1 ? " segundos" : " segundo") : "");

    return diferencia;
  }
