$(document).ready(function() {
    $('#totalPrestamotr').remove();
    $('#editar').hide();
    $('#rango-semana').text(`${fechai.date} de ${meses[fechai.months]} de ${fechai.years} al ${fechaf.date} de ${meses[fechaf.months]} de ${fechaf.years}`);
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
       `<table id="nomina" class="table m-b-0 toggle-arrow-tiny">
          <thead>
              <tr>
                  <th data-toggle="true" data-sort-ignore="true"> Nombre  </th>
                  <th data-hide="phone"> Percepciones </th>
                  <th data-hide="phone"> Deducciones </th>
                  <th data-hide="phone"> Neto a pagar </th>
                  <th data-hide="phone" class="text-center"> Acciones </th>
                  <th hidden>Días trabajados</th>
                  <th hidden>Faltas sin justificar</th>
                  <th hidden>Días de descanso</th>
                  <th hidden>Horas sábado</th>
                  <th hidden>Sueldo base</th>
                  <th hidden>Horas extras</th>
                  <th hidden>Monto horas extras</th>
                  <th hidden>Abono prestamo</th>
                  <th hidden>Infonavit</th>
                  <th hidden>Bono P y A</th>
                  <th hidden>Bono extra</th>
              </tr>
          </thead>
          <tbody>`;
      for(var x=0; x<tamanio; x++) {
        var conceptos = detalle[x].conceptos;
        var tamanioc =  detalle[x].conceptos.length;
        var tr =  detalle[x];
        tr.deduccion = 0, tr.percepcion = 0;
          for (var i = 0; i <tamanioc; i++) {
            if(conceptos[i].Tipo == 0)
              tr.deduccion += conceptos[i].Monto;
            else
              tr.percepcion += conceptos[i].Monto;
          }
          tr.diasTrabajados = 0;
          tr.horasExtras = 0;
          tr.diasDescanso = 1;
          tr.horasSabado = 0;
          tr.faltasSinJustificar = 0; 

          for (var i = 0; i < tr.asistencia.length; i++) {
            //console.log(tr.asistencia[i])
            if(tr.asistencia[i].Hora_salida === 1 && tr.asistencia[i].Hora_entrada === 1) {
              tr.horasSabado += 0.5;
              tr.diasTrabajados ++;
            }
            else if(tr.asistencia[i].Hora_salida === 1 || tr.asistencia[i].Hora_entrada === 1)
              tr.diasTrabajados +=0.5;
            if(tr.asistencia[i].Hora_extra === 1)
              tr.horasExtras ++;
          }
          tr.faltasSinJustificar = 6 - tr.diasTrabajados;
          html += `<tr>
                      <td>${tr.Nombre} ${tr.Apellidos}</td>
                      <td>$${tr.deduccion}</td>
                      <td>$${tr.percepcion}</td>
                      <td>$${tr.Cantidad}</td>
                      <td class="text-center">
                          <span data-toggle="modal" data-target=".bs-example-modal-lg" data-body="${tr.id}" class="modal-show">
                              <a data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye "></i> </a>
                          </span>
                      </td>
                      <td hidden>${tr.diasTrabajados}</td>
                      <td hidden>${tr.faltasSinJustificar}</td>
                      <td hidden>${tr.diasDescanso}</td>
                      <td hidden>${tr.horasSabado}</td>
                      <td hidden>${tr.conceptos[2].Monto}</td>
                      <td hidden>${tr.horasExtras}</td>
                      <td hidden>${tr.conceptos[3].Monto}</td>
                      <td hidden>${tr.conceptos[0].Monto}</td>
                      <td hidden>${tr.conceptos[2].Monto}</td>
                      <td hidden>${tr.conceptos[4].Monto}</td>
                      <td hidden>${tr.conceptos[5].Monto}</td>
                   </tr>`;
      }
      html += `<tbody>
          </table>`;
      $( ".tabla" ).append(html);

      imprimir();
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
