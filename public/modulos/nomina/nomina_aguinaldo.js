

  // Boton para guardar nomina
  var boton = `<button type="button" class="btn waves-effect waves-light btn-primary float-right" id="btnGuardar"><i class="fa fa-plus"></i> Guardar</button>`;
  var botonGenerar = `<button id="genera" type="button" class="btn waves-effect waves-light btn-primary"><i class="fa fa-plus"></i> Generar nómina</button>`;
  var trabajadores = [];
  // Consulta si esta el anio guardado
  $('#anio-aguinaldo').text(`Aguinaldos de ${anio}`);
  $.ajax({
    type: "GET",
    dataType: "json",
    url: 'confirma/'+anio,
    success: function (data) {
        if(data['Error'])
        Swal.fire({type: 'error',title: 'Error',text: "Ha ocurrido un error, inténtelo más tarde."});
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
    var totalSubtotal = 0, totalBonoExtra = 0, totalBonoPyA = 0, total = 0;
    var html =
     `<table id="nomina" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
         <thead>
             <tr>
               <th>Nombre</th>
               <th>Dias Trabajados</th>
               <th>Sueldo Base</th>
               <th>Subtotal</th>
               <th>Bono Extra</th>
               <th>Total</th>
             </tr>
         </thead>
        <tbody>`;
    for(var x=0; x<tamanio; x++) {
        var tr = trabajadores[x];
        // Falta este
        // bonoExtra
        if(tr.Tipo == 'Base') {
           tr.Subtotal = Math.round( (tr.Sueldo * 2) / 365 * tr.Asistencia_total );
           tr.Nomina = {
             xPercepciones: {}
           };
           tr.Nomina.xPercepciones['Subtotal'] = tr.Subtotal; 

            if(tr.bonoExtra != 0 || tr.bonoExtra != null) {
              tr.Nomina.xPercepciones['Bono Extra'] = Math.round( Math.abs((((tr.Bono_Extra * 2) / 365) * tr.Asistencia_total) - tr.Subtotal ))
            } else
              alert('no entro')
            tr.xTotal = tr.Subtotal + tr.Nomina.xPercepciones['Bono Extra'];
            totalSubtotal += tr.Subtotal;
            totalBonoExtra += tr.Nomina.xPercepciones['Bono Extra'];
            total += tr.xTotal;
            html += `<tr>
                        <td>${tr.Nombre} ${tr.Apellidos}</td>
                        <td>${tr.Asistencia_total}</td>
                        <td>${tr.Sueldo}</td>
                        <td>${tr.Subtotal}</td>
                        <td>${tr.Nomina.xPercepciones['Bono Extra']}</td>
                        <td>${tr.xTotal}</td>
                    </tr>`;
       }
    }
    html += `<tbody>
              <tfoot>
                <tr>
                  <th></th>
                  <th></th>
                  <th>Totales</th>
                  <th>${totalSubtotal}</th>
                  <th>${totalBonoExtra}</th>
                  <th>${total}</th>
                </tr>
              </tfoot>
        </table>`;
    $( ".tabla" ).append(html);
    imprime();
  }
//  obtieneDatos();

  $(document).on('click', '#genera', function() {
      $(this).attr('disabled', true);
      obtieneDatos('muestra/Base');
  });

  $(document).on('click','#btnGuardar', function() {
    console.log('save')
    saveNomina();
  });

  function saveNomina() {
    console.log(trabajadores)
    Swal.fire({
      onOpen: function () {
        Swal.showLoading();
        $.ajax({
             type: 'POST',
             url: 'saveNomina',
             data: {
               '_token': $('meta[name="csrf-token"]').attr('content'),
               'trabajadores':trabajadores,
               'semana': anio,
               'tipo': 'aguinaldo'
             },
             success: function(data) {
                 console.log(data);
                 Swal.close();
                 if(data['Error']) {
                  $('#btnGuardar').attr('disabled', false);
                  Swal.fire({type: 'error',title: 'Error',text: "Ha ocurrido un error, inténtelo más tarde."});
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
    });
  }
