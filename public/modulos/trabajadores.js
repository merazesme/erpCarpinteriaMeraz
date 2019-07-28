  $(document).ready(function () {
    console.log(location.href);
  	if(location.href == base_url+'/trabajadores/lista'){
      console.log("Lista trabajadores");
      tablaTrabajadores();
    }
    else if(location.href == base_url+'/trabajadores/agregar'){
      console.log("Agregar trabajador");
    }
    else {
      console.log("Editar Trabajador");
      var p = location.href.split('/');
      console.log(p[5]);
      editarTrabajador(p[5]);
    }
  });

  // TABLA TRABAJADORES
  function tablaTrabajadores(){
    $.ajax({
        type: 'GET',
        dataType: "json",
    		enctype: "multipart/form-data",
        url: base_url+'/trabajadores/tabla',
        success: function(msg){
          console.log(msg);
          let data = msg;
          if(data['error'] == "Ocurrio un error"){
            console.log("Ha ocurrido un error, inténtelo más tarde.");
          }
          else{
            var tam = data.length;
            console.log("tam: " + tam);
            var htmlActivo="", htmlInactivo="";
            $("#trabajadoresActivos").DataTable().clear();
            $("#trabajadoresActivos").DataTable().destroy();
            $("#clientesInactivos").DataTable().clear();
            $("#clientesInactivos").DataTable().destroy();
            for (var i = 0; i < tam; i++) {
              var html="";
              html=
                `<tr>
                  <td>${data[i].Nombre} ${data[i].Apellidos}</td>
                  <td>${data[i].Puesto}</td>
                  <td>20/08/2020</td>
                  <td class="text-nowrap">
                    <a href="#" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye text-inverse m-r-10"></i> </a>
                    <a href="/trabajadores/editar/${data[i].id}" data-toggle="tooltip" data-original-title="Editar"> <i class="icon-pencil text-inverse m-r-10"></i> </a>
                    <a href="#" data-toggle="tooltip" data-original-title="Liquidar"> <i class="mdi `;
              if(data[i].Estado == 0 || data[i].Estado == null){
                // USUARIO INACTIVO
                html += `mdi-file-document text-inverse m-r-10"></i> </a>
                        </td>
                      </tr>`;
                htmlInactivo += html;
              }
              else {
                // USUARIO ACTIVO
                html += `mdi-file-check text-inverse m-r-10"></i> </a>
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
    else {
      if(id<0){
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
  	        swal("¡Éxito!", mensaje, "success");
          }
          else if(msg['error'] == "Ocurrio un error"){
            swal(mensaje2, "Ha ocurrido un error, inténtelo más tarde.", "error");
          }
        }, error: function(error) {
            swal(mensaje2, "Ha ocurrido un error, inténtelo más tarde.", "error");
        }
    });
  }

  // EDITAR TRABAJADOR
  function editarTrabajador(id){
      console.log("LLEGO ESTE ID: " + id);
      $.ajax({
          type: 'GET',
          dataType: "json",
      		enctype: "multipart/form-data",
          url: base_url+'/trabajadores/trabajador/'+id,
          success: function(msg){
            let data = msg;
            if(data['error'] == "Ocurrio un error"){
              console.log("Ha ocurrido un error, inténtelo más tarde.");
            }
            else{
              // SECTION 1
              $("#nombre").val(data[0].Nombre);
              $("#apellidos").val(data[0].Apellidos);
              $("#celular").val(data[0].Celular);
              $("#numero_alternativo").val(data[0].Num_alternativo);
              $("#domicilio").val(data[0].Domicilio);
              $("#estado_civil").val(data[0].Estado_civil);
              $("#fecha_nacimiento").val(data[0].Fecha_nacimiento);
              $("#lugar_nacimiento").val(data[0].Lugar_nacimiento);
              $("#escolaridad").val(data[0].Escolaridad);
              $("#apodo").val(data[0].Apodo);
              // SECTION 2
              $("#NSS").val(data[0].NSS);
              $("#infonavit").val(data[0].Infonavit);
              $("#numero_credencial").val(data[0].Num_credencial);
              // SECTION 3
              $("#tipo").val(data[0].Tipo);
              $("#fecha_inicio").val(data[0].Fecha_inicio);
              $("#fecha_final").val(data[0].Fecha_final);
              $("#puesto").val(data[0].Puesto);
              $("#sueldo").val(data[0].Sueldo);
              $("#hora_extra").val(data[0].Monto_Hora_Extra);
              $("#bono_asistencia").val(data[0].Bono_produc_asis);
              $("#bono_extra").val(data[0].Bono_extra);
              $("#firma").val(data[0].Firma);
            }
          }
      });
  }
