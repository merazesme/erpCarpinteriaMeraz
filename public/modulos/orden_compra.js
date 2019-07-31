//Funcion para validar campos
function validation(children, parent){
    if (children.length == 0 ) {
        console.log("Entra");
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

$('#tabla_curso').on("click",".modificarOrdenCompra", function(e){
  var id = $(this).parent().attr("data-material");
  cargarDatosModalModificarCompra();
  $.ajax({
  type: "GET",
  dataType: "json",
  enctype: "multipart/form-data",
  url: base_url+'/inventario/orden_compra/especifico/'+id,
  success: function (msg) {
          var data = JSON.parse(msg)
          // console.log("ge: " , data);
          $("#select_CompraProveedorModificar option[value="+ data[0].ProveedorId +"]").attr("selected",true);
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

                  $("#select_CompraProveedorModificar").empty().append(html);
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
    datos_ordenCompra.append("Tipo_mov", "1");
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

  if($("#select_CompraMaterialModificar").val() == 0){
      validation($("#select_CompraMaterialModificar"), $("#select_CompraMaterialModificar").parent());
      bandera_validar = bandera_validar +1;
  }

  if($("#select_CompraProveedorModificar").val() == 0){
      validation($("#select_CompraProveedorModificar"), $("#select_CompraProveedorModificar").parent());
      bandera_validar = bandera_validar +1;
  }
  if (bandera_validar == 0) {
    console.log("id: ", id);
    var datos_material = ""
    datos_material = new FormData();
    datos_material.append("_token", token);

    datos_material.append("idUsuario_material", "1");

    var num_notaModificar =  $("#num_notaModificar").val();
    var cantidad =  $("#cantidadOrdenCompraModificar").val();
    var id_estado = $('input:radio[name=Estado_ModificarOrden]:checked').val();
    var tipo = $("#select_CompraProveedorModificar").val();
    var tipo2 = $("#select_CompraMaterialModificar").val();

    datos_material.append("num_notaModificar",num_notaModificar);
    datos_material.append("cantidadOrdenCompra",cantidad);
    datos_material.append("Estado_Compra", id_estado);
    datos_material.append("ProveedorSelect",tipo);
    datos_material.append("NombreMaterial",tipo2);

    console.log("num: ", num_notaModificar);console.log("cantidad: ",cantidad);console.log("id_estado: ",id_estado);console.log("tipo: ", tipo);console.log("tipo2: ", tipo2);

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
            console.log("data: ", data);
            if(data == 0){
                $('#modal_modificar_ordenCompra').modal('hide')
                swal(titulo, mensaje, "success");
                tablaOrdenCompra(0,"#tabla_curso");
                tablaOrdenCompra(1,"#tabla_recibido");
                tablaOrdenCompra(2,"#tabla_cancelado");
                tablaOrdenCompra(3,"#tabla_pagado");

                //limpiar campos
                $("#num_notaModificar").val("");
                $("#cantidadOrdenCompraModificar").val("");
                $("#select_CompraMaterialModificar").val("0");
                $("#select_CompraProveedorModificar").val("0");
            }else{
                swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
                //limpiar campos
                $("#num_notaModificar").val("");
                $("#cantidadOrdenCompraModificar").val("");
                $("#select_CompraMaterialModificar").val("0");
                $("#select_CompraProveedorModificar").val("0");
            }
        }, error: function(error) {
            swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
                //limpiar campos
                $("#num_notaModificar").val("");
                $("#cantidadOrdenCompraModificar").val("");
                $("#select_CompraMaterialModificar").val("0");
                $("#select_CompraProveedorModificar").val("0");
        }
    });
  }else {
    swal("Error", "Por favor llenar todos los campos", "error");
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
                          <a href="#" class="modificarOrdenCompra" data-toggle="tooltip" data-original-title="Modificar"><i class="icon-pencil text-danger m-r-10"></i></a>
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
                          <a href="#" class="modificarOrdenCompra" data-toggle="tooltip" data-original-title="Modificar"><i class="icon-pencil text-danger m-r-10"></i></a>
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
                          <a href="#" class="modificarMaterial" data-toggle="tooltip" data-original-title="Modificar"><i class="icon-pencil text-danger m-r-10"></i></a>
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
                          <a href="#" class="modificarMaterial" data-toggle="tooltip" data-original-title="Modificar"><i class="icon-pencil text-danger m-r-10"></i></a>
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
});

//Validacion de los campos
$("#cantidadOrdenCompra").on('input',function(e){
    validation($(this), $(this).parent())
});
$("#num_nota").on('input',function(e){
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
