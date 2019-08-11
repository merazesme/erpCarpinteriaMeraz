$(document).ready(function() {
    $('#anio').text(`Años ${anio}`);
    var nomina = [];
    $.ajax({
      type: "GET",
      dataType: "json",
      url: `${base_url}/nomina/detalleNomina/${anio}`,
      success: function (data) {
          console.log(data)
          if(data['Error'])
            swal("Error", "Ha ocurrido un error, inténtelo más tarde.", "error");
          else if(data['NotFound']) {
            $('#errorSemana').append('<br><h5 class="text-danger"> Está nómina aún no se ha generado </h5>');
          } else {
              toastSuccess("Datos de nómina cargados exitosamente.");
              nomina = data;
              muestra();
          }
      }, error: function(error) {
          toastError();
      }
    });

    // Funcion que hace los calculos y genera las filas de la tabla
    function muestra() {
      var tamanio = nomina['detalleNomina'].length;
      var detalle = nomina['detalleNomina'];
      var totalSueldoBase = 0, totalVacaciones = 0, totalPrima = 0, totalBonoExtra = 0, totalInfonavit = 0, total = 0;
      var html =
       `<table id="nomina" class="table m-b-0 toggle-arrow-tiny">
           <thead>
               <tr>
                 <th>Nombre</th>
                 <th>Sueldo Base</th>
                 <th>Vacaciones 3 días</th>
                 <th>25% Prima</th>
                 <th>Bono Extra</th>
                 <th>Infonavit</th>
                 <th>Total</th>
               </tr>
           </thead>
          <tbody>`;
      for(var x=0; x<tamanio; x++) {
        var conceptos = detalle[x].conceptos;
        var tamanioc =  detalle[x].conceptos.length;
        var tr =  detalle[x];

        totalSueldoBase += tr.Sueldo;
        totalVacaciones += tr.conceptos[0].Monto;
        totalPrima += tr.conceptos[2].Monto;
        totalBonoExtra += tr.conceptos[1].Monto;
        totalInfonavit += tr.conceptos[3].Monto;
        total += tr.Cantidad;

        html += `<tr>
                    <td>${tr.Nombre} ${tr.Apellidos}</td>
                    <td>${tr.Sueldo}</td>
                    <td>${tr.conceptos[0].Monto}</td>
                    <td>${tr.conceptos[2].Monto}</td>
                    <td>${tr.conceptos[1].Monto}</td>
                    <td>${tr.conceptos[3].Monto}</td>
                    <td>${tr.Cantidad}</td>
                </tr>`;
      }
      html += `<tbody>
                <tfoot>
                  <tr>
                    <th>Totales</th>
                    <th>${totalSueldoBase}</th>
                    <th>${totalVacaciones}</th>
                    <th>${totalPrima}</th>
                    <th>${totalBonoExtra}</th>
                    <th>${totalInfonavit}</th>
                    <th>${total}</th>
                  </tr>
                </tfoot>
          </table>`;
      $( ".tabla" ).append(html);
      imprime();
    }
});
