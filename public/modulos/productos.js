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
          // for (var i = 0; i < data.length; i++) {
          //   var t =i+1;
          //     html2+='<input type="text" class="form-control d-none" name="cantidadOrdenSalida'+t+'" value="'+data[i].Precio_por_unidad+'" id="cantidadOrdenSalida'+t+'"><p></p>';
          // }

          $("#select_materiaPrima").empty().append(html);
          $("#valores").empty().append(html);
          $('#modal_agregar_productos').modal('show');
        }
  });
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
                      <td>${data[i].Subtotal}</td>
                      <td>${data[i].IVA}</td>
                      <td>${data[i].Total}</td>
                      <td class="text-nowrap" data-material="${data[i].id}">
                          <a href="#" class="modificarOrdenSalida" data-toggle="tooltip" data-original-title="Modificar"><i class="icon-pencil text m-r-10"></i></a>
                          <a href="#" class="eliminarOrdenSalida" data-toggle="tooltip" data-original-title="Cancelar"> <i class="icon-close text-danger m-r-10"></i></a>
                          <a href="#" class="detalleOrdenSalida" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye "></i> </a>
                      </td>
                  </tr>`;
                }else if (data[i].Estado == 0) {
                  tabla_productosCancelados+=
                  `<tr>
                      <td>${data[i].Num_nota}</td>
                      <td>${data[i].Fecha}</td>
                      <td>${data[i].Nombre}</td>
                      <td>${data[i].Descripcion}</td>
                      <td class="text-nowrap" data-material="${data[i].id}">
                          <a href="#" class="detalleOrdenSalida" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="icon-eye "></i> </a>
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

$("#txtCostosAdicionales").on('input',function(e){
    validation($(this), $(this).parent())
    var total = 0;
    var costo = parseInt($("#txtCostosAdicionales").val());
    var total_mataprima = parseInt($("#totalMateriaPrima").val());
    if ($("#totalMateriaPrima").val().length == 0) {
      total_mataprima = 0;
    }
    total = costo + total_mataprima;
    $("#totalMateriaPrimaFinal").val(total);
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
              $("#totalMateriaPrimaFinal").val(totalA);

            }
       });
  }
});

$(document).ready(function () {
	tablaProductos();
  $(".select2").select2();
});
