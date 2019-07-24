  $(document).ready(function () {
  	tablaTrabajadores();
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
              console.log("GOLA")
              var html="";
              html=
                `<tr>
                  <td>${data[i].Nombre} ${data[i].Apellidos}</td>
                  <td>${data[i].Puesto}</td>
                  <td>20/08/2020</td>
                  <td class="text-nowrap">
                    <a href="#" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye text-inverse m-r-10"></i> </a>
                    <a href="/trabajadores/editar/${data[i].Nombre}" data-toggle="tooltip" data-original-title="Editar"> <i class="icon-pencil text-inverse m-r-10"></i> </a>
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

  function agregarTrabajador(){
    // POST AGREGAR TRABAJADOR
    var datosTrabajador = new FormData (document.querySelector('#formularioTrabajador'));
    datosTrabajador.append("idUsuario", "1");
    datosTrabajador.append("_token", token);
    for (var concepto of datosTrabajador.entries()) {
      console.log("Formulario: " + concepto[0]+ ', ' + concepto[1]);
    }
    // INSERT TRABAJADOR
    $.ajax({
        type: 'POST',
        processData: false,
        contentType: false,
        cache: false,
        data: datosTrabajador,
        dataType: false,
        enctype: 'multipart/form-data',
        url: base_url+'/trabajadores/agregarTrabajador',
        success: function(msg){
          console.log(msg);
          if(msg['success'] == "Se agrego exitosamente"){
            reset_form('.validation-wizard');
  	        swal("¡Éxito!", "Registro guardado con éxito.", "success");
            // location.href = "/trabajadores/lista";
          }
          else if(msg['error'] == "Ocurrio un error"){
            swal("Agregar trabajador", "Ha ocurrido un error, inténtelo más tarde.", "error");
          }
        }, error: function(error) {
            swal("Nuevo trabajador", "Ha ocurrido un error, inténtelo más tarde.", "error");
        }
    });
  }
