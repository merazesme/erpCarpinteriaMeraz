  $(document).ready(function () {
    tablaAsistencias();

    // ACTIVAR TITULOS
    $("body").tooltip({ selector: '[data-toggle="tooltip"]' });
  });

  // TABLA ASISTENCIA
  function tablaAsistencias(){
    $.ajax({
        type: 'GET',
        dataType: "json",
    		enctype: "multipart/form-data",
        url: base_url+'/trabajadores/asistencias/tabla',
        success: function(msg){
          msg.reverse();
          console.log(msg);
          if(msg['error'] == "Ocurrio un error"){
            console.log("Ha ocurrido un error, inténtelo más tarde.");
          }
          else{
            var data = msg;
            $("#asistenciaTrabajadores").DataTable().clear();
            $("#asistenciaTrabajadores").DataTable().destroy();
            var html="";
            var tam = data.length;
            for (var i = 0; i < tam; i++) {
              html+=
                `<tr>
                  <td>${data[i].Nombre} ${data[i].Apellidos}</td>
                  <td>
                    <div class="switch">
                        <label>
                            <input type="checkbox" checked><span class="lever switch-col-teal"></span>
                            <a class="horaLlegadaTrabajador" data-target="#verDetallesTrabajador" data-toggle="tooltip" data-original-title="Llegada"> <i class="mdi mdi-timer text-inverse m-r-10"></i> </a>
                        </label>
                    </div>
                  </td>
                  <td>
                    <div class="switch">
                        <label>
                            <input type="checkbox" checked><span class="lever switch-col-teal"></span>
                        </label>
                    </div>
                  </td>
                  <td>
                    <div class="checkbox checkbox-info">
                      <input type="checkbox" id="md_checkbox_29" class="filled-in chk-col-teal" checked />
                      <label for="md_checkbox_29">Trabajo</label>
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
          }
        }
    });
  }
