
  /************** Generar nomina semanal ******************/
  // Boton para guardar nomina
  var boton = `<button type="button" class="btn waves-effect waves-light btn-primary float-right" id="btnGuardar"><i class="fa fa-plus"></i> Guardar</button>`;
  var botonGenerar = `<button id="genera" type="button" class="btn waves-effect waves-light btn-primary"><i class="fa fa-plus"></i> Generar nómina</button>`;
  $('#rango-semana').text(`${fechai.date} de ${meses[fechai.months]} de ${fechai.years} al ${fechaf.date} de ${meses[fechaf.months]} de ${fechaf.years}`);

  // Consulta si esta la semana guardada
  $.ajax({
    type: "GET",
    dataType: "json",
    url: 'confirma/'+numSemana,
    success: function (data) {
        if(data['Error'])
          swal("Error", "Ha ocurrido un error, inténtelo más tarde.", "error");
        else if(data['NotFound'])
          $('#btnGenerar').append(botonGenerar);
        else
          $('#btnGenerar').append('<br><h5 class="text-danger"> Ya se generó la nómina de está semana </h5>');
    }, error: function(error) {
        toastError();
    }
  });
  // Aqui se guardan todos los datos de nomina del trabajador
  var trabajadores = [];

  $(document).on('click','#genera', function() {
      $(this).attr('disabled', true);
      obtieneDatos('muestra/'+moment(f_i).format()+'/'+moment(f_f).format());
  });
  //obtieneDatos();

  // Funcion que hace los calculos y genera las filas de la tabla
  function muestra() {
    var tamanio = trabajadores.length;
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
        trabajadores[x].Nomina = {
          xDeducciones: {}
        };
        trabajadores[x]['Total Percepciones'] = 0;
        trabajadores[x]['Total Deducciones'] = 0;
        var tr = trabajadores[x]
        tr.diasTrabajados = 0;
        tr.horasExtras = 0;
        tr.diasDescanso = 1;
        tr.horasSabado = 0;
        tr.faltasSinJustificar = 0;
        if(tr.totalPrestamos == null)
          tr.totalPrestamos = 0;
        for (var i = 0; i < tr.asistencia.length; i++) {
          if(tr.asistencia[i].Hora_salida === 3 && tr.asistencia[i].Hora_entrada === 5) {
            tr.diasTrabajados ++;
          }
          else if(tr.asistencia[i].Hora_salida === 3 || tr.asistencia[i].Hora_entrada === 5)
            tr.diasTrabajados += 0.5;
          if(tr.asistencia[i].Hora_extra === 1) {
            tr.horasExtras ++;
            tr.horasSabado += 0.5;
          }
        }
        tr.faltasSinJustificar = 6 - tr.diasTrabajados;
        tr.NombreyApodo = tr.Nombre + ' ' + tr.Apellidos + ' (' + tr.Apodo + ')'
        // 	* 	Percepciones	* 	//
        tr.Nomina.xPercepciones = {
          'Sueldo': Math.round( (tr.Sueldo/48) * (tr.diasTrabajados * 8 ) + (tr.diasDescanso * 8) - 8 - (2.5) + tr.horasSabado ),
          'Horas Extras': Math.round( (tr.Monto_Hora_Extra / 5) * (tr.horasExtras) ),
          'Bono P y A': Math.round( (tr.Bono_Produc_Asis/6) * (tr.diasTrabajados + tr.diasDescanso - 1) ),
          'Bono Extra': Math.round( (tr.Bono_Extra/6) * (tr.diasTrabajados + tr.diasDescanso - 1) ),
        };
        tr['Total Percepciones'] = Math.round(tr.Nomina.xPercepciones['Sueldo'] + tr.Nomina.xPercepciones['Horas Extras'] + tr.Nomina.xPercepciones['Bono P y A'] + tr.Nomina.xPercepciones['Bono Extra']);
        // * 		Deducciones		*		//
        tr.totalPrestamos >= 100 ? tr.Nomina.xDeducciones["Abono Prestamo"] = 100 :
        tr.totalPrestamos > 0 ? tr.Nomina.xDeducciones["Abono Prestamo"] = tr.totalPrestamos :
        tr.Nomina.xDeducciones["Abono Prestamo"] = 0;

        tr.Infonavit != 0 ? tr.Nomina.xDeducciones['Infonavit'] = tr.Infonavit :
        tr.Nomina.xDeducciones['Infonavit'] = 0;

        tr['Total Deducciones'] = Math.round(tr.Nomina.xDeducciones["Abono Prestamo"] + tr.Nomina.xDeducciones['Infonavit']);
        // Redondea el total
        tr.xTotal = Math.round(tr['Total Percepciones'] - tr['Total Deducciones']);

        html += `<tr>
                    <td>${tr.Nombre} ${tr.Apellidos}</td>
                    <td>$${tr['Total Percepciones']}</td>
                    <td id="deduccion${x}">$${tr['Total Deducciones']}</td>
                    <td id="total${x}">$${tr.xTotal}</td>
                    <td class="text-center">
                        <span data-toggle="modal" data-target=".bs-example-modal-lg" data-body="${tr.id}" data-posicion="${x}" class="modal-edit">
                            <a data-toggle="tooltip" data-original-title="Editar"> <i class="icon-pencil text-inverse m-r-10"></i> </a>
                        </span>
                        <span data-toggle="modal" data-target=".bs-example-modal-lg" data-body="${tr.id}" data-posicion="${x}" class="modal-show">
                            <a data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye "></i> </a>
                        </span>
                    </td>
                    <td hidden>${tr.diasTrabajados}</td>
                    <td hidden>${tr.faltasSinJustificar}</td>
                    <td hidden>${tr.diasDescanso}</td>
                    <td hidden>${tr.horasSabado}</td>
                    <td hidden>${tr.Nomina.xPercepciones['Sueldo']}</td>
                    <td hidden>${tr.horasExtras}</td>
                    <td hidden>${tr.Nomina.xPercepciones['Horas Extras']}</td>
                    <td hidden>${tr.Nomina.xDeducciones['Abono Prestamo']}</td>
                    <td hidden>${tr.Nomina.xDeducciones['Infonavit']}</td>
                    <td hidden>${tr.Nomina.xPercepciones['Bono P y A']}</td>
                    <td hidden>${tr.Nomina.xPercepciones['Bono Extra']}</td>
                 </tr>`;
    }
    html += `<tbody>
        </table>`;
    $( ".tabla" ).append(html);
    imprimir();
  }

  // Funcion que muestra los datos en el modal
  function setData(data, bandera) {
    var results = trabajadores.filter(function (trabajador) { return trabajador.id == data; });
    var objeto = (results.length > 0) ? results[0] : null;
    $('#nombre').text(objeto.NombreyApodo);
    $('#diasTrabajados').val(objeto.diasTrabajados);
    $('#faltasSinJustificar').val(objeto.faltasSinJustificar);
    $('#diasDescanso').val(objeto.diasDescanso);
    $('#horasSabado').val(objeto.horasSabado);
    $('#horasExtras').val(objeto.horasExtras);
    $('#totalPrestamo').val(objeto.totalPrestamos);
    $('#sueldoBase').val('$'+objeto.Nomina.xPercepciones['Sueldo']);
    $('#horasExtrasMonto').val('$'+objeto.Nomina.xPercepciones['Horas Extras']);
    $('#bonopya').val('$'+objeto.Nomina.xPercepciones['Bono P y A']);
    $('#bonoExtra').val('$'+objeto.Nomina.xPercepciones['Bono Extra']);
    $('#totalPercepciones').val('$'+objeto['Total Percepciones']);
    if(bandera == 1) {
      $('#abonoPrestamo').get(0).type = 'number';
      $('#abonoPrestamo').val(objeto.Nomina.xDeducciones['Abono Prestamo']).attr({
           "max" : objeto.totalPrestamos
        });
    }
    else {
      $('#abonoPrestamo').get(0).type = 'text';
      $('#abonoPrestamo').val('$'+objeto.Nomina.xDeducciones['Abono Prestamo']);
    }
    $('#infonavit').val('$'+objeto.Infonavit);
    $('#totalDeducciones').val('$'+objeto['Total Deducciones']);
    $('#total').val('$'+objeto.xTotal);
  }
  var posicion = null;
  // Muestra el modal para editar nomina
  $(document).on('click','.modal-edit', function() {
    $('.modal-title').text('Editar nómina');
    var data = $(this).data('body');
    posicion = $(this).data('posicion');
    $('#abonoPrestamo').prop('disabled', false).removeClass('deshabilitado');
    $('#editar').show();
    $('#ver').hide();
    setData(data, 1);
  });

  // Muestra el modal de detalles de nomina
  $(document).on('click','.modal-show', function() {
    $('.modal-title').text('Detalles nómina');
    var data = $(this).data('body');
    posicion = $(this).data('posicion');
    $('#abonoPrestamo').prop('disabled', true).addClass('deshabilitado');
    $('#editar').hide();
    $('#ver').show();
    setData(data,0);
  });

  $(document).on('click','#guardarDatos', function() {
    trabajadores[posicion].Nomina.xDeducciones["Abono Prestamo"] = prestamoEdicion;
    trabajadores[posicion]['Total Deducciones'] = totalDeduccionEdicion;
    trabajadores[posicion].xTotal = totalEdicion;
    $('#deduccion'+posicion).text('$'+trabajadores[posicion]['Total Deducciones']);
    $('#total'+posicion).text('$'+trabajadores[posicion].xTotal);
  });

  var prestamoEdicion = 0, totalDeduccionEdicion = 0, totalEdicion = 0;
  $( "#abonoPrestamo" ).bind("keyup change", function(e){
    //console.log($( this ).val())
    var nuevo = $( this ).val();
    if(nuevo === '')
      nuevo = 0;
    if(nuevo > trabajadores[posicion]['totalPrestamos']) {
      $('#guardarDatos').prop('disabled', true);
      $('#abonoPrestamo').addClass('errorPrestamo');
    }
    else {
      $('#guardarDatos').prop('disabled', false)
      $('#abonoPrestamo').removeClass('errorPrestamo');
    }
    prestamoEdicion = parseInt(nuevo);
    totalDeduccionEdicion = Math.round(prestamoEdicion + trabajadores[posicion].Nomina.xDeducciones['Infonavit']);
    totalEdicion = Math.round(trabajadores[posicion]['Total Percepciones'] - totalDeduccionEdicion);
    $('#totalDeducciones').val('$'+totalDeduccionEdicion);
    $('#total').val('$'+totalEdicion);
  })

  $(document).on('click','#btnGuardar', function() {
      $(this).attr('disabled', true);
      saveNomina();
  });

  // Funcion que guarda la nomina en la base de datos
  function saveNomina() {
    //console.log(trabajadores)
    $.ajax({
         type: 'POST',
         url: 'saveNomina',
         data: {
           '_token': $('meta[name="csrf-token"]').attr('content'),
           'trabajadores':trabajadores,
           'semana': numSemana,
           'tipo': 'semanal'
         },
         success: function(data) {
             //console.log(data);
             if(data['Error']) {
              $('#btnGuardar').attr('disabled', false);
              swal("Error", "Ha ocurrido un error, inténtelo más tarde.", "error");
             }
             else {
               toastSuccess("Nómina guardada exitosamente.");
               $('.modal-edit').hide("slow");
               $('#guardar').hide("slow");
             }
        }, error: function(error) {
            $('#btnGuardar').attr('disabled', false);
            toastError();
        }
    });
  }
