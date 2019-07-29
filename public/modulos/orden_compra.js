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
  cargarDatosModalAgregarCompra();
})

//Funcion para cargar la lista de materiales
function listaMateriales(){
  $.ajax({
  type: "GET",
  dataType: "json",
  enctype: "multipart/form-data",
  url: base_url+'/inventario/orden_compra/lista_materiales/',
  success: function (msg) {
          var data = JSON.parse(msg)
          console.log(data);
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

//Funcion para cargar la lista de los proveedores
function listaProveedores(){
  $.ajax({
  type: "GET",
  dataType: "json",
  enctype: "multipart/form-data",
  url: base_url+'/inventario/orden_compra/lista_proveedor/',
  success: function (msg) {
          var data = JSON.parse(msg)
          console.log(data);
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
          // $("#agregarTituloNuevaCompra").html("Nueva orden de compra");
          // $('#modal_nueva_ordenCompra').modal('show');
          // $("#actionAgregarNuevaCompra").attr("onclick", "nuevoOrdenCompra()");
        }
});
}

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

//Funcion para agregar nueva orden de compra
function nuevoOrdenCompra() {
  var bandera_validar=0;

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
    console.log("smn");
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
                          <a href="#" class="modificarMaterial" data-toggle="tooltip" data-original-title="Modificar"><i class="icon-pencil text-danger m-r-10"></i></a>
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
                          <a href="#" class="modificarMaterial" data-toggle="tooltip" data-original-title="Modificar"><i class="icon-pencil text-danger m-r-10"></i></a>
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
$("#select_CompraMaterial").on('change',function(e){
    validation($(this), $(this).parent())
    validation($("#validar").val("1"), $("#cantidadOrdenCompra").parent());
});
$('#select_CompraProveedor').on('input',function(e){
  validation($(this), $(this).parent())
  validation($("#validar").val("1"), $("#cantidadOrdenCompra").parent());
});
