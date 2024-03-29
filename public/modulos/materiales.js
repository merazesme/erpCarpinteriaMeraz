//Funcion para validar campos
function validation(children, parent){
    if (children.length == 0 ) {
        // console.log("Entra");
        parent.removeClass("error");
    }else {
      if(children.val().length == 0 ){
          parent.addClass("error");
      }else{
          parent.removeClass("error");
      }
    }
}

//Funcion para agregar un nuevo material
function nuevoMaterial(){
    var bandera_validar=0;

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
      //El objeto que se envia en el POST
      var datos_material = ""
      datos_material = new FormData(document.querySelector('#frmAgregarMaterial'));
      datos_material.append("_token", token);
      //
      // datos_material.append("idUsuario", "1");
      datos_material.append("idUsuario_material", "1");
      datos_material.append("estado_material", "1");
      var tipo = $("#select_tipoMaterial").val();
      datos_material.append("select_tipoMateriall",tipo);

      var url = "";
      url = base_url+'/inventario/materiales/agregar_material';
      var mensaje = "El material ha sido agregado con éxito";
      var titulo = "Nuevo material";
      Swal.fire({
        onOpen: function () {
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
                  var data = JSON.parse(msg)
                  if(data == 0){
                      $('#modal_agregar_material').modal('hide')

                      // swal(titulo, mensaje, "success");
                      tablaMateriales(0,"#materiales_tableActivos");
                      tablaMateriales(1,"#materiales_tableInactivos");

                      //limpiar campos
                      $("#txtCantidadMaterial").val("");
                      $("#txtNombreMaterial").val("");
                      $("#select_tipoMaterial").val("0");
                      Swal.close()
                      alerta_temporizador(
                          'success',
                          'Nuevo material',
                          'El material ha sido agregado con éxito',
                          2500
                      );

                  }else{
                      // swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
                      //limpiar campos
                      $("#txtCantidadMaterial").val("");
                      $("#txtNombreMaterial").val("");
                      $("#select_tipoMaterial").val("0");
                      Swal.close()
                      alerta_temporizador(
                          'error',
                          'Nuevo material',
                          'Ha ocurrido un error, inténtelo más tarde.',
                          2500
                      );
                  }
              }, error: function(error) {
                  // swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
                  //limpiar campos
                  $("#txtCantidadMaterial").val("");
                  $("#txtNombreMaterial").val("");
                  $("#select_tipoMaterial").val("0");
                  Swal.close()
                  alerta_temporizador(
                      'error',
                      'Nuevo material',
                      'Ha ocurrido un error, inténtelo más tarde.',
                      2500
                  );
              }
          });
        }
      })

    }else {
      // swal("Error", "Por favor llenar todos los campos", "error");
      alerta_temporizador(
          'error',
          'Nuevo material',
          'Por favor llenar todos los campos',
          2500
      );
    }
}

//Funcion para modificar el material
function ModificarMaterial(id){
      //Aqui para para módificar un material
      var bandera_validar=0;

      if($("#txtCantidadMaterialModificar").val().length == 0){
          validation($("#txtCantidadMaterialModificar"), $("#txtCantidadMaterialModificar").parent());
          bandera_validar = bandera_validar +1;
      }

      if($("#txtNombreMaterialModificar").val().length == 0){
          validation($("#txtNombreMaterialModificar"), $("#txtNombreMaterialModificar").parent());
          bandera_validar = bandera_validar +1;
      }

      if($("#select_tipoMaterialModificar").val() == 0){
          validation($("#select_tipoMaterialModificar"), $("#select_tipoMaterialModificar").parent());
          bandera_validar = bandera_validar +1;
      }
      if (bandera_validar == 0) {
        //El objeto que se envia en el POST
        var datos_material = ""
        datos_material = new FormData(document.querySelector('#frmModificarMaterial'));
        datos_material.append("_token", token);
        //
        // datos_material.append("idUsuario", "1");
        datos_material.append("idUsuario_material", "1");
        var id_estado = $('input:radio[name=Estado_Modificar]:checked').val();
        // console.log("id_estado: " + id_estado);
        datos_material.append("estado_material", id_estado);
        var tipo = $("#select_tipoMaterialModificar").val();
        datos_material.append("select_tipoMaterialModificar",tipo);

        url = base_url+'/inventario/materiales/modificar/'+id;
        mensaje = "El material ha sido actualizado con éxito";
        titulo = "Actualizar material";

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
                    var data = JSON.parse(msg)
                    if(data == 0){
                        $('#modal_editar_material').modal('hide')
                        // swal(titulo, mensaje, "success");
                        tablaMateriales(0,"#materiales_tableActivos");
                        tablaMateriales(1,"#materiales_tableInactivos");
                        Swal.close()
                        alerta_temporizador(
                          'success',
                          'Actualizar material',
                          'El material ha sido actualizado con éxito',
                          2500
                        );
                    }else{
                        // swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
                        Swal.close()
                        alerta_temporizador(
                          'error',
                          'Actualizar material',
                          'Ha ocurrido un error, inténtelo más tarde.',
                          2500
                        );
                    }
                }, error: function(error) {
                    // swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
                    Swal.close()
                    alerta_temporizador(
                      'error',
                      'Actualizar material',
                      'Ha ocurrido un error, inténtelo más tarde.',
                      2500
                    );
                }
            });
          }
        })
    }else {
      // swal("Error", "Por favor llenar todos los campos", "error");
      alerta_temporizador(
        'error',
        'Actualizar material',
        'Por favor llenar todos los campos',
        2500
      );
    }
}

//Funcion para cargar datos al select
function tipo_material(id,idMaterial){
    //Agregar material
    if (id == 1) {
      // console.log("1");
      Swal.fire({
        onOpen: function (){
          Swal.showLoading()
          $.ajax({
          type: "GET",
          dataType: "json",
          enctype: "multipart/form-data",
          url: base_url+'/inventario/materiales/tipo_material/',
          success: function (msg) {
                  Swal.close()
                  var data = JSON.parse(msg)
                  // console.log(data);
                  // console.log("a");
                  var html = "";
                  html+=
                  `<option value="0">
                    <font style="vertical-align: inherit;">Seleccione una opción</font>
                  </option>`;
                  for (var i = 0; i < data.length; i++) {
                    if (data[i].Estado !=0) {
                      html+=
                      `<option value="${data[i].id}">
                        <font style="vertical-align: inherit;">${data[i].Concepto}</font>
                      </option>`;
                    }
                  }

                  $("#select_tipoMaterial").empty().append(html);
                  $("#agregarTitulo").html("Agregar material");
                  $('#modal_agregar_material').modal('show');
                  $("#actionAgregar").attr("onclick", "nuevoMaterial()");
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

  }else if (id == 2) {
      //Modificar
      // console.log("2");
      Swal.fire({
        onOpen: function (){
          Swal.showLoading()
          $.ajax({
          type: "GET",
          dataType: "json",
          enctype: "multipart/form-data",
          url: base_url+'/inventario/materiales/tipo_material/',
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
                        <font style="vertical-align: inherit;">${data[i].Concepto}</font>
                      </option>`;
                    }
                  }

                  $("#select_tipoMaterialModificar").empty().append(html);
                  // $("#agregarTituloModificar").html("Editar material");
                  // $('#modal_editar_material').modal('show');

                  // console.log("consulta_especifica: " + id);
                  $("#Estado_Activo").prop('checked', false);
                  $("#Estado_Inactivo").prop('checked', false);
                  $.ajax({
                  type: "GET",
                  dataType: "json",
                  enctype: "multipart/form-data",
                  url: base_url+'/inventario/materiales/especifico/'+idMaterial,
                  success: function (msg) {
                          Swal.close()
                          var data = JSON.parse(msg)
                          // console.log(data);

                          $("#actionAgregarModificar").attr("onclick", "ModificarMaterial("+idMaterial+")");

                          $("#txtNombreMaterialModificar").val(data.Nombre);
                          $("#txtCantidadMaterialModificar").val(data.Existencia);
                          $("#estado_material").val(data.Estado);
                          if (data.Estado == 1) {
                            // console.log("1");
                            $("#Estado_Activo").prop('checked', true);
                          }else {
                            // console.log("0");
                            $("#Estado_Inactivo").prop('checked', true);
                          }
                          $("#idUsuario_material").val(data.idUsuario);
                          $("#select_tipoMateriall").val(data.Clasificacion_material_idClasificacion_material);
                          $("#select_tipoMaterialModificar").val(data.Clasificacion_material_idClasificacion_material);
                          $("#select_tipoMaterialModificar option[value="+ data.Clasificacion_material_idClasificacion_material +"]").attr("selected",true);

                          $("#agregarTituloModificar").html("Editar material");
                          $('#modal_editar_material').modal('show');
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
  }else if(id == 3){
      // console.log("3");
      //Tipo material
      Swal.fire({
        onOpen: function (){
          Swal.showLoading()
          $.ajax({
          type: "GET",
          dataType: "json",
          enctype: "multipart/form-data",
          url: base_url+'/inventario/materiales/tipo_material/',
          success: function (msg) {
                  Swal.close()
                  var data = JSON.parse(msg)
                  // console.log(data);
                  var html = "";
                  var htmlInactivo = "";
                  html+=
                  `<option value="0">
                    <font style="vertical-align: inherit;">Seleccione una opción</font>
                  </option>`;
                  htmlInactivo+=
                  `<option value="0">
                    <font style="vertical-align: inherit;">Seleccione una opción</font>
                  </option>`;
                  for (var i = 0; i < data.length; i++) {
                    if (data[i].Estado !=0) {
                      html+=
                      `<option value="${data[i].id}">
                        <font style="vertical-align: inherit;">${data[i].Concepto}</font>
                      </option>`;
                    }else {
                      htmlInactivo+=
                      `<option value="${data[i].id}">
                        <font style="vertical-align: inherit;">${data[i].Concepto}</font>
                      </option>`;
                    }
                  }
                  $("#select_tipoMaterial_TipoInactivo").empty().append(htmlInactivo);
                  $("#select_tipoMaterial_Tipo").empty().append(html);
                  $("#agregarTituloTipoMaterial").html("Tipo material");
                  $('#modal_agregar_tipoMaterial').modal('show')
                  $("#actionAgregarTipoMaterial").attr("onclick", "NuevoTipoMaterial()");
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
    }else{

    }
}

//Funcion para abrir el modal de eliminar o activar tipo material
$('#boton_nuevoTipoMaterial').on("click", function(e){
  e.preventDefault();
  e.stopImmediatePropagation();
  //Limpiar campos
  $("#select_tipoMaterial_Tipo").val("0");
  $("#select_tipoMaterial_TipoInactivo").val("0");
  $("#txtNombreTipoMaterial").val("");

  tipo_material(3,0);
})

//Funcion para abrir el modal de nuevo tipo de material
$('#boton_nuevoTipoMaterial2').on("click", function(e){
  e.preventDefault();
  e.stopImmediatePropagation();
  //Limpiar campos
  $("#txtNombreTipoMaterial2").val("");

  $('#modal_agregarNuevo_tipoMaterial').modal('show');
  $("#actionAgregarTipoMaterial2").attr("onclick", "NuevoTipoMaterial2()");
})

//Funcion para eliminar o activar un tipo de material
function NuevoTipoMaterial(id){

  var bandera_validar=0;
  var bandera_validar2=0;
  var bandera_validar3=0;

  if($("#select_tipoMaterial_Tipo").val() == 0){
      validation($("#select_tipoMaterial_Tipo"), $("#select_tipoMaterial_Tipo").parent());
      bandera_validar2 = bandera_validar2 +1;
  }

  if($("#select_tipoMaterial_TipoInactivo").val() == 0){
      validation($("#select_tipoMaterial_TipoInactivo"), $("#select_tipoMaterial_TipoInactivo").parent());
      bandera_validar3 = bandera_validar3 +1;
  }

  // if($("#txtNombreTipoMaterial").val().length == 0){
  //     // if(bandera_validar2 != 0){
  //       validation($("#txtNombreTipoMaterial"), $("#txtNombreTipoMaterial").parent());
  //       bandera_validar = bandera_validar +1;
  //     // }
  // }

  if(bandera_validar2 == 1 && bandera_validar3 == 1){
    // console.log("Nuevo:");
    var datos_Tipomaterial = ""
    datos_Tipomaterial = new FormData(document.querySelector('#frmAgregarTipoMaterial'));
    datos_Tipomaterial.append("_token", token);
    datos_Tipomaterial.append("idUsuario_Tipomaterial", "1");

    var url = "";
    url = base_url+'/inventario/materiales/agregar_Tipomaterial';
    var mensaje = "El tipo material ha sido agregado con éxito";
    var titulo = "Nuevo tipo material";

    Swal.fire({
      onOpen: function (){
        Swal.showLoading()
        $.ajax({
            type: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            data: datos_Tipomaterial,
            dataType: false,
            enctype: 'multipart/form-data',
            url: url,
            success: function(msg){
                var data = JSON.parse(msg)
                if(data == 0){
                    $('#modal_agregar_tipoMaterial').modal('hide')
                    // swal(titulo, mensaje, "success");
                    tablaMateriales(0,"#materiales_tableActivos");
                    tablaMateriales(1,"#materiales_tableInactivos");
                    //Limpiar campos
                    $("#select_tipoMaterial_Tipo").val("0");
                    $("#select_tipoMaterial_TipoInactivo").val("0");
                    $("#txtNombreTipoMaterial").val("");
                     bandera_validar=0;
                     bandera_validar2=0;
                     bandera_validar3=0;
                     validation($("#validar").val("1"), $("#txtNombreTipoMaterial").parent());
                     Swal.close()
                     alerta_temporizador(
                           'success',
                           'Nuevo tipo material',
                           'El tipo material ha sido agregado con éxito',
                           2500
                       );
                }else{
                    // swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
                    //Limpiar campos
                    $("#select_tipoMaterial_Tipo").val("0");
                    $("#select_tipoMaterial_TipoInactivo").val("0");
                    $("#txtNombreTipoMaterial").val("");
                     bandera_validar=0;
                     bandera_validar2=0;
                     bandera_validar3=0;
                     validation($("#validar").val("1"), $("#txtNombreTipoMaterial").parent());
                     Swal.close()
                     alerta_temporizador(
                           'error',
                           'Nuevo tipo material',
                           'Ha ocurrido un error, inténtelo más tarde.',
                           2500
                       );
                }
            }, error: function(error) {
                // swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
                //Limpiar campos
                $("#select_tipoMaterial_Tipo").val("0");
                $("#select_tipoMaterial_TipoInactivo").val("0");
                $("#txtNombreTipoMaterial").val("");
                 bandera_validar=0;
                 bandera_validar2=0;
                 bandera_validar3=0;
                 validation($("#validar").val("1"), $("#txtNombreTipoMaterial").parent());
                 Swal.close()
                 alerta_temporizador(
                       'error',
                       'Nuevo tipo material',
                       'Ha ocurrido un error, inténtelo más tarde.',
                       2500
                   );
            }
        });
      }
    })

  }else if(bandera_validar2 != 1 && bandera_validar3 == 1){
    // console.log("Eliminar:");
    var datos_Tipomaterial = ""
    datos_Tipomaterial = new FormData(document.querySelector('#frmAgregarTipoMaterial'));
    var id_tipo = ""
    id_tipo = $("#select_tipoMaterial_Tipo").val()
    datos_Tipomaterial.append("_token", token);
    datos_Tipomaterial.append("EstadoTipoMaterial", "0");

    var url = "";
    url = base_url+'/inventario/materiales/eliminarTipoMaterial/'+id_tipo;
    var mensaje = "El tipo material ha sido eliminado con éxito";
    var titulo = "Eliminar tipo material";

    Swal.fire({
      onOpen: function (){
        Swal.showLoading()
        $.ajax({
            type: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            data: datos_Tipomaterial,
            dataType: false,
            enctype: 'multipart/form-data',
            url: url,
            success: function(msg){
                var data = JSON.parse(msg)
                if(data == 0){
                    $('#modal_agregar_tipoMaterial').modal('hide')
                    // swal(titulo, mensaje, "success");
                    tablaMateriales(0,"#materiales_tableActivos");
                    tablaMateriales(1,"#materiales_tableInactivos");
                    //Limpiar campos
                    $("#select_tipoMaterial_Tipo").val("0");
                    $("#select_tipoMaterial_TipoInactivo").val("0");
                    $("#txtNombreTipoMaterial").val("");
                     bandera_validar=0;
                     bandera_validar2=0;
                     bandera_validar3=0;
                     validation($("#validar").val("1"), $("#txtNombreTipoMaterial").parent());
                     Swal.close()
                     alerta_temporizador(
                           'success',
                           'Eliminar tipo material',
                           'El tipo material ha sido eliminado con éxito',
                           2500
                       );

                }else{
                    // swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
                    //Limpiar campos
                    $("#select_tipoMaterial_Tipo").val("0");
                    $("#select_tipoMaterial_TipoInactivo").val("0");
                    $("#txtNombreTipoMaterial").val("");
                     bandera_validar=0;
                     bandera_validar2=0;
                     bandera_validar3=0;
                     validation($("#validar").val("1"), $("#txtNombreTipoMaterial").parent());
                     Swal.close()
                     alerta_temporizador(
                           'error',
                           'Eliminar tipo material',
                           'Ha ocurrido un error, inténtelo más tarde.',
                           2500
                       );
                }
            }, error: function(error) {
                // swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
                //Limpiar campos
                $("#select_tipoMaterial_Tipo").val("0");
                $("#select_tipoMaterial_TipoInactivo").val("0");
                $("#txtNombreTipoMaterial").val("");
                 bandera_validar=0;
                 bandera_validar2=0;
                 bandera_validar3=0;
                 validation($("#validar").val("1"), $("#txtNombreTipoMaterial").parent());
                 Swal.close()
                 alerta_temporizador(
                       'error',
                       'Eliminar tipo material',
                       'Ha ocurrido un error, inténtelo más tarde.',
                       2500
                   );
            }
        });
      }
    })

  }else if (bandera_validar3 != 1 && bandera_validar2 == 1) {
    // console.log("Activar:");
    var datos_Tipomaterial = ""
    datos_Tipomaterial = new FormData(document.querySelector('#frmAgregarTipoMaterial'));
    var id_tipo = ""
    id_tipo = $("#select_tipoMaterial_TipoInactivo").val()
    datos_Tipomaterial.append("_token", token);
    datos_Tipomaterial.append("EstadoTipoMaterial", "1");

    var url = "";
    url = base_url+'/inventario/materiales/eliminarTipoMaterial/'+id_tipo;
    var mensaje = "El tipo material ha sido activado con éxito";
    var titulo = "Activar tipo material";

    Swal.fire({
      onOpen: function (){
        Swal.showLoading()
        $.ajax({
            type: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            data: datos_Tipomaterial,
            dataType: false,
            enctype: 'multipart/form-data',
            url: url,
            success: function(msg){
                var data = JSON.parse(msg)
                if(data == 0){
                    $('#modal_agregar_tipoMaterial').modal('hide')
                    // swal(titulo, mensaje, "success");
                    tablaMateriales(0,"#materiales_tableActivos");
                    tablaMateriales(1,"#materiales_tableInactivos");
                    //Limpiar campos
                    $("#select_tipoMaterial_Tipo").val("0");
                    $("#select_tipoMaterial_TipoInactivo").val("0");
                    $("#txtNombreTipoMaterial").val("");
                     bandera_validar=0;
                     bandera_validar2=0;
                     bandera_validar3=0;
                     validation($("#validar").val("1"), $("#txtNombreTipoMaterial").parent());
                     Swal.close()
                     alerta_temporizador(
                           'success',
                           'Activar tipo material',
                           'El tipo material ha sido activado con éxito',
                           2500
                       );

                }else{
                    // swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
                    //Limpiar campos
                    $("#select_tipoMaterial_Tipo").val("0");
                    $("#select_tipoMaterial_TipoInactivo").val("0");
                    $("#txtNombreTipoMaterial").val("");
                     bandera_validar=0;
                     bandera_validar2=0;
                     bandera_validar3=0;
                     validation($("#validar").val("1"), $("#txtNombreTipoMaterial").parent());
                     Swal.close()
                     alerta_temporizador(
                           'error',
                           'Activar tipo material',
                           'Ha ocurrido un error, inténtelo más tarde.',
                           2500
                       );
                }
            }, error: function(error) {
                // swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
                //Limpiar campos
                $("#select_tipoMaterial_Tipo").val("0");
                $("#select_tipoMaterial_TipoInactivo").val("0");
                $("#txtNombreTipoMaterial").val("");
                 bandera_validar=0;
                 bandera_validar2=0;
                 bandera_validar3=0;
                 validation($("#validar").val("1"), $("#txtNombreTipoMaterial").parent());
                 Swal.close()
                 alerta_temporizador(
                       'error',
                       'Activar tipo material',
                       'Ha ocurrido un error, inténtelo más tarde.',
                       2500
                   );
            }
        });
      }
    })

  }else {
    // swal("Error", "Por favor seleccione solo una opción", "error");
    validation($("#validar").val("1"), $("#txtNombreTipoMaterial").parent());
    alerta_temporizador(
          'error',
          'Activar tipo material',
          'Por favor seleccione solo una opción',
          2500
      );
  }


}

//Funcion para agregar un nuevo tipo de material
function NuevoTipoMaterial2() {
  var bandera_validar=0;

  if($("#txtNombreTipoMaterial2").val().length == 0){
      // if(bandera_validar2 != 0){
        validation($("#txtNombreTipoMaterial2"), $("#txtNombreTipoMaterial2").parent());
        bandera_validar = bandera_validar +1;
      // }
  }
  if (bandera_validar == 0) {

    var datos_Tipomaterial = ""
    datos_Tipomaterial = new FormData(document.querySelector('#frmAgregarTipoMaterial'));
    datos_Tipomaterial.append("_token", token);
    datos_Tipomaterial.append("idUsuario_Tipomaterial", "1");
    var txtNombreTipoMaterial = $("#txtNombreTipoMaterial2").val()
    datos_Tipomaterial.append("txtNombreTipoMaterial", txtNombreTipoMaterial);

    var url = "";
    url = base_url+'/inventario/materiales/agregar_Tipomaterial';
    var mensaje = "El tipo material ha sido agregado con éxito";
    var titulo = "Nuevo tipo material";

    Swal.fire({
      onOpen: function (){
        Swal.showLoading()
        $.ajax({
            type: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            data: datos_Tipomaterial,
            dataType: false,
            enctype: 'multipart/form-data',
            url: url,
            success: function(msg){
                var data = JSON.parse(msg)
                if(data == 0){
                    $('#modal_agregarNuevo_tipoMaterial').modal('hide')
                    // swal(titulo, mensaje, "success");
                    tablaMateriales(0,"#materiales_tableActivos");
                    tablaMateriales(1,"#materiales_tableInactivos");
                    //Limpiar campos
                    $("#txtNombreTipoMaterial2").val("");
                    Swal.close()
                    alerta_temporizador(
                          'success',
                          'Nuevo tipo material',
                          'El tipo material ha sido agregado con éxito',
                          2500
                      );

                }else{
                    // swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
                    //Limpiar campos
                    $("#txtNombreTipoMaterial2").val("");
                    Swal.close()
                    alerta_temporizador(
                          'error',
                          'Nuevo tipo material',
                          'Ha ocurrido un error, inténtelo más tarde.',
                          2500
                      );
                }
            }, error: function(error) {
                // swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
                //Limpiar campos
                $("#txtNombreTipoMaterial2").val("");
                Swal.close()
                alerta_temporizador(
                      'error',
                      'Nuevo tipo material',
                      'Ha ocurrido un error, inténtelo más tarde.',
                      2500
                  )
            }
        });
      }
    })

  }else {
    // swal("Error", "Por favor llenar todos los campos", "error");
    alerta_temporizador(
        'error',
        'Nuevo tipo material',
        'Por favor llenar todos los campos',
        2500
    );
  }
}

//Funcion para traer la informacion de un material
function datos_especificos(id){
  // console.log("consulta_especifica: " + id);
  $("#Estado_Activo").prop('checked', false);
  $("#Estado_Inactivo").prop('checked', false);

  Swal.fire({
    onOpen: function (){
      Swal.showLoading()
      $.ajax({
      type: "GET",
      dataType: "json",
      enctype: "multipart/form-data",
      url: base_url+'/inventario/materiales/especifico/'+id,
      success: function (msg) {
              Swal.close()
              var data = JSON.parse(msg)
              // console.log(data);

              $("#actionAgregarModificar").attr("onclick", "ModificarMaterial("+id+")");

              $("#txtNombreMaterialModificar").val(data.Nombre);
              $("#txtCantidadMaterialModificar").val(data.Existencia);
              $("#estado_material").val(data.Estado);
              if (data.Estado == 1) {
                // console.log("1");
                $("#Estado_Activo").prop('checked', true);
              }else {
                // console.log("0");
                $("#Estado_Inactivo").prop('checked', true);
              }
              $("#idUsuario_material").val(data.idUsuario);
              $("#select_tipoMateriall").val(data.Clasificacion_material_idClasificacion_material);
              $("#select_tipoMaterialModificar").val(data.Clasificacion_material_idClasificacion_material);
              $("#select_tipoMaterialModificar option[value="+ data.Clasificacion_material_idClasificacion_material +"]").attr("selected",true);
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

//Funcion para traer los datos a un select de un modal
$("#boton_agregarMaterial").on("click", function(e){
  e.preventDefault();
  e.stopImmediatePropagation();
  //limpiar campos
  $("#txtCantidadMaterial").val("");
  $("#txtNombreMaterial").val("");
  $("#select_tipoMaterial").val("0")

  // $('#modal_agregar_material').modal('show');
  // console.log("btn");
  tipo_material(1,0);
})

//Funcion para abrir y cargar datos en el modalModificarMaterial
$("#materiales_tableActivos").on("click", ".modificarMaterial", function(e){
  var id = $(this).parent().attr("data-material");
  // console.log(id);
  e.preventDefault();
  e.stopImmediatePropagation();
  tipo_material(2,id);
  // datos_especificos(id);

  $("input[name=Estado_Modificar]").click(function (){
    var id_estado = $('input:radio[name=Estado_Modificar]:checked').val();
    // console.log("id_estado: " + id_estado);
  });
})

//Funcion para eliminar un material
$("#materiales_tableActivos").on("click", ".eliminarMaterial", function(e){
  var id = $(this).parent().attr("data-material");
  e.preventDefault();
  e.stopImmediatePropagation();
  // datos_especificos(id);

  //El objeto que se envia en el POST
  var datos_material = ""
  datos_material = new FormData(document.querySelector('#frmAgregarMaterial'));
  datos_material.append("idUsuario", "1");
  datos_material.append("_token", token);

  var url = "";
  url = base_url+'/inventario/materiales/eliminar/'+id;
  mensaje = "El material ha sido eliminado con éxito";
  titulo = "Eliminar material";

  Swal.fire({
    onOpen: function () {
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
              var data = JSON.parse(msg)
              if(data == 0){
                  // swal("Eliminado", "El material ha sido eliminado con éxito", "success");
                  tablaMateriales(0,"#materiales_tableActivos");
                  tablaMateriales(1,"#materiales_tableInactivos");
                  Swal.close()
                  alerta_temporizador(
                          'success',
                          'Eliminar material',
                          'El material ha sido eliminado con éxito',
                          2500
                      );
              }else{
                  // swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
                  Swal.close()
                  alerta_temporizador(
                          'error',
                          'Eliminar material',
                          'Ha ocurrido un error, inténtelo más tarde.',
                          2500
                      );
              }
          }, error: function(error) {
              // swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
              Swal.close()
              alerta_temporizador(
                      'error',
                      'Eliminar material',
                      'Ha ocurrido un error, inténtelo más tarde.',
                      2500
                  );
          }
      });
    }
  })

  // Swal.fire({
  //     title: "¿Deseas eliminar el material?",
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
  //           data: datos_material,
  //           dataType: false,
  //           enctype: 'multipart/form-data',
  //           url: url,
  //           success: function(msg){
  //               var data = JSON.parse(msg)
  //               if(data == 0){
  //                   swal("Eliminado", "El material ha sido eliminado con éxito", "success");
  //                   tablaMateriales(0,"#materiales_tableActivos");
  //                   tablaMateriales(1,"#materiales_tableInactivos");
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

//Funcion para abrir y cargar datos en el modalModificarMaterial
$("#materiales_tableInactivos").on("click", ".modificarMaterial", function(e){
  var id = $(this).parent().attr("data-material");
  // console.log(id);
  e.preventDefault();
  e.stopImmediatePropagation();
  tipo_material(2,id);
  // datos_especificos(id);

  $("input[name=Estado_Modificar]").click(function (){
    var id_estado = $('input:radio[name=Estado_Modificar]:checked').val();
    // console.log("id_estado: " + id_estado);
  });
})

//Validacion de los campos
$("#txtNombreMaterial").on('input',function(e){
    validation($(this), $(this).parent())
});
$("#txtNombreTipoMaterial2").on('input',function(e){
    validation($(this), $(this).parent())
});
$("#txtCantidadMaterial").on('input',function(e){
    validation($(this), $(this).parent())
});
$("#select_tipoMaterial").on('change',function(e){
    validation($(this), $(this).parent())
});
$('#txtNombreTipoMaterial').on('input',function(e){
  validation($(this), $(this).parent())
});
$("#select_tipoMaterial_Tipo").on('change',function(e){
    validation($(this), $(this).parent())
    validation($("#validar").val("1"), $("#txtNombreTipoMaterial").parent());
});
$("#select_tipoMaterial_TipoInactivo").on('change',function(e){
    validation($(this), $(this).parent())
    validation($("#validar").val("1"), $("#txtNombreTipoMaterial").parent());
});

//Funcion para crear y cargar los datos a la tabla
function tablaMateriales(){
  Swal.fire({
    onOpen: function (){
      Swal.showLoading()
      $.ajax({
  		type: "GET",
  		dataType: "json",
  		enctype: "multipart/form-data",
  		url: base_url+'/inventario/materiales/lista',
  		success: function (msg) {
              var data = JSON.parse(msg)
  			      // console.log("datos: " , data);
              var html = "";
              var htmlInactivo = "";

              $("#materiales_tableActivos").DataTable().clear();
  			      $("#materiales_tableActivos").DataTable().destroy();

              $("#materiales_tableInactivos").DataTable().clear();
              $("#materiales_tableInactivos").DataTable().destroy();

              for (var i = 0; i < data.length; i++) {
                  if(data[i].Estado == 0){
                    html+=
                    `<tr>
                        <td>${data[i].Nombre}</td>
                        <td>${data[i].Concepto}</td>
                        <td>${data[i].Existencia}</td>
                        <td class="text-nowrap" data-material="${data[i].id}">
                            <a href="#" class="modificarMaterial" data-toggle="tooltip" data-original-title="Modificar"><i class="icon-pencil text m-r-10"></i></a>
                        </td>
                    </tr>`;
                  }else if(data[i].Estado == 1){
                    htmlInactivo+=
                    `<tr>
                        <td>${data[i].Nombre}</td>
                        <td>${data[i].Concepto}</td>
                        <td>${data[i].Existencia}</td>
                        <td class="text-nowrap" data-material="${data[i].id}">
                          <a href="#" class="modificarMaterial" data-toggle="tooltip" data-original-title="Modificar"><i class="icon-pencil text m-r-10"></i></a>
                          <a href="#" class="eliminarMaterial" data-toggle="tooltip" data-original-title="Borrar"> <i class="icon-close text-danger m-r-10"></i></a>
                        </td>
                    </tr>`;
                  }
              }
              $("#materiales_tableActivos tbody").empty().append(htmlInactivo);
              $('#materiales_tableActivos').DataTable({
                dom: 'Bfrtip',
                buttons: ['excel', 'pdf', 'print']
              });

              $("#materiales_tableInactivos tbody").empty().append(html);
              $('#materiales_tableInactivos').DataTable({
                dom: 'Bfrtip',
                buttons: ['excel', 'pdf', 'print']
              });
              $("body").tooltip({ selector: '[data-toggle="tooltip"]' });
              Swal.close()
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

function alerta_temporizador(tipo, titulo, texto, tiempo) {
    Swal.fire({
        type: tipo,
        title: titulo,
        text: texto,
        showConfirmButton: false,
        timer: tiempo
    });
}
//Funcion para ejecuar cuando se carga este script
$(document).ready(function () {
	tablaMateriales();
  console.log("ma");
  // SOLO NÚMEROS
    $('body').on('input', ".input-number", function(e){
      this.value = this.value.replace(/[^0-9]/g,'');
    });
});
