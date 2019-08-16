  $(document).ready(function () {
    tablaPrestamos();

    // ACTIVAR TITULOS
    $("body").tooltip({ selector: '[data-toggle="tooltip"]' });

    // SOLO NÚMEROS
    $('body').on('input', ".input-number", function(e){
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
                  msg['prestamos'][x].Num_prestamos = 1;
                  prestamos.push(msg['prestamos'][x]);
                  // console.log(msg['prestamos'][x].id_trabajador + ' no existe ese id.');
                } else if (id_trabajadores.indexOf(msg['prestamos'][x].id_trabajador) > -1) {
                  // console.log(msg['prestamos'][x].id_trabajador + ' ya existe ese id.');
                  var posicion = id_trabajadores.indexOf(msg['prestamos'][x].id_trabajador);
                  prestamos[posicion].Monto = prestamos[posicion].Monto + msg['prestamos'][x].Monto;
                  prestamos[posicion].Num_prestamos += 1;
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
            var txt = "prestamos";
            for (var i = 0; i < tam3; i++) {
              if(prestamos[i].Num_prestamos == 1){
                txt = "prestamo";
              }

              htmlPrestamos+=
                `<tr>
                  <td>${prestamos[i].Nombre} ${prestamos[i].Apellidos}</td>
                  <td><span class="badge badge-warning">${prestamos[i].Num_prestamos} `+txt+`</td></span>
                  <td>$${prestamos[i].Monto}</td>
                  <td>$${prestamos[i].Resta}</td>
                  <td class="text-nowrap" id_trabajador="${prestamos[i].id_trabajador}">
                    <a onclick="mostrarModalAgregarPrestamo(${prestamos[i].id_trabajador},'detalles',${prestamos[i].id_prestamo},1)" data-target="#verDetallePrestamo" data-toggle="tooltip" data-original-title="Detalles"> <i class="icon-eye text-inverse m-r-10"></i> </a>
                    <a onclick="mostrarModalAgregarPrestamo(${prestamos[i].id_trabajador},'historial',-1,2)" data-toggle="tooltip" data-original-title="Historial"> <i class="mdi mdi-information-outline text-inverse m-r-10"></i> </a>
                    <a onclick="mostrarModalAgregarPrestamo(${prestamos[i].id_trabajador},'editar',${prestamos[i].id_prestamo},1)" data-target="#verEditarPrestamo" data-toggle="tooltip" data-original-title="Editar"> <i class="icon-pencil text-inverse m-r-10"></i> </a>
                    <a onclick="mostrarModalAgregarPrestamo(${prestamos[i].id_trabajador},'abonar',${prestamos[i].id_prestamo},1)" resta="${prestamos[i].Resta}" data-target="#modalAbonarPrestamo" data-toggle="tooltip" data-original-title="Abonar"> <i class="ti-money text-inverse m-r-10"></i> </a>
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

  (function () {
    var intento = 0;
    // BOTON AGREGAR
    $('body').on('click', "#btnAgregar", function(e){
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
          alerta("Generar prestamo", "Has superado los intentos permitidos, inténtelo más tarde.", "error");
        }
        else{
          validarFirma(intento, "agregar");
        }
      }
    });
  })();

  (function () {
    var intento = 0;
    // BOTON ABONAR
    $('body').on('click', "#btnAbonar", function(e){
      var resta = $(this).parent().attr("resta");
      console.log(resta);
      $('#mensajeVacio').remove();
      let bandera = 0;
      if($("#montoAbono").val().length == 0){
        validation(0, $("#montoAbono"), $("#montoAbono").parent());
        bandera += 1;
      }
      if($("#montoAbono").val() > resta){
        $('#validacionAbono').append(
            `<label style="color:red;" id="mensajeMonto" name="mensajeMonto" class="control-label">Esta cantidad supera el monto a deber.</label>`);
        bandera += 1;
      }
      if($("#comentario").val().length == 0){
        validation(0, $("#comentario"), $("#comentario").parent());
        bandera += 1;
      }
      if($("#firmaAbono").val().length == 0){
        validation(0, $("#firmaAbono"), $("#firmaAbono").parent());
        bandera += 1;
      }
      // ESTAN LLENOS TODOS LOS CAMPOS
      if(bandera == 0){
        intento += 1;
        // MENSAJE DE SUPERA LOS 3 INTENTOS AL INGRESAR FIRMA TRABAJADOR
        if (intento == 3) {
          limpiarModal();
          $('#modalAgregarPrestamo').hide();
          alerta("Abonar prestamo", "Has superado los intentos permitidos, inténtelo más tarde.", "error");
        }
        else{
          // validarFirma(intento, "abonar");
          console.log("HOLIS");
        }
      }
    });
  })();

  $('body').on('click', "#btnEditar", function(e){
    $('#mensajeVacio').remove();
    let bandera = 0;
    if($("#concepto").val().length == 0){
      validation(0, $("#concepto"), $("#concepto").parent());
      bandera += 1;
    }
    if($("#descripcion").val().length == 0){
      validation(0, $("#descripcion"), $("#descripcion").parent());
      bandera += 1;
    }
    // ESTAN LLENOS TODOS LOS CAMPOS
    if(bandera == 0){
      agregarPrestamo("editar")
    }
  });

  // FUNCION PARA VALIDAR FIRMA TRABAJADOR
  function validarFirma(intento, bandera){
    if(bandera == "agregar"){
      var id = $("#id_trabajador").val();
      var firma = $("#firma").val();
    }
    else if(bandera == "abonar"){
      var id = $("#id_tra").val();
      var firma = $("#firmaAbono").val();
    }
    $.ajax({
        type: 'GET',
        processData: false,
        contentType: false,
        cache: false,
        dataType: false,
        enctype: 'multipart/form-data',
        url: base_url+'/trabajadores/prestamos/verificarFirma/'+id+'/'+firma,
        success: function(msg){
          // console.log(msg);
          if(msg['success'] == "La firma coincide"){
            if(bandera == "agregar"){
              agregarPrestamo("agregar");
            }
            else{
              agregarPrestamo("abonar");
            }
          }
          else if(msg['fail'] == "La firma no coinciden"){
            if(bandera == "agregar"){
              $("#firma").val("");
              $('#validacionFirma').append(
                `<label style="color:red;" id="mensajeFirmaIncorrecta" name="mensajeFirmaIncorrecta"
                  class="control-label">La firma del trabajador no coincide, asegurese de que sea correcta.
                  Intento `+ intento +` de 3.</label>`);
            }
            else if("abonar"){
              $("#firmaAbono").val("");
            }
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

  function agregarPrestamo(bandera){
    var f = new Date();
    var fecha = (f.getFullYear() + "/" + (f.getMonth() +1) + "/" + f.getDate());
    // EXTRAER DATOS DE FORMULARIO
    var datosPrestamo = new FormData (document.querySelector('#formularioPrestamo'));
    datosPrestamo.append("idUsuario", "1");
    datosPrestamo.append("fecha", fecha);
    for (var concepto of datosPrestamo.entries()) {
      console.log("Formulario: " + concepto[0]+ ', ' + concepto[1]);
    }
    // // DATOS INSERTAR
    if(bandera == "agregar"){
      var url = base_url+'/trabajadores/prestamos/agregarPrestamo';
      var mensaje = "Registro guardado con éxito.";
      var mensaje2 = "Agregar prestamo";
    }
    // DATOS EDITAR
    else if(bandera == "editar"){
      if(datosPrestamo.id_prestamo>0){
        var url = base_url+'/trabajadores/editarPrestamo/'+datosPrestamo.id_prestamo;
        var mensaje = "Registro actualizado con éxito.";
        var mensaje2 = "Actualizar trabajador";
      }
      else {
        swal("Actualizar trabajador", "Ha ocurrido un error, inténtelo más tarde.", "error");
      }
    }
    else if(bandera == "abonar"){
      var url = base_url+'/trabajadores/prestamos/agregarMovimiento/';
      var mensaje = "Registro guardado con éxito.";
      var mensaje2 = "Agregar prestamo";
    }
    console.log();
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
          // console.log(msg);
          if(msg['success'] == "Se agrego exitosamente"){
            limpiarModal();
            $('#modalAgregarPrestamo').hide();
            alerta("¡Éxito!", mensaje, "success");
            if(bandera == "abonar"){
              consultarMovimientosPrestamo(datosPrestamo.id_prestamo);
            }
          }
          else if(msg['error'] == "Ocurrio un error"){
            swal(mensaje2, "Ha ocurrido un error, inténtelo más tarde.", "error");
          }
        }, error: function(error) {
            swal(mensaje2, "Ha ocurrido un error, inténtelo más tarde.", "error");
        }
    });
  }

  // MOSTRAR MODAL Y DEPENDIENDO QUE SEA AGREGA O EDITA
  function mostrarModalAgregarPrestamo(id_trabajador, bandera, identificador, estado){
    console.log(identificador);
    $("#id_pre").val(identificador);
    $('#divisiones').remove();
    $("#detallesPrestamo").remove();
    $('#divForm').remove();
    $('#divSeparador').remove();
    $('#btnEditar').remove();
    $('#btnAgregar').remove();
    $('#btnAbonar').remove();
    $('#tituloModal').remove();

    var htmlTitulo=`<h4 class="modal-title" id="tituloModal" name="tituloModal" value="`+bandera+` prestamo">`+bandera+` prestamo</h4>`;
    $("#tituloValor").val(bandera+" prestamo");
    $("#cerrar").before(htmlTitulo);
    $("#id_tra").val(id_trabajador);

    // CONSULTAR LOS PRESTAMOS DE UN TRABAJADOR EN ESPECIFICO
    $.ajax({
        type: 'GET',
        dataType: "json",
        enctype: "multipart/form-data",
        url: base_url+'/trabajadores/prestamos/trabajador/'+id_trabajador+'/'+estado,
        success: function(msg){
          console.log(msg);
          let data = msg;
          if(data['error'] == "Ocurrio un error"){
            console.log("Ha ocurrido un error, inténtelo más tarde.");
          }
          else{
            if(data!=0){
              var htmlPrestamos="", htmlTrabajadores="";
              var num_prestamos = data.length;
              if(id_trabajador!=0 && bandera!="agregar"){
                var text = " prestamos";
                if(num_prestamos==1){
                  text = " prestamo";
                }

                // INSERTAR ROW PARA NOMBRE Y SELECT PRESTAMOS
                var htmlRow="";
                htmlRow=`
                  <div id="divisiones" name="divisiones" class="row">
                      <div class="col-md-6">
                          <div id="nombreTrabajador" name="nombreTrabajador" class="form-group">
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div id="buscarPrestamo" name="buscarPrestamo" class="form-group">
                          </div>
                      </div>
                  </div>`;

                $('#prestamo').before(htmlRow);

                // INSERTAR DATOS TRABAJADOR
                var htmlNombreTrabajador="";
                htmlNombreTrabajador +=
                  `<div id="datosTrabajador" style="text-align:center;">
                    <h3 class="m-b-0">${data[0].Nombre} ${data[0].Apellidos}</h3>
                    <span class="label label-success label-rounded">`+ num_prestamos + text + `</span>
                   </div>`;

                // INSERTAR SELECT DE PRESTAMOS
                var htmlBuscarPrestamo="";
                htmlBuscarPrestamo +=
                  `<form id="escogerPrestamo" name="escogerPrestamo">
                    <div class="form-group">
                      <select id="id_prestamo" name="id_prestamo" class="select2 form-control custom-select" style="width: 100%; height:36px;">
                        <option>Seleccionar</option>
                        <optgroup id="selectPrestamos" label="Prestamos">`;

                // LLENAR SELECT DE PRESTAMOS
                for (var i = 0; i < num_prestamos; i++) {
                  htmlBuscarPrestamo+=
                    `<option value="${data[i].id_prestamo}">${data[i].Concepto}</option>`;
                }

                htmlBuscarPrestamo +=
                  `</optgroup>
                      </select>
                    </div>
                  </form>`;

                // INSERTAR SEPARADOR
                var htmlSeparador="";
                htmlSeparador +=
                  `<div id="divSeparador" name="divSeparador" class="activity-box">
                    <div class="date-devider">
                      <span>`+bandera+` prestamo</span>
                    </div>
                  </div>`;

                $("#formularioPrestamo").append(htmlSeparador);

              }
              if(bandera == "detalles" || bandera == "historial" || bandera == "abonar"){
                var p = "";
                if(identificador == -1){
                  p = 0;
                }
                else{
                  var i = [];
                  if(num_prestamos!=0){
                    for (var x = 0; x < num_prestamos; x++) {
                      // if()
                      i[x]=data[x].id_prestamo;
                    }
                    var ide = parseInt(identificador);
                    p = i.indexOf(ide);
                  }
                }

                // INSERTAR DETALLES PRESTAMO
                var htmlDetalles="";
                htmlDetalles +=
                  `<table id="detallesPrestamo" name="detallesPrestamo" class="table vm no-th-brd pro-of-month">
                    <tbody>
                      <tr>
                          <td style="padding: .50rem; border-top:0px;" class="m-b-0"><strong>Concepto: </strong>${data[p].Concepto}</td>
                          <td style="padding: .50rem; border-top:0px;" class="m-b-0"><strong>Descripción </strong>${data[p].Descripción}</td>
                      </tr>
                      <tr>
                          <td style="padding: .50rem; border-top:0px;" class="m-b-0"><strong>Monto: </strong>${data[p].Monto}</td>
                          <td style="padding: .50rem; border-top:0px;" class="m-b-0"><strong>Fecha: </strong>${data[p].Fecha}</td>
                      </tr>
                    </tbody>
                  </table>`;

                $("#buscarPrestamo").append(htmlBuscarPrestamo);
                $("#nombreTrabajador").append(htmlNombreTrabajador);
                // $("#formularioPrestamo").append(htmlPrestamos);
                $("#formularioPrestamo").append(htmlDetalles);
                $("#id_prestamo").val(data[p].id_prestamo).trigger("change.select2");
                $("id_tra").val(data[p].id_trabajador);

                // INSERTAR OPCIONES DE ABONAR
                if(bandera == "abonar"){
                  var hmtlFormularioAbonar="";
                  hmtlFormularioAbonar +=
                    `<div id="divForm" name="divForm">
                       <div class="row">
                           <div class="col-md-6">
                               <div class="form-group">
                                 <label for="montoAbono" class="control-label">Monto:</label>
                                 <input type="text" class="form-control input-number" id="montoAbono" name="montoAbono">
                                 <div id="validacionAbono" name="validacionAbono">
                                 </div>
                               </div>
                           </div>
                           <div class="col-md-6">
                               <div class="form-group">
                                   <label for="comentario" class="control-label">Comentario:</label>
                                   <input type="text" class="form-control" id="comentario" nameS="comentario">
                               </div>
                           </div>
                       </div>
                       <div class="form-group">
                           <label>Firma(trabajador):</label>
                           <input type="password" class="form-control input-number" id="firmaAbono" name="firmaAbono">
                           <div id="validacionFirma" name="validacionFirma">
                       </div>
                     </div>`;

                   var htmlBoton="";
                   htmlBoton=`<button type="button" id="btnAbonar" class="btn btn-info">Guardar</button>`;
                   $('#btnCancelar').after(htmlBoton);
                   $("#formularioPrestamo").append(hmtlFormularioAbonar);
                }
                else if(bandera == "detalles"){
                  // consultarMovimientosPrestamo(data[p].id_prestamo);
                }
              }
              else{
                // INSERTAR FORMULARIO PRESTAMOS
                htmlPrestamos +=
                  `<div id="divForm" name="divForm">
                    <div class="form-group">
                        <label for="id_trabajador" class="control-label">Trabajador <span class="danger">*</span> </label>
                        <select id="id_trabajador" name="id_trabajador" class="select2 form-control custom-select" style="width: 100%; height:36px;">
                          <option>Seleccionar</option>
                          <optgroup id="selectTrabajadores" label="Trabajadores">
                          </optgroup>
                        </select>
                        <div id="validacionTrabajador" name="validacionTrabajador">
                        </div>
                      </div>
                      <div class="row">
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="concepto" class="control-label">Concepto: <span class="danger">*</span> </label>
                                  <input type="text" class="form-control" id="concepto" name="concepto">
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group">
                                <label for="montoPrestamo" class="control-label">Monto: <span class="danger">*</span> </label>
                                <input type="text" class="form-control input-number" id="montoPrestamo" name="montoPrestamo">
                              </div>
                          </div>
                      </div>
                      <div class="form-group">
                          <label>Descripción: <span class="danger">*</span> </label>
                          <textarea class="form-control" rows="2" id="descripcion" name="descripcion"></textarea>
                      </div>
                      <div class="form-group">
                          <label for="firma">Firma(trabajador): <span class="danger">*</span> </label>
                          <input type="password" class="form-control input-number" id="firma" name="firma">
                          <div id="validacionFirma" name="validacionFirma">
                          </div>
                      </div>
                    </div>`;

                // LLENAR SELECT TRABAJADORES
                $.ajax({
                    type: 'GET',
                    dataType: "json",
                    enctype: "multipart/form-data",
                    url: base_url+'/trabajadores/prestamos/trabajadores',
                    success: function(msg2){
                      // console.log(msg2);
                      if(msg2['error'] == "Ocurrio un error"){
                        console.log("Ha ocurrido un error, inténtelo más tarde.");
                      }
                      else{
                        var data2 = msg2;
                        // console.log(data2);
                        var tam = data2.length;
                        for (var i = 0; i < tam; i++) {
                          htmlTrabajadores+=
                            `<option value="${data2[i].id_trabajador}">${data2[i].Nombre} ${data2[i].Apellidos}</option>`;
                        }
                        var htmlBoton="";
                        if(bandera == "agregar"){
                          htmlBoton=`<button type="button" id="btnAgregar" class="btn btn-info">Guardar</button>`;

                          $("#formularioPrestamo").append(htmlPrestamos);
                          $('#selectTrabajadores').after(htmlTrabajadores);
                        }
                        else{
                          $("#buscarPrestamo").append(htmlBuscarPrestamo);
                          $("#nombreTrabajador").append(htmlNombreTrabajador);
                          htmlBoton=`<button type="button" id="btnEditar" class="btn btn-info">Guardar</button>`;
                          $("#formularioPrestamo").append(htmlPrestamos);
                          $('#selectTrabajadores').after(htmlTrabajadores);
                          if(identificador == -1){
                            llenarCampos(data[0]);
                          }
                          else{
                            var i = [];
                            if(num_prestamos!=0){
                              for (var x = 0; x < num_prestamos; x++) {
                                i[x]=data[x].id_prestamo;
                              }
                              var ide = parseInt(identificador);
                              var posicion = i.indexOf(ide);
                              llenarCampos(data[posicion]);
                            }
                          }
                        }
                        $('#btnCancelar').after(htmlBoton);
                      }
                    }
                });
              }
              $('#modalAgregarPrestamo').modal('show');
              $(".select2").select2();
            }
            else if(bandera == "historial"){
              swal({
                type: "warning",
                title: "Historial prestamos",
                text: "Por el momento no tiene prestamos pasados.",
                showConfirmButton: false,
                timer: 1500
              });
            }
          }
        }
    });

  }

  function consultarMovimientosPrestamo(id_prestamo){
    // CONSULTAR MOVIMIENTOS DE UN PRESTAMO
    $.ajax({
        type: 'GET',
        dataType: "json",
        enctype: "multipart/form-data",
        url: base_url+'/trabajadores/prestamos/consultarMovimientos/'+id_prestamo,
        success: function(msg){
          console.log(msg);
          if(msg['error'] == "Ocurrio un error"){
            console.log("Ha ocurrido un error, inténtelo más tarde.");
          }
          else{
            // CORRECTO
          }
        }
    });

    // for (var c = 0; c < tam3; c++) {
    //   if(data[c].Estado==0){
    //     htmlHistorialContratos+=
    //       `<tr>
    //         <td>${data[c].Puesto}</td>
    //         <td>${data[c].Fecha_inicio}</td>
    //         <td>${data[c].Fecha_final}</td>
    //         <td>${data[c].Sueldo}</td>
    //         <td>${data[c].Monto_Hora_Extra}</td>
    //         <td>${data[c].Bono_extra}</td>
    //         <td>${data[c].Bono_produc_asis}</td>
    //       </tr>`;
    //   }
    // }
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

  // VALIDACIONES FORMULARIO AGREGAR PRESTAMO
  $('body').on('change', "#id_trabajador", function(e){
    var select = $("#id_trabajador").val();
    if(select == "Seleccionar"){
      validation(1, $(this), $(this).parent());
    }
    else{
      $('#mensajeVacio').remove();
    }
  });

  $('body').on('input', "#concepto", function(e){
    validation(0, $(this), $(this).parent());
  });

  $('body').on('input', "#montoPrestamo", function(e){
    validation(0, $(this), $(this).parent());
  });

  $('body').on('input', "#descripcion", function(e){
    validation(0, $(this), $(this).parent());
  });

  $('body').on('input', "#firma", function(e){
    $('#mensajeFirmaIncorrecta').remove();
    validation(0, $(this), $(this).parent());
  });
  // FIN VALIDACIONES FORMULARIO

  $('body').on('change', "#id_prestamo", function(e){
    var id_prestamo = $("#id_prestamo").val();
    if(id_prestamo != "Seleccionar"){
      if($('#tituloValor').val() == "editar prestamo"){
        var id_trabajador = $("#id_trabajador").val();
        mostrarModalAgregarPrestamo(id_trabajador, "editar", id_prestamo, 1);
        console.log(id_trabajador, "editar", id_prestamo);
      }
      else if($('#tituloValor').val() == "detalles prestamo"){
        var id_trabajador = $("#id_tra").val();
        mostrarModalAgregarPrestamo(id_trabajador, "detalles", id_prestamo, 1);
        console.log(id_trabajador, "detalles", id_prestamo);
      }
      else if($('#tituloValor').val() == "historial prestamo"){
        var id_trabajador = $("#id_tra").val();
        mostrarModalAgregarPrestamo(id_trabajador, "historial", id_prestamo, 2);
        console.log(id_trabajador, "historial", id_prestamo);
      }
      else if($('#tituloValor').val() == "abonar prestamo"){
        var id_trabajador = $("#id_tra").val();
        mostrarModalAgregarPrestamo(id_trabajador, "abonar", id_prestamo, 1);
        console.log(id_trabajador, "abonar", id_prestamo);
      }
    }
  });

  // VALIDACIONES FORMULARIO ABONAR PRESTAMO
  $('body').on('input', "#montoAbono", function(e){
    validation(0, $(this), $(this).parent());
  });
  $('body').on('input', "#comentario", function(e){
    validation(0, $(this), $(this).parent());
  });
  $('body').on('input', "#firmaAbono", function(e){
    $('#mensajeFirmaIncorrecta').remove();
    validation(0, $(this), $(this).parent());
  });
  // FIN VALIDACIONES FORMULARIO ABONAR PRESTAMO

  function limpiarModal(){
    $("#id_trabajador").val("Seleccionar");
    $("#concepto").val("");
    $("#montoPrestamo").val("");
    $("#descripcion").val("");
    $("#firma").val("");
  }

  function alerta(title, mensaje, type){
    swal({
      title: title,
      text: mensaje,
      type: type,
      closeOnConfirm: false
    }, function(isConfirm){
      if (isConfirm) {
        location.href = "/trabajadores/prestamos";
      }
    });
  }

  function llenarCampos(data, bandera){
    $("#id_prestamo").val(data.id_prestamo).trigger("change.select2");
    $("#id_trabajador").val(data.id_trabajador).trigger("change.select2");
    $("#concepto").val(data.Concepto);
    $("#montoPrestamo").val(data.Monto);
    $("#descripcion").val(data.Descripción);
    $("#firma").val("prueba");

    $("#montoPrestamo").prop('disabled', true);
    $("#id_trabajador").prop('disabled', true);
    $("#firma").prop('disabled', true);
  }
