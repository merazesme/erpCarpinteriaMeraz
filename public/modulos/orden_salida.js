//Funcion para validar campos
function validation(children, parent){
    if (children.length == 0 ) {
        parent.removeClass("error");
    }else {
      if(children.val().length == 0 ){
          parent.addClass("error");
      }else{
          parent.removeClass("error");
      }
    }
}

//Accon para abrir el modal de nueva orden de salida
$('#boton_agregarOrdenSalida').on("click", function(e){
  $("#txtDescripcion").val("");
  $("#txtNotaOrdenSalida").val("");
  cargarDatosModalAgregarCompra();
})
//Accion para abrir el modal de modificar orden de salida
$('#tabla_ordenSalidaActivas').on("click",".modificarOrdenSalida", function(e){
  var id = $(this).parent().attr("data-material");
  validation($("#validar").val("1"), $("#txtDescripcionModificar").parent());
  validation($("#validar").val("1"), $("#txtNotaOrdenSalidaModificar").parent());
  e.preventDefault();
  $.ajax({
  type: "GET",
  dataType: "json",
  enctype: "multipart/form-data",
  url: base_url+'/inventario/orden_salida/lista_trabajador/',
  success: function (msg) {
          var data = JSON.parse(msg)
          // console.log(data);
          var html = "";
          html+=
          `<option value="0">
            <font style="vertical-align: inherit;">Seleccione una opción</font>
          </option>`;
          for (var i = 0; i < data.length; i++) {
              html+=
              `<option value="${data[i].id}">
                <font style="vertical-align: inherit;">${data[i].Nombre}</font>
              </option>`;
          }
          $("#select_trabajadorOrdenSalidaModificar").empty().append(html);

          $.ajax({
          type: "GET",
          dataType: "json",
          enctype: "multipart/form-data",
          url: base_url+'/inventario/orden_salida/lista_orden_salidas/'+id,
          success: function (msg) {
                  var data = JSON.parse(msg);
                  $("#txtNotaOrdenSalidaModificar").val(data[0].Num_nota);
                  $("#txtDescripcionModificar").val(data[0].Descripcion);
                  $("#select_trabajadorOrdenSalidaModificar option[value="+ data[0].Trabajadores_idTrabajadore +"]").attr("selected",true);
                  $('#modal_agregar_ordenSalidaModificar').modal('show');
                  $("#actionAgregarOrdenSalidaModificar").attr("onclick", "ModificarOrdenSalida("+id+")");
                }
           });

        }
  });
})
//Accion para eliminar una orden de salida (CHECAR)
$('#tabla_ordenSalidaActivas').on("click", ".eliminarOrdenSalida", function(e) {
  var id = $(this).parent().attr("data-material");
  e.preventDefault();

  //El objeto que se envia en el POST
  var datos_ordenCompra = ""
  datos_ordenCompra = new FormData();
  datos_ordenCompra.append("idUsuario", "1");
  datos_ordenCompra.append("_token", token);
  datos_ordenCompra.append("Estado_Compra", "0");

  var url = "";
  url = base_url+'/inventario/orden_compra/eliminarorden/'+id;
  mensaje = "La orden de compra ha sido eliminado con éxito";
  titulo = "Eliminar orden de compra";
  swal({
      title: "¿Deseas eliminar la orden de compra?",
      // text: "No podrás recuperarlo",
      type: "error",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Eliminar",
      cancelButtonText: "Cancelar",
      closeOnConfirm: false,
      closeOnCancel: true
  }, function(isConfirm){
      if (isConfirm) {
        $.ajax({
            type: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            data: datos_ordenCompra,
            dataType: false,
            enctype: 'multipart/form-data',
            url: url,
            success: function(msg){
                var data = JSON.parse(msg)
                if(data == 0){
                    swal("Eliminado", mensaje, "success");
                    tablaOrdenCompra(0,"#tabla_curso");
                    tablaOrdenCompra(1,"#tabla_recibido");
                    tablaOrdenCompra(2,"#tabla_cancelado");
                    tablaOrdenCompra(3,"#tabla_pagado");
                }else{
                    swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
                }
            }, error: function(error) {
                swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
            }
        });
      }
  });
})

//Funcion para cargar los datos de agregar nuevo orden de Salida
function cargarDatosModalAgregarCompra() {
$.ajax({
type: "GET",
dataType: "json",
enctype: "multipart/form-data",
url: base_url+'/inventario/orden_salida/lista_trabajador/',
success: function (msg) {
        var data = JSON.parse(msg)
        // console.log(data);
        var html = "";
        html+=
        `<option value="0">
          <font style="vertical-align: inherit;">Seleccione una opción</font>
        </option>`;
        for (var i = 0; i < data.length; i++) {
            html+=
            `<option value="${data[i].id}">
              <font style="vertical-align: inherit;">${data[i].Nombre}</font>
            </option>`;
        }
        $("#select_trabajadorOrdenSalida").empty().append(html);

        $.ajax({
        type: "GET",
        dataType: "json",
        enctype: "multipart/form-data",
        url: base_url+'/inventario/orden_salida/lista_materiales/',
        success: function (msg) {
                var data = JSON.parse(msg)
                // console.log(data);
                var html = "";
                $('.select2').remove();
                html+=
                `<label for="recipient-name" class="control-label">Nombre <span class="danger">*</label>
                <select id="select_materialesOrdenSalida" class="select2 m-b-10 select2-multiple" style="width: 100%;" multiple="multiple" data-placeholder="Seleccione">
                </select>`;
                $("#materiales_orden_salida").empty().append(html);
                var html = "";
                $(".select2").select2();
                for (var i = 0; i < data.length; i++) {
                    html+=
                    `<option value="${data[i].id}">
                      <font style="vertical-align: inherit;">${data[i].Nombre}</font>
                    </option>`;
                }

                $("#select_materialesOrdenSalida").empty().append(html);
                // $("#agregarTituloNuevaCompra").html("Nueva orden de compra");
                $('#modal_agregar_ordenSalida').modal('show');
              }
      });
      }
});
//Hacer dinámico para agregar cantidad
   var nextinput = 0;
   var tipo;
   var temp;
   var temp2 = 0;
$('body').on('change', "#select_materialesOrdenSalida", function(e){
       tipo =  $("#select_materialesOrdenSalida").val();
       // console.log("**************");
       temp = tipo.length;
       // console.log("temp: ", temp);
       // console.log("validar: ", temp, temp2);
       // $("#cantidadcrear").empty();
       var html2 = "";
      if (temp > temp2) {
        // console.log("si");
        nextinput++;
        // console.log("nextinput, ", nextinput);
        for (var i = 0; i < temp; i++) {
          var t = i+1;
          html2+=
          '<input type="text" class="form-control" name="cantidadOrdenSalida'+t+'" id="cantidadOrdenSalida'+t+'"><p></p>';
        }
        $("#DinamicoOrdenSalida").empty().append(html2);
        $("#actionAgregarOrdenSalida").attr("onclick", "nuevoOrdenSalida("+nextinput+")");
      }else {
        temp2 = temp;
        nextinput = temp2;
        // console.log("temp2 else: ", temp2);
        var html = "";
        for (var i = 0; i < temp2; i++) {
          var t = i+1;
          html+=
          '<input type="text" class="form-control" name="cantidadOrdenSalida'+t+'" id="cantidadOrdenSalida'+t+'"><p></p>';
        }
        $("#DinamicoOrdenSalida").empty().append(html);
        $("#actionAgregarOrdenSalida").attr("onclick", "nuevoOrdenSalida("+nextinput+")");
      }
        temp2 = tipo.length;
        // console.log("temp2: ", temp2);
});
}

//Funcion para agregar nueva orden de Salida
function nuevoOrdenSalida(para) {
  var bandera_validar=0;

  if($("#txtNotaOrdenSalida").val().length == 0){
      validation($("#txtNotaOrdenSalida"), $("#txtNotaOrdenSalida").parent());
      bandera_validar = bandera_validar +1;
  }

  if($("#txtDescripcion").val().length == 0){
      validation($("#txtDescripcion"), $("#txtDescripcion").parent());
      bandera_validar = bandera_validar +1;
  }

  for (var i = 0; i < para; i++) {
    var t = i+1;
    if($("#cantidadOrdenSalida"+t+"").val().length == 0){
        validation($("#cantidadOrdenSalida"), $("#cantidadOrdenSalida").parent());
        bandera_validar = bandera_validar +1;
    }
  }

  if($("#select_trabajadorOrdenSalida").val() == 0){
      validation($("#select_trabajadorOrdenSalida"), $("#select_trabajadorOrdenSalida").parent());
      bandera_validar = bandera_validar +1;
  }

  if (bandera_validar == 0) {

    var d = new Date();
    var month = d.getMonth()+1;
    var day = d.getDate();
    var output = d.getFullYear() + '-' +
    (month<10 ? '0' : '') + month + '-' +
    (day<10 ? '0' : '') + day;
    var fecha = output;
    var idUsuario = 1;

    var datos_ordenSalida = "";
    datos_ordenSalida = new FormData();
    datos_ordenSalida.append("_token", token);


    //Para la tabla orden de salida
    var Num_nota = $("#txtNotaOrdenSalida").val();
    var Descripcion = $("#txtDescripcion").val();
    var Trabajadores_idTrabajadore = $("#select_trabajadorOrdenSalida").val();
    datos_ordenSalida.append("Num_nota", Num_nota);
    datos_ordenSalida.append("Fecha", fecha);
    datos_ordenSalida.append("Estado", "1");
    datos_ordenSalida.append("idUsuario", idUsuario);
    datos_ordenSalida.append("Descripcion", Descripcion);
    datos_ordenSalida.append("Trabajadores_idTrabajadore", Trabajadores_idTrabajadore);

    var mensaje = "La nueva orden de salida se a generado con éxito";
    var titulo = "Nuevo orden de salida";

    var nombre_material = $("#select_materialesOrdenSalida").val();
    // console.log("id_material: ", nombre_material);
    // console.log("Primero");
    // for (var i = 0; i < 2; i++) {
    //   $.ajax({
    //       type: "GET",
    //       dataType: "json",
    //       enctype: "multipart/form-data",
    //       url: base_url+'/inventario/orden_salida/lista_materialesExistencia/'+materiales_idMateriale[i],
    //       success: function (msg) {
    //               console.log("id: ", id);
    //               var data = JSON.parse(msg);
    //               console.log("existencia: ", data);
    //
    //             }, error: function(error) {
    //                 swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
    //                 //limpiar campos
    //                 $("#txtDescripcion").val("");
    //                 $("#txtNotaOrdenSalida").val("");
    //             }
    //       });
    // }
    //  console.log("segundo");

    $.ajax({
        type: 'POST',
        processData: false,
        contentType: false,
        cache: false,
        data: datos_ordenSalida,
        dataType: false,
        enctype: 'multipart/form-data',
        url: base_url+'/inventario/orden_salida/agregar_ordenSalida',
        success: function(msg){
            var data = JSON.parse(msg)
            console.log("data salida: " , data);
            if(data >= 0){

              var datos_materiales = "";
              datos_materiales = new FormData();
              datos_materiales.append("_token", token);

              var datos_movmateriales = "";
              datos_movmateriales = new FormData();
              datos_movmateriales.append("_token", token);

              var datos_salidamovmateriales = "";
              var Orden_salida_idOrden_Salidas = data;
              datos_salidamovmateriales = new FormData();
              datos_salidamovmateriales.append("_token", token);

              //Para mov_materiales

              for (var i = 0; i < nombre_material.length; i++) {
                      var t = i+1;
                      var cantidad = $("#cantidadOrdenSalida"+t+"").val();
                      var materiales_idMateriale = nombre_material[i];

                      datos_movmateriales.append("Tipo_mov", "2");
                      datos_movmateriales.append("Cantidad", cantidad); //Dinamico
                      datos_movmateriales.append("Fecha", fecha);
                      datos_movmateriales.append("Estado", "1");
                      datos_movmateriales.append("idUsuario", idUsuario);
                      datos_movmateriales.append("Materiales_idMateriale", materiales_idMateriale); //Dinamico

                  $.ajax({
                      type: 'POST',
                      processData: false,
                      contentType: false,
                      cache: false,
                      data: datos_movmateriales,
                      dataType: false,
                      enctype: 'multipart/form-data',
                      url: base_url+'/inventario/orden_salida/agregar_movmateriales',
                      success: function(msg){
                          // var data = JSON.parse(msg)
                          var id = msg.id;
                          var cantidad = msg.Cantidad;
                          console.log("d: ", msg);
                          var existencia = msg.Existencia[0].Existencia;
                          var idMaterial = msg.Existencia[0].materialid;
                          console.log("data: ", data);
                          console.log("cantidad: ", cantidad);
                          console.log("existencia: ", existencia);
                          console.log("idMaterial: ", idMaterial);
                          var total = existencia - cantidad;
                          console.log("total: ", total);
                          if(data >= 0){

                            var Mov_materiale_idMov_Materiales = id;


                            datos_salidamovmateriales.append("Mov_materiale_idMov_Materiales", Mov_materiale_idMov_Materiales);
                            datos_salidamovmateriales.append("Orden_salida_idOrden_Salidas", Orden_salida_idOrden_Salidas);
                            datos_salidamovmateriales.append("idUsuario", idUsuario);

                          $.ajax({
                              type: 'POST',
                              processData: false,
                              contentType: false,
                              cache: false,
                              data: datos_salidamovmateriales,
                              dataType: false,
                              enctype: 'multipart/form-data',
                              url: base_url+'/inventario/orden_salida/agregar_salidamovmateriales',
                              success: function(msg){
                                  var data = JSON.parse(msg)
                                  console.log("data salida_mov_materiales: " , data);
                                  if(data == 0){

                                    // start aaaaaaaaa
                                    var datos_materiales = "";
                                    datos_materiales = new FormData();
                                    datos_materiales.append("_token", token);

                                    datos_materiales.append("Existencia", total);
                                    datos_materiales.append("idUsuario", idUsuario);
                                    console.log("id: ", id);

                                    $.ajax({
                                        type: 'POST',
                                        processData: false,
                                        contentType: false,
                                        cache: false,
                                        data: datos_materiales,
                                        dataType: false,
                                        enctype: 'multipart/form-data',
                                        url: base_url+'/inventario/orden_salida/modificar_existencia/'+idMaterial,
                                        success: function(msg){
                                            var data = JSON.parse(msg)
                                            console.log("data update_Existencia: " , data);
                                            if(data == 0){

                                              console.log("hecho, ", id);

                                              $('#modal_agregar_ordenSalida').modal('hide')
                                              swal(titulo, mensaje, "success");
                                              tablaOrdenSalida(0,"#tabla_ordenSalidaActivas");
                                              tablaOrdenSalida(1,"#tabla_ordenSalidaCancelada");

                                              //limpiar campos
                                              $("#txtDescripcion").val("");
                                              $("#txtNotaOrdenSalida").val("");

                                            }else{
                                                swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
                                                //limpiar campos
                                                $("#txtDescripcion").val("");
                                                $("#txtNotaOrdenSalida").val("");
                                            }
                                        }, error: function(error) {
                                            swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
                                            //limpiar campos
                                            $("#txtDescripcion").val("");
                                            $("#txtNotaOrdenSalida").val("");
                                        }
                                    });
                                    // end aaaaaa

                                  }else{
                                      swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
                                      //limpiar campos
                                      $("#txtDescripcion").val("");
                                      $("#txtNotaOrdenSalida").val("");
                                  }
                              }, error: function(error) {
                                  swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
                                  //limpiar campos
                                  $("#txtDescripcion").val("");
                                  $("#txtNotaOrdenSalida").val("");
                              }
                          });

                          }else{
                              swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
                              //limpiar campos
                              $("#txtDescripcion").val("");
                              $("#txtNotaOrdenSalida").val("");
                          }
                          }, error: function(error) {
                            swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
                            //limpiar campos
                            $("#txtDescripcion").val("");
                            $("#txtNotaOrdenSalida").val("");
                          }
                      });

                    }

            }else{
                swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
                //limpiar campos
                $("#txtDescripcion").val("");
                $("#txtNotaOrdenSalida").val("");
            }
        }, error: function(error) {
            swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
                //limpiar campos
                $("#txtDescripcion").val("");
                $("#txtNotaOrdenSalida").val("");
        }
    });

    // console.log("*************");
    // var cantidad = [];
    // var materiales_idMateriale = [];
    //
    // for (var i = 0; i < para; i++) {
    //   var t = i+1;
    //   cantidad[i] = $("#cantidadOrdenSalida"+t+"").val();
    //   materiales_idMateriale[i] = nombre_material[i];
    //   }
    //
    //   // console.log("cantidad ff ",cantidad);
    //   // console.log("materiales_idMateriale ff ",materiales_idMateriale);
    //   var total = [];
    //   var existencia = [];
    //
    //   for (var i = 0; i < materiales_idMateriale.length; i++) {
    //     var id = materiales_idMateriale[i];
    //     // console.log("id exis: ", id);
    //     // var can = cantidad[i];
    //     // console.log("cantidad: ", can);


          // var datos_materiales = "";
          // datos_materiales = new FormData();
          // datos_materiales.append("_token", token);

          // for (var i = 0; i < total.length; i++) {
          //   var id = materiales_idMateriale[i];
          //   var to = total[i];
          //   console.log("id up: ", id);
          //   console.log("to up: ", to);
          //   datos_materiales.append("Existencia", to);
          //   datos_materiales.append("idUsuario", idUsuario);
          //   $.ajax({
          //       type: 'POST',
          //       processData: false,
          //       contentType: false,
          //       cache: false,
          //       data: datos_materiales,
          //       dataType: false,
          //       enctype: 'multipart/form-data',
          //       url: base_url+'/inventario/orden_salida/modificar_existencia/'+id,
          //       success: function(msg){
          //           var data = JSON.parse(msg)
          //           console.log("data update_Existencia: " , data);
          //           if(data == 0){
          //             console.log("hecho");
          //           }else{
          //               swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
          //               //limpiar campos
          //               $("#txtDescripcion").val("");
          //               $("#txtNotaOrdenSalida").val("");
          //           }
          //       }, error: function(error) {
          //           swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
          //           //limpiar campos
          //           $("#txtDescripcion").val("");
          //           $("#txtNotaOrdenSalida").val("");
          //       }
          //   });
          //
          // }

  }else {
    swal("Error", "Por favor llenar todos los campos", "error");
  }

}

//Funcion para modificar orden de salida
function ModificarOrdenSalida(para) {
  var bandera_validar=0;

  if($("#txtNotaOrdenSalidaModificar").val().length == 0){
      validation($("#txtNotaOrdenSalidaModificar"), $("#txtNotaOrdenSalidaModificar").parent());
      bandera_validar = bandera_validar +1;
  }

  if($("#txtDescripcionModificar").val().length == 0){
      validation($("#txtDescripcionModificar"), $("#txtDescripcionModificar").parent());
      bandera_validar = bandera_validar +1;
  }

  if($("#select_trabajadorOrdenSalidaModificar").val() == 0){
      validation($("#select_trabajadorOrdenSalidaModificar"), $("#select_trabajadorOrdenSalidaModificar").parent());
      bandera_validar = bandera_validar +1;
  }
  if (bandera_validar == 0) {
    var d = new Date();
    var month = d.getMonth()+1;
    var day = d.getDate();
    var output = d.getFullYear() + '-' +
    (month<10 ? '0' : '') + month + '-' +
    (day<10 ? '0' : '') + day;
    var fecha = output;
    console.log("f: ", fecha);
    var idUsuario = 1;

    var datos_ordenSalida = "";
    datos_ordenSalida = new FormData();
    datos_ordenSalida.append("_token", token);

    var Trabajadores_idTrabajadore = $("#select_trabajadorOrdenSalidaModificar").val();
    var Num_nota = $("#txtNotaOrdenSalidaModificar").val();
    var Descripcion = $("#txtDescripcionModificar").val();
    datos_ordenSalida.append("Trabajadores_idTrabajadore", Trabajadores_idTrabajadore);
    datos_ordenSalida.append("Num_nota", Num_nota);
    datos_ordenSalida.append("Descripcion", Descripcion);
    datos_ordenSalida.append("idUsuario", idUsuario);
    datos_ordenSalida.append("Fecha", fecha);

    var mensaje = "La nueva orden de salida se a modificad0 con éxito";
    var titulo = "Modificar orden de salida";

    $.ajax({
        type: 'POST',
        processData: false,
        contentType: false,
        cache: false,
        data: datos_ordenSalida,
        dataType: false,
        enctype: 'multipart/form-data',
        url: base_url+'/inventario/orden_salida/modificar_ordenSalida/'+para,
        success: function(msg){
            var data = JSON.parse(msg)
            console.log("data update" , data);
            if(data == 0){

              $('#modal_agregar_ordenSalidaModificar').modal('hide')
              swal(titulo, mensaje, "success");
              tablaOrdenSalida(0,"#tabla_ordenSalidaActivas");
              tablaOrdenSalida(1,"#tabla_ordenSalidaCancelada");

              //limpiar campos
              $("#txtDescripcionModificar").val("");
              $("#txtNotaOrdenSalidaModificar").val("");

            }else{
                swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
                //limpiar campos
                $("#txtDescripcionModificar").val("");
                $("#txtNotaOrdenSalidaModificar").val("");
            }
        }, error: function(error) {
            swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
            //limpiar campos
            $("#txtDescripcionModificar").val("");
            $("#txtNotaOrdenSalidaModificar").val("");
        }
    });
  }
}

//Funcion para crear y cargar los datos a la tabla
function tablaOrdenSalida(){
    $.ajax({
		type: "GET",
		dataType: "json",
		enctype: "multipart/form-data",
		url: base_url+'/inventario/orden_salida/lista',
		success: function (msg) {

            var data = JSON.parse(msg)
			      // console.log("datos: " , data);

            var tabla_ordenSalidaActivas = "";
            var tabla_ordenSalidaCancelada = "";

            $("#tabla_ordenSalidaActivas").DataTable().clear();
            $("#tabla_ordenSalidaActivas").DataTable().destroy();

            $("#tabla_ordenSalidaCancelada").DataTable().clear();
            $("#tabla_ordenSalidaCancelada").DataTable().destroy();

            for (var i = 0; i < data.length; i++) {
                if (data[i].Estado == 1) {
                  tabla_ordenSalidaActivas+=
                  `<tr>
                      <td>${data[i].Num_nota}</td>
                      <td>${data[i].Fecha}</td>
                      <td>${data[i].Nombre}</td>
                      <td>${data[i].Descripcion}</td>
                      <td class="text-nowrap" data-material="${data[i].id}">
                          <a href="#" class="modificarOrdenSalida" data-toggle="tooltip" data-original-title="Modificar"><i class="icon-pencil text m-r-10"></i></a>
                          <a href="#" class="eliminarOrdenSalida" data-toggle="tooltip" data-original-title="Cancelar"> <i class="icon-close text-danger m-r-10"></i></a>
                      </td>
                  </tr>`;
                }else if (data[i].Estado == 0) {
                  tabla_ordenSalidaCancelada+=
                  `<tr>
                      <td>${data[i].Num_nota}</td>
                      <td>${data[i].Fecha}</td>
                      <td>${data[i].Nombre}</td>
                      <td>${data[i].Descripcion}</td>
                      <td class="text-nowrap" data-material="${data[i].id}">
                          <a href="#" class="modificarOrdenSalida" data-toggle="tooltip" data-original-title="Modificar"><i class="icon-pencil text m-r-10"></i></a>
                      </td>
                  </tr>`;
                }
            }
            $("#tabla_ordenSalidaActivas tbody").empty().append(tabla_ordenSalidaActivas);
            $('#tabla_ordenSalidaActivas').DataTable({
              dom: 'Bfrtip',
              buttons: ['excel', 'pdf', 'print']
            });
            $("#tabla_ordenSalidaCancelada tbody").empty().append(tabla_ordenSalidaCancelada);
            $('#tabla_ordenSalidaCancelada').DataTable({
              dom: 'Bfrtip',
              buttons: ['excel', 'pdf', 'print']
            });
            $("body").tooltip({ selector: '[data-toggle="tooltip"]' });
		}
	});
}

//Funcion para ejecuar cuando se carga este script
$(document).ready(function () {
	tablaOrdenSalida();
  $(".select2").select2();
});

//Validacion de los campos
$("#txtNotaOrdenSalida").on('input',function(e){
    validation($(this), $(this).parent())
});
$("#txtDescripcion").on('input',function(e){
    validation($(this), $(this).parent())
});
$("#select_trabajadorOrdenSalida").on('change',function(e){
    validation($(this), $(this).parent())
    validation($("#validar").val("1"), $("#txtDescripcion").parent());
});
$("#txtNotaOrdenSalidaModificar").on('input',function(e){
    validation($(this), $(this).parent())
});
$("#txtDescripcionModificar").on('input',function(e){
    validation($(this), $(this).parent())
});
$("#select_trabajadorOrdenSalidaModificar").on('change',function(e){
    validation($(this), $(this).parent())
    validation($("#validar").val("1"), $("#txtDescripcionModificar").parent());
    validation($("#validar").val("1"), $("#txtNotaOrdenSalidaModificar").parent());
});
$('body').on('change', "#select_materialesOrdenSalida", function(e){
    validation($(this), $(this).parent())
    validation($("#validar").val("1"), $("#txtDescripcion").parent());
});
