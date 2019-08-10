/************** Muestra historial semanal ******************/

var historial = [];

$(document).on('click','#historial', function() {
    $("#myTable").DataTable().destroy();
    $("#myTable" ).remove();
    console.log(tipo)
    obtieneDatosHistorial(tipo);
});

// Obtiene los datos del historial de nominas
function obtieneDatosHistorial(tipo) {
  $.ajax({
    type: "GET",
    dataType: "json",
    url: 'nominaSemanal/historialNomina/'+tipo,
    success: function (data) {
        console.log(data)
        if(data['Error'])
          swal("Error", "Ha ocurrido un error, inténtelo más tarde.", "error");
        else {
          historial = data;
          var nomina = '';
          switch (tipo) {
            case 'semanal':
                  nomina = 'Semanal';
            break;
            case 'aguinaldo':
                  nomina = 'Aguinaldo';
            break;
            case 'vacacional':
                  nomina = 'Vacacional';
            break;
            default:
            break;
          }
          muestraHistorial(nomina);
        }
    }, error: function(error) {
        toastError();
    }
  });
}

// Genera las filas de la tabla
function muestraHistorial(tipo) {
  var tamanio = historial.length;
  var html =
   `<table id="myTable" class="table table-bordered table-striped">
     <thead>
         <tr>
           <th>No. de nomina</th>
           <th>Fecha</th>
           <th>Elaborada por</th>
           <th class="text-center">Acciones</th>
         </tr>
     </thead>
     <tfoot>
       <tr>
         <th>No. de nomina</th>
         <th>Fecha</th>
         <th>Elaborada por</th>
         <th>Acciones</th>
       </tr>
     </tfoot>
     <tbody>`;
  for(var x=0; x<tamanio; x++) {

      html += `<tr>
                <td>${historial[x].Semana}</td>
                <td><i class="fa fa-clock-o"></i> ${historial[x].Fecha}</td>
                <td>${historial[x].usuario}</td>
                <td class="text-center">
                  <a href="nomina${tipo}/detalles/${historial[x].Semana}" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye "></i> </a>
                </td>

               </tr>`;
  }
  html += `<tbody>
      </table>`;
  $( ".tablaHistorial" ).append(html);
  $('#myTable').DataTable({
    "order": [[ 1, "desc" ]]
  });
}

// Imprime las tablas que no tienen columnas ocultas
function imprime() {
  $('#nomina').DataTable({
      dom: 'Bfrtip',
      buttons: [{
          extend: 'copyHtml5',
          title: `Carpintería Meraz | Nómina ${tipo} | ${anio}`,
          footer: true
      },
      {
          extend: 'excelHtml5',
          title: `Carpintería Meraz | Nómina ${tipo} | ${anio}`,
          filename: `Nomina-${tipo}-excel-${anio}`,
          footer: true
      },
      {
          extend: 'pdfHtml5',
          text: 'PDF',
          title: `Carpintería Meraz | Nómina ${tipo} | ${anio}`,
          filename: `Nomina-${tipo}-${anio}`,
          footer: true
      }]
  });
}
