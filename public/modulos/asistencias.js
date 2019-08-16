  $(document).ready(function () {

    tablaTrabajadores();

    obtenerHorarios();

    // ACTIVAR TITULOS
    $("body").tooltip({ selector: '[data-toggle="tooltip"]' });
  });

  // VARIABLES GLOBALES
  var idsTodos = [];
  var idsMañana = [];
  var idsTarde = [];
  var idsHoraExtra = [];
  var idsFaltas = [];
  var a = "";
  var diferenciaMañana = 0;
  var diferenciaTarde = 0;
  var diferenciaHoraExtra = 0;
  // FECHA
  var f = new Date();
  var fecha = (f.getFullYear() + "/" + (f.getMonth() +1) + "/" + f.getDate());
  $("#fecha").append(`<h5>`+fecha+`</h5>`);

  (function () {
    // CHECAR CAMBIOS EN LOS CHECKBOX
    $('body').on('change', "input[type=checkbox]", function(e){
      if ($(this).is(':checked') ) {
        var checkbox = $(this).prop("id");
        a = true;
      }
      else{
        var checkbox = $(this).prop("id");
        a = false;
      }

      // EXTRAE EL TIPO DE CHECKBOX
      var p = checkbox.split('-');
      var letra = p[0];
      var id = p[1];
      var checkboxTarde = "#t-"+p[1];
      var checkboxHoraExtra = "#h-"+p[1];

      // SI CAMBIO UN CHECKBOX DE MAÑANA
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

      // SI CAMBIO UN CHECKBOX DE TARDE
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

    // SI DA CLICK EN GUARDAR CAMBIOS
    $("#btnGuardar").click(function(){
      console.log("idsMañana: " + idsMañana);
      console.log("idsTarde: " + idsTarde);
      console.log("idsHoraExtra: " + idsHoraExtra);
      console.log("idsTodos: " + idsTodos);
      var idsTodosFINAL = [];
      for (var i = 0; i < idsTodos.length; i++) {
        if(idsTodosFINAL.indexOf(idsTodos[i]) === -1){
          idsTodosFINAL.push(idsTodos[i]);
        }
      }
      console.log("LA QUE SE MANDA: " + idsTodosFINAL);

      // COMPARA SI ALGUN TRABAJADOR ESTA REGISTRADO PERO NO TIENE NONGUNA ASISTENCIA
      var idsFaltasFINAL = [];
      for (var i = 0; i < idsFaltas.length; i++) {
        if(idsTodosFINAL.indexOf(idsFaltas[i]) === -1){
          console.log("NO EXISTE EN EL TODOS FINAL: " + idsFaltas[i]);
          idsFaltasFINAL.push(idsFaltas[i]);
        }
      }
      console.log("LOS QUE NO TIENEN ASISTENCIA: " + idsFaltasFINAL);

      if(idsTodosFINAL.length != 0 || idsFaltasFINAL.length != 0){
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
              'idsFaltas': idsFaltasFINAL,
              'tamañoMañana': idsMañana.length,
              'tamañoTarde': idsTarde.length,
              'tamañoHoraExtra': idsHoraExtra.length,
              'tamañoTodos': idsTodosFINAL.length,
              'tamañoFaltas': idsFaltasFINAL.length,
              'diferenciaMañana': diferenciaMañana,
              'diferenciaTarde': diferenciaTarde,
              'diferenciaHoraExtra': diferenciaHoraExtra,
              'idUsuario': 1
            },
            url: base_url+'/trabajadores/asistencias/guardarAsistencia',
            success: function(msg){
              // console.log(msg);
              if(msg['success'] == "Se agrego exitosamente"){
                swal({
                  type: "success",
                  title: "¡Éxito!",
                  text: "Asistencia guardada con éxito.",
                  showConfirmButton: false,
                  timer: 1500
                });
               tablaTrabajadores();
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

  function tablaTrabajadores(){
    console.log("SE ACTUALIZA LA HABLA");
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
                      </label>
                      <a onclick="agregarHoras('mañana', ${trabajadores[i].id_trabajador})" data-target="#verAgregarHoras" data-toggle="tooltip" data-original-title="Llegada"> <i class="mdi mdi-timer text-inverse m-r-10"></i> </a>
                    </div>
                  </td>
                  <td>
                    <div class="switch">
                      <label>
                        <input type="checkbox" id="t-${trabajadores[i].id_trabajador}" name="t-${trabajadores[i].id_trabajador}"><span class="lever switch-col-teal"></span>
                      </label>
                      <a onclick="agregarHoras('tarde', ${trabajadores[i].id_trabajador})" data-target="#verAgregarHoras" data-toggle="tooltip" data-original-title="Llegada"> <i class="mdi mdi-timer text-inverse m-r-10"></i> </a>
                    </div>
                  </td>
                  <td>
                    <div class="switch">
                      <label>
                        <input type="checkbox" id="h-${trabajadores[i].id_trabajador}" name="h-${trabajadores[i].id_trabajador}"><span class="lever switch-col-teal"></span>
                      </label>
                    </div>
                  </td>
                  <td class="text-nowrap">
                    <a id="false-${trabajadores[i].id_trabajador}" name="false-${trabajadores[i].id_trabajador}" onclick="noAsistio(${trabajadores[i].id_trabajador})" data-toggle="tooltip" data-original-title="Limpiar"> <i class="ti-close text-inverse m-r-10"></i> </a>
                    <a id="true-${trabajadores[i].id_trabajador}" name="true-${trabajadores[i].id_trabajador}" onclick="asistio(${trabajadores[i].id_trabajador})" data-toggle="tooltip" data-original-title="Llenar"> <i class="ti-check-box text-inverse m-r-10"></i> </a>
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
            idsTodos = [];
            idsMañana = [];
            idsTarde = [];
            idsHoraExtra = [];
            var asistencia = msg['asistencia'];
            console.log(asistencia);
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

            // IGUALO A EL ARRAY DE FALTAS
            idsFaltas = [];
            for (var i = 0; i < idsTodos.length; i++) {
              if(idsFaltas.indexOf(idsTodos[i]) === -1){
                idsFaltas.push(idsTodos[i]);
              }
            }
            console.log("idsMañana: " + idsMañana);
            console.log("idsTarde: " + idsTarde);
            console.log("idsHoraExtra: " + idsHoraExtra);
            console.log("idsTodos: " + idsTodos);
            console.log("idsFaltas: " + idsFaltas);
          }
        }
    });
  }

  function obtenerHorarios(){
    $.ajax({
        type: 'GET',
        processData: false,
        contentType: false,
        cache: false,
        dataType: false,
        enctype: 'multipart/form-data',
        url: base_url+'/trabajadores/asistencias/horarios',
        success: function(msg){
          console.log(msg);
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
  }

  function agregarHoras(bandera, id_trabajador){
    $('#modalHoras').modal('show');
  }

  function asistio(id_trabajador){
    var checkMañana = "#m-"+id_trabajador;
    var checkTarde = "#t-"+id_trabajador;
    var checkHoraExtra = "#h-"+id_trabajador;

    // PONER ASISTENCIA MAÑANA
    idsMañana.push(""+id_trabajador);
    idsTodos.push(""+id_trabajador);
    $(checkMañana).prop("checked", true);

    // PONER ASISTENCIA TARDE
    idsTarde.push(""+id_trabajador);
    idsTodos.push(""+id_trabajador);
    $(checkTarde).prop("checked", true);

    // PONER ASITENCIA HORA EXTRA
    idsHoraExtra.push(""+id_trabajador);
    idsTodos.push(""+id_trabajador);
    $(checkHoraExtra).prop("checked", true);

    var i = idsFaltas.indexOf(id_trabajador);
    if ( i !== -1 ) {
      idsFaltas.splice(i, 1);
    }
  }

  function noAsistio(id_trabajador){
    var checkMañana = "#m-"+id_trabajador;
    var checkTarde = "#t-"+id_trabajador;
    var checkHoraExtra = "#h-"+id_trabajador;

    $(checkMañana).prop("checked", false);
    $(checkTarde).prop("checked", false);
    $(checkHoraExtra).prop("checked", false);

    // SE AGREGA AL ARRAY FALTAS
    idsFaltas.push(id_trabajador);
  }

  function diferenciaHoras(hora_entrada, hora_salida){
    // DIFERENCIA HORAS DE ASISTENCIA
    var hora1 = hora_salida.split(":"),
    hora2 = hora_entrada.split(":"),
    t1 = new Date(), t2 = new Date();

    t1.setHours(hora1[0], hora1[1], hora1[2]);
    t2.setHours(hora2[0], hora2[1], hora2[2]);
    t1.setHours(t1.getHours() - t2.getHours(), t1.getMinutes() - t2.getMinutes(), t1.getSeconds() - t2.getSeconds());
    var diferencia = t1.getHours();

    // var diferenciaCompleta = "La diferencia es de: " + (t1.getHours() ? t1.getHours() + (t1.getHours() > 1 ? " horas" : " hora") : "")
    // + (t1.getMinutes() ? ", " + t1.getMinutes() + (t1.getMinutes() > 1 ? " minutos" : " minuto") : "")
    // + (t1.getSeconds() ? (t1.getHours() || t1.getMinutes() ? " y " : "") + t1.getSeconds() + (t1.getSeconds() > 1 ? " segundos" : " segundo") : "");

    return diferencia;
  }
