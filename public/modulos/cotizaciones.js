var tablaProductos = [];
var iva = 0;

$(document).ready(function() {
    $("body").tooltip({ selector: '[data-toggle="tooltip"]' });

    var url = (location.href).split("/");
    if(url[url.length - 1] == "nueva") {
        initialize_validate_form(1, null);
        cargarClientes();
        cargarRecomendados();
        cargarProductos();
        cargarMateria();
        cargarIVA();
    } else if(url[url.length - 2] == "editar"){
        /** Cargar los datos de registro específico */
        // initialize_validate_form(2, url[url.length - 1]);
        // datos_proveedor_especifico(url[url.length - 1]);
    } else {
        /** Cargar los datos de los registros en general */
        // datos_proveedor();
    }
});

function iniciar(){
    $("#selectPrioridad").val(1);
    $("#descripcion").val("aaaa");
}

// -------------------------------------------------------------------------------------------------------------------------------------------------
                                                                        /*Funciones de agregar*/
// -------------------------------------------------------------------------------------------------------------------------------------------------

//Información necesaria
function cargarIVA(){
    $.ajax({
        type: "GET",
        dataType: "json",
        enctype: "multipart/form-data",
        url: base_url+'/cotizaciones/getIVA',
        success: function (msg) {
            var data = JSON.parse(msg)
            iva = parseFloat(data[0].IVA);
        }
    });
}

function cargarRecomendados(){
    $.ajax({
		type: "GET",
		dataType: "json",
		enctype: "multipart/form-data",
		url: base_url+'/cotizaciones/getRecomendados',
		success: function (msg) {
            var data = JSON.parse(msg)
            var html = "<option value='-1'>Selecciona la persona que recomendó</option>";
            for (var item in data) {
                html += `<option value="${data[item].id}">${data[item].Nombre} - ${data[item].Porcentaje}%</option>`
            }
            $("#selectRecomendado").empty().append(html);
		}
	});
}

function cargarClientes(){
    $.ajax({
		type: "GET",
		dataType: "json",
		enctype: "multipart/form-data",
		url: base_url+'/cotizaciones/getClientes',
		success: function (msg) {
            var data = JSON.parse(msg)
            var html = "<option value='-1'>Selecciona un cliente</option>";
            for (var item in data) {
                html += `<option value="${data[item].id}">${data[item].Nombre} ${data[item].Apellidos}</option>`
            }
            $("#selectCliente").empty().append(html);
		}
	});
}

function cargarProductos(){
    $.ajax({
		type: "GET",
		dataType: "json",
		enctype: "multipart/form-data",
		url: base_url+'/cotizaciones/getProductos',
		success: function (msg) {
            var data = JSON.parse(msg)
            var html = "<option value='-1'>Selecciona un producto</option>";
            for (var item in data) {
                html += `<option value="${data[item].id}">${data[item].Descripcion}</option>`
            }
            $("#selectProductos").empty().append(html);
		}
	});
}

function cargarMateria(){
    $.ajax({
		type: "GET",
		dataType: "json",
		enctype: "multipart/form-data",
		url: base_url+'/cotizaciones/getMateria',
		success: function (msg) {
            var data = JSON.parse(msg)
            var html = "";
            for (var item in data) {
                html += `<option value="${data[item].id}">${data[item].Descripcion}</option>`
            }
            $("#selectMateriaPrima").empty().append(html);
		}
	});
}
//

//Validaciones
function validation(children, parent){
    if(children.val().length == 0){
        parent.addClass("error");
    }else{
        parent.removeClass("error");
    }
}

function validationMensaje(children, parent){
    $("#"+children.attr("id")+"-error").remove();
    if(children.val().length == 0){
        parent.append(`<label id="${children.attr("id")}-error" class="text-error" for="${children.attr("id")}">Este campo es requerido.</label>`)
    }
}
//

//sweet alert
function mensaje(titulo, msg, tipo){
    Swal.fire({
        type: tipo,
        title: titulo,
        text: msg,
    });
}
//

//Modal de Recomendacion
$("#nombreReco").on('input',function(e){
    validation($(this), $(this).parent())
});

$("#porcentajeReco").on('input',function(e){
    validation($(this), $(this).parent())
});
//

//Modal de producto
$("#descripcionProducto").on('input',function(e){
    validation($(this), $(this).parent())
});

$("#subtotalProducto").on('input',function(e){
    validation($(this), $(this).parent())
    calcularTotal();
});

function calcularTotal(){
    if($("#subtotalProducto").val().length != 0){
        var ivalocal = parseFloat($("#subtotalProducto").val()) * (iva/100);
        var total = parseFloat($("#subtotalProducto").val()) + ivalocal;

        var ivalocal_decimal = parseFloat(ivalocal).toFixed(2);
        $("#ivaProducto").html("$"+ivalocal_decimal);

        var total_decimal = parseFloat(total).toFixed(2);
        $("#totalProducto").html("$"+total_decimal);
    }else{
        $("#ivaProducto").html("$0.00");
        $("#totalProducto").html("$0.00");

    }
}
//

//input de la parte de los productos
$("body").on('input', "#cantidad", function(e){
    validationMensaje($(this), $(this).parent())
});

$("body").on('input', "#descripcionP", function(e){
    validationMensaje($(this), $(this).parent())
});

//select de recomendado
$('body').on('change', "#selectRecomendado", function () {
    var valor =$(this).val();
    if(valor == -1){
        $("#btnNuevoRecomendado").addClass("btn-success").removeClass("btn-info");
        $("#btnNuevoRecomendado").empty().append('<i class="fa fa-plus"></i>');
        $("#btnNuevoRecomendado").attr("data-original-title","Agregar nueva persona de recomendación");
        $("#btnNuevoRecomendado").attr("onclick","modalAccionRecomanedado('agregar')");
    }else {
        $("#selectCliente-error").remove();
        $("#btnNuevoRecomendado").removeClass("btn-success").addClass("btn-info");
        $("#btnNuevoRecomendado").empty().append('<i class="fa fa-edit"></i>');
        $("#btnNuevoRecomendado").attr("data-original-title","Modificar persona de recomendación");
        $("#btnNuevoRecomendado").attr("onclick","modalAccionRecomanedado("+valor+")");
    }
});

//select de cliente
$('body').on('change', "#selectCliente", function () {
    $("#selectCliente-error").remove();
});

//select de producto
$('body').on('change', "#selectProductos", function () {
    var valor = $(this).val();
    if(valor == -1){
        $("#btnNuevoProducto").addClass("btn-success").removeClass("btn-info");
        $("#btnNuevoProducto").empty().append('<i class="fa fa-plus"></i>');
        $("#btnNuevoProducto").attr("data-original-title","Agregar nuevo producto");
        $("#btnNuevoProducto").attr("onclick","modalAccionProducto('agregar')");
    }else {
        $("#selectProductos-error").remove();
        $("#btnNuevoProducto").removeClass("btn-success").addClass("btn-info");
        $("#btnNuevoProducto").empty().append('<i class="fa fa-edit"></i>');
        $("#btnNuevoProducto").attr("data-original-title","Modificar producto");
        $("#btnNuevoProducto").attr("onclick","modalAccionProducto("+valor+")");
        $("selectProductos-error").remove();
    }
});

//select de Materia prima
$('body').on('change', "#selectMateriaPrima", function () {
    var valor = $(this).val();
    if(valor.length > 0){
        $("#selectMateriaPrima-error").remove();
    }else{
        $("#selectMateriaPrima").parent().append(`<label id="selectMateriaPrima-error" class="text-error" style="display: block;" for="selectMateriaPrima">Este campo es requerido.</label>`);
    }
});

//Acciones de los modales
function modalAccionRecomanedado(accion){
    $("#nombreReco").parent().removeClass("error");
    $("#porcentajeReco").parent().removeClass("error");

    if(accion == "agregar"){
        $(".modal-title").html("Agregar nueva persona que recomendó");
        $("#nombreReco").val("");
        $("#porcentajeReco").val(1);
        $("#botonModalRecomendado").attr("onclick", "nuevoRecomendado()");
    }else if($.isNumeric(accion)){
        //consulta chida
        $.ajax({
    		type: "GET",
    		dataType: "json",
    		enctype: "multipart/form-data",
    		url: base_url+'/cotizaciones/getSpecificRecomendados/'+accion,
    		success: function (msg) {
                var data = JSON.parse(msg)
                $(".modal-title").html("Modificar persona que recomendó");

                $("#nombreReco").val(data.Nombre);
                $("#porcentajeReco").val(data.Porcentaje);
                $("#botonModalRecomendado").attr("onclick", "nuevoRecomendado("+data.id+")");
    		}
    	});
    }
    $('#modalRecomendado').modal('show')
}

function modalAccionProducto(accion){
    $("#descripcionProducto").parent().removeClass("error");
    $("#subtotalProducto").parent().removeClass("error");

    if(accion == "agregar"){
        $(".modal-title-producto").html("Agregar nuevo producto");

        $("#descripcionProducto").val("");
        $("#subtotalProducto").val("");
        $("#ivaProducto").html("$0.00");
        $("#selectMateriaPrima").val("-1");
        $("#totalProducto").html("$0.00");

        $("#botonModalProducto").attr("onclick", "nuevoProducto()");
    }else if($.isNumeric(accion)){
        //consulta chida
        $.ajax({
    		type: "GET",
    		dataType: "json",
    		enctype: "multipart/form-data",
    		url: base_url+'/cotizaciones/getSpecificProducto/'+accion,
    		success: function (msg) {
                var data = JSON.parse(msg)
                $(".modal-title-producto").html("Modificar producto");

                $("#descripcionProducto").val(data[0].Descripcion);
                $("#subtotalProducto").val(data[0].Subtotal);
                $("#ivaProducto").text("$"+parseFloat(data[0].IVA).toFixed(2));
                $("#totalProducto").text("$"+parseFloat(data[0].Total).toFixed(2));

                var materia = [];
                for (var i = 0; i < data.length; i++) {
                    materia.push(data[i].Materia_prima_idMateria_prima)
                }

                $("#selectMateriaPrima").val(materia).trigger('change');
                $("#botonModalRecomendado").attr("onclick", "nuevoProducto("+data[0].id+")");
    		}
    	});
    }
    $('#modalProducto').modal('show')
}
//

//Respuesta al dar click en el boton de los modales
function nuevoRecomendado(id){
    var url = base_url+"/cotizaciones/nuevoRecomendado";
    var titulo = "Nueva persona de recomendación";
    var texto = "Se ha agregado con éxito";
    if(id){
        url = base_url+"/cotizaciones/modificarRecomendado/"+id;
        titulo = "Actualización de persona de recomendación";
        var texto = "Se ha actualizado con éxito";
    }

    var banValidation=false;

    if($("#nombreReco").val().length == 0){
        validation($("#nombreReco"), $("#nombreReco").parent());
        banValidation=true;
    }

    if($("#porcentajeReco").val().length == 0){
        validation($("#porcentajeReco"), $("#porcentajeReco").parent());
        banValidation=true;
    }

    if(!banValidation){
        var datos = new FormData(document.querySelector('#formRecomendado'));
        datos.append("idUsuario", "1");

        $.ajax({
            type: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            data: datos,
            dataType: false,
            enctype: 'multipart/form-data',
            url: url,
            success: function(msg){
                var data = JSON.parse(msg)
                if(data == 0){
                    $('#modalRecomendado').modal('hide')
                    mensaje(titulo, texto, "success");
                    cargarRecomendados();
                }else{
                    mensaje(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
                }
            }, error: function(error) {
                mensaje(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
            }
        });
    }
}

function nuevoProducto(id){
    var url = base_url+"/cotizaciones/nuevoProducto";
    var titulo = "Nuevo producto";
    var texto = "Se ha agregado con éxito";
    if(id){
        url = base_url+"/cotizaciones/modificarProducto/"+id;
        titulo = "Actualización de producto";
        var texto = "Se ha actualizado con éxito";
    }

    var banValidation=false;

    if($("#descripcionProducto").val().length == 0){
        validation($("#descripcionProducto"), $("#descripcionProducto").parent());
        banValidation=true;
    }

    if($("#subtotalProducto").val().length == 0){
        validation($("#subtotalProducto"), $("#subtotalProducto").parent());
        banValidation=true;
    }

    if($("#selectMateriaPrima").val().length == 0){
        $("#selectMateriaPrima").parent().append(`<label id="selectMateriaPrima-error" class="text-error" style="display: block;" for="selectMateriaPrima">Este campo es requerido.</label>`);
        banValidation=true;
    }

    if(!banValidation){
        var datos = new FormData(document.querySelector('#formProducto'));
        var total = $("#totalProducto").text().split("$");
        var iva = $("#ivaProducto").text().split("$");
        datos.append("materiaPrima", JSON.stringify($("#selectMateriaPrima").val()));
        datos.append("totalProducto", total[1]);
        datos.append("ivaProducto", iva[1]);

        datos.append("idUsuario", "1");

        $.ajax({
            type: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            data: datos,
            dataType: false,
            enctype: 'multipart/form-data',
            url: url,
            success: function(msg){
                var data = JSON.parse(msg)
                if(data == 0){
                    $('#modalProducto').modal('hide')
                    mensaje(titulo, texto, "success");
                    cargarProductos();
                }else if(data == 1){
                    mensaje(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
                }else if(data == -1){
                    mensaje(titulo, "Ha ocurrido un error al guardar los materiales, inténtelo más tarde.", "error");
                }
            }, error: function(error) {
                mensaje(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
            }
        });
    }
}
//

//reiniciar formulario wizard
function reset_form(identifier_form) {
    cargarRecomendados();
    cargarClientes();
    cargarProductos();
    cargarMateria();
    cargarIVA();
    tablaProductos = [];

    llenarTablaProductos();

    $(identifier_form).steps("reset");
    $(identifier_form)[0].reset();
}

//validar formulario wizard
function initialize_validate_form(tipo, id) {
    finish = tipo == 1 ? 'Guardar' : 'Actualizar';
    $(".validation-wizard").steps({
        headerTag: "h6"
        , bodyTag: "section"
        , transitionEffect: "fade"
        , titleTemplate: '<span class="step">#index#</span> #title#'
        , enableCancelButton: true
        , onCanceled: function (event) {
            reset_form('.validation-wizard');
        }
        , labels: {
            cancel  : "Cancelar",
            previous: "Anterior",
            finish
        }
        , onStepChanging: function (event, currentIndex, newIndex) {
            $("#selectCliente-error").remove();
            if ( currentIndex > newIndex || !(3 === newIndex && Number($("#age-2").val()) < 18) &&
                (currentIndex < newIndex && (
                    form.find(".body:eq(" + newIndex + ") label.error").remove(),
                    form.find(".body:eq(" + newIndex + ") .error").removeClass("error")),
                    form.validate().settings.ignore = ":disabled,:hidden",
                    form.valid())
             ) {
                 if($("#selectCliente").val() == -1){
                     $("#divSelectCliente").append(`<label id="selectCliente-error" class="text-error" style="display: block;" for="selectCliente">Este campo es requerido.</label>`);
                     return false;
                 }
                 return true;
            }else {
                if($("#selectCliente").val() == -1){
                    $("#divSelectCliente").append(`<label id="selectCliente-error" class="text-error" style="display: block;" for="selectCliente">Este campo es requerido.</label>`);
                    return false;
                }
            }
        }
        , onFinishing: function (event, currentIndex) {
            if(form.validate().settings.ignore = ":disabled" && form.valid()){
                if(tablaProductos.length == 0){
                    mensaje("¡Atención!", "Se debe de agregar al menos un producto a la cotización", "error");
                    return false;
                }
                return true;
            }else{
                if(tablaProductos.length == 0){
                    mensaje("¡Atención!", "Se debe de agregar al menos un producto a la cotización", "error");
                    return false;
                }
            }
        }
        , onFinished: function (event, currentIndex) {
            if(tipo == 1) {
                guardarCotizacion();
            } else {
                // actualizar_proveedor(id);
            }
        }
    });
    delete finish;
    $('a[href*="#cancel"]').css({'background' : '#CC0000'});
    $(".select2").select2();
}

//guardar wizard
function guardarCotizacion(){
    var costo = 0;
    for (var i = 0; i < tablaProductos.length; i++) {
        costo  += parseFloat(tablaProductos[i].total);
    }

    var datos = new FormData();
    datos.append("idCliente",$("#selectCliente").val());
    datos.append("descripcion",$("#descripcion").val());
    datos.append("prioridad",$("#selectPrioridad").val());
    datos.append("costo",costo);
    datos.append("documento","proximamente.docx");
    datos.append("_token", token);
    datos.append("idUsuario", "1");

    if($("#selectRecomendado").val() != "-1"){
        datos.append("idRecomendado",$("#selectRecomendado").val());
        var porcentaje = $("#selectRecomendado option:selected" ).text().split("- ")
        porcentaje = porcentaje[1].split("%")
        datos.append("porcentaje",porcentaje[0]);
    }

    datos.append("productos",JSON.stringify(tablaProductos));
    Swal.fire({
        onOpen: function () {
            Swal.showLoading()
            $.ajax({
                type: 'POST',
                url: base_url+'/cotizaciones/nuevaCotizacion',
                data: datos,
                contentType: false,
            	processData: false,
            })
            .done(function(resp) {
                Swal.close()
                var data = JSON.parse(resp)
                if(data == 0) {
                    mensaje("Nueva cotización", "Se ha agregado la nueva cotización con éxito", "success");
                    reset_form('.validation-wizard');
                } else if(data == -1){
                   mensaje("Nueva cotización", "Ha ocurrido un error al guardar los productos, inténtelo más tarde.", "error");
               }else{
                   mensaje("Nueva cotización", "Ha ocurrido un error, inténtelo más tarde.", "error");
               }
            })
            .fail(function(err) {
                mensaje("Nueva cotización", "Ha ocurrido un error, inténtelo más tarde.", "error");
            });
        }
    })
}

//Acciones de productos dentro de la cotización
    //agregar
function agregarProductoCotizacion(){
    var ban = false;
    if($("#selectProductos").val() == "-1"){
        $("#selectProductos").parent().append(`<label id="selectProductos-error" class="text-error" for="selectProductos">Este campo es requerido.</label>`)
        ban = true;
    }else{
        $("selectProductos-error").remove();
    }

    if($("#cantidad").val().length == 0){
        validationMensaje($("#cantidad"), $("#cantidad").parent())
        ban = true;
    }

    if($("#descripcionP").val().length == 0){
        validationMensaje($("#descripcionP"), $("#descripcionP").parent())
        ban = true;
    }

    if(!ban){
        //consulta para traer la info necesaria
        $.ajax({
            type: "GET",
            dataType: "json",
            enctype: "multipart/form-data",
            url: base_url+'/cotizaciones/getSpecificProductoMaterial/'+$("#selectProductos").val(),
            success: function (msg) {
                var data = JSON.parse(msg)

                var materia = [];
                for (var i = 0; i < data.length; i++) {
                    materia.push( {
                        idMateria: data[i].idMateria,
                        materia:  data[i].descripcionMateria
                    })
                }

                tablaProductos.push({
                    idProducto: $("#selectProductos").val(),
                    producto: $("#selectProductos option:selected" ).text(),
                    descripcion: $("#descripcionP").val(),
                    cantidad: $("#cantidad").val(),
                    subtotal: data[0].Subtotal,
                    iva: data[0].IVA,
                    total: data[0].Total,
                    materia: materia
                })

                $("#selectProductos").val("-1").trigger("change");
                $("#descripcionP").val("")
                $("#cantidad").val("")

                llenarTablaProductos();
            }
        });
    }
}

    //modificar
$("body").on("click", ".modificarProductoCotizacion", function(e){
    e.preventDefault();
    var id = $(this).parent().attr("id");
    $("#selectProductos").val(tablaProductos[id].idProducto).trigger("change");
    $("#descripcionP").val(tablaProductos[id].descripcion)
    $("#cantidad").val(parseInt(tablaProductos[id].cantidad))
    $("#btnAgregarProducto").text("Actualizar Producto");
    $("#btnAgregarProducto").attr("onclick", "modificarProductoCotizacion("+id+")");
})

    //acción al modificar
function modificarProductoCotizacion(id){
    if(tablaProductos[id].idProducto != $("#selectProductos").val()){
        //consulta
        $.ajax({
            type: "GET",
            dataType: "json",
            enctype: "multipart/form-data",
            url: base_url+'/cotizaciones/getSpecificProductoMaterial/'+$("#selectProductos").val(),
            success: function (msg) {
                var data = JSON.parse(msg)

                var materia = [];
                for (var i = 0; i < data.length; i++) {
                    materia.push( {
                        idMateria: data[i].idMateria,
                        materia:  data[i].descripcionMateria
                    })
                }

                tablaProductos[id] = {
                    idProducto: $("#selectProductos").val(),
                    producto: $("#selectProductos option:selected" ).text(),
                    descripcion: $("#descripcionP").val(),
                    cantidad: $("#cantidad").val(),
                    subtotal: data[0].Subtotal,
                    iva: data[0].IVA,
                    total: data[0].Total,
                    materia: materia
                }

                $("#selectProductos").val("-1").trigger("change");
                $("#descripcionP").val("")
                $("#cantidad").val("")

                $("#btnAgregarProducto").text("Agregar Producto");
                $("#btnAgregarProducto").attr("onclick", "agregarProductoCotizacion()");

                llenarTablaProductos();
            }
        });
    }else{
        tablaProductos[id].descripcion = $("#descripcionP").val()
        tablaProductos[id].cantidad = $("#cantidad").val()

        $("#selectProductos").val("-1").trigger("change");
        $("#descripcionP").val("")
        $("#cantidad").val("")

        $("#btnAgregarProducto").text("Agregar Producto");
        $("#btnAgregarProducto").attr("onclick", "agregarProductoCotizacion()");

        llenarTablaProductos();
    }
}

    //eliminar
$("body").on("click", ".eliminarProductoCotizacion", function(e){
    e.preventDefault();
    var id = $(this).parent().attr("id");
    Swal.fire({
      title: "¿Deseas eliminar el producto de la cotización?",
      type: "error",
      showCancelButton: true,
      confirmButtonColor: '#DD6B55',
      confirmButtonText: "Eliminar",
      cancelButtonText: "Cancelar",
    }).then((result) => {
      if (result.value) {
          tablaProductos.splice(id, 1);
          mensaje("Eliminado", "El producto ha sido eliminado con éxito de la cotización", "success");
          llenarTablaProductos();
      }
    })
})

    //acción al eliminar
function llenarTablaProductos(){
    var row="";
    var costo = 0;
    if(tablaProductos.length > 0){
        tablaProductos.forEach((item, index) =>{
            var iva = parseFloat(item.iva)*parseFloat(item.cantidad);
            var total = parseFloat(item.total)*parseFloat(item.cantidad);
            var subtotal = parseFloat(item.subtotal)*parseFloat(item.cantidad);

            costo  += parseFloat(total);

            iva = "$"+parseFloat(iva).toFixed(2);
            total = "$"+parseFloat(total).toFixed(2);
            subtotal = "$"+parseFloat(subtotal).toFixed(2);

            row += `
                <tr>
                    <td>${item.cantidad}</td>
                    <td>${item.producto}</td>
                    <td>${item.descripcion}</td>
                    <td>
                        <ul>`
            for (var i = 0; i < item.materia.length; i++) {
                row +=    `<li>${item.materia[i].materia}</li>`
            }
            row +=      `</ul>
                    </td>
                    <td>${subtotal}</td>
                    <td>${iva}</td>
                    <td>${total}</td>
                    <td id="${index}">
                        <a href="#" class="modificarProductoCotizacion" data-toggle="tooltip" data-original-title="Editar"> <i class="icon-pencil text-inverse m-r-10"></i> </a>
                        <a href="#" class="eliminarProductoCotizacion" data-toggle="tooltip" data-original-title="Borrar"> <i class="icon-close text-danger m-r-10"></i> </a>
                    </td>
                </tr>`
        });


        $("#costoTotal").text("$"+parseFloat(costo).toFixed(2));
        $("#tablaProductos tbody").empty().append(row);
    }else{
        $("#costoTotal").text("$"+parseFloat(costo).toFixed(2));
        $("#tablaProductos tbody").empty().append(
            `<tr>
              <td colspan="8">
                  No hay productos en la cotización...
              </td>
            </tr>`);
    }
}
//

// ----------------------------------------------------------------------------------------------------------------------------------------------------
                                                                        /*Funciones de mostrar datos*/
// -------------------------------------------------------------------------------------------------------------------------------------------------
$(".detalleCotizacion").click(function(e){
    e.preventDefault();
})

// ----------------------------------------------------------------------------------------------------------------------------------------------------
                                                                        /*Funciones de eliminar cotización*/
// -------------------------------------------------------------------------------------------------------------------------------------------------

$(".eliminarCotizacion").click(function(e){
    e.preventDefault();
    Swal.fire({
        title: "¿Deseas eliminar la cotización?",
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
            mensaje("Eliminado", "La cotización ha sido eliminada con éxito", "success");
        }
    });
})

// ----------------------------------------------------------------------------------------------------------------------------------------------------
                                                                        /*Funciones de modificar datos*/
// -------------------------------------------------------------------------------------------------------------------------------------------------
