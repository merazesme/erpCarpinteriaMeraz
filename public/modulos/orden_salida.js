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
  cargarDatosModalAgregarCompra();
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

    var datos_ordenSalida = "";
    datos_ordenSalida = new FormData();
    datos_ordenSalida.append("_token", token);


  }else {
    swal("Error", "Por favor llenar todos los campos", "error");
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
                      <td>${data[i].Nombre}</td>
                      <td>${data[i].Descripcion}</td>
                      <td>${data[i].Fecha}</td>
                      <td>${data[i].Cantidad}</td>
                      <td class="text-nowrap" data-material="${data[i].id}">
                          <a href="#" class="modificarOrdenCompra" data-toggle="tooltip" data-original-title="Modificar"><i class="icon-pencil text m-r-10"></i></a>
                          <a href="#" class="eliminarOrdenCompra" data-toggle="tooltip" data-original-title="Cancelar"> <i class="icon-close text-danger m-r-10"></i></a>
                      </td>
                  </tr>`;
                }else if (data[i].Estado == 0) {
                  tabla_ordenSalidaCancelada+=
                  `<tr>
                      <td>${data[i].Nombre}</td>
                      <td>${data[i].Descripcion}</td>
                      <td>${data[i].Fecha}</td>
                      <td>${data[i].Cantidad}</td>
                      <td class="text-nowrap" data-material="${data[i].id}">
                          <a href="#" class="modificarOrdenCompra" data-toggle="tooltip" data-original-title="Modificar"><i class="icon-pencil text m-r-10"></i></a>
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
$("#txtDescripcion").on('input',function(e){
    validation($(this), $(this).parent())
});
$("#select_trabajadorOrdenSalida").on('change',function(e){
    validation($(this), $(this).parent())
    validation($("#validar").val("1"), $("#txtDescripcion").parent());
});
$('body').on('change', "#select_materialesOrdenSalida", function(e){
    validation($(this), $(this).parent())
    validation($("#validar").val("1"), $("#txtDescripcion").parent());
});
