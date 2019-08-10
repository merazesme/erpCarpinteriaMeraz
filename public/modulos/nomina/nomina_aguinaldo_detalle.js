$(document).ready(function() {
    $('#anio').text(`Año ${anio}`);
    var nomina = [];
    $.ajax({
      type: "GET",
      dataType: "json",
      url: `${base_url}/nomina/nominaSemanal/detalleNomina/${anio}`,
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
      var totalSubtotal = 0, totalBonoExtra = 0, totalBonoPyA = 0, total = 0;
      var html =
       `<table id="nomina" class="table m-b-0 toggle-arrow-tiny">
           <thead>
               <tr>
                 <th>Nombre</th>
                 <th>Dias Trabajados</th>
                 <th>Sueldo Base</th>
                 <th>Subtotal</th>
                 <th>Bono Extra</th>
                 <th>Bono P y A</th>
                 <th>Total</th>
               </tr>
           </thead>
          <tbody>`;
      for(var x=0; x<tamanio; x++) {
        var conceptos = detalle[x].conceptos;
        var tamanioc =  detalle[x].conceptos.length;
        var tr =  detalle[x];

        totalSubtotal += tr.conceptos[1].Monto;
        totalBonoExtra += tr.conceptos[2].Monto;
        totalBonoPyA += tr.conceptos[0].Monto;
        total += tr.Cantidad;

        html += `<tr>
                    <td>${tr.Nombre} ${tr.Apellidos}</td>
                    <td>${tr.Asistencia_total}</td>
                    <td>${tr.Sueldo}</td>
                    <td>${tr.conceptos[1].Monto}</td>
                    <td>${tr.conceptos[2].Monto}</td>
                    <td>${tr.conceptos[0].Monto}</td>
                    <td>${tr.Cantidad}</td>
                </tr>`;
      }
      html += `<tbody>
                <tfoot>
                  <tr>
                    <th></th>
                    <th></th>
                    <th>Totales</th>
                    <th>${totalSubtotal}</th>
                    <th>${totalBonoExtra}</th>
                    <th>${totalBonoPyA}</th>
                    <th>${total}</th>
                  </tr>
                </tfoot>
          </table>`;
      $( ".tabla" ).append(html);
      imprime();
    }


});
