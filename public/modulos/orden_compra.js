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
  $("#num_nota").val("");
  $("#cantidadOrdenCompra").val("");
  $("#select_CompraMaterial").val("0");
  $("#select_CompraProveedor").val("0");
  cargarDatosModalAgregarCompra();
})

//Accion para abrir modal de pagar compras
$('#boton_pagarCompra').on("click", function(e) {
  // $("#select_CompraMaterial").empty().append(html);
  $("#agregarTituloPagarCompra").html("Pagar compra");
  $('#modal_pagar_ordenCompra').modal('show');
  $("#actionPagarCompra").attr("onclick", "pagarCompra()");

  $("#todo").empty();
  $("#select_PagarCompra").val("0");
  $("#select_OrdenCompras").val("0");
  $("#select_proveedorCompraPagar").val("0");

  $('#select_PagarCompra').on('change',function(e){
    var tipo = $("#select_PagarCompra").val();
    $('.select2').remove();
    if (tipo == 1) {
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
              <select id="select_OrdenCompras" class="select2 m-b-10 select2-multiple" style="width: 100%;" multiple="multiple" data-placeholder="Seleccione" disabled>
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
                <input type="text" class="form-control required" id="txtTotal" name="txtTotal">
            </div>
        </div>
      </div>`;

      $("#todo").empty().append(html);
      $(".select2").select2();
    }else if (tipo == 2) {
      var html = "";
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
              <select id="select_OrdenCompras" class="select2 m-b-10 select2-multiple" style="width: 100%;" multiple="multiple" data-placeholder="Seleccione" disabled>
              </select>
          </div>
        </div>
       </div>
       <div class="row">
          <div class="col-md-12">
            <div class="form-group">
                <label for="recipient-name" class="control-label">$Total <span class="danger">*</label>
                <input type="text" class="form-control required" id="txtTotal" name="txtTotal">
            </div>
        </div>
      </div>`;
      $("#todo").empty().append(html);
      $(".select2").select2();
    }else {
      $("#todo").empty();
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
                  if (data[i].estatus == 1) {
                    html+=
                    `<option value="${data[i].id}">
                      <font style="vertical-align: inherit;">${data[i].Nombre}</font>
                    </option>`;
                  }
                }

                $("#select_OrdenCompras").empty().append(html);
              }
         });
      }else {
        console.log("0");
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
  validation($("#validar").val("1"), $("#TotalModificarCompra").parent());
  $("#TotalModificarCompra").val("");
  var id = $(this).parent().attr("data-material");
  e.preventDefault();
  cargarDatosModalModificarCompra();
  $.ajax({
  type: "GET",
  dataType: "json",
  enctype: "multipart/form-data",
  url: base_url+'/inventario/orden_compra/especifico/'+id,
  success: function (msg) {
          var data = JSON.parse(msg)
          // console.log("ge: " , data);
          $("#select_proveedorCompra option[value="+ data[0].Proid +"]").attr("selected",true);
          $("#num_notaModificar").val(data[0].Num_nota);
          $("#cantidadOrdenCompraModificar").val(data[0].Cantidad);
          $("#select_CompraMaterialModificar option[value="+ data[0].MaterialesId +"]").attr("selected",true);
          if (data[0].Estado == 1) {
            $("#Estado_Curso").attr('checked', true);
          }else if(data[0].Estado == 2){
            $("#Estado_Recibido").attr('checked', true);
          }else if (data[0].Estado == 3) {
            $("#Estado_Cancelado").attr('checked', true);
          }
          $.ajax({
          type: "GET",
          dataType: "json",
          enctype: "multipart/form-data",
          url: base_url+'/inventario/orden_compra/especificomov/'+id,
          success: function (msg) {
                  var data = JSON.parse(msg)
                  // console.log("ge: " , data);
                  var idM = data[0].id

                  $("#agregarTituloModificarCompra").html("Modificar orden de compra");
                  $('#modal_modificar_ordenCompra').modal('show');
                  $("#actionAgregarModificarCompra").attr("onclick", "ModificarOrdenCompra("+id+","+idM+")");

                }
        });

        }
});
})
$('#tabla_curso').on("click", ".eliminarOrdenCompra", function(e) {
  var id = $(this).parent().attr("data-material");
  e.preventDefault();

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

//Funcion para cargar los datos del model de agregar nueva orden de compra
function cargarDatosModalAgregarCompra() {
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

                $("#select_CompraMaterial").empty().append(html);
                $("#agregarTituloNuevaCompra").html("Nueva orden de compra");
                $('#modal_nueva_ordenCompra').modal('show');
                $("#actionAgregarNuevaCompra").attr("onclick", "nuevoOrdenCompra()");
              }
      });
      }
});
}

//Funcion para cargar los datos del modal de modificarCompra
function cargarDatosModalModificarCompra() {
  $.ajax({
  type: "GET",
  dataType: "json",
  enctype: "multipart/form-data",
  url: base_url+'/inventario/orden_compra/lista_materiales/',
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

          $("#select_CompraMaterialModificar").empty().append(html);

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

                  $("#select_proveedorCompra").empty().append(html);
                }
           });

        }
  });
}

//Funcion para agregar nueva orden de compra
function nuevoOrdenCompra() {
  var bandera_validar=0;

  if($("#num_nota").val().length == 0){
      validation($("#num_nota"), $("#num_nota").parent());
      bandera_validar = bandera_validar +1;
  }

  if($("#cantidadOrdenCompra").val().length == 0){
      validation($("#cantidadOrdenCompra"), $("#cantidadOrdenCompra").parent());
      bandera_validar = bandera_validar +1;
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
    var datos_ordenCompra = ""
    datos_ordenCompra = new FormData(document.querySelector('#frmNuevaOrdenCompra'));

    var nombre_material = $("#select_CompraMaterial").val();
    var nombre_proveedor = $("#select_CompraProveedor").val();
    var cantidad_material = $("#cantidadOrdenCompra").val();

    datos_ordenCompra.append("_token", token);

    //Datos para la tabla de Compra
    datos_ordenCompra.append("FechaCompra", "2019-07-26");
    datos_ordenCompra.append("EstadoCompra", "1");
    datos_ordenCompra.append("idUsuarioCompra", "1");
    datos_ordenCompra.append("Proveedores_idProveedor", nombre_proveedor);

    //Datos para la tabla mov_materiales
    // datos_ordenCompra.append("Tipo_mov", "1");
    datos_ordenCompra.append("CantidadMovMaterial", cantidad_material);
    datos_ordenCompra.append("FechaMovMaterial", "2019-07-26");
    datos_ordenCompra.append("idUsuarioMovMaterial", "1");
    datos_ordenCompra.append("Materiales_idMateriale", nombre_material);

    //Datos para la tabla compras_has_mov_material
    datos_ordenCompra.append("idUsuariocompras_has_mov_material", "1");

    var url = "";
    url = base_url+'/inventario/orden_compra/agregar_ordenCompra';
    var mensaje = "La nueva orden de compra se a generado con éxito";
    var titulo = "Nuevo orden de compra";

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
            console.log("data: " , data);
            if(data == 0){
                $('#modal_nueva_ordenCompra').modal('hide')
                swal(titulo, mensaje, "success");
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
                swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
                //limpiar campos
                $("#num_nota").val("");
                $("#txtNombreMaterial").val("");
                $("#select_CompraMaterial").val("0");
                $("#select_CompraProveedor").val("0");
            }
        }, error: function(error) {
            console.log("no success");
            swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
            //limpiar campos
            $("#num_nota").val("");
            $("#txtNombreMaterial").val("");
            $("#select_CompraMaterial").val("0");
            $("#select_CompraProveedor").val("0");
        }
    });

  }else {
    swal("Error", "Por favor llenar todos los campos", "error");
  }

}

//Funcion para modificarOrdenCompra
function ModificarOrdenCompra(id,idM) {
  var bandera_validar=0;

  if($("#num_notaModificar").val().length == 0){
      validation($("#num_notaModificar"), $("#num_notaModificar").parent());
      bandera_validar = bandera_validar +1;
  }

  if($("#cantidadOrdenCompraModificar").val().length == 0){
      validation($("#cantidadOrdenCompraModificar"), $("#cantidadOrdenCompraModificar").parent());
      bandera_validar = bandera_validar +1;
  }

  if($("#TotalModificarCompra").val().length == 0){
      validation($("#TotalModificarCompra"), $("#TotalModificarCompra").parent());
      // bandera_validar = bandera_validar +1;
  }

  if($("#select_CompraMaterialModificar").val() == 0){
      validation($("#select_CompraMaterialModificar"), $("#select_CompraMaterialModificar").parent());
      bandera_validar = bandera_validar +1;
  }

  if($("#select_proveedorCompra").val() == 0){
      validation($("#select_proveedorCompra"), $("#select_proveedorCompra").parent());
      bandera_validar = bandera_validar +1;
  }
  if (bandera_validar == 0) {
    var datos_material = ""
    datos_material = new FormData();
    datos_material.append("_token", token);
    datos_material.append("idUsuario_material", "1");

    var num_notaModificar =  $("#num_notaModificar").val();
    var cantidad =  $("#cantidadOrdenCompraModificar").val();
    var id_estado = $('input:radio[name=Estado_ModificarOrden]:checked').val();
    var tipo = $("#select_proveedorCompra").val();
    var tipo2 = $("#select_CompraMaterialModificar").val();

    datos_material.append("num_notaModificar",num_notaModificar);
    datos_material.append("cantidadOrdenCompra",cantidad);
    datos_material.append("Estado_Compra", id_estado);
    datos_material.append("ProveedorSelect",tipo);
    datos_material.append("NombreMaterial",tipo2);

    // console.log("num: ", num_notaModificar);console.log("cantidad: ",cantidad);console.log("id_estado: ",id_estado);console.log("tipo: ", tipo);console.log("tipo2: ", tipo2);

    //Para insertar los cantidad de material a la tabla de materiales
    var total_m = $("#TotalModificarCompra").val();
    if (id_estado == 2) {
      $.ajax({
      type: "GET",
      dataType: "json",
      enctype: "multipart/form-data",
      url: base_url+'/inventario/orden_compra/especifico/'+id,
      success: function (msg) {
              var data = JSON.parse(msg)
              // console.log("ge: " , data);
              var cantidad = data[0].Cantidad;
              console.log("can: ", cantidad);

              $.ajax({
              type: "GET",
              dataType: "json",
              enctype: "multipart/form-data",
              url: base_url+'/inventario/orden_compra/existencia_material/'+id,
              success: function (msg) {
                      var data = JSON.parse(msg)
                      // console.log("ge: " , data);
                      var existencia = data[0].Existencia;
                      var idMaterial = data[0].id;
                      var idMovMaterial = data[0].movid;
                      var adeudo = data[0].Adeudo;
                      var idprove = data[0].proveid;

                      if (adeudo == null) {
                        adeudo = 0;
                      }
                      // console.log("adeudo: ", adeudo);

                      // console.log("existencia: ", existencia);
                      var total = cantidad + existencia;
                      // console.log("total: ", total);

                      var total_money = adeudo + parseInt(total_m);

                      // console.log("total_money: ", total_money);

                      if(total_m ==null){
                        datos_cantidad = new FormData();
                        datos_cantidad.append("_token", token);
                        datos_cantidad.append("idUsuario_material", "1");
                        datos_cantidad.append("total", total);
                        datos_cantidad.append("Tipo_mov", "1");
                      }else {
                        datos_cantidad = new FormData();
                        datos_cantidad.append("_token", token);
                        datos_cantidad.append("idUsuario_material", "1");
                        datos_cantidad.append("total", total);
                        datos_cantidad.append("Tipo_mov", "1");
                        datos_cantidad.append("total_money", total_money);
                      }

                      url = base_url+'/inventario/orden_compra/modificar_material/'+idMaterial+'/'+idMovMaterial+'/'+idprove;
                      mensaje = "La orden de compra ha sido actualizado con éxito";
                      titulo = "Actualizar orden de compra";

                      $.ajax({
                          type: 'POST',
                          processData: false,
                          contentType: false,
                          cache: false,
                          data: datos_cantidad,
                          dataType: false,
                          enctype: 'multipart/form-data',
                          url: url,
                          success: function(msg){
                              var data = JSON.parse(msg)
                              console.log("data m: ", data);
                              if(data == 0){

                                url = base_url+'/inventario/orden_compra/modificar/'+id+'/'+idM;
                                mensaje = "La orden de compra ha sido actualizado con éxito";
                                titulo = "Actualizar orden de compra";

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
                                        var data = JSON.parse(msg)
                                        console.log("data a: ", data);
                                        if(data == 0){
                                            $('#modal_modificar_ordenCompra').modal('hide')
                                            swal(titulo, mensaje, "success");
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
                                            swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
                                            //limpiar campos
                                            $("#num_notaModificar").val("");
                                            $("#TotalModificarCompra").val("");
                                            $("#cantidadOrdenCompraModificar").val("");
                                            $("#select_CompraMaterialModificar").val("0");
                                            $("#select_proveedorCompra").val("0");
                                        }
                                    }, error: function(error) {
                                        swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
                                            //limpiar campos
                                            $("#num_notaModificar").val("");
                                            $("#TotalModificarCompra").val("");
                                            $("#cantidadOrdenCompraModificar").val("");
                                            $("#select_CompraMaterialModificar").val("0");
                                            $("#select_proveedorCompra").val("0");
                                    }
                                });

                              }else{
                                  swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");

                              }
                          }, error: function(error) {
                              swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");

                          }
                      });

                    }
            });

            }
    });


  }else if(total_m ==0){
    url = base_url+'/inventario/orden_compra/modificar/'+id+'/'+idM;
    mensaje = "La orden de compra ha sido actualizado con éxito";
    titulo = "Actualizar orden de compra";

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
            var data = JSON.parse(msg)
            console.log("data a: ", data);
            if(data == 0){
                $('#modal_modificar_ordenCompra').modal('hide')
                swal(titulo, mensaje, "success");
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
                swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
                //limpiar campos
                $("#num_notaModificar").val("");
                $("#TotalModificarCompra").val("");
                $("#cantidadOrdenCompraModificar").val("");
                $("#select_CompraMaterialModificar").val("0");
                $("#select_proveedorCompra").val("0");
            }
        }, error: function(error) {
            swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
                //limpiar campos
                $("#num_notaModificar").val("");
                $("#TotalModificarCompra").val("");
                $("#cantidadOrdenCompraModificar").val("");
                $("#select_CompraMaterialModificar").val("0");
                $("#select_proveedorCompra").val("0");
        }
    });

  }else {
    swal("Error", "No se permite esa accion ", "error");
    $("#TotalModificarCompra").val("");
  }

  }else {
    swal("Error", "Por favor llenar todos los campos", "error");
  }

}

//Funcion para pagar compras al proveedor
function pagarCompra() {
  var bandera_validar=0;

  if($("#txtCheque").val().length == 0){
      validation($("#txtCheque"), $("#txtCheque").parent());
      bandera_validar = bandera_validar +1;
  }

  if($("#txtTotal").val().length == 0){
      validation($("#txtTotal"), $("#txtTotal").parent());
      bandera_validar = bandera_validar +1;
  }

  if($("#select_proveedorCompraPagar").val() == 0){
      validation($("#select_proveedorCompraPagar"), $("#select_proveedorCompraPagar").parent());
      bandera_validar = bandera_validar +1;
  }

  if($("#select_OrdenCompras").val() == 0){
      validation($("#select_OrdenCompras"), $("#select_OrdenCompras").parent());
      bandera_validar = bandera_validar +1;
  }

  if (bandera_validar == 0) {
    console.log("f");
  }
}

//Funcion para crear y cargar los datos a la tabla
function tablaOrdenCompra(){
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
                      <td>${data[i].Material}</td>
                      <td>${data[i].Cantidad}</td>
                      <td class="text-nowrap" data-material="${data[i].id}">
                          <a href="#" class="modificarOrdenCompra" data-toggle="tooltip" data-original-title="Modificar"><i class="icon-pencil text m-r-10"></i></a>
                          <a href="#" class="eliminarOrdenCompra" data-toggle="tooltip" data-original-title="Cancelar"> <i class="icon-close text-danger m-r-10"></i></a>
                      </td>
                  </tr>`;
                }else if(data[i].Estado == 2){
                  html_tabla_recibido+=
                  `<tr>
                      <td>${data[i].Num_nota}</td>
                      <td>${data[i].Fecha}</td>
                      <td>${data[i].Proveedor}</td>
                      <td>${data[i].Material}</td>
                      <td>${data[i].Cantidad}</td>
                      <td class="text-nowrap" data-material="${data[i].id}">

                      </td>
                  </tr>`;
                }else if (data[i].Estado == 3) {
                  html_tabla_cancelado+=
                  `<tr>
                      <td>${data[i].Num_nota}</td>
                      <td>${data[i].Fecha}</td>
                      <td>${data[i].Proveedor}</td>
                      <td>${data[i].Material}</td>
                      <td>${data[i].Cantidad}</td>
                      <td class="text-nowrap" data-material="${data[i].id}">

                      </td>
                  </tr>`;
                }else if (data[i].Estado == 4) {
                  html_tabla_pagado+=
                  `<tr>
                      <td>${data[i].Num_nota}</td>
                      <td>${data[i].Fecha}</td>
                      <td>${data[i].Proveedor}</td>
                      <td>${data[i].Material}</td>
                      <td>${data[i].Cantidad}</td>
                      <td class="text-nowrap" data-material="${data[i].id}">

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
		}
	});
}

//Funcion para ejecuar cuando se carga este script
$(document).ready(function () {
	tablaOrdenCompra();
  $(".select2").select2();
});

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
$("#select_CompraMaterial").on('change',function(e){
    validation($(this), $(this).parent())
    validation($("#validar").val("1"), $("#cantidadOrdenCompra").parent());
    validation($("#validar").val("1"), $("#num_nota").parent());
});
$('#select_CompraProveedor').on('change',function(e){
  validation($(this), $(this).parent())
  validation($("#validar").val("1"), $("#cantidadOrdenCompra").parent());
  validation($("#validar").val("1"), $("#num_nota").parent());
});
