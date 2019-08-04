$(document).ready(function() {
    $('#totalPrestamotr').remove();
    $('#editar').hide();
    $('#rango-semana').text(`${fechai.date} de ${meses[fechai.months]} de ${fechai.years} al ${fechaf.date} de ${meses[fechai.months]} de ${fechaf.years}`);
    var nomina = [];
    $.ajax({
      type: "GET",
      dataType: "json",
      url: `${base_url}/nomina/nominaSemanal/detalleNomina/${numSemana}/${moment(f_i).format()}'/${moment(f_f).format()}`,
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
      var html =
       `<table id="demo-foo-accordion" class="table m-b-0 toggle-arrow-tiny">
          <thead>
              <tr>
                  <th data-toggle="true" data-sort-ignore="true"> Nombre  </th>
                  <th data-hide="phone"> Percepciones </th>
                  <th data-hide="phone"> Deducciones </th>
                  <th data-hide="phone"> Neto a pagar </th>
                  <th data-hide="phone" class="text-center"> Acciones </th>
              </tr>
          </thead>
          <tbody>`;
      for(var x=0; x<tamanio; x++) {
        var conceptos = detalle[x].conceptos;
        var tamanioc =  detalle[x].conceptos.length;
        detalle[x].deduccion = 0, detalle[x].percepcion = 0;
          for (var i = 0; i <tamanioc; i++) {
            if(conceptos[i].Tipo == 0)
              detalle[x].deduccion += conceptos[i].Monto;
            else
              detalle[x].percepcion += conceptos[i].Monto;
          }
          detalle[x].diasTrabajados = 0;
          detalle[x].horasExtras = 0;
          detalle[x].diasDescanso = 1;
          detalle[x].horasSabado = 2.5; // Falta por definir
          detalle[x].faltasSinJustificar = 0; // Falta por definir

          for (var i = 0; i < detalle[x].asistencia.length; i++) {
            //console.log(detalle[x].asistencia[i])
            if(detalle[x].asistencia[i].Hora_salida === 1 && detalle[x].asistencia[i].Hora_entrada === 1)
              detalle[x].diasTrabajados ++;
            else if(detalle[x].asistencia[i].Hora_salida === 1 || detalle[x].asistencia[i].Hora_entrada === 1)
              detalle[x].diasTrabajados +=0.5;
            if(detalle[x].asistencia[i].Hora_extra === 1)
              detalle[x].horasExtras ++;
          }
          html += `<tr>
                      <td>${detalle[x].Nombre} ${detalle[x].Apellidos}</td>
                      <td>$${detalle[x].deduccion}</td>
                      <td>$${detalle[x].percepcion}</td>
                      <td>$${detalle[x].Cantidad}</td>
                      <td class="text-center">
                          <span data-toggle="modal" data-target=".bs-example-modal-lg" data-body="${detalle[x].id}" class="modal-show">
                              <a data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye "></i> </a>
                          </span>
                      </td>
                   </tr>`;
      }
      html += `<tbody>
          </table>`;
      $( ".tabla" ).append(html);
    }

    // Muestra el modal de detalles de nomina
    $(document).on('click','.modal-show', function() {
      $('.modal-title').text('Detalles nómina');
      var data = $(this).data('body');

      setData(data);
    });

    // Funcion que muestra los datos en el modal
    function setData(data) {
      var results = nomina['detalleNomina'].filter(function (trabajador) { return trabajador.id == data; });
      var objeto = (results.length > 0) ? results[0] : null;
      console.log(objeto)


      $('#nombre').text(`${objeto.Nombre} ${objeto.Apellidos} (${objeto.Apodo})`);
      $('#diasTrabajados').val(objeto.diasTrabajados);
      $('#faltasSinJustificar').val(objeto.faltasSinJustificar);
      $('#diasDescanso').val(objeto.diasDescanso);
      $('#horasSabado').val(objeto.horasSabado);
      $('#horasExtras').val(objeto.horasExtras);

      $('#sueldoBase').val('$'+objeto.conceptos[2].Monto);
      $('#horasExtrasMonto').val('$'+objeto.conceptos[3].Monto);
      $('#bonopya').val('$'+objeto.conceptos[4].Monto);
      $('#bonoExtra').val('$'+objeto.conceptos[5].Monto);
      $('#totalPercepciones').val('$'+objeto.percepcion);

      $('#abonoPrestamo').get(0).type = 'text';
      $('#abonoPrestamo').val('$'+objeto.conceptos[0].Monto);

      $('#infonavit').val('$'+objeto.conceptos[1].Monto);
      $('#totalDeducciones').val('$'+objeto.deduccion);
      $('#total').val('$'+objeto.Cantidad);
    }
});
