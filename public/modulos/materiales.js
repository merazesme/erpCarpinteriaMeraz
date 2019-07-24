//Funcion para validar campos
function validation(children, parent){
    if(children.val().length == 0){
        parent.addClass("error");
    }else{
        parent.removeClass("error");
    }
}

//Funcion para abrir modal de agregarMaterial
function agregarMaterial(){
    // $("#agregarTitulo").html("Agregar material");
    // $('#modal_agregar_material').modal('show')
    // $("#actionAgregar").attr("onclick", "nuevoMaterial()");
}

//Funcion para agregar un nuevo material
function nuevoMaterial(id){
    var bandera_validar=0;
    console.log("id: " + id);

    if($("#txtCantidadMaterial").val().length == 0){
        validation($("#txtCantidadMaterial"), $("#txtCantidadMaterial").parent());
        bandera_validar = bandera_validar +1;
    }

    if($("#txtNombreMaterial").val().length == 0){
        validation($("#txtNombreMaterial"), $("#txtNombreMaterial").parent());
        bandera_validar = bandera_validar +1;
    }

    if($("#select_tipoMaterial").val() == 0){
        validation($("#select_tipoMaterial"), $("#select_tipoMaterial").parent());
        bandera_validar = bandera_validar +1;
    }
    if (bandera_validar == 0) {
      //Datos extras que no se ven en el formulario
      $("#select_tipoMateriall").val($("#select_tipoMaterial").val());
      $("#estado_material").val(1);
      $("#idUsuario_material").val(1);
      console.log("inpu_select: " + $("#select_tipoMateriall").val());
      console.log("inpu_estado: " + $("#estado_material").val());
      console.log("inpu_idUsuario: " + $("#idUsuario_material").val());

      //El objeto que se envia en el POST
      var datos_material = ""
      datos_material = new FormData(document.querySelector('#frmAgregarMaterial'));
      datos_material.append("idUsuario", "1");
      datos_material.append("_token", token);
      console.log("Datos: " + datos_material);
      var url = "";
      url = base_url+'/inventario/materiales/agregar_material';
      var mensaje = "El material ha sido agregado con éxito";
      var titulo = "Nuevo material";
      if(id != undefined){
          url = base_url+'/inventario/materiales/modificar/'+id;
          mensaje = "El material ha sido actualizado con éxito";
          titulo = "Actualizar material";
      }
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
              if(data == 0){
                  $('#modal_agregar_material').modal('hide')
                  swal(titulo, mensaje, "success");
                  tablaMateriales();
              }else{
                  swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
              }
          }, error: function(error) {
              swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
          }
      });

    }else {

    }
}

//Funcion para cargar datos al select
function tipo_material(id){
    $.ajax({
    type: "GET",
    dataType: "json",
    enctype: "multipart/form-data",
    url: base_url+'/inventario/materiales/tipo_material/',
    success: function (msg) {
            var data = JSON.parse(msg)
            console.log(data);
            var html = "";
            html+=
            `<option value="0">
              <font style="vertical-align: inherit;">Seleccione una opción</font>
            </option>`;
            for (var i = 0; i < data.length; i++) {
              html+=
              `<option value="${data[i].id}">
                <font style="vertical-align: inherit;">${data[i].Concepto}</font>
              </option>`;
            }
            $("#select_tipoMaterial").empty().append(html);

            if (id != undefined) {
              $("#agregarTitulo").html("Editar material");
              $('#modal_agregar_material').modal('show')
              $("#actionAgregar").attr("onclick", "nuevoMaterial("+id+")");
            }else {
              $("#agregarTitulo").html("Agregar material");
              $('#modal_agregar_material').modal('show')
              $("#actionAgregar").attr("onclick", "nuevoMaterial()");
            }
          }
  });
}

//Funcion para traer la informacion de un material
function datos_especificos(id){
  console.log("consulta_especifica: " + id);
  $.ajax({
  type: "GET",
  dataType: "json",
  enctype: "multipart/form-data",
  url: base_url+'/inventario/materiales/especifico/'+id,
  success: function (msg) {
          var data = JSON.parse(msg)
    console.log(data);
          $("#txtNombreMaterial").val(data.Nombre);
          $("#txtCantidadMaterial").val(data.Existencia);
          $("#estado_material").val(data.Estado);
          $("#idUsuario_material").val(data.idUsuario);
          $("#select_tipoMateriall").val(data.Clasificacion_material_idClasificacion_material);
          $("#select_tipoMaterial").val(data.Clasificacion_material_idClasificacion_material);
          $("#select_tipoMaterial option[value="+ data.Clasificacion_material_idClasificacion_material +"]").attr("selected",true);
  }
});
}

//Funcion para traer los datos a un select de un modal
$("#boton_agregarMaterial").on("click", function(e){
  tipo_material();
})

//Funcion para abrir y cargar datos en el modalModificarMaterial
$("#materiales_table").on("click", ".modificarMaterial", function(e){
  var id = $(this).parent().attr("data-material");
  console.log(id);
  e.preventDefault();
  tipo_material(id);
  datos_especificos(id);
})

//Funcion para eliminar un material
$("#materiales_table").on("click", ".eliminarMaterial", function(e){
  var id = $(this).parent().attr("data-material");
  e.preventDefault();
  datos_especificos(id);

  //El objeto que se envia en el POST
  var datos_material = ""
  datos_material = new FormData(document.querySelector('#frmAgregarMaterial'));
  datos_material.append("idUsuario", "1");
  datos_material.append("_token", token);

  var url = "";
  url = base_url+'/inventario/materiales/eliminar/'+id;
  mensaje = "El material ha sido eliminado con éxito";
  titulo = "Eliminar material";

  swal({
      title: "¿Deseas eliminar el material?",
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
            data: datos_material,
            dataType: false,
            enctype: 'multipart/form-data',
            url: url,
            success: function(msg){
                var data = JSON.parse(msg)
                if(data == 0){
                    swal("Eliminado", "El material ha sido eliminado con éxito", "success");
                    tablaMateriales();
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


//Validacion de los campos
$("#txtNombreMaterial").on('input',function(e){
    validation($(this), $(this).parent())
});
$("#txtCantidadMaterial").on('input',function(e){
    validation($(this), $(this).parent())
});
$("#select_tipoMaterial").on('change',function(e){
    validation($(this), $(this).parent())
});

//Funcion para crear y cargar los datos a la tabla
function tablaMateriales(){
    $.ajax({
		type: "GET",
		dataType: "json",
		enctype: "multipart/form-data",
		url: base_url+'/inventario/materiales/lista',
		success: function (msg) {
            var data = JSON.parse(msg)
			console.log("datos: " , data);
            var html = "";
            $("#materiales_table").DataTable().clear();
			$("#materiales_table").DataTable().destroy();
            for (var i = 0; i < data.length; i++) {
                if(data[i].Estado == 0){
                  html+=
                  `<tr>
                      <td>${data[i].Nombre}</td>
                      <td>${data[i].Concepto}</td>
                      <td>${data[i].Existencia}</td>
                      <td><span class="label label-danger"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Inactivo</font></font></span></td>
                      <td class="text-nowrap" data-material="${data[i].id}">
                          <a href="#" class="modificarMaterial" data-toggle="tooltip" data-original-title="Modificar"><i class="icon-pencil text-danger m-r-10"></i></a>
                          <a href="#" class="eliminarMaterial" data-toggle="tooltip" data-original-title="Borrar"> <i class="icon-close text-danger m-r-10"></i></a>
                          <a href="#" class="detalleMaterial" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye "></i></a>
                      </td>
                  </tr>`;
                }else if(data[i].Estado == 1){
                  html+=
                  `<tr>
                      <td>${data[i].Nombre}</td>
                      <td>${data[i].Concepto}</td>
                      <td>${data[i].Existencia}</td>
                      <td><span class="label label-success"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Activo</font></font></span></td>
                      <td class="text-nowrap" data-material="${data[i].id}">
                        <a href="#" class="modificarMaterial" data-toggle="tooltip" data-original-title="Modificar"><i class="icon-pencil text-danger m-r-10"></i></a>
                        <a href="#" class="eliminarMaterial" data-toggle="tooltip" data-original-title="Borrar"> <i class="icon-close text-danger m-r-10"></i></a>
                        <a href="#" class="detalleMaterial" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye "></i></a>
                      </td>
                  </tr>`;
                }
            }
            $("#materiales_table tbody").empty().append(html);
            $('#materiales_table').DataTable({
              dom: 'Bfrtip',
              buttons: ['excel', 'pdf', 'print']
            });
            $("body").tooltip({ selector: '[data-toggle="tooltip"]' });
		}
	});
}

//Funcion para ejecuar cuando se carga este script
$(document).ready(function () {
	tablaMateriales();
});
