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

//Accion para abrir el modal de nueva orden de compra
$('#boton_agregarOrdenCompra').on("click", function(e){
  e.preventDefault();
  e.stopImmediatePropagation();
  $("#num_nota").val("");
  $("#cantidadOrdenCompra").val("");
  $("#select_CompraMaterial").val("0");
  $("#select_CompraProveedor").val("0");
  $("#cantidadcrear").empty();
  cargarDatosModalAgregarCompra();
})

//Accion para abrir modal de pagar compras
$('#boton_pagarCompra').on("click", function(e) {
  // $("#select_CompraMaterial").empty().append(html);
  e.preventDefault();
  e.stopImmediatePropagation();
  $("#agregarTituloPagarCompra").html("Pagar compra");
  $('#modal_pagar_ordenCompra').modal('show');
  $("#actionPagarCompra").attr("onclick", "pagarCompra()");

  $("#todo").empty();
  $("#select_PagarCompra").val("0");
  $("#select_OrdenCompras").val("0");
  $("#select_proveedorCompraPagar").val("0");

  var html = "";
  html+=
  `<div class="row">
    <div class="col-md-6">
      <div class="form-group">
          <label for="recipient-name" class="control-label">Forma de pago <span class="danger">*</label>
          <select id="select_PagarCompra" class="form-control">
            <option value="0">Seleccione una opcion</option>
            <option value="1">Cheque</option>
            <option value="2">Transferencia</option>
          </select>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
          <label for="recipient-name" class="control-label">Factura <span class="danger">*</label>
          <input type="text" class="form-control required" id="factura" name="factura" disabled>
      </div>
    </div>
  </div>
  <div id="todo">
  </div>`;
  $("#principal").empty().append(html);
  $('#select_PagarCompra').on('change',function(e){
    var tipo = $("#select_PagarCompra").val();
    $('.select2').remove();
    if (tipo == 1) {
      $("#factura").removeAttr("disabled");
      $('.select2').remove();
      var html = "";
      html+=
      `<div class="row">
         <div class="col-md-6">
          <div class="form-group">
              <label for="recipient-name" class="control-label">Proveedor <span class="danger">*</label>
              <select id="select_proveedorCompraPagar" class="form-control">
              </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
              <label for="message-text" class="control-label">Ordenes de compras <span class="danger">*</label>
              <select id="select_OrdenCompras" class="select2 m-b-10 select2-multiple" style="width: 100%;" multiple="multiple" data-placeholder="Seleccione #notas" disabled>
              </select>
          </div>
        </div>
       </div>
       <div class="row">
           <div class="col-md-6">
             <div class="form-group">
                 <label for="recipient-name" class="control-label">#Cheque <span class="danger">*</label>
                 <input type="text" class="form-control required" id="txtCheque" name="txtCheque">
             </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
                <label for="recipient-name" class="control-label">$Total <span class="danger">*</label>
                <input type="text" class="form-control required" id="txtTotal" name="txtTotal" value="0" disabled>
            </div>
         </div>
      </div>`;

      $("#todo").empty().append(html);
      $(".select2").select2();
    }else if (tipo == 2) {
      var html = "";
      $("#factura").removeAttr("disabled");
      $('.select2').remove();
      html+=
      `<div class="row">
         <div class="col-md-6">
          <div class="form-group">
              <label for="recipient-name" class="control-label">Proveedor <span class="danger">*</label>
              <select id="select_proveedorCompraPagar" class="form-control">
              </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
              <label for="message-text" class="control-label">Ordenes de compras <span class="danger">*</label>
              <select id="select_OrdenCompras" class="select2 m-b-10 select2-multiple" style="width: 100%;" multiple="multiple" data-placeholder="Seleccione #notas" disabled>
              </select>
          </div>
        </div>
       </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="recipient-name" class="control-label">$Total <span class="danger">*</label>
            <input type="text" class="form-control required" id="txtTotal" name="txtTotal" value="0" disabled>
          </div>
        </div>
      </div>`;
      $("#todo").empty().append(html);
      $(".select2").select2();
    }else {
      $("#todo").empty();
      $("#factura").attr("disabled",true);
    }

    $('#select_proveedorCompraPagar').on('change',function(e){
      var tipo_pro = $("#select_proveedorCompraPagar").val();

      if (tipo_pro !=0) {
        $("#select_OrdenCompras").removeAttr("disabled");
        $.ajax({
        type: "GET",
        dataType: "json",
        enctype: "multipart/form-data",
        url: base_url+'/inventario/orden_compra/lista_compras/'+tipo_pro,
        success: function (msg) {
                var data = JSON.parse(msg)
                // console.log(data);
                var html = "";
                // html+=
                // `<option value="0">
                //   <font style="vertical-align: inherit;">Seleccione una opción</font>
                // </option>`;
                for (var i = 0; i < data.length; i++) {
                  if (data[i].estatus == 2) {
                    html+=
                    `<option value="${data[i].id}">
                      <font style="vertical-align: inherit;">${data[i].Num_nota}</font>
                    </option>`;
                  }
                }

                $("#select_OrdenCompras").empty().append(html);
              }
         });
      }else {
        // console.log("0");
        $("#select_OrdenCompras").attr("disabled",true);
      }
    })

    $.ajax({
    type: "GET",
    dataType: "json",
    enctype: "multipart/form-data",
    url: base_url+'/inventario/orden_compra/lista_proveedor/',
    success: function (msg) {
            var data = JSON.parse(msg)
            // console.log(data);
            var html = "";
            html+=
            `<option value="0">
              <font style="vertical-align: inherit;">Seleccione una opción</font>
            </option>`;
            for (var i = 0; i < data.length; i++) {
              if (data[i].estatus !=0) {
                html+=
                `<option value="${data[i].id}">
                  <font style="vertical-align: inherit;">${data[i].Nombre}</font>
                </option>`;
              }
            }

            $("#select_proveedorCompraPagar").empty().append(html);
          }
     });
  });
})

//Accion para abrir el modal de modificar la orden_compra
$('#tabla_curso').on("click",".modificarOrdenCompra", function(e){
  e.preventDefault();
  e.stopImmediatePropagation();
  validation($("#validar").val("1"), $("#TotalModificarCompra").parent());
  $("#TotalModificarCompra").val("");
  $("#Estado_Curso").prop('checked', false);
  $("#Estado_Recibido").prop('checked', false);
  $("#Estado_Cancelado").prop('checked', false);
  var id = $(this).parent().attr("data-material");

  Swal.fire({
    onOpen: function (){
      Swal.showLoading()
      $.ajax({
      type: "GET",
      dataType: "json",
      enctype: "multipart/form-data",
      url: base_url+'/inventario/orden_compra/lista_proveedor/',
      success: function (msg) {
              var data = JSON.parse(msg)
              // console.log(data);
              var html = "";
              html+=
              `<option value="0">
                <font style="vertical-align: inherit;">Seleccione una opción</font>
              </option>`;
              for (var i = 0; i < data.length; i++) {
                if (data[i].estatus !=0) {
                  html+=
                  `<option value="${data[i].id}">
                    <font style="vertical-align: inherit;">${data[i].Nombre}</font>
                  </option>`;
                }
              }
              $("#select_proCompra").empty().append(html);

              $.ajax({
              type: "GET",
              dataType: "json",
              enctype: "multipart/form-data",
              url: base_url+'/inventario/orden_compra/especifico/'+id,
              success: function (msg) {
                      Swal.close()
                      var data = JSON.parse(msg)
                      $("#num_notaModificar").val(data[0].Num_nota);
                      if (data[0].Estado == 1) {
                        $("#Estado_Curso").prop('checked', true);
                      }else if(data[0].Estado == 2){
                        $("#Estado_Recibido").prop('checked', true);
                      }else if (data[0].Estado == 3) {
                        $("#Estado_Cancelado").prop('checked', true);
                      }
                      $("#select_proCompra option[value="+ data[0].proid +"]").attr("selected",true);

                      $("#agregarTituloModificarCompra").html("Modificar orden de compra");
                      $('#modal_modificar_ordenCompra').modal('show');
                      $("#actionAgregarModificarCompra").attr("onclick", "ModificarOrdenCompra("+id+")");
                    }, error: function(error) {
                        Swal.close()
                        // alerta_temporizador(
                        //     'error',
                        //     'Nuevo material',
                        //     'Ha ocurrido un error, inténtelo más tarde.',
                        //     2500
                        // );
                    }
               });
            }, error: function(error) {
                Swal.close()
                // alerta_temporizador(
                //     'error',
                //     'Nuevo material',
                //     'Ha ocurrido un error, inténtelo más tarde.',
                //     2500
                // );
            }
       });
    }
  })

})
$('#tabla_curso').on("click", ".eliminarOrdenCompra", function(e) {
  var id = $(this).parent().attr("data-material");
  e.preventDefault();
  e.stopImmediatePropagation();

  //El objeto que se envia en el POST
  var datos_ordenCompra = ""
  datos_ordenCompra = new FormData();
  datos_ordenCompra.append("idUsuario", "1");
  datos_ordenCompra.append("_token", token);
  datos_ordenCompra.append("Estado_Compra", "3");

  var url = "";
  url = base_url+'/inventario/orden_compra/eliminarorden/'+id;
  mensaje = "La orden de compra ha sido eliminado con éxito";
  titulo = "Eliminar orden de compra";

  Swal.fire({
    onOpen: function (){
      Swal.showLoading()
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
              Swal.close()
              var data = JSON.parse(msg)
              if(data == 0){
                  // swal("Eliminado", mensaje, "success");
                  alerta_temporizador(
                          'success',
                          'Eliminar orden de compra',
                          'La orden de compra ha sido eliminado con éxito',
                          2000
                      );
                  tablaOrdenCompra(0,"#tabla_curso");
                  tablaOrdenCompra(1,"#tabla_recibido");
                  tablaOrdenCompra(2,"#tabla_cancelado");
                  tablaOrdenCompra(3,"#tabla_pagado");
              }else{
                  // swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
                  Swal.close()
                  alerta_temporizador(
                          'error',
                          'Eliminar orden de compra',
                          'Ha ocurrido un error, inténtelo más tarde.',
                          2000
                      );
              }
          }, error: function(error) {
              // swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
              Swal.close()
              alerta_temporizador(
                      'error',
                      'Eliminar orden de compra',
                      'Ha ocurrido un error, inténtelo más tarde.',
                      2000
                  );
          }
      });
    }
  })
  // swal({
  //     title: "¿Deseas eliminar la orden de compra?",
  //     // text: "No podrás recuperarlo",
  //     type: "error",
  //     showCancelButton: true,
  //     confirmButtonColor: "#DD6B55",
  //     confirmButtonText: "Eliminar",
  //     cancelButtonText: "Cancelar",
  //     closeOnConfirm: false,
  //     closeOnCancel: true
  // }, function(isConfirm){
  //     if (isConfirm) {
  //       $.ajax({
  //           type: 'POST',
  //           processData: false,
  //           contentType: false,
  //           cache: false,
  //           data: datos_ordenCompra,
  //           dataType: false,
  //           enctype: 'multipart/form-data',
  //           url: url,
  //           success: function(msg){
  //               var data = JSON.parse(msg)
  //               if(data == 0){
  //                   swal("Eliminado", mensaje, "success");
  //                   tablaOrdenCompra(0,"#tabla_curso");
  //                   tablaOrdenCompra(1,"#tabla_recibido");
  //                   tablaOrdenCompra(2,"#tabla_cancelado");
  //                   tablaOrdenCompra(3,"#tabla_pagado");
  //               }else{
  //                   swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
  //               }
  //           }, error: function(error) {
  //               swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
  //           }
  //       });
  //     }
  // });
})
$('#tabla_curso').on("click", ".detalleOrdenCompra", function(e) {
  var id = $(this).parent().attr("data-material");
  // console.log("id", id);
  e.preventDefault();
  e.stopImmediatePropagation();

  Swal.fire({
   onOpen: function (){
     Swal.showLoading()
     $.ajax({
     type: "GET",
     dataType: "json",
     enctype: "multipart/form-data",
     url: base_url+'/inventario/orden_compra/especifico/'+id,
     success: function (msg) {
             Swal.close()
             var data = JSON.parse(msg)
             // console.log(data);
             // console.log("da: ", data);
             var html = "";
             for (var i = 0; i < data.length; i++) {
               html+=
               `<tr>
                   <td>${data[i].Material}</td>
                   <td>${data[i].Cantidad}</td>
               </tr>`;
             }

            $("#infoOrdenCompra tbody").empty().append(html);
            $('#modal_info_ordenCompra').modal('show');
          }, error: function(error) {
              // swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
              Swal.close()
              // alerta_temporizador(
              //         'error',
              //         'Eliminar material',
              //         'Ha ocurrido un error, inténtelo más tarde.',
              //         2500
              //     );
          }
   });
     }
   })
})
$('#tabla_recibido').on("click", ".detalleOrdenCompra", function(e) {
  var id = $(this).parent().attr("data-material");
  // console.log("id", id);
  e.preventDefault();
  e.stopImmediatePropagation();

  Swal.fire({
   onOpen: function (){
     Swal.showLoading()
     $.ajax({
     type: "GET",
     dataType: "json",
     enctype: "multipart/form-data",
     url: base_url+'/inventario/orden_compra/especifico/'+id,
     success: function (msg) {
             Swal.close()
             var data = JSON.parse(msg)
             // console.log(data);
             // console.log("da: ", data);
             var html = "";
             for (var i = 0; i < data.length; i++) {
               html+=
               `<tr>
                   <td>${data[i].Material}</td>
                   <td>${data[i].Cantidad}</td>
               </tr>`;
             }

            $("#infoOrdenCompra tbody").empty().append(html);
            $('#modal_info_ordenCompra').modal('show');
          }, error: function(error) {
              // swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
              Swal.close()
              // alerta_temporizador(
              //         'error',
              //         'Eliminar material',
              //         'Ha ocurrido un error, inténtelo más tarde.',
              //         2500
              //     );
          }
   });
     }
   })
})
$('#tabla_cancelado').on("click", ".detalleOrdenCompra", function(e) {
  var id = $(this).parent().attr("data-material");
  // console.log("id", id);
  e.preventDefault();
  e.stopImmediatePropagation();

  Swal.fire({
   onOpen: function (){
     Swal.showLoading()
     $.ajax({
     type: "GET",
     dataType: "json",
     enctype: "multipart/form-data",
     url: base_url+'/inventario/orden_compra/especifico/'+id,
     success: function (msg) {
             Swal.close()
             var data = JSON.parse(msg)
             // console.log(data);
             // console.log("da: ", data);
             var html = "";
             for (var i = 0; i < data.length; i++) {
               html+=
               `<tr>
                   <td>${data[i].Material}</td>
                   <td>${data[i].Cantidad}</td>
               </tr>`;
             }

            $("#infoOrdenCompra tbody").empty().append(html);
            $('#modal_info_ordenCompra').modal('show');
          }, error: function(error) {
              // swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
              Swal.close()
              // alerta_temporizador(
              //         'error',
              //         'Eliminar material',
              //         'Ha ocurrido un error, inténtelo más tarde.',
              //         2500
              //     );
          }
   });
     }
   })
})
$('#tabla_pagado').on("click", ".detalleOrdenCompra", function(e) {
  var id = $(this).parent().attr("data-material");
  // console.log("id", id);
  e.preventDefault();
  e.stopImmediatePropagation();

  Swal.fire({
   onOpen: function (){
     Swal.showLoading()
     $.ajax({
     type: "GET",
     dataType: "json",
     enctype: "multipart/form-data",
     url: base_url+'/inventario/orden_compra/especifico/'+id,
     success: function (msg) {
             Swal.close()
             var data = JSON.parse(msg)
             // console.log(data);
             // console.log("da: ", data);
             var html = "";
             for (var i = 0; i < data.length; i++) {
               html+=
               `<tr>
                   <td>${data[i].Material}</td>
                   <td>${data[i].Cantidad}</td>
               </tr>`;
             }

            $("#infoOrdenCompra tbody").empty().append(html);
            $('#modal_info_ordenCompra').modal('show');
          }, error: function(error) {
              // swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
              Swal.close()
              // alerta_temporizador(
              //         'error',
              //         'Eliminar material',
              //         'Ha ocurrido un error, inténtelo más tarde.',
              //         2500
              //     );
          }
   });
     }
   })
})

//Funcion para cargar los datos del model de agregar nueva orden de compra
function cargarDatosModalAgregarCompra() {
  Swal.fire({
      onOpen: function (){
        Swal.showLoading()
        $.ajax({
        type: "GET",
        dataType: "json",
        enctype: "multipart/form-data",
        url: base_url+'/inventario/orden_compra/lista_proveedor/',
        success: function (msg) {
                var data = JSON.parse(msg)
                // console.log(data);
                var html = "";
                html+=
                `<option value="0">
                  <font style="vertical-align: inherit;">Seleccione una opción</font>
                </option>`;
                for (var i = 0; i < data.length; i++) {
                  if (data[i].Estado !=0) {
                    html+=
                    `<option value="${data[i].id}">
                      <font style="vertical-align: inherit;">${data[i].Nombre}</font>
                    </option>`;
                  }
                }

                $("#select_CompraProveedor").empty().append(html);

                $.ajax({
                type: "GET",
                dataType: "json",
                enctype: "multipart/form-data",
                url: base_url+'/inventario/orden_compra/lista_materiales/',
                success: function (msg) {
                        Swal.close()
                        var data = JSON.parse(msg)
                        // console.log(data);
                        var html = "";
                        $('.select2').remove();
                        html+=
                        `<label for="recipient-name" class="control-label">Nombre <span class="danger">*</label>
                        <select id="select_CompraMaterial" class="select2 m-b-10 select2-multiple" style="width: 100%;" multiple="multiple" data-placeholder="Seleccione">
                        </select>`;
                        $("#compramaterialafter").empty().append(html);
                        var html = "";
                        $(".select2").select2();
                        for (var i = 0; i < data.length; i++) {
                          if (data[i].Estado !=0) {
                            html+=
                            `<option value="${data[i].id}">
                              <font style="vertical-align: inherit;">${data[i].Nombre}</font>
                            </option>`;
                          }
                        }

                        $("#select_CompraMaterial").empty().append(html);
                        $("#agregarTituloNuevaCompra").html("Nueva orden de compra");
                        $('#modal_nueva_ordenCompra').modal('show');

                      }, error: function(error) {
                          Swal.close()
                          // alerta_temporizador(
                          //     'error',
                          //     'Nuevo material',
                          //     'Ha ocurrido un error, inténtelo más tarde.',
                          //     2500
                          // );
                      }
              });
            }, error: function(error) {
                Swal.close()
                // alerta_temporizador(
                //     'error',
                //     'Nuevo material',
                //     'Ha ocurrido un error, inténtelo más tarde.',
                //     2500
                // );
            }
        });
      }
    })
//Hacer dinámico para agregar cantidad
   var nextinput = 0;
   var tipo;
   var temp;
   var temp2 = 0;
$('body').on('change', "#select_CompraMaterial", function(e){
       tipo =  $("#select_CompraMaterial").val();
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
          '<input type="text" class="form-control input-number" name="cantidadOrdenCompra'+t+'" id="cantidadOrdenCompra'+t+'"><p></p>';
        }
        $("#cantidadcrear").empty().append(html2);
        $("#actionAgregarNuevaCompra").attr("onclick", "nuevoOrdenCompra("+nextinput+")");
      }else {
        temp2 = temp;
        nextinput = temp2;
        // console.log("temp2 else: ", temp2);
        var html = "";
        for (var i = 0; i < temp2; i++) {
          var t = i+1;
          html+=
          '<input type="text" class="form-control input-number" name="cantidadOrdenCompra'+t+'" id="cantidadOrdenCompra'+t+'"><p></p>';
        }
        $("#cantidadcrear").empty().append(html);
        $("#actionAgregarNuevaCompra").attr("onclick", "nuevoOrdenCompra("+nextinput+")");
      }
        temp2 = tipo.length;
        // console.log("temp2: ", temp2);
});
}

//Funcion para agregar nueva orden de compra
function nuevoOrdenCompra(para) {
  var bandera_validar=0;

  if($("#num_nota").val().length == 0){
      validation($("#num_nota"), $("#num_nota").parent());
      bandera_validar = bandera_validar +1;
  }

  for (var i = 0; i < para; i++) {
    var t = i+1;
    if($("#cantidadOrdenCompra"+t+"").val().length == 0){
        validation($("#cantidadOrdenCompra"), $("#cantidadOrdenCompra").parent());
        bandera_validar = bandera_validar +1;
    }
  }

  if($("#select_CompraMaterial").val() == 0){
      validation($("#select_CompraMaterial"), $("#select_CompraMaterial").parent());
      bandera_validar = bandera_validar +1;
  }

  if($("#select_CompraProveedor").val() == 0){
      validation($("#select_CompraProveedor"), $("#select_CompraProveedor").parent());
      bandera_validar = bandera_validar +1;
  }

  if (bandera_validar == 0) {

    var nombre_material = $("#select_CompraMaterial").val();
    // console.log("materiales: ", nombre_material);
    var cantidad_material = [];
    for (var i = 0; i < para; i++) {
            var t = i+1;
            cantidad_material[i] = $("#cantidadOrdenCompra"+t+"").val();
    }
    // console.log("ca: ", cantidad_material);

    var d = new Date();
    var month = d.getMonth()+1;
    var day = d.getDate();
    var output = d.getFullYear() + '-' +
    (month<10 ? '0' : '') + month + '-' +
    (day<10 ? '0' : '') + day;

    var nombre_proveedor = $("#select_CompraProveedor").val();
    var num_nota = $("#num_nota").val();
    var fecha = output;
    var idUsuario = "1";

    //Datos para la tabla de Compra
    var datos_ordenCompra = "";
    datos_ordenCompra = new FormData();
    datos_ordenCompra.append("_token", token);

    datos_ordenCompra.append("num_nota", num_nota);
    datos_ordenCompra.append("Fecha", fecha);
    datos_ordenCompra.append("EstadoCompra", "1");
    datos_ordenCompra.append("idUsuario", idUsuario);
    datos_ordenCompra.append("Proveedores_idProveedor", nombre_proveedor);

    var url = "";
    url = base_url+'/inventario/orden_compra/id_ordenCompra';
    var mensaje = "La nueva orden de compra se a generado con éxito";
    var titulo = "Nuevo orden de compra";

    Swal.fire({
    onOpen: function (){
      Swal.showLoading()
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
              // console.log("data 1: " , data);
              if(data >= 0){

                    var idCompra = data;
                    //Datos para la tabla mov_materiales
                    var datos_cantidaMov = "";
                    datos_cantidaMov = new FormData();
                    datos_cantidaMov.append("_token", token);

                    var url = "";
                    url = base_url+'/inventario/orden_compra/agregar_ordenCompra';

                    for (var i = 0; i < cantidad_material.length; i++) {
                        var cantidaMaterial = cantidad_material[i];
                        var nombreMaterial = nombre_material[i];

                        // datos_cantidaMov.append("Tipo_mov", "1");
                        datos_cantidaMov.append("CantidadMovMaterial", cantidaMaterial); //array
                        datos_cantidaMov.append("Fecha", fecha);
                        datos_cantidaMov.append("idUsuario", idUsuario);
                        datos_cantidaMov.append("Materiales_idMateriale", nombreMaterial); //array

                        //Datos para la tabla compras_has_mov_material
                        datos_cantidaMov.append("idCompra", idCompra);
                        datos_cantidaMov.append("idUsuario", idUsuario);

                        $.ajax({
                            type: 'POST',
                            processData: false,
                            contentType: false,
                            cache: false,
                            data: datos_cantidaMov,
                            dataType: false,
                            enctype: 'multipart/form-data',
                            url: url,
                            success: function(msg){
                                Swal.close()
                                var data = JSON.parse(msg)
                                // console.log("data 2: " , data);
                                if(data == 0){
                                    $('#modal_nueva_ordenCompra').modal('hide')
                                    // swal(titulo, mensaje, "success");
                                    alerta_temporizador(
                                        'success',
                                        'Nuevo orden de compra',
                                        'La nueva orden de compra se a generado con éxito',
                                        2500
                                    );
                                    tablaOrdenCompra(0,"#tabla_curso");
                                    tablaOrdenCompra(1,"#tabla_recibido");
                                    tablaOrdenCompra(2,"#tabla_cancelado");
                                    tablaOrdenCompra(3,"#tabla_pagado");

                                    //limpiar campos
                                    $("#num_nota").val("");
                                    $("#txtNombreMaterial").val("");
                                    $("#select_CompraMaterial").val("0");
                                    $("#select_CompraProveedor").val("0");

                                }else{
                                    // swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
                                    Swal.close()
                                    alerta_temporizador(
                                        'error',
                                        'Nuevo orden de compra',
                                        'Ha ocurrido un error, inténtelo más tarde.',
                                        2000
                                    );
                                    //limpiar campos
                                    $("#num_nota").val("");
                                    $("#txtNombreMaterial").val("");
                                    $("#select_CompraMaterial").val("0");
                                    $("#select_CompraProveedor").val("0");
                                }
                            }, error: function(error) {
                                // console.log("no success");
                                // swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
                                Swal.close()
                                alerta_temporizador(
                                    'error',
                                    'Nuevo orden de compra',
                                    'Ha ocurrido un error, inténtelo más tarde.',
                                    2000
                                );
                                //limpiar campos
                                $("#num_nota").val("");
                                $("#txtNombreMaterial").val("");
                                $("#select_CompraMaterial").val("0");
                                $("#select_CompraProveedor").val("0");
                            }
                        });

                    }

              }else{
                  // swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
                  Swal.close()
                  alerta_temporizador(
                      'error',
                      'Nuevo orden de compra',
                      'Ha ocurrido un error, inténtelo más tarde.',
                      2000
                  );
                  //limpiar campos
                  $("#num_nota").val("");
                  $("#txtNombreMaterial").val("");
                  $("#select_CompraMaterial").val("0");
                  $("#select_CompraProveedor").val("0");
              }
          }, error: function(error) {
              // console.log("no success");
              // swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
              Swal.close()
              alerta_temporizador(
                    'error',
                    'Nuevo orden de compra',
                    'Ha ocurrido un error, inténtelo más tarde.',
                    2000
                );
              //limpiar campos
              $("#num_nota").val("");
              $("#txtNombreMaterial").val("");
              $("#select_CompraMaterial").val("0");
              $("#select_CompraProveedor").val("0");
          }
        });
      }
    })

  }else {
    // swal("Error", "Por favor llenar todos los campos", "error");
    alerta_temporizador(
          'error',
          'Nuevo orden de compra',
          'Por favor llenar todos los campos',
          2000
      );
  }

}

//Funcion para modificarOrdenCompra
function ModificarOrdenCompra(id) {
  var bandera_validar=0;

  if($("#num_notaModificar").val().length == 0){
      validation($("#num_notaModificar"), $("#num_notaModificar").parent());
      bandera_validar = bandera_validar +1;
  }

  if($("#TotalModificarCompra").val().length == 0){
      validation($("#TotalModificarCompra"), $("#TotalModificarCompra").parent());
      bandera_validar = bandera_validar +1;
  }

  if($("#select_proveedorCompra").val() == 0){
      validation($("#select_proveedorCompra"), $("#select_proveedorCompra").parent());
      bandera_validar = bandera_validar +1;
  }
  if (bandera_validar == 0) {

    //Para insertar los cantidad de material a la tabla de materiales
    var total_m = $("#TotalModificarCompra").val().length;
    var id_estado = $('input:radio[name=Estado_ModificarOrden]:checked').val();
    if (id_estado == 2) {

      Swal.fire({
        onOpen: function (){
          Swal.showLoading()
          $.ajax({
          type: "GET",
          dataType: "json",
          enctype: "multipart/form-data",
          url: base_url+'/inventario/orden_compra/especifico/'+id,
          success: function (msg) {
                  var data = JSON.parse(msg)
                  // console.log("ge: " , data);
                  var cantidadCompra = [];
                  var idMaterial = [];
                  var existenciaMaterial = [];
                  var existenciaMaterialFinal = [];
                  var movId = [];
                  var idprove = data[0].proid;
                  var adeudo = data[0].Adeudo;
                  var idCompra = data[0].comid;
                  if ($("#TotalModificarCompra").val().length == 0) {
                    var txtTotal = 0;
                  }else {
                    var txtTotal = parseInt($("#TotalModificarCompra").val());
                  }
                  var aduedoFinal = txtTotal + adeudo;

                  for (var i = 0; i < data.length; i++) {
                    cantidadCompra[i] = data[i].Cantidad;
                    idMaterial[i] = data[i].Materiales_idMateriale;
                    existenciaMaterial[i] = data[i].Existencia;
                    movId[i] = data[i].movid;
                    existenciaMaterialFinal[i] = cantidadCompra[i] + existenciaMaterial[i];
                  }
                  // console.log("cantidadCompra: ", cantidadCompra);
                  // console.log("idMaterial: ", idMaterial);//need
                  // console.log("existenciaMaterial: ", existenciaMaterial);
                  // console.log("idprove: ", idprove);
                  // console.log("adeudo: ", adeudo);
                  // console.log("txtTotal: ", txtTotal);
                  // console.log("movId: ", movId);//need
                  //
                  // console.log("aduedoFinal: ", aduedoFinal);//need
                  // console.log("existenciaMaterialFinal: ", existenciaMaterialFinal);//need

                  var datos_material = ""
                  datos_material = new FormData();
                  var total_money = aduedoFinal;

                  for (var i = 0; i < movId.length; i++) {
                    var total = existenciaMaterialFinal[i];
                    var idMa = idMaterial[i];
                    var tipo_mov = movId[i];
                    datos_material.append("_token", token);
                    datos_material.append("idUsuario", "1");
                    datos_material.append("total", total);
                    datos_material.append("Tipo_mov", "1");
                    datos_material.append("Cantidad", txtTotal);
                    datos_material.append("total_money", total_money);
                    datos_material.append("Estado", "2");

                    $.ajax({
                        type: 'POST',
                        processData: false,
                        contentType: false,
                        cache: false,
                        data: datos_material,
                        dataType: false,
                        enctype: 'multipart/form-data',
                        url: base_url+'/inventario/orden_compra/modificar_material/'+idMa+'/'+tipo_mov+'/'+idprove+'/'+idCompra,
                        success: function(msg){
                            var data = JSON.parse(msg)
                            // console.log("data mod: ", data);
                            if(data == 0){

                              url = base_url+'/inventario/orden_compra/modificar/'+id;
                              mensaje = "La orden de compra ha sido actualizado con éxito";
                              titulo = "Actualizar orden de compra";

                              var datos_material = ""
                              datos_material = new FormData();
                              datos_material.append("_token", token);
                              datos_material.append("idUsuario", "1");

                              var num_notaModificar =  $("#num_notaModificar").val();
                              var id_estado = $('input:radio[name=Estado_ModificarOrden]:checked').val();
                              var tipo = $("#select_proCompra").val();

                              datos_material.append("num_notaModificar",num_notaModificar);
                              datos_material.append("Estado_Compra", id_estado);
                              datos_material.append("ProveedorSelect",tipo);

                              $.ajax({
                                  type: 'POST',
                                  processData: false,
                                  contentType: false,
                                  cache: false,
                                  data: datos_material,
                                  dataType: false,
                                  enctype: 'multipart/form-data',
                                  url: url,
                                  success: function(msg){
                                      Swal.close()
                                      var data = JSON.parse(msg)
                                      // console.log("data a: ", data);
                                      if(data == 0){
                                          $('#modal_modificar_ordenCompra').modal('hide')
                                          // swal(titulo, mensaje, "success");
                                          alerta_temporizador(
                                              'success',
                                              'Actualizar orden de compra',
                                              'La orden de compra ha sido actualizado con éxito',
                                              2000
                                          );
                                          tablaOrdenCompra(0,"#tabla_curso");
                                          tablaOrdenCompra(1,"#tabla_recibido");
                                          tablaOrdenCompra(2,"#tabla_cancelado");
                                          tablaOrdenCompra(3,"#tabla_pagado");

                                          //limpiar campos
                                          $("#num_notaModificar").val("");
                                          $("#TotalModificarCompra").val("");
                                          $("#cantidadOrdenCompraModificar").val("");
                                          $("#select_CompraMaterialModificar").val("0");
                                          $("#select_proveedorCompra").val("0");
                                      }else{
                                          // swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
                                          Swal.close()
                                          alerta_temporizador(
                                              'error',
                                              'Actualizar orden de compra',
                                              'Ha ocurrido un error, inténtelo más tarde.',
                                              2000
                                          );
                                          //limpiar campos
                                          $("#num_notaModificar").val("");
                                          $("#TotalModificarCompra").val("");
                                          $("#cantidadOrdenCompraModificar").val("");
                                          $("#select_CompraMaterialModificar").val("0");
                                          $("#select_proveedorCompra").val("0");
                                      }
                                  }, error: function(error) {
                                          // swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
                                          Swal.close()
                                          alerta_temporizador(
                                              'error',
                                              'Actualizar orden de compra',
                                              'Ha ocurrido un error, inténtelo más tarde.',
                                              2000
                                          );
                                          //limpiar campos
                                          $("#num_notaModificar").val("");
                                          $("#TotalModificarCompra").val("");
                                          $("#cantidadOrdenCompraModificar").val("");
                                          $("#select_CompraMaterialModificar").val("0");
                                          $("#select_proveedorCompra").val("0");
                                  }
                              });

                            }else{
                                // swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
                                Swal.close()
                                alerta_temporizador(
                                    'error',
                                    'Actualizar orden de compra',
                                    'Ha ocurrido un error, inténtelo más tarde.',
                                    2000
                                );
                            }
                        }, error: function(error) {
                            // swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
                            Swal.close()
                            alerta_temporizador(
                                'error',
                                'Actualizar orden de compra',
                                'Ha ocurrido un error, inténtelo más tarde.',
                                2000
                            );
                        }
                    });

                  }

                }, error: function(error) {
                    // swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
                    Swal.close()
                    alerta_temporizador(
                        'error',
                        'Actualizar orden de compra',
                        'Ha ocurrido un error, inténtelo más tarde.',
                        2000
                    );
                }
           });
        }
      })

  }else if(total_m ==0){
    url = base_url+'/inventario/orden_compra/modificar/'+id;
    mensaje = "La orden de compra ha sido actualizado con éxito";
    titulo = "Actualizar orden de compra";

    var datos_material = ""
    datos_material = new FormData();
    datos_material.append("_token", token);
    datos_material.append("idUsuario", "1");

    var num_notaModificar =  $("#num_notaModificar").val();
    var id_estado = $('input:radio[name=Estado_ModificarOrden]:checked').val();
    var tipo = $("#select_proCompra").val();

    datos_material.append("num_notaModificar",num_notaModificar);
    datos_material.append("Estado_Compra", id_estado);
    datos_material.append("ProveedorSelect",tipo);

    Swal.fire({
    onOpen: function (){
      Swal.showLoading()
      $.ajax({
          type: 'POST',
          processData: false,
          contentType: false,
          cache: false,
          data: datos_material,
          dataType: false,
          enctype: 'multipart/form-data',
          url: url,
          success: function(msg){
              Swal.close()
              var data = JSON.parse(msg)
              // console.log("data a: ", data);
              if(data == 0){
                  $('#modal_modificar_ordenCompra').modal('hide')
                  // swal(titulo, mensaje, "success");
                  alerta_temporizador(
                          'success',
                          'Actualizar orden de compra',
                          'La orden de compra ha sido actualizado con éxito',
                          2000
                  );
                  tablaOrdenCompra(0,"#tabla_curso");
                  tablaOrdenCompra(1,"#tabla_recibido");
                  tablaOrdenCompra(2,"#tabla_cancelado");
                  tablaOrdenCompra(3,"#tabla_pagado");

                  //limpiar campos
                  $("#num_notaModificar").val("");
                  $("#TotalModificarCompra").val("");
                  $("#cantidadOrdenCompraModificar").val("");
                  $("#select_CompraMaterialModificar").val("0");
                  $("#select_proveedorCompra").val("0");
              }else{
                  // swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
                  Swal.close()
                  alerta_temporizador(
                          'error',
                          'Actualizar orden de compra',
                          'Ha ocurrido un error, inténtelo más tarde.',
                          2000
                  );
                  //limpiar campos
                  $("#num_notaModificar").val("");
                  $("#TotalModificarCompra").val("");
                  $("#cantidadOrdenCompraModificar").val("");
                  $("#select_CompraMaterialModificar").val("0");
                  $("#select_proveedorCompra").val("0");
              }
          }, error: function(error) {
                  // swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
                  Swal.close()
                  alerta_temporizador(
                          'error',
                          'Actualizar orden de compra',
                          'Ha ocurrido un error, inténtelo más tarde.',
                          2000
                  );
                  //limpiar campos
                  $("#num_notaModificar").val("");
                  $("#TotalModificarCompra").val("");
                  $("#cantidadOrdenCompraModificar").val("");
                  $("#select_CompraMaterialModificar").val("0");
                  $("#select_proveedorCompra").val("0");
          }
       });
      }
    })

  }else {
    // swal("Error", "No se permite esa accion ", "error");
    Swal.close()
    alerta_temporizador(
            'error',
            'Actualizar orden de compra',
            'Ha ocurrido un error, inténtelo más tarde.',
            2000
    );
    $("#TotalModificarCompra").val("");
  }

  }else {
    // swal("Error", "Por favor llenar todos los campos", "error");
    alerta_temporizador(
            'error',
            'Actualizar orden de compra',
            'Por favor llenar todos los campos',
            2000
    );
  }

}

//Funcion para pagar compras al proveedor
function pagarCompra() {
  var bandera_validar=0;

  var tipo = $("#select_PagarCompra").val();

  if (tipo == 1) {

    if($("#factura").val().length == 0){
        validation($("#factura"), $("#factura").parent());
        bandera_validar = bandera_validar +1;
    }

    if($("#txtCheque").val().length == 0){
        validation($("#txtCheque"), $("#txtCheque").parent());
        bandera_validar = bandera_validar +1;
    }

    // if($("#txtTotal").val().length == 0){
    //     validation($("#txtTotal"), $("#txtTotal").parent());
    //     bandera_validar = bandera_validar +1;
    // }

    if($("#select_proveedorCompraPagar").val() == 0){
        validation($("#select_proveedorCompraPagar"), $("#select_proveedorCompraPagar").parent());
        bandera_validar = bandera_validar +1;
    }

    if($("#select_OrdenCompras").val() == 0){
        validation($("#select_OrdenCompras"), $("#select_OrdenCompras").parent());
        bandera_validar = bandera_validar +1;
    }
  }else if (tipo == 2) {

    if($("#factura").val().length == 0){
        validation($("#factura"), $("#factura").parent());
        bandera_validar = bandera_validar +1;
    }

    // if($("#txtTotal").val().length == 0){
    //     validation($("#txtTotal"), $("#txtTotal").parent());
    //     bandera_validar = bandera_validar +1;
    // }

    if($("#select_proveedorCompraPagar").val() == 0){
        validation($("#select_proveedorCompraPagar"), $("#select_proveedorCompraPagar").parent());
        bandera_validar = bandera_validar +1;
    }

    if($("#select_OrdenCompras").val() == 0){
        validation($("#select_OrdenCompras"), $("#select_OrdenCompras").parent());
        bandera_validar = bandera_validar +1;
    }
  }

  if (bandera_validar == 0) {
    var temp = $("#select_OrdenCompras").val();
    var idPro = $("#select_proveedorCompraPagar").val();
    if ($("#txtCheque").val() == undefined) {
      var n_cheque = "";
    }else {
      var n_cheque = $("#txtCheque").val();
    }
    var total = parseInt($("#txtTotal").val());

    Swal.fire({
     onOpen: function (){
      Swal.showLoading()
      $.ajax({
      type: "GET",
      dataType: "json",
      enctype: "multipart/form-data",
      url: base_url+'/inventario/orden_compra/proveedor_adeudo/'+ idPro,
      success: function (msg) {
              var data = JSON.parse(msg)
              var adeudo_sobrante = data[0].Adeudo;
              // adeudo_sobrante = adeudo_sobrante - total;

              datos_pagarOrden = new FormData();
              datos_pagarOrden.append("_token", token);
              datos_pagarOrden.append("idUsuario", "1");

              // datos_pagarOrden.append("adeudo_sobrante", adeudo_sobrante);
              datos_pagarOrden.append("Total", total);
              datos_pagarOrden.append("Fecha", "2019-07-26");
              datos_pagarOrden.append("Tipo_Pago", tipo);
              datos_pagarOrden.append("Num_cheque", n_cheque);

              var url = "";
              url = base_url+'/inventario/orden_compra/insertar_pago_proveedor/'+ idPro;
              var mensaje = "Se a completado el pago con éxito";
              var titulo = "Pago de compras";

              $.ajax({
                  type: 'POST',
                  processData: false,
                  contentType: false,
                  cache: false,
                  data: datos_pagarOrden,
                  dataType: false,
                  enctype: 'multipart/form-data',
                  url: url,
                  success: function(msg){
                      var data = JSON.parse(msg)
                      // console.log("data inser: " , data);
                      if(data == 0){

                          //Para cambiar el estado a las ordenes de compras
                          var datos_ordenCompra = ""
                          datos_ordenCompra = new FormData();
                          datos_ordenCompra.append("idUsuario", "1");
                          datos_ordenCompra.append("_token", token);
                          datos_ordenCompra.append("Estado_Compra", "4");
                          var factura = $("#factura").val();
                          datos_ordenCompra.append("Factura", factura);

                          var hasta = temp.length;
                          // console.log("hasta: ", hasta);
                          for (var i = 0; i < temp.length; i++) {
                            var idO = temp[i];
                              $.ajax({
                                  type: 'POST',
                                  processData: false,
                                  contentType: false,
                                  cache: false,
                                  data: datos_ordenCompra,
                                  dataType: false,
                                  enctype: 'multipart/form-data',
                                  url: base_url+'/inventario/orden_compra/eliminarorden/'+idO,
                                  success: function(msg){
                                      Swal.close()
                                      var data = JSON.parse(msg)
                                      // console.log("data change: ", data);
                                      if(data == 0){

                                              // console.log("here");
                                              $('#modal_pagar_ordenCompra').modal('hide')
                                              // swal(titulo, mensaje, "success");
                                              alerta_temporizador(
                                                  'success',
                                                  'Pago de compras',
                                                  'Se a completado el pago con éxito',
                                                  2000
                                              );
                                              tablaOrdenCompra(0,"#tabla_curso");
                                              tablaOrdenCompra(1,"#tabla_recibido");
                                              tablaOrdenCompra(2,"#tabla_cancelado");
                                              tablaOrdenCompra(3,"#tabla_pagado");

                                              //limpiar campos
                                              $("#txtCheque").val("");
                                              $("#txtTotal").val("");
                                              $("#select_proveedorCompraPagar").val("0");
                                              $("#select_OrdenCompras").val("0");

                                      }else{
                                          // swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
                                          Swal.close()
                                          alerta_temporizador(
                                              'error',
                                              'Pago de compras',
                                              'Ha ocurrido un error, inténtelo más tarde.',
                                              2000
                                          );
                                          //limpiar campos
                                          $("#txtCheque").val("");
                                          $("#txtTotal").val("");
                                          $("#select_proveedorCompraPagar").val("0");
                                          $("#select_OrdenCompras").val("0");
                                      }
                                  }, error: function(error) {
                                      // swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
                                      Swal.close()
                                      alerta_temporizador(
                                          'error',
                                          'Pago de compras',
                                          'Ha ocurrido un error, inténtelo más tarde.',
                                          2000
                                      );
                                      //limpiar campos
                                      $("#txtCheque").val("");
                                      $("#txtTotal").val("");
                                      $("#select_proveedorCompraPagar").val("0");
                                      $("#select_OrdenCompras").val("0");
                                  }
                              });
                          }

                      }else{
                          // swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
                          Swal.close()
                          alerta_temporizador(
                              'error',
                              'Pago de compras',
                              'Ha ocurrido un error, inténtelo más tarde.',
                              2000
                          );
                          //limpiar campos
                          $("#txtCheque").val("");
                          $("#txtTotal").val("");
                          $("#select_proveedorCompraPagar").val("0");
                          $("#select_OrdenCompras").val("0");
                      }
                  }, error: function(error) {
                      // console.log("no success");
                          // swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
                          Swal.close()
                          alerta_temporizador(
                              'error',
                              'Pago de compras',
                              'Ha ocurrido un error, inténtelo más tarde.',
                              2000
                          );
                          //limpiar campos
                          $("#txtCheque").val("");
                          $("#txtTotal").val("");
                          $("#select_proveedorCompraPagar").val("0");
                          $("#select_OrdenCompras").val("0");
                  }
              });

            }, error: function(error) {
                Swal.close()
                // alerta_temporizador(
                //     'error',
                //     'Nuevo material',
                //     'Ha ocurrido un error, inténtelo más tarde.',
                //     2500
                // );
            }
       });
      }
    })

  }
}

//Funcion para crear y cargar los datos a la tabla
function tablaOrdenCompra(){
  Swal.fire({
    onOpen: function (){
      Swal.showLoading()
      $.ajax({
  		type: "GET",
  		dataType: "json",
  		enctype: "multipart/form-data",
  		url: base_url+'/inventario/orden_compra/lista',
  		success: function (msg) {

              var data = JSON.parse(msg)
  			      // console.log("datos: " , data);

              var html_tabla_curso = "";
              var html_tabla_recibido = "";
              var html_tabla_cancelado = "";
              var html_tabla_pagado = "";

              $("#tabla_curso").DataTable().clear();
              $("#tabla_curso").DataTable().destroy();

              $("#tabla_recibido").DataTable().clear();
              $("#tabla_recibido").DataTable().destroy();

              $("#tabla_cancelado").DataTable().clear();
              $("#tabla_cancelado").DataTable().destroy();

              $("#tabla_pagado").DataTable().clear();
              $("#tabla_pagado").DataTable().destroy();

              for (var i = 0; i < data.length; i++) {
                  //En curso
                  if(data[i].Estado == 1){
                    html_tabla_curso+=
                    `<tr>
                        <td>${data[i].Num_nota}</td>
                        <td>${data[i].Fecha}</td>
                        <td>${data[i].Proveedor}</td>
                        <td class="text-nowrap" data-material="${data[i].id}">
                            <a href="#" class="modificarOrdenCompra" data-toggle="tooltip" data-original-title="Modificar"><i class="icon-pencil text m-r-10"></i></a>
                            <a href="#" class="eliminarOrdenCompra" data-toggle="tooltip" data-original-title="Cancelar"> <i class="icon-close text-danger m-r-10"></i></a>
                            <a href="#" class="detalleOrdenCompra" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye "></i> </a>
                        </td>
                    </tr>`;
                  }else if(data[i].Estado == 2){
                    html_tabla_recibido+=
                    `<tr>
                        <td>${data[i].Num_nota}</td>
                        <td>${data[i].Fecha}</td>
                        <td>${data[i].Proveedor}</td>
                        <td class="text-nowrap" data-material="${data[i].id}">
                        <a href="#" class="detalleOrdenCompra" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye "></i> </a>
                        </td>
                    </tr>`;
                  }else if (data[i].Estado == 3) {
                    html_tabla_cancelado+=
                    `<tr>
                        <td>${data[i].Num_nota}</td>
                        <td>${data[i].Fecha}</td>
                        <td>${data[i].Proveedor}</td>
                        <td class="text-nowrap" data-material="${data[i].id}">
                        <a href="#" class="detalleOrdenCompra" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye "></i> </a>
                        </td>
                    </tr>`;
                  }else if (data[i].Estado == 4) {
                    html_tabla_pagado+=
                    `<tr>
                        <td>${data[i].Num_nota}</td>
                        <td>${data[i].Fecha}</td>
                        <td>${data[i].Proveedor}</td>
                        <td class="text-nowrap" data-material="${data[i].id}">
                        <a href="#" class="detalleOrdenCompra" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye "></i> </a>
                        </td>
                    </tr>`;
                  }
              }
              $("#tabla_curso tbody").empty().append(html_tabla_curso);
              $('#tabla_curso').DataTable({
                dom: 'Bfrtip',
                buttons: ['excel', 'pdf', 'print']
              });

              $("#tabla_recibido tbody").empty().append(html_tabla_recibido);
              $('#tabla_recibido').DataTable({
                dom: 'Bfrtip',
                buttons: ['excel', 'pdf', 'print']
              });

              $("#tabla_cancelado tbody").empty().append(html_tabla_cancelado);
              $('#tabla_cancelado').DataTable({
                dom: 'Bfrtip',
                buttons: ['excel', 'pdf', 'print']
              });

              $("#tabla_pagado tbody").empty().append(html_tabla_pagado);
              $('#tabla_pagado').DataTable({
                dom: 'Bfrtip',
                buttons: ['excel', 'pdf', 'print']
              });

              $("body").tooltip({ selector: '[data-toggle="tooltip"]' });
              Swal.close()
  		}
  	});
    }
  })
}

//Funcion para ejecuar cuando se carga este script
$(document).ready(function () {
	tablaOrdenCompra();
  $(".select2").select2();
  // SOLO NÚMEROS
    $('body').on('input', ".input-number", function(e){
      this.value = this.value.replace(/[^0-9]/g,'');
    });
});

function alerta_temporizador(tipo, titulo, texto, tiempo) {
    Swal.fire({
        type: tipo,
        title: titulo,
        text: texto,
        showConfirmButton: false,
        timer: tiempo
    });
}

//Validacion de los campos
$("#cantidadOrdenCompra").on('input',function(e){
    validation($(this), $(this).parent())
});
$("#num_nota").on('input',function(e){
    validation($(this), $(this).parent())
});
$("#TotalModificarCompra").on('input',function(e){
    validation($(this), $(this).parent())
});
$("#txtCheque").on('input',function(e){
    validation($(this), $(this).parent())
});
$("#txtTotal").on('input',function(e){
    validation($(this), $(this).parent())
});
$('body').on('change', "#select_CompraMaterial", function(e){
    validation($(this), $(this).parent())
    validation($("#validar").val("1"), $("#cantidadOrdenCompra").parent());
    validation($("#validar").val("1"), $("#num_nota").parent());
});
$('body').on('change', "#select_CompraProveedor", function(e){
  validation($(this), $(this).parent())
  validation($("#validar").val("1"), $("#cantidadOrdenCompra").parent());
  validation($("#validar").val("1"), $("#num_nota").parent());
});
$('body').on('change', "#select_OrdenCompras", function(e){
  var tipo =  $("#select_OrdenCompras").val();
  // console.log("tipo: ", tipo);
  if (tipo.length == 0) {
    $("#txtTotal").val(0);
  }
  var temporal = 0;
  var total = 0;
  for (var i = 0; i < tipo.length; i++) {
      var id = tipo[i];
      $.ajax({
      type: "GET",
      dataType: "json",
      enctype: "multipart/form-data",
      url: base_url+'/inventario/orden_compra/cantidad_compras/'+id,
      success: function (msg) {
              var data = JSON.parse(msg)
              // console.log("data: ", data[0].Cantidad);
              var cantidad = data[0].Cantidad;
              total = total + cantidad;
              $("#txtTotal").val(total);
              // console.log("total: ", total);
            }
       });
  }
});
