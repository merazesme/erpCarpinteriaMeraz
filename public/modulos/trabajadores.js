  $(document).ready(function () {
    // VALIDACION FORMULARIO
    initialize_validate_form();

    // ACTIVAR TITULOS
    $("body").tooltip({ selector: '[data-toggle="tooltip"]' });

    // SOLO NÚMEROS
    $('body').on('input', ".input-number", function(e){
      this.value = this.value.replace(/[^0-9]/g,'');
    });

    // ACTIVAR VALIDACIÓN FIRMA
    $('#validarFirma').hide();

    // IDENTIFICAR QUE METODO ES
    // console.log(location.href);
    // TABLA
  	if(location.href == base_url+'/trabajadores/lista'){
      console.log("Lista trabajadores");
      tablaTrabajadores();
    }
    // AGREGAR
    else if(location.href == base_url+'/trabajadores/agregar'){
      console.log("Agregar trabajador");
    }
    else {
      var p = location.href.split('/');
      // EDITAR
      if(p[4] == "editar"){
        console.log("Editar Trabajador");
        trabajadorEspecifico(p[5], "editar");
      }
      // CONTRATAR
      else if(p[4] == "contrato"){
        console.log("Generar Contrato");
        contratarTrabajador(p[5]);
      }
    }

    // SE EJECUTA CUANDO SE CIERRA MODAL
    $("#modalDetalles").on('hidden.bs.modal', function () {
      $("#datosTrabajador").remove();
      $("#br").remove();
    });

    // SE EJECUTA CUANDO SE CIERRA MODAL
    $("#modalHistorial").on('hidden.bs.modal', function () {
      $("#datosTrabajador").remove();
      $("#br").remove();
    });
  });

  function cancelar_registro() {
      $('#formularioTrabajador')[0].reset();
      location.href = "/trabajadores/lista";
  }

  function regresar() {
      location.href = "/trabajadores/lista";
  }

  function reset_form(identifier_form) {
      $(identifier_form).steps("reset");
      $(identifier_form)[0].reset();
  }

  // FUNCIONES BOTON FORMULARIO
  function tipoBotonFormulario() {
      var url = (location.href).split("/");
      if(url[url.length - 1] == "agregar") {
        agregarTrabajador("agregar", -1);
      }
      else if(url[url.length - 2] == "editar") {
        var p = location.href.split('/');
        // console.log(p[5]);
        agregarTrabajador("editar", p[5]);
      }
      else if(url[url.length - 2] == "contrato"){
        var p = location.href.split('/');
        // console.log(p[5]);
        generarContrato(p[5]);
      }
  }

  function initialize_validate_form() {
      $(".validation-wizard").steps({
          headerTag: "h6"
          , bodyTag: "section"
          , transitionEffect: "fade"
          , titleTemplate: '<span class="step">#index#</span> #title#'
          , enableCancelButton: true
          , onCanceled: function (event) {
              reset_form('.validation-wizard');
          }
          , labels: {
              cancel: "Cancelar",
              finish: "Finalizar",
              previous: "Anterior"
          }
          , onStepChanging: function (event, currentIndex, newIndex) {
              return currentIndex > newIndex || !(3 === newIndex && Number($("#age-2").val()) < 18) && (currentIndex < newIndex && (form.find(".body:eq(" + newIndex + ") label.error").remove(), form.find(".body:eq(" + newIndex + ") .error").removeClass("error")), form.validate().settings.ignore = ":disabled,:hidden", form.valid())
          }
          , onFinishing: function (event, currentIndex) {
              return form.validate().settings.ignore = ":disabled", form.valid()
          }
          , onFinished: function (event, currentIndex) {
              if($("#firma").val().length == 6){
                $('#validarFirma').hide();
                tipoBotonFormulario();
              }
              else{
                $('#validarFirma').show();
              }
          }
      });
      $('a[href*="#cancel"]').css({'background' : '#CC0000'});
  }

  // TABLA TRABAJADORES
  function tablaTrabajadores(){
    $.ajax({
        type: 'GET',
        dataType: "json",
    		enctype: "multipart/form-data",
        url: base_url+'/trabajadores/tabla',
        success: function(msg){
          msg.reverse();
          console.log(msg);
          if(msg['error'] == "Ocurrio un error"){
            console.log("Ha ocurrido un error, inténtelo más tarde.");
          }
          else{
            $("#trabajadoresActivos").DataTable().clear();
            $("#trabajadoresActivos").DataTable().destroy();
            $("#trabajadoresInactivos").DataTable().clear();
            $("#trabajadoresInactivos").DataTable().destroy();
            // ARRAY CON LOS ID
            var arreglo = [];
            var data = [];
            // COMPARAR SI ESTA REPETIDO ESE ID
            var tam = msg.length;
            for (var x = 0; x < tam; x++) {
              if (arreglo.indexOf(msg[x].id_trabajador) === -1) {
                  arreglo.push(msg[x].id_trabajador);
                  data.push(msg[x]);
                  // console.log("Arreglo: " + arreglo);
              } else if (arreglo.indexOf(msg[x].id_trabajador) > -1) {
                  // console.log(msg[x].id + ' ya existe ese id.');
              }
            }
            // console.log(arreglo);
            // console.log(data);
            var htmlActivo="", htmlInactivo="";
            var tam2 = data.length;
            for (var i = 0; i < tam2; i++) {
              if(data[i].Fecha_final == null){
                data[i].Fecha_final = "Indefinida";
              }
              var html="";
              html=
                `<tr>
                  <td>${data[i].Nombre} ${data[i].Apellidos}</td>
                  <td>${data[i].Puesto}</td>
                  <td>${data[i].Fecha_final}</td>
                  <td class="text-nowrap" id_trabajador="${data[i].id_trabajador}">
                    <a class="detallesTrabajador" href="#" data-target="#verDetallesTrabajador" data-toggle="tooltip" data-original-title="Detalles"> <i class="icon-eye text-inverse m-r-10"></i> </a>
                    <a class="historialTrabajador" href="#" data-target="#verHistorialTrabajador" data-toggle="tooltip" data-original-title="Historial"> <i class="mdi mdi-information-outline text-inverse m-r-10"></i> </a>
                    <a href="/trabajadores/editar/${data[i].id_trabajador}" data-toggle="tooltip" data-original-title="Editar"> <i class="icon-pencil text-inverse m-r-10"></i> </a>`;
              if(data[i].trabajador_estado == 0 && data[i].contrato_estado == 0){
                // USUARIO INACTIVO
                html += `<a class="contratarTrabajador" href="#" data-toggle="tooltip" data-original-title="Contratar"> <i class="mdi mdi-file-document text-inverse m-r-10"></i> </a>
                        </td>
                      </tr>`;
                htmlInactivo += html;
              }
              else if(data[i].trabajador_estado == 1 && data[i].contrato_estado == 1){
                // USUARIO ACTIVO
                html += `<a class="liquidarTrabajador" href="#" data-toggle="tooltip" data-original-title="Liquidar"> <i class="mdi mdi-file-check text-inverse m-r-10"></i> </a>
                        </td>
                      </tr>`;
                htmlActivo += html;
              }
            }
            $("#trabajadoresActivos tbody").empty().append(htmlActivo);
            $('#trabajadoresActivos').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
            $("#trabajadoresInactivos tbody").empty().append(htmlInactivo);
            $('#trabajadoresInactivos').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
          }
        }
    });
  }

  // AGREGAR Y EDITAR TRABAJADORES
  function agregarTrabajador(bandera, id){
    // EXTRAER DATOS DE FORMULARIO
    var datosTrabajador = new FormData (document.querySelector('#formularioTrabajador'));
    var variable = $('input:radio[name=tipo]:checked').val();
    if(variable == "Temporal"){
      datosTrabajador.append("fecha_final", $("#fecha_final").val());
    }
    datosTrabajador.append("idUsuario", "1");
    for (var concepto of datosTrabajador.entries()) {
      console.log("Formulario: " + concepto[0]+ ', ' + concepto[1]);
    }
    // DATOS INSERTAR
    if(bandera == "agregar"){
      var url = base_url+'/trabajadores/agregarTrabajador';
      var mensaje = "Registro guardado con éxito.";
      var mensaje2 = "Agregar trabajador";
    }
    // DATOS EDITAR
    else if(bandera == "editar"){
      if(id>0){
        // COMPARAR SI CAMBIO LA CONTRASEÑA
        var cambiarFirma = 0;
        if($("#firma").val()!="prueba"){
          cambiarFirma = 1;
        }
        datosTrabajador.append("cambiarFirma", cambiarFirma);
        // console.log("ENTRA A EDITAR");
        var url = base_url+'/trabajadores/editarTrabajador/'+id;
        var mensaje = "Registro actualizado con éxito.";
        var mensaje2 = "Actualizar trabajador";
      }
      else {
        swal("Actualizar trabajador", "Ha ocurrido un error, inténtelo más tarde.", "error");
      }
    }
    // SERVICIO
    $.ajax({
        type: 'POST',
        processData: false,
        contentType: false,
        cache: false,
        data: datosTrabajador,
        dataType: false,
        enctype: 'multipart/form-data',
        url: url,
        success: function(msg){
          console.log(msg);
          if(msg['success'] == "Se agrego exitosamente"){
            reset_form('.validation-wizard');
            success(mensaje);
          }
          else if(msg['error'] == "Ocurrio un error"){
            swal(mensaje2, "Ha ocurrido un error, inténtelo más tarde.", "error");
          }
        }, error: function(error) {
            swal(mensaje2, "Ha ocurrido un error, inténtelo más tarde.", "error");
        }
    });
  }

  // AGARRAR DATOS TRABAJADOR ESPECIFICO
  function trabajadorEspecifico(id_trabajador, bandera){
    // console.log("LLEGO ESTE ID: " + id);
    $.ajax({
        type: 'GET',
        dataType: "json",
    		enctype: "multipart/form-data",
        url: base_url+'/trabajadores/trabajador/'+id_trabajador,
        success: function(msg){
          console.log(msg);
          let data = msg;
          msg.reverse();
          if(data['error'] == "Ocurrio un error"){
            console.log("Ha ocurrido un error, inténtelo más tarde.");
          }
          else{
            if(bandera=="editar") {
              llenarCampos(data);
              // SECTION 3
              if(data[0].Tipo=="Temporal"){
                agregarInputFechas();
                $("#tipo_temporal").attr('checked', true);
                $("#tiempo").val(data[0].Tiempo);
                $("#fecha_inicio").val(data[0].Fecha_inicio);
                $("#fecha_final").val(data[0].Fecha_final);
              }
              else{
                $("#tipo_base").attr('checked', true);
              }
              $("#puesto").val(data[0].Puesto);
              $("#sueldo").val(data[0].Sueldo);
              $("#hora_extra").val(data[0].Monto_Hora_Extra);
              $("#bono_asistencia").val(data[0].Bono_produc_asis);
              $("#bono_extra").val(data[0].Bono_extra);
            }
            else if(bandera == "contratar"){
              llenarCampos(data);
              alert('Para generar el contrato', 'Favor de verificar si los datos del trabajador son correctos.', 'warning');
            }
            else {
              var htmlNombre="", htmlDetallesTrabajador="", htmlDetallesContrato="";
              htmlNombre=
                `<div id="datosTrabajador" style="text-align:center;">
                  <h3 class="m-b-0">${data[0].Nombre} ${data[0].Apellidos}</h3>
                  <h6 class="text-muted">${data[0].Puesto}</h6>`;
              if(data[0].Estado == 0 || data[0].Estado == null){
                // TRABAJADOR INACTIVO
                var estado="Inactivo";
                var color="danger";
              }
              else {
                // TRABAJADOR ACTIVO
                var estado="Activo";
                var color="success";
              }
              htmlNombre +=
                ` <span class="label label-warning label-rounded">${data[0].Tipo}</span>
                  <span class="label label-`+ color +` label-rounded">`+ estado + ` </span>
                </div>
                <br id="br">`;

              if(data[0].Fecha_final == null){
                data[0].Fecha_final = "Indefinida";
              }

              if(bandera == "detalles"){
                htmlDetallesTrabajador=
                  `<tr>
                      <td style="padding: .50rem; border-top:0px;" class="m-b-0"><strong>Celular: </strong>${data[0].Celular}</td>
                      <td style="padding: .50rem; border-top:0px;" class="m-b-0"><strong>Número alternativo: </strong>${data[0].Num_alternativo}</td>
                  </tr>
                  <tr>
                      <td style="padding: .50rem; border-top:0px;" class="m-b-0"><strong>Fecha de nacimiento: </strong>${data[0].Fecha_nacimiento}</td>
                      <td style="padding: .50rem; border-top:0px;" class="m-b-0"><strong>Lugar de nacimiento: </strong>${data[0].Lugar_nacimiento}</td>
                  </tr>
                  <tr>
                      <td style="padding: .50rem; border-top:0px;" class="m-b-0"><strong>Domicilio: </strong>${data[0].Domicilio}</td>
                      <td style="padding: .50rem; border-top:0px;" class="m-b-0"><strong>Estado civil: </strong>${data[0].Estado_civil}</td>
                  </tr>
                  <tr>
                      <td style="padding: .50rem; border-top:0px;" class="m-b-0"><strong>Escolaridad: </strong>${data[0].Escolaridad}</td>
                      <td style="padding: .50rem; border-top:0px;" class="m-b-0"><strong>Nacionalidad: </strong>${data[0].Nacionalidad}</td>
                  </tr>
                  <tr>
                      <td style="padding: .50rem; border-top:0px;" class="m-b-0"><strong>NSS: </strong>${data[0].NSS}</td>
                      <td style="padding: .50rem; border-top:0px;" class="m-b-0"><strong>Núm. Credencial: </strong>${data[0].Num_credencial}</td>
                  </tr>
                  <tr>
                      <td style="padding: .50rem; border-top:0px;" class="m-b-0"><strong>Infonavit: </strong>${data[0].Infonavit}</td>
                      <td style="padding: .50rem; border-top:0px;" class="m-b-0"><strong>Apodo: </strong>${data[0].Apodo}</td>
                  </tr>`;
                if(data[0].Tipo=="Temporal"){
                  htmlDetallesContrato=
                    `<tr>
                        <td style="padding: .50rem; border-top:0px;" class="m-b-0"><strong>Fecha inicio: </strong>${data[0].Fecha_inicio}</td>
                        <td style="padding: .50rem; border-top:0px;" class="m-b-0"><strong>Fecha final: </strong>${data[0].Fecha_final}</td>
                    </tr>`;
                }
                htmlDetallesContrato+=
                  `<tr>
                      <td style="padding: .50rem; border-top:0px;" class="m-b-0"><strong>Sueldo: </strong>$${data[0].Sueldo}</td>
                      <td style="padding: .50rem; border-top:0px;" class="m-b-0"><strong>Bono asistencia: </strong>$${data[0].Bono_produc_asis}</td>
                  </tr>
                  <tr>
                      <td style="padding: .50rem; border-top:0px;" class="m-b-0"><strong>Hora extra: </strong>$${data[0].Monto_Hora_Extra}</td>
                      <td style="padding: .50rem; border-top:0px;" class="m-b-0"><strong>Bono extra: </strong>$${data[0].Bono_extra}</td>
                  </tr>`;

                $("#datos").before(htmlNombre);
                $("#detallesTrabajador tbody").empty().append(htmlDetallesTrabajador);
                $("#detallesContrato tbody").empty().append(htmlDetallesContrato);
              }
              else if(bandera == "historial"){
                var htmlHistorialContratos="", htmlHistorialLiquidaciones="";
                var tam3 = data.length;
                console.log(tam3);
                console.log(data);
                for (var c = 0; c < tam3; c++) {
                  if(data[c].Fecha_final == null){
                    data[c].Fecha_final = "Indefinida";
                  }
                  if(data[c].Estado==0){
                    htmlHistorialContratos+=
                      `<tr>
                        <td>${data[c].Puesto}</td>
                        <td>${data[c].Fecha_inicio}</td>
                        <td>${data[c].Fecha_final}</td>
                        <td>${data[c].Sueldo}</td>
                        <td>${data[c].Monto_Hora_Extra}</td>
                        <td>${data[c].Bono_extra}</td>
                        <td>${data[c].Bono_produc_asis}</td>
                      </tr>`;
                  }
                }

                htmlHistorialLiquidaciones=
                  ``;

                $("#datos2").before(htmlNombre);
                $("#historialContratos tbody").empty().append(htmlHistorialContratos);
                $('#historialContratos').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'pdf', 'print'
                    ]
                });
              }
            }
          }
        }
    });
  }

  // LIQUIDAR Y CONTRATAR TRABAJADOR
  function liquidar_contratar_Trabajador(bandera, id){
    // LIQUIDAR
    if(bandera == "liquidar"){
      var url = base_url+'/trabajadores/liquidarTrabajador/'+id;
      var title = "¿Seguro que deseas liquidar a este trabajador?";
      var boton = "Liquidar";
      var mensaje = "Trabajador liquidado con éxito.";
      var mensaje2 = "Liquidar trabajador";
      var datosTrabajador = new FormData ();
      datosTrabajador.append("_token", token);
      datosTrabajador.append("estado", "0");
      datosTrabajador.append("idUsuario", "1");
    }
    // CONTRATAR
    else if(bandera == "contratar") {
      // var url = base_url+'/trabajadores/agregarTrabajador';
      var title = "¿Seguro que deseas contratar a este trabajador?";
      var boton = "Contratar";
      var mensaje = "Trabajador contratado con éxito.";
      var mensaje2 = "Contratar trabajador";
    }
    swal({
        title: title,
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: boton,
        cancelButtonText: "Cancelar",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm){
        if (isConfirm) {
          if(bandera == "liquidar"){
            // console.log("SI LIQUIDAR");
            // SERVICIO
            $.ajax({
                type: 'POST',
                processData: false,
                contentType: false,
                cache: false,
                data: datosTrabajador,
                dataType: false,
                enctype: 'multipart/form-data',
                url: url,
                success: function(msg){
                  console.log(msg);
                  if(msg['success'] == "Se liquido exitosamente"){
                    swal({
                          title: "¡Éxito!",
                          type: "success",
                          closeOnConfirm: false
                      }, function(isConfirm){
                          if (isConfirm) {
                            if(bandera == "liquidar"){
                              // PREGUNTAR SI DESEA CREAR CONTACTO
                              var title = "¿Deseas generarle un nuevo contrato a este trabajador?";
                              var boton = "Contratar";
                              swal({
                                  title: title,
                                  type: "warning",
                                  showCancelButton: true,
                                  confirmButtonColor: "#DD6B55",
                                  confirmButtonText: boton,
                                  cancelButtonText: "Cancelar",
                                  closeOnConfirm: false,
                                  closeOnCancel: true
                              }, function(isConfirm){
                                  if (isConfirm) {
                                    location.href = "/trabajadores/contrato/"+id;
                                  }
                                  else{
                                    tablaTrabajadores();
                                  }
                              });
                            }
                          }
                          else{
                            location.href = "/trabajadores/lista";
                          }
                      });
                  }
                  else if(msg['error'] == "Ocurrio un error"){
                    swal(mensaje2, "Ha ocurrido un error, inténtelo más tarde.", "error");
                  }
                }, error: function(error) {
                    swal(mensaje2, "Ha ocurrido un error, inténtelo más tarde.", "error");
                }
            });
          }
          else if(bandera == "contratar"){
            location.href = "/trabajadores/contrato/"+id;
          }
        }
    });
  }

  function llenarCampos(data){
    // SECTION 1
    $("#id_contrato").val(data[0].id);
    $("#nombre").val(data[0].Nombre);
    $("#apellidos").val(data[0].Apellidos);
    $("#celular").val(data[0].Celular);
    $("#numero_alternativo").val(data[0].Num_alternativo);
    $("#domicilio").val(data[0].Domicilio);
    $("#estado_civil").val(data[0].Estado_civil);
    $("#fecha_nacimiento").val(data[0].Fecha_nacimiento);
    $("#lugar_nacimiento").val(data[0].Lugar_nacimiento);
    $("#nacionalidad").val(data[0].Nacionalidad);
    $("#escolaridad").val(data[0].Escolaridad);
    $("#apodo").val(data[0].Apodo);
    // SECTION 2
    $("#NSS").val(data[0].NSS);
    $("#infonavit").val(data[0].Infonavit);
    $("#numero_credencial").val(data[0].Num_credencial);
    $("#firma").val("prueba");
  }

  function contratarTrabajador(id_trabajador){
    // console.log(id);
    trabajadorEspecifico(id_trabajador, "contratar");
  }

  function generarContrato(id){
    // console.log(id);
    var datosTrabajador = new FormData (document.querySelector('#formularioTrabajador'));
    datosTrabajador.append("idUsuario", "1");
    var url = base_url+'/trabajadores/contratarTrabajador/'+id;
    // COMPARAR SI CAMBIO LA CONTRASEÑA
    var cambiarFirma = 0;
    if($("#firma").val()!="prueba"){
      cambiarFirma = 1;
    }
    datosTrabajador.append("cambiarFirma", cambiarFirma);
    // Servicio
    $.ajax({
        type: 'POST',
        processData: false,
        contentType: false,
        cache: false,
        data: datosTrabajador,
        dataType: false,
        enctype: 'multipart/form-data',
        url: url,
        success: function(msg){
          console.log(msg);
          if(msg['success'] == "Se contrato exitosamente"){
  	        mensaje = "Contrato generado con éxito.";
            success(mensaje);
          }
          else if(msg['error'] == "Ocurrio un error"){
            swal("Generar contrato", "Ha ocurrido un error, inténtelo más tarde.", "error");
          }
        }, error: function(error) {
            swal("Generar contrato", "Ha ocurrido un error, inténtelo más tarde.", "error");
        }
    });
  }

  // BOTON TABLA DETALLE TRABAJADOR
  $("body").on("click", ".detallesTrabajador", function(e){
    var id_trabajador = $(this).parent().attr("id_trabajador");
    trabajadorEspecifico(id_trabajador, "detalles");
    $('#modalDetalles').modal('show');
  })

  // BOTON TABLA HISTORIAL TRABAJADOR
  $("body").on("click", ".historialTrabajador", function(e){
    var id_trabajador = $(this).parent().attr("id_trabajador");
    trabajadorEspecifico(id_trabajador, "historial");
    $('#modalHistorial').modal('show');
  })

  // BOTON TABLA LIQUIDAR TRABAJADOR ACTIVO
  $("body").on("click", ".liquidarTrabajador", function(e){
    console.log("Liquidar");
    var id_trabajador = $(this).parent().attr("id_trabajador");
    liquidar_contratar_Trabajador("liquidar", id_trabajador);
  })

  // BOTON TABLA CONTRATAR TRABAJADOR INACTIVO
  $("body").on("click", ".contratarTrabajador", function(e){
    console.log("Contratar");
    var id_trabajador = $(this).parent().attr("id_trabajador");
    liquidar_contratar_Trabajador("contratar", id_trabajador);
  })

  $("#tipoDeDocumento").on("click", ".tipoDeDocumento", function(e){
    console.log("DIO CLICK");
    console.log($("#tipoDeDocumento").val());
  })

  function alert(heading, text, icon){
    $.toast({
      heading: heading,
      text: text,
      position: 'top-right',
      loaderBg:'#ff6849',
      icon: icon,
      hideAfter: 3500,
      stack: 6
    });
  }

  function success(mensaje){
    swal({
      title: "¡Éxito!",
      text: mensaje,
      type: "success",
      closeOnConfirm: false
    }, function(isConfirm){
      if (isConfirm) {
        location.href = "/trabajadores/lista";
      }
    });
  }

  function agregarInputFechas(){
    $("#divFechas").remove();

    var htmlSelectTiempo="";
    htmlSelectTiempo=
      `<div id="divFechas" name="divFechas">
        <label for="tiempo">Tiempo: <span class="danger">*</span> </label>
         <select class="custom-select form-control required" id="tiempo" name="tiempo">
           <option value=""></option>
           <option value="3">3 meses</option>
           <option value="6">6 meses</option>
           <option value="1">1 año</option>
         </select>
       </div>`;

    $("#selectFechas").append(htmlSelectTiempo);

    var htmlFechas="";
    htmlFechas=
    `<div class="col-md-6" id="fechasTemporal" name="fechasTemporal">
        <div class="form-group">
            <label for="fecha_inicio">Fecha de inicio: <span class="danger">*</span> </label>
            <input type="date" class="form-control required" id="fecha_inicio" name="fecha_inicio">
            <div id="validacionFechaInicio" name="validacionFechaInicio">
            </div>
        </div>
    </div>
    <div class="col-md-6" id="fechasTemporal2" name="fechasTemporal2">
        <div class="form-group">
            <label for="fecha_final">Fecha final: <span class="danger">*</span> </label>
            <input type="date" class="form-control required" id="fecha_final" name="fecha_final">
        </div>
    </div>`;

    $("#fechas").append(htmlFechas);
    $("#fecha_final").prop('disabled', true);
  }

  function tipoTrabajador(bandera){
    // 1 - Temporal   2 - Base
    if(bandera == 1){
      agregarInputFechas();
    }
    else{
      $("#fecha_inicio").val();
      $("#fecha_final").val();
      $("#fechasTemporal").remove();
      $("#fechasTemporal2").remove();
      $("#tiempo").val();
      $("#divFechas").remove();
    }
  }

  function calcularTiempoContrato(tiempo, tipo){
    var fecha_inicio = $("#fecha_inicio").val();
    var separador = separador || "-";
    var arrayFecha = fecha_inicio.split(separador);
    var anio = arrayFecha[0];
    var mes = arrayFecha[1];
    var dia = arrayFecha[2];

    var inicio = new Date(anio, mes - 1, dia);
    var final = inicio;
    if(tipo=="mes"){
      final.setMonth(inicio.getMonth()+parseInt(tiempo));
    }
    else if(tipo=="año"){
      final.setFullYear(inicio.getFullYear()+parseInt(tiempo));
    }

    dia = final.getDate();
    mes = final.getMonth() + 1;
    anio = final.getFullYear();

    dia = (dia.toString().length == 1) ? "0" + dia.toString() : dia;
    mes = (mes.toString().length == 1) ? "0" + mes.toString() : mes;

    var fechaFINAL = anio + "-" + mes + "-" + dia;

    $("#fecha_final").val(fechaFINAL);
  }

  $('body').on('change', "#tiempo", function(e){
    var tiempo = $("#tiempo").val();
    var fecha_inicio = $("#fecha_inicio").val();
    if(tiempo != ""){
      if(fecha_inicio != ""){
        if(tiempo == 1){
          calcularTiempoContrato(tiempo, 'año');
        }
        else{
          calcularTiempoContrato(tiempo, 'mes');
        }
      }
      else{
        $("#fecha_final").val("");
      }
    }
    else{
      $("#fecha_final").val("");
    }
  });

  $('body').on('change', "#fecha_inicio", function(e){
    $('#mensajeVacio').remove();
    var tiempo = $("#tiempo").val();
    var fecha_inicio = $("#fecha_inicio").val();

    var hoy = new Date();
    var h = hoy.toString();
    var fechaFormulario = new Date(fecha_inicio);
    var f = fechaFormulario.toString();

    var separador = " ";
    var fecha1 = h.split(separador);
    var mes1 = fecha1[1];
    var dia1 = fecha1[2];
    var anio1 = fecha1[3];

    var fecha2 = f.split(" ");
    var mes2 = fecha2[1];
    var dia2 = fecha2[2];
    var anio2 = fecha2[3];

    var bandera = 0;
    if(mes1 == mes2 && dia1 == dia2 && anio1 == anio2){
      // console.log("es hoy");
    }
    else{
      hoy.setHours(0,0,0,0);
      fechaFormulario.setHours(0,0,0,0);
      if (hoy <= fechaFormulario) {
        // console.log("Fecha a partir de hoy");
      }
      else {
        bandera += 1;
        // console.log("Fecha pasado");
        $('#validacionFechaInicio').append(
          `<label style="color:red;" id="mensajeVacio" name="mensajeVacio" class="control-label">No se pueden ingresar fechas pasadas.</label>`);
        $("#fecha_final").val("");
      }
    }

    // SI LA FECHA ES CORRECTA
    if(bandera == 0){
      if(tiempo != ""){
        if(fecha_inicio != ""){
          if(tiempo == 1){
            calcularTiempoContrato(tiempo, 'año');
          }
          else{
            calcularTiempoContrato(tiempo, 'mes');
          }
        }
        else{
          $("#fecha_final").val("");
        }
      }
      else{
        $("#fecha_final").val("");
      }
    }
  });
