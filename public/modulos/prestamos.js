  $(document).ready(function () {
    tablaPrestamos();

    // ACTIVAR TITULOS
    $("body").tooltip({ selector: '[data-toggle="tooltip"]' });

    // SOLO NÚMEROS
    $('.input-number').on('input', function () {
      this.value = this.value.replace(/[^0-9]/g,'');
    });
  });

  // TABLA PRESTAMOS
  function tablaPrestamos(){
    $.ajax({
        type: 'GET',
        dataType: "json",
    		enctype: "multipart/form-data",
        url: base_url+'/trabajadores/prestamos/tabla',
        success: function(msg){
          console.log(msg);
          if(msg['error'] == "Ocurrio un error"){
            console.log("Ha ocurrido un error, inténtelo más tarde.");
          }
          else{
            // COMPARAR SI ESE TRABAJADOR TIENE MAS DE UN PRESTAMO Y JUNTAR EL MONTO A DEBER
            var id_trabajadores = [];
            var prestamos = [];
            var tam = msg['prestamos'].length;
            if(tam!=0){
              for (var x = 0; x < tam; x++) {
                if (id_trabajadores.indexOf(msg['prestamos'][x].id_trabajador) === -1) {
                    id_trabajadores.push(msg['prestamos'][x].id_trabajador);
                    msg['prestamos'][x].Abono = 0;
                    msg['prestamos'][x].Resta = 0;
                    prestamos.push(msg['prestamos'][x]);
                    // console.log(msg['prestamos'][x].id_trabajador + ' no existe ese id.');
                } else if (id_trabajadores.indexOf(msg['prestamos'][x].id_trabajador) > -1) {
                    // console.log(msg['prestamos'][x].id_trabajador + ' ya existe ese id.');
                    var posicion = id_trabajadores.indexOf(msg['prestamos'][x].id_trabajador);
                    prestamos[posicion].Monto = prestamos[posicion].Monto + msg['prestamos'][x].Monto;
                }
              }
            }
            // console.log(prestamos);
            // console.log(id_trabajadores);

            // COMPARAR SI ESE TRABAJADOR TIENE ABONOS Y JUNTAR EL MONTO RESTANTE
            var tam2 = msg['movimientos'].length;
            if(tam2!=0){
              for (var x = 0; x < tam2; x++) {
                var posicion = id_trabajadores.indexOf(msg['movimientos'][x].id_trabajador);
                prestamos[posicion].Abono = prestamos[posicion].Abono + msg['movimientos'][x].Abono;
                prestamos[posicion].Resta = prestamos[posicion].Monto - prestamos[posicion].Abono;
              }
            }

            // console.log(prestamos);

            for (var m = 0; m < prestamos.length; m++) {
              if(prestamos[m].Abono == 0){
                prestamos[m].Resta = prestamos[m].Monto;
              }
            }

            var htmlPrestamos="";
            var tam3 = prestamos.length;
            for (var i = 0; i < tam3; i++) {
              htmlPrestamos+=
                `<tr>
                  <td>${prestamos[i].Nombre} ${prestamos[i].Apellidos}</td>
                  <td>$${prestamos[i].Monto}</td>
                  <td>$${prestamos[i].Resta}</td>
                  <td class="text-nowrap" id_trabajador="${prestamos[i].id_trabajador}">
                    <a class="detallesPrestamo" href="#" data-target="#verDetallePrestamo" data-toggle="tooltip" data-original-title="Detalles"> <i class="icon-eye text-inverse m-r-10"></i> </a>
                    <a class="historialPrestamos" href="#" data-target="#verHistorialPrestamos" data-toggle="tooltip" data-original-title="Historial"> <i class="mdi mdi-information-outline text-inverse m-r-10"></i> </a>
                    <a href="/prestamos/editar/${prestamos[i].id_trabajador}" data-toggle="tooltip" data-original-title="Editar"> <i class="icon-pencil text-inverse m-r-10"></i> </a>
                    <a class="abonarPrestamo" href="#" data-target="#modalAbonarPrestamo" data-toggle="tooltip" data-original-title="Abonar"> <i class="ti-money text-inverse m-r-10"></i> </a>
                    <a class="liquidarPrestamo" href="#" data-target="#modalLiquidarPrestamo" data-toggle="tooltip" data-original-title="Liquidar"> <i class="ti-check text-danger m-r-10"></i> </a>
                  </td>
                </tr>`;
            }
            $("#prestamos tbody").empty().append(htmlPrestamos);
            $('#prestamos').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
          }
        }
    });
  }

  // FUNCION PARA MOSTRAR MODAL AGREGAR PRESTAMO
  function mostrarModalAgregarPrestamo(){
    $.ajax({
        type: 'GET',
        dataType: "json",
    		enctype: "multipart/form-data",
        url: base_url+'/trabajadores/prestamos/trabajadores',
        success: function(msg){
          console.log(msg);
          if(msg['error'] == "Ocurrio un error"){
            console.log("Ha ocurrido un error, inténtelo más tarde.");
          }
          else{
            var data = msg;
            console.log(data);
            var htmlTrabajadores="";
            var tam = data.length;
            for (var i = 0; i < tam; i++) {
              htmlTrabajadores+=
                `<option value="${data[i].id_trabajador}">${data[i].Nombre} ${data[i].Apellidos}</option>`;
            }
            $('#selectTrabajadores').after(htmlTrabajadores);
            $(".select2").select2();
          }
        }
    });
    $('#modalAgregarPrestamo').modal('show');
    $("#btnAgregar").attr("onclick");
  }

  (function () {
    var intento = 0;
    $('#btnAgregar').click(function () {
      $('#mensajeVacio').remove();
      let bandera = 0;
      if($("#id_trabajador").val() == "Seleccionar"){
        validation(1, $("#id_trabajador"), $("#id_trabajador").parent());
        bandera += 1;
      }
      if($("#concepto").val().length == 0){
        validation(0, $("#concepto"), $("#concepto").parent());
        bandera += 1;
      }
      if($("#montoPrestamo").val().length == 0){
        validation(0, $("#montoPrestamo"), $("#montoPrestamo").parent());
        bandera += 1;
      }
      if($("#descripcion").val().length == 0){
        validation(0, $("#descripcion"), $("#descripcion").parent());
        bandera += 1;
      }
      if($("#firma").val().length == 0){
        validation(0, $("#firma"), $("#firma").parent());
        bandera += 1;
      }
      // ESTAN LLENOS TODOS LOS CAMPOS
      if(bandera == 0){
        intento += 1;
        // MENSAJE DE SUPERA LOS 3 INTENTOS AL INGRESAR FIRMA TRABAJADOR
        if (intento == 3) {
          limpiarModal();
          $('#modalAgregarPrestamo').hide();
          swal("Generar prestamo", "Has superado los intentos permitidos, inténtelo más tarde.", "error");
        }
        else{
          validarFirma(intento);
        }
      }
    });
  })();

  // FUNCION PARA VALIDAR FIRMA TRABAJADOR
  function validarFirma(intento){
    var id = $("#id_trabajador").val();
    var firma = $("#firma").val();
    $.ajax({
        type: 'GET',
        processData: false,
        contentType: false,
        cache: false,
        dataType: false,
        enctype: 'multipart/form-data',
        url: base_url+'/trabajadores/prestamos/verificarFirma/'+id+'/'+firma,
        success: function(msg){
          console.log(msg);
          if(msg['success'] == "La firma coincide"){
            limpiarModal();
            $('#modalAgregarPrestamo').hide();
            agregarPrestamo();
          }
          else if(msg['fail'] == "La firma no coinciden"){
            $("#firma").val("");
            $('#validacionFirma').append(
              `<label style="color:red;" id="mensajeFirmaIncorrecta" name="mensajeFirmaIncorrecta"
                class="control-label">La firma del trabajador no coincide, asegurese de que sea correcta.
                Intento `+ intento +` de 3.</label>`);
          }
        }, error: function(error) {
            console.log("Error al verificar firma");
        }
    });
  }

  function agregarPrestamo(){
    var f = new Date();
    var fecha = (f.getFullYear() + "/" + (f.getMonth() +1) + "/" + f.getDate());
    console.log("Fecha: " + fecha);
    // EXTRAER DATOS DE FORMULARIO
    // document.querySelector('#formularioPrestamo')
    var datosPrestamo = new FormData ();
    console.log("Concepto: " + $("#concepto").val());
    datosPrestamo.append("_token", $("#_token").val());
    datosPrestamo.append("id_trabajador", $("#id_trabajador").val());
    datosPrestamo.append("concepto", $("#concepto").val());
    datosPrestamo.append("montoPrestamo", $("#montoPrestamo").val());
    datosPrestamo.append("descripcion", $("#descripcion").val());
    datosPrestamo.append("idUsuario", "1");
    datosPrestamo.append("fecha", fecha);
    for (var concepto of datosPrestamo.entries()) {
      console.log("Formulario: " + concepto[0]+ ', ' + concepto[1]);
    }
    // // DATOS INSERTAR
    // if(bandera == "agregar"){
      var url = base_url+'/trabajadores/prestamos/agregarPrestamo';
      var mensaje = "Registro guardado con éxito.";
      var mensaje2 = "Agregar prestamo";
    // }
    // DATOS EDITAR
    // else if(bandera == "editar"){
      // if(id>0){
      //   // console.log("ENTRA A EDITAR");
      //   var url = base_url+'/trabajadores/editarTrabajador/'+id;
      //   var mensaje = "Registro actualizado con éxito.";
      //   var mensaje2 = "Actualizar trabajador";
      // }
      // else {
      //   swal("Actualizar trabajador", "Ha ocurrido un error, inténtelo más tarde.", "error");
      // }
    // }
    // SERVICIO
    $.ajax({
        type: 'POST',
        processData: false,
        contentType: false,
        cache: false,
        data: datosPrestamo,
        dataType: false,
        enctype: 'multipart/form-data',
        url: url,
        success: function(msg){
          console.log(msg);
          // if(msg['success'] == "Se agrego exitosamente"){
          //   reset_form('.validation-wizard');
          //   success(mensaje);
          // }
          // else if(msg['error'] == "Ocurrio un error"){
          //   swal(mensaje2, "Ha ocurrido un error, inténtelo más tarde.", "error");
          // }
        }, error: function(error) {
            swal(mensaje2, "Ha ocurrido un error, inténtelo más tarde.", "error");
        }
    });
  }

  function validation(bandera, children, parent){
    if(bandera == 1){
      $('#validacionTrabajador').append(
        `<label style="color:red;" id="mensajeVacio" name="mensajeVacio" class="control-label">Este campo es requerido</label>`);
    }
    else{
      if(children.val().length == 0){
          parent.addClass("error");
      }else{
          parent.removeClass("error");
      }
    }
  }

  // VALIDACIONES FORMULARIO
  $("#id_trabajador").on('change',function(e){
      var select = $("#id_trabajador").val();
      if(select == "Seleccionar"){
        validation(1, $(this), $(this).parent());
      }
      else{
        $('#mensajeVacio').remove();
      }
  });

  $("#concepto").on('input',function(e){
      validation(0, $(this), $(this).parent());
  });

  $("#montoPrestamo").on('input',function(e){
      validation(0, $(this), $(this).parent());
  });

  $("#descripcion").on('input',function(e){
      validation(0, $(this), $(this).parent());
  });

  $("#firma").on('input',function(e){
      $('#mensajeFirmaIncorrecta').remove();
      validation(0, $(this), $(this).parent());
  });
  // FIN VALIDACIONES FORMULARIO

  function limpiarModal(){
    $("#id_trabajador").val("Seleccionar");
    $("#concepto").val("");
    $("#montoPrestamo").val("");
    $("#descripcion").val("");
    $("#firma").val("");
  }
