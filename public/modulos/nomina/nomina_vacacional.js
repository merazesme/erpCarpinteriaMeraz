
  // Boton para guardar nomina
  var boton = `<button type="button" class="btn waves-effect waves-light btn-primary float-right" id="btnGuardar"><i class="fa fa-plus"></i> Guardar</button>`;
  var botonGenerar = `<button id="genera" type="button" class="btn waves-effect waves-light btn-primary"><i class="fa fa-plus"></i> Generar nómina</button>`;
  var trabajadores = [];
  // Consulta si esta el anio guardado
  //ALTER TABLE `nominas` CHANGE `Semana` `Semana` VARCHAR(11) NOT NULL;
  $('#anio-vacacional').text(`Vacaciones ${anioAnterior} - ${anioActual}`);
  $.ajax({
    type: "GET",
    dataType: "json",
    url: `confirma/${anioAnterior}-${anioActual}`,
    success: function (data) {
        if(data['Error'])
          swal("Error", "Ha ocurrido un error, inténtelo más tarde.", "error");
        else if(data['NotFound'])
          $('#btnGenerar').append(botonGenerar);
        else
          $('#btnGenerar').append('<br><h5 class="text-danger"> Ya se generó la nómina de esté año </h5>');
    }, error: function(error) {
        toastError();
    }
  });
  // Funcion que hace los calculos y genera las filas de la tabla
  function muestra() {
    var tamanio = trabajadores.length;
    var totalSueldoBase = 0, totalVacaciones = 0, totalPrima = 0, totalBonoExtra = 0, totalInfonavit = 0, total = 0;
    var html =
     `<table id="nomina" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
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
       var tr = trabajadores[x];
       tr.dias = 3;
       tr.Nomina = {
          xPercepciones: {
            'Vacaciones': Math.round( tr.Sueldo / 6 * tr.dias ),
            'Bono Extra': tr.Bono_Extra
          },
          xDeducciones: {
             'Infonavit': tr.Infonavit
          }
        };
        tr.Nomina.xPercepciones['Prima'] = Math.round( tr.Nomina.xPercepciones['Vacaciones'] * 0.25 );

        tr.xTotal = tr.Nomina.xPercepciones['Vacaciones'] + tr.Nomina.xPercepciones['Prima'] + tr.Nomina.xPercepciones['Bono Extra'] - tr.Infonavit;

        totalSueldoBase += tr.Sueldo;
        totalVacaciones += tr.Nomina.xPercepciones['Vacaciones'];
        totalPrima += tr.Nomina.xPercepciones['Prima'];
        totalBonoExtra += tr.Nomina.xPercepciones['Bono Extra'];
        totalInfonavit += tr.Infonavit;
        total += tr.xTotal;

        html += `<tr>
                    <td>${tr.Nombre} ${tr.Apellidos}</td>
                    <td>${tr.Sueldo}</td>
                    <td>${tr.Nomina.xPercepciones['Vacaciones']}</td>
                    <td>${tr.Nomina.xPercepciones['Prima']}</td>
                    <td>${tr.Nomina.xPercepciones['Bono Extra']}</td>
                    <td>${tr.Infonavit}</td>
                    <td>${tr.xTotal}</td>
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

  $(document).on('click', '#genera', function() {
      $(this).attr('disabled', true);
      obtieneDatos('muestra');
  });

  $(document).on('click','#btnGuardar', function() {
    console.log('save')
    saveNomina();
  });

  function saveNomina() {
    console.log(trabajadores)
    $.ajax({
         type: 'POST',
         url: 'saveNomina',
         data: {
           '_token': $('meta[name="csrf-token"]').attr('content'),
           'trabajadores':trabajadores,
           'semana': `${anioAnterior}-${anioActual}`,
           'tipo': 'vacacional'
         },
         success: function(data) {
             console.log(data);
             if(data['Error']) {
              $('#btnGuardar').attr('disabled', false);
              swal("Error", "Ha ocurrido un error, inténtelo más tarde.", "error");
             }
             else {
               $('#guardar').hide("slow");
               toastSuccess("Nómina guardada exitosamente.");
             }
        }, error: function(error) {
            $('#btnGuardar').attr('disabled', false);
            toastError();
        }
    });
  }


