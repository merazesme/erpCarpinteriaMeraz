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
$('#boton_agregarProducto').on("click", function(e){
  $("#totalMateriaPrima").val(0);
  $("#totalMateriaPrimaFinal").val(0);
  $("#txtDescripcionProductos").val("");
  $("#txtCostosAdicionales").val("");
  cargarDatosModalAgregarProducto();
})

//Accion para modificar producto
$('#tabla_productosActivos').on("click",".modificarProducto", function(e){
  var idP = $(this).parent().attr("data-material");
  console.log("idp: ", idP);
  // validation($("#validar").val("1"), $("#txtDescripcionModificar").parent());
  // validation($("#validar").val("1"), $("#txtNotaOrdenSalidaModificar").parent());
  e.preventDefault();

 $.ajax({
 type: "GET",
 dataType: "json",
 enctype: "multipart/form-data",
 url: base_url+'/productos/lista_matprima',
 success: function (msg) {
         var data = JSON.parse(msg)
         // console.log(data);
         var html = "";
         $('.select2').remove();
         html+=
         `<label for="recipient-name" class="control-label">Materia prima <span class="danger">*</label>
         <select id="select_materiaPrimaModificar" class="select2 m-b-10 select2-multiple" style="width: 100%;" multiple="multiple" data-placeholder="Seleccione">
         </select>`;
         $("#materiaprimaModificar").empty().append(html);
         var html = "";
         var html2 = "";
         $(".select2").select2();
         for (var i = 0; i < data.length; i++) {
             html+=
             `<option value="${data[i].id}">
               <font style="vertical-align: inherit;">${data[i].Descripcion}</font>
             </option>`;
         }

         $.ajax({
         type: "GET",
         dataType: "json",
         enctype: "multipart/form-data",
         url: base_url+'/productos/IVA',
         success: function (msg) {
                 var data = JSON.parse(msg)
                 var iva = data[0].IVA;

                 $.ajax({
                 type: "GET",
                 dataType: "json",
                 enctype: "multipart/form-data",
                 url: base_url+'/productos/lista_productos_especifico/'+idP,
                 success: function (msg) {
                         var data = JSON.parse(msg);
                         // console.log("data: ", data);
                         $("#select_materiaPrimaModificar").empty().append(html);

                         var matid = [];
                         var id;
                         for (var i = 0; i < data.length; i++) {
                           id = data[i].Mateid.toString();
                           // console.log("id: ", id);
                           matid.push(id);
                         }

                         // console.log("matid: ", matid);
                         $('#select_materiaPrimaModificar').val(matid).trigger('change');;


                         $("#txtDescripcionProductosModificar").val(data[0].Descripcion);
                         $("#txtCostosAdicionalesModificar").val(data[0].Costo_adicional);
                         $("#totalMateriaPrimaModificar").val(data[0].Subtotal);
                         $("#totalMateriaPrimaFinalModificar").val(data[0].Total);

                         $('#modal_modificar_productos').modal('show');
                         $("#actionAgregarProductoModificar").attr("onclick", "modificarProducto("+iva+","+idP+")");
                       }
                  });

               }
         });

       }
 });
})
$('#tabla_productosActivos').on("click",".eliminarProducto", function(e) {
  var id = $(this).parent().attr("data-material");
  e.preventDefault();

  mensaje = "El producto se ha eliminado con éxito";
  titulo = "Eliminar producto";
  swal({
      title: "¿Deseas eliminar el producto?",
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
        var datos_productos_cancel = ""
        datos_productos_cancel = new FormData();
        datos_productos_cancel.append("idUsuario", "1");
        datos_productos_cancel.append("_token", token);
        datos_productos_cancel.append("Estado", "0");

        $.ajax({
            type: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            data: datos_productos_cancel,
            dataType: false,
            enctype: 'multipart/form-data',
            url: base_url+'/productos/cancelar_producto/'+id,
            success: function(msg){
                var data = JSON.parse(msg)
                console.log("data update_Existencia: " , data);
                if(data >= 0){

                  swal("Eliminado", mensaje, "success");
                  tablaProductos(0,"#tabla_productosActivos");
                  tablaProductos(1,"#tabla_productosCancelados");

                }else{
                    swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
                    //limpiar campos
                }
            }, error: function(error) {
                swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
                //limpiar campos
            }
        });
      }
  });
})

//Funcion para cargar los datos de agregar nuevo producto
function cargarDatosModalAgregarProducto() {

  $.ajax({
  type: "GET",
  dataType: "json",
  enctype: "multipart/form-data",
  url: base_url+'/productos/lista_matprima',
  success: function (msg) {
          var data = JSON.parse(msg)
          // console.log(data);
          var html = "";
          $('.select2').remove();
          html+=
          `<label for="recipient-name" class="control-label">Materia prima <span class="danger">*</label>
          <select id="select_materiaPrima" class="select2 m-b-10 select2-multiple" style="width: 100%;" multiple="multiple" data-placeholder="Seleccione">
          </select>`;
          $("#materiaprima").empty().append(html);
          var html = "";
          var html2 = "";
          $(".select2").select2();
          for (var i = 0; i < data.length; i++) {
              html+=
              `<option value="${data[i].id}">
                <font style="vertical-align: inherit;">${data[i].Descripcion}</font>
              </option>`;
          }

          $.ajax({
          type: "GET",
          dataType: "json",
          enctype: "multipart/form-data",
          url: base_url+'/productos/IVA',
          success: function (msg) {
                  var data = JSON.parse(msg)
                  var iva = data[0].IVA;

                  $("#select_materiaPrima").empty().append(html);
                  $("#valores").empty().append(html);
                  $('#modal_agregar_productos').modal('show');
                  $("#actionAgregarProducto").attr("onclick", "nuevoProducto("+iva+")");
                }
          });

        }
  });
}

//Funcion para agregar nuevo producto
function nuevoProducto(iva) {
  var bandera_validar=0;

  if($("#txtDescripcionProductos").val().length == 0){
      validation($("#txtDescripcionProductos"), $("#txtDescripcionProductos").parent());
      bandera_validar = bandera_validar +1;
  }

  if($("#select_materiaPrima").val() == 0){
      validation($("#select_materiaPrima"), $("#select_materiaPrima").parent());
      bandera_validar = bandera_validar +1;
  }

  if($("#txtCostosAdicionales").val().length == 0){
      validation($("#txtCostosAdicionales"), $("#txtCostosAdicionales").parent());
      bandera_validar = bandera_validar +1;
  }

  if (bandera_validar == 0) {

    console.log("");

    var d = new Date();
    var month = d.getMonth()+1;
    var day = d.getDate();
    var output = d.getFullYear() + '-' +
    (month<10 ? '0' : '') + month + '-' +
    (day<10 ? '0' : '') + day;
    var fecha = output;
    var idUsuario = 1;

    var datos_productos= "";
    datos_productos = new FormData();
    datos_productos.append("_token", token);


    //Para la tabla orden de salida
    var descripcion = $("#txtDescripcionProductos").val();
    var materiaPrima = $("#select_materiaPrima").val();
    var subtotal = $("#totalMateriaPrima").val();
    var costo_adicional = $("#txtCostosAdicionales").val();
    var total = $("#totalMateriaPrimaFinal").val();

    // var Trabajadores_idTrabajadore = $("#select_trabajadorOrdenSalida").val();
    datos_productos.append("Descripcion", descripcion);
    datos_productos.append("Subtotal", subtotal);
    datos_productos.append("Costo_adicional", costo_adicional);
    datos_productos.append("IVA", iva);
    datos_productos.append("Total", total);
    datos_productos.append("idUsuario", idUsuario);
    datos_productos.append("Fecha", fecha);
    datos_productos.append("Estado", "1");

    var mensaje = "El nuevo producto se a agregado con éxito";
    var titulo = "Nuevo producto";

    $.ajax({
        type: 'POST',
        processData: false,
        contentType: false,
        cache: false,
        data: datos_productos,
        dataType: false,
        enctype: 'multipart/form-data',
        url: base_url+'/productos/nuevo_producto',
        success: function(msg){
            var data = JSON.parse(msg)
            idProducto = data;

            for (var i = 0; i < materiaPrima.length; i++) {
              var idMatePrima = materiaPrima[i];

              var datos_productos_prima= "";
              datos_productos_prima = new FormData();
              datos_productos_prima.append("_token", token);

              datos_productos_prima.append("Productos_idProducto", idProducto);
              datos_productos_prima.append("Materia_prima_idMateria_prima", idMatePrima);
              datos_productos_prima.append("idUsuario", idUsuario);

              $.ajax({
                  type: 'POST',
                  processData: false,
                  contentType: false,
                  cache: false,
                  data: datos_productos_prima,
                  dataType: false,
                  enctype: 'multipart/form-data',
                  url: base_url+'/productos/nuevo_producto_prima',
                  success: function(msg){
                      var data = JSON.parse(msg)

                      $('#modal_agregar_productos').modal('hide')
                      swal(titulo, mensaje, "success");
                      tablaProductos(0,"#tabla_productosActivos");
                      tablaProductos(1,"#tabla_productosCancelados");

                      //limpiar campos
                      $("#totalMateriaPrima").val(0);
                      $("#totalMateriaPrimaFinal").val(0);
                      $("#txtDescripcionProductos").val("");
                      $("#txtCostosAdicionales").val("");

                  }, error: function(error) {
                      swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
                      //limpiar campos
                      $("#totalMateriaPrima").val(0);
                      $("#totalMateriaPrimaFinal").val(0);
                      $("#txtDescripcionProductos").val("");
                      $("#txtCostosAdicionales").val("");
                  }
              });

            }

        }, error: function(error) {
            swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
            //limpiar campos
            $("#totalMateriaPrima").val(0);
            $("#totalMateriaPrimaFinal").val(0);
            $("#txtDescripcionProductos").val("");
            $("#txtCostosAdicionales").val("");
        }
    });

  }else {
    swal("Error", "Por favor llenar todos los campos", "error");
  }

}

//Funcion para modificar producto
function modificarProducto(iva,idP) {
  var bandera_validar=0;
  // console.log("id, ", idP);
  if($("#txtDescripcionProductosModificar").val().length == 0){
      validation($("#txtDescripcionProductosModificar"), $("#txtDescripcionProductosModificar").parent());
      bandera_validar = bandera_validar +1;
  }

  if($("#select_materiaPrimaModificar").val() == 0){
      validation($("#select_materiaPrimaModificar"), $("#select_materiaPrimaModificar").parent());
      bandera_validar = bandera_validar +1;
  }

  if($("#txtCostosAdicionalesModificar").val().length == 0){
      validation($("#txtCostosAdicionalesModificar"), $("#txtCostosAdicionalesModificar").parent());
      bandera_validar = bandera_validar +1;
  }

  if (bandera_validar == 0) {

    var idUsuario = 1;

    var datos_productos_modificar= "";
    datos_productos_modificar = new FormData();
    datos_productos_modificar.append("_token", token);


    //Para la tabla orden de salida
    var descripcion = $("#txtDescripcionProductosModificar").val();
    var materiaPrima = $("#select_materiaPrimaModificar").val();
    var subtotal = $("#totalMateriaPrimaModificar").val();
    var costo_adicional = $("#txtCostosAdicionalesModificar").val();
    var total = $("#totalMateriaPrimaFinalModificar").val();

    // var Trabajadores_idTrabajadore = $("#select_trabajadorOrdenSalida").val();
    datos_productos_modificar.append("Descripcion", descripcion);
    datos_productos_modificar.append("Subtotal", subtotal);
    datos_productos_modificar.append("Costo_adicional", costo_adicional);
    datos_productos_modificar.append("IVA", iva);
    datos_productos_modificar.append("Total", total);
    datos_productos_modificar.append("idUsuario", idUsuario);
    datos_productos_modificar.append("Fecha", fecha);
    datos_productos_modificar.append("Estado", "1");

    var mensaje = "El nuevo producto se a agregado con éxito";
    var titulo = "Nuevo producto";

    $.ajax({
        type: 'POST',
        processData: false,
        contentType: false,
        cache: false,
        data: datos_productos_modificar,
        dataType: false,
        enctype: 'multipart/form-data',
        url: base_url+'/productos/modificar_producto/'+idP,
        success: function(msg){
            var data = JSON.parse(msg)
            idProducto = data;

            for (var i = 0; i < materiaPrima.length; i++) {
              var idMatePrima = materiaPrima[i];

              var datos_productos_prima_modificar= "";
              datos_productos_prima_modificar = new FormData();
              datos_productos_prima_modificar.append("_token", token);

              datos_productos_prima_modificar.append("Productos_idProducto", idProducto);
              datos_productos_prima_modificar.append("Materia_prima_idMateria_prima", idMatePrima);
              datos_productos_prima_modificar.append("idUsuario", idUsuario);

              $.ajax({
                  type: 'POST',
                  processData: false,
                  contentType: false,
                  cache: false,
                  data: datos_productos_prima_modificar,
                  dataType: false,
                  enctype: 'multipart/form-data',
                  url: base_url+'/productos/nuevo_producto_prima',
                  success: function(msg){
                      var data = JSON.parse(msg)

                      $('#modal_agregar_productos').modal('hide')
                      swal(titulo, mensaje, "success");
                      tablaProductos(0,"#tabla_productosActivos");
                      tablaProductos(1,"#tabla_productosCancelados");

                      //limpiar campos
                      $("#totalMateriaPrima").val(0);
                      $("#totalMateriaPrimaFinal").val(0);
                      $("#txtDescripcionProductos").val("");
                      $("#txtCostosAdicionales").val("");

                  }, error: function(error) {
                      swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
                      //limpiar campos
                      $("#totalMateriaPrima").val(0);
                      $("#totalMateriaPrimaFinal").val(0);
                      $("#txtDescripcionProductos").val("");
                      $("#txtCostosAdicionales").val("");
                  }
              });

            }

        }, error: function(error) {
            swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
            //limpiar campos
            $("#totalMateriaPrima").val(0);
            $("#totalMateriaPrimaFinal").val(0);
            $("#txtDescripcionProductos").val("");
            $("#txtCostosAdicionales").val("");
        }
    });

  }
}

//Funcion para crear y cargar los datos a la tabla
function tablaProductos(){
    $.ajax({
		type: "GET",
		dataType: "json",
		enctype: "multipart/form-data",
		url: base_url+'/productos/lista_productos',
		success: function (msg) {

            var data = JSON.parse(msg)
			      // console.log("datos: " , data);

            var tabla_productosActivos = "";
            var tabla_productosCancelados = "";

            $("#tabla_productosActivos").DataTable().clear();
            $("#tabla_productosActivos").DataTable().destroy();

            $("#tabla_productosCancelados").DataTable().clear();
            $("#tabla_productosCancelados").DataTable().destroy();

            for (var i = 0; i < data.length; i++) {
                if (data[i].Estado == 1) {
                  tabla_productosActivos+=
                  `<tr>
                      <td>${data[i].Descripcion}</td>
                      <td>${data[i].Fecha}</td>
                      <td>${data[i].Subtotal}</td>
                      <td>${data[i].Costo_adicional}</td>
                      <td>${data[i].IVA}</td>
                      <td>${data[i].Total}</td>
                      <td class="text-nowrap" data-material="${data[i].id}">
                          <a href="#" class="modificarProducto" data-toggle="tooltip" data-original-title="Modificar"><i class="icon-pencil text m-r-10"></i></a>
                          <a href="#" class="eliminarProducto" data-toggle="tooltip" data-original-title="Cancelar"> <i class="icon-close text-danger m-r-10"></i></a>
                          <a href="#" class="detalleProducto" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye "></i> </a>
                      </td>
                  </tr>`;
                }else if (data[i].Estado == 0) {
                  tabla_productosCancelados+=
                  `<tr>
                      <td>${data[i].Descripcion}</td>
                      <td>${data[i].Fecha}</td>
                      <td>${data[i].Subtotal}</td>
                      <td>${data[i].Costo_adicional}</td>
                      <td>${data[i].IVA}</td>
                      <td>${data[i].Total}</td>
                      <td class="text-nowrap" data-material="${data[i].id}">
                          <a href="#" class="detalleProducto" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye "></i> </a>
                      </td>
                  </tr>`;
                }
            }
            $("#tabla_productosActivos tbody").empty().append(tabla_productosActivos);
            $('#tabla_productosActivos').DataTable({
              dom: 'Bfrtip',
              buttons: ['excel', 'pdf', 'print']
            });
            $("#tabla_productosCancelados tbody").empty().append(tabla_productosCancelados);
            $('#tabla_productosCancelados').DataTable({
              dom: 'Bfrtip',
              buttons: ['excel', 'pdf', 'print']
            });
            $("body").tooltip({ selector: '[data-toggle="tooltip"]' });
		}
	});
}

$("#txtDescripcionProductos").on('input',function(e){
    validation($(this), $(this).parent())
});
$("#txtCostosAdicionales").on('input',function(e){
    validation($(this), $(this).parent())
    var total = 0;
    var costo = parseInt($("#txtCostosAdicionales").val());
    var total_mataprima = parseInt($("#totalMateriaPrima").val());
    if ($("#totalMateriaPrima").val().length == 0) {
      total_mataprima = 0;
    }

    $.ajax({
    type: "GET",
    dataType: "json",
    enctype: "multipart/form-data",
    url: base_url+'/productos/IVA',
    success: function (msg) {
            var data = JSON.parse(msg)
            var iva = data[0].IVA;

            total = costo + total_mataprima;
            var tanto = total * iva;
            var IVA = tanto / 100;
            total = total + IVA;
            $("#totalMateriaPrimaFinal").val(total);

          }
    });

});
$('body').on('change', "#select_materiaPrima", function(e){
  var tipo =  $("#select_materiaPrima").val();
  console.log("tipo: ", tipo);
  if (tipo.length == 0) {
    // $("#totalMateriaPrima").prop("value");
    $("#totalMateriaPrima").val(0);
  }
  var temporal = 0;
  var total = 0;

  $.ajax({
  type: "GET",
  dataType: "json",
  enctype: "multipart/form-data",
  url: base_url+'/productos/IVA',
  success: function (msg) {
          var data = JSON.parse(msg)
          var iva = data[0].IVA;

          for (var i = 0; i < tipo.length; i++) {
              var id = tipo[i];
              $.ajax({
              type: "GET",
              dataType: "json",
              enctype: "multipart/form-data",
              url: base_url+'/productos/lista_matprima_especifico/'+id,
              success: function (msg) {
                      var data = JSON.parse(msg)
                      var cantidad = data[0].Precio_por_unidad;
                      total = total + cantidad;
                      $("#totalMateriaPrima").val(total);

                      var totalA = 0;
                      var costoA = parseInt($("#txtCostosAdicionales").val());
                      totalA = costoA + total;
                      var tanto = totalA * iva;
                      var IVA = tanto / 100;
                      totalA = totalA + IVA;
                      $("#totalMateriaPrimaFinal").val(totalA);

                    }
               });
          }

        }
  });
});
$("#txtCostosAdicionales").on('input',function(e){
    validation($(this), $(this).parent())
    var total = 0;
    var costo = parseInt($("#txtCostosAdicionales").val());
    var total_mataprima = parseInt($("#totalMateriaPrima").val());
    if ($("#totalMateriaPrima").val().length == 0) {
      total_mataprima = 0;
    }

    $.ajax({
    type: "GET",
    dataType: "json",
    enctype: "multipart/form-data",
    url: base_url+'/productos/IVA',
    success: function (msg) {
            var data = JSON.parse(msg)
            var iva = data[0].IVA;

            total = costo + total_mataprima;
            var tanto = total * iva;
            var IVA = tanto / 100;
            total = total + IVA;
            $("#totalMateriaPrimaFinal").val(total);

          }
    });

});
$('body').on('change', "#select_materiaPrima", function(e){
  var tipo =  $("#select_materiaPrima").val();
  console.log("tipo: ", tipo);
  if (tipo.length == 0) {
    // $("#totalMateriaPrima").prop("value");
    $("#totalMateriaPrima").val(0);
  }
  var temporal = 0;
  var total = 0;

  $.ajax({
  type: "GET",
  dataType: "json",
  enctype: "multipart/form-data",
  url: base_url+'/productos/IVA',
  success: function (msg) {
          var data = JSON.parse(msg)
          var iva = data[0].IVA;

          for (var i = 0; i < tipo.length; i++) {
              var id = tipo[i];
              $.ajax({
              type: "GET",
              dataType: "json",
              enctype: "multipart/form-data",
              url: base_url+'/productos/lista_matprima_especifico/'+id,
              success: function (msg) {
                      var data = JSON.parse(msg)
                      var cantidad = data[0].Precio_por_unidad;
                      total = total + cantidad;
                      $("#totalMateriaPrima").val(total);

                      var totalA = 0;
                      var costoA = parseInt($("#txtCostosAdicionales").val());
                      totalA = costoA + total;
                      var tanto = totalA * iva;
                      var IVA = tanto / 100;
                      totalA = totalA + IVA;
                      $("#totalMateriaPrimaFinal").val(totalA);

                    }
               });
          }

        }
  });

  // for (var i = 0; i < tipo.length; i++) {
  //     var id = tipo[i];
  //     $.ajax({
  //     type: "GET",
  //     dataType: "json",
  //     enctype: "multipart/form-data",
  //     url: base_url+'/productos/lista_matprima_especifico/'+id,
  //     success: function (msg) {
  //             var data = JSON.parse(msg)
  //             var cantidad = data[0].Precio_por_unidad;
  //             total = total + cantidad;
  //             $("#totalMateriaPrima").val(total);
  //
  //             var totalA = 0;
  //             var costoA = parseInt($("#txtCostosAdicionales").val());
  //             totalA = costoA + total;
  //             var IVA = totalA * .16;
  //             totalA = totalA + IVA;
  //             $("#totalMateriaPrimaFinal").val(totalA);
  //
  //           }
  //      });
  // }
});

$(document).ready(function () {
	tablaProductos();
  $(".select2").select2();
});
