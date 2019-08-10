var tablaProductos = [];
var iva = 0;

$(document).ready(function() {
    $("body").tooltip({ selector: '[data-toggle="tooltip"]' });

    var url = (location.href).split("/");
    if(url[url.length - 1] == "nueva") {
        initialize_validate_form(1, null);
        iniciar();
    } else if(url[url.length - 2] == "modificar"){
        /** Cargar los datos de registro específico */
        cargarIVA();
        cargarProductos();
        cargarMateria();

        initialize_validate_form(2, url[url.length - 1]);
        datos_cotizacion_especifica(url[url.length - 1]);
    } else {
        /** Cargar los datos de los registros en general */
        datosCotizaciones();
    }
});

function iniciar(){
    cargarClientes();
    cargarRecomendados();
    cargarProductos();
    cargarMateria();
    cargarIVA();
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

function cargarRecomendados(id){
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
            if(id){
                $("#selectRecomendado").val(id);
                $("#selectCliente-error").remove();
                $("#btnNuevoRecomendado").removeClass("btn-success").addClass("btn-info");
                $("#btnNuevoRecomendado").empty().append('<i class="fa fa-edit"></i>');
                $("#btnNuevoRecomendado").attr("data-original-title","Modificar persona de recomendación");
                $("#btnNuevoRecomendado").attr("onclick","modalAccionRecomanedado("+id+")");
            }
		}
	});
}

function cargarClientes(id){
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
            $("#selectCliente").empty().append(html).trigger('change');

            if(id){
                // $("#selectCliente").val(id);
                $("#selectCliente").val(id).trigger('change');

            }
		}
	});
}

function cargarProductos(id){
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
            if(id){
                $("#selectProductos").val(id);
                $("#selectProductos-error").remove();
                $("#btnNuevoProducto").removeClass("btn-success").addClass("btn-info");
                $("#btnNuevoProducto").empty().append('<i class="fa fa-edit"></i>');
                $("#btnNuevoProducto").attr("data-original-title","Modificar producto");
                $("#btnNuevoProducto").attr("onclick","modalAccionProducto("+id+")");
                $("selectProductos-error").remove();
            }
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
        parent.append(`<label id="${children.attr("id")}-error" class="text-error-itzel" for="${children.attr("id")}">Este campo es requerido.</label>`)
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
        $("#selectMateriaPrima").parent().append(`<label id="selectMateriaPrima-error" class="text-error-itzel" style="display: block;" for="selectMateriaPrima">Este campo es requerido.</label>`);
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
                $("#botonModalProducto").attr("onclick", "nuevoProducto("+accion+")");
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
                    cargarRecomendados(id);
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
        $("#selectMateriaPrima").parent().append(`<label id="selectMateriaPrima-error" class="text-error-itzel" style="display: block;" for="selectMateriaPrima">Este campo es requerido.</label>`);
        banValidation=true;
    }

    if(!banValidation){
        var datos = new FormData(document.querySelector('#formProducto'));
        var total = $("#totalProducto").text().split("$");
        var iva = $("#ivaProducto").text().split("$");
        datos.append("materiaPrima", JSON.stringify($("#selectMateriaPrima").val()));
        datos.append("totalProducto", total[1]);
        datos.append("ivaProducto", iva[1]);
        datos.append("_token", token);

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
                    cargarProductos(id);
                }else if(data == 1){
                    mensaje(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
                }else if(data == -1){
                    mensaje(titulo, "Ha ocurrido un error al guardar los materiales, inténtelo más tarde.", "error");
                }else if(data == -1){
                    mensaje(titulo, "Ha ocurrido un error al actualizar los materiales, inténtelo más tarde.", "error");
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
                     $("#divSelectCliente").append(`<label id="selectCliente-error" class="text-error-itzel" style="display: block;" for="selectCliente">Este campo es requerido.</label>`);
                     return false;
                 }
                 return true;
            }else {
                if($("#selectCliente").val() == -1){
                    $("#divSelectCliente").append(`<label id="selectCliente-error" class="text-error-itzel" style="display: block;" for="selectCliente">Este campo es requerido.</label>`);
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
                actualizar_Cotizacion(id);
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
    datos.append("fecha_inicio", $("#fechaInicio").val());
    datos.append("fecha_fin", $("#fechaFin").val());
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
        $("#selectProductos").parent().append(`<label id="selectProductos-error" class="text-error-itzel" for="selectProductos">Este campo es requerido.</label>`)
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
$("body").on("click", ".detalleCotizacion", function(e){
    e.preventDefault();
    var id = $(this).parent().attr("id");
    $.ajax({
        type: "GET",
        dataType: "json",
        enctype: "multipart/form-data",
        url: base_url+'/cotizaciones/cotizacionDetalle/'+id,
        success: function (msg) {
            var data = JSON.parse(msg)
            var html = "";
            for (var i = 0; i < data.length; i++) {
                var subtotal = parseFloat(data[i].subtotal)*parseFloat(data[i].Cantidad);
                var total = parseFloat(data[i].total)*parseFloat(data[i].Cantidad);
                var iva = parseFloat(data[i].iva)*parseFloat(data[i].Cantidad);

                subtotal =parseFloat(subtotal) .toFixed(2);
                iva =parseFloat(iva) .toFixed(2);
                total =parseFloat(total) .toFixed(2);

                html +=
                `<tr>
                  <td>${data[i].Cantidad}</td>
                  <td>${data[i].nombreProducto}</td>
                  <td>${data[i].descripcion}</td>
                  <td>
                  <ul>`
                  for (var j = 0; j < data[i].materiales.length; j++) {
                      html += `<li>${data[i].materiales[j].Descripcion}</li>`;
                  }

                html+=`</ul>
                </td>
                  <td>$${subtotal}</td>
                  <td>$${iva}</td>
                  <td>$${total}</td>
                </tr>`;
            }
            $("#tablaDetalleCotizacion tbody").empty().append(html);
            $("#modalCotizacion").modal("show");
        }
    });
})


function datosCotizaciones(){
    $.ajax({
        type: "GET",
        dataType: "json",
        enctype: "multipart/form-data",
        url: base_url+'/cotizaciones/getCotizaciones',
        success: function (msg) {
            var data = JSON.parse(msg)
            var htmlActivo = "";
            var htmlTermiado = "";
            var htmlRecha = "";
            if(data.length > 0){
                $("#cotizaciones").DataTable().destroy();
                $("#cotizacionesTerminadas").DataTable().destroy();
                $("#cotizacionesRechazadas").DataTable().destroy();

                const months = ["Ene", "Feb", "Mar","Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"];
                data.forEach(item =>{
                    var html = "";
                    var estado = `<span class="badge badge-success">Aceptada</span>`;
                    var mensaje = "En taller"
                    if(item.Estado == 0){
                        estado = `<span class="badge badge-danger">Rechazada</span>`
                        mensaje = "Cambiar estado a Aceptado"
                    } else if(item.Estado == 2){
                        estado = `<span class="badge badge-warning">En taller</span>`
                        mensaje = "Cambiar estado a Terminado"
                    }else if(item.Estado == 3){
                        estado = `<span class="label label-light-success">Por confirmar</span>`
                        mensaje = "Cambiar estado"
                    }else if(item.Estado == 4){
                        estado = `<span class="badge badge-info">Terminado</span>`
                    }

                    var cambiarEstado = `<a class="cambiarEstado" estado="${item.Estado}" href="#" data-toggle="tooltip" data-original-title="${mensaje}"><i class="text-success icon-note"></i></a>`
                    if(item.Estado == 4){
                        cambiarEstado="";
                    }
                    var total = parseFloat(item.costo).toFixed(2);

                    prioridad = `<span class="badge badge-primary">Alta</span>`
                    if(item.Prioridad == 2){
                        prioridad = `<span class="badge badge-info">Media</span>`
                    }else if(item.Prioridad == 1){
                        prioridad = `<span class="badge badge-inverse">Baja</span>`
                    }

                    let fecha_inicio = '<i class="mdi mdi-minus"></i>'
                    let fecha_fin = '<i class="mdi mdi-minus"></i>'
                    if(item.fecha_inicio){
                        let fecha = new Date(item.fecha_inicio)
                        fecha_inicio = fecha.getDate() + "/" + months[fecha.getMonth()] + "/" + fecha.getFullYear()
                    }

                    if(item.fecha_fin){
                        let fecha = new Date(item.fecha_fin)
                        fecha_fin = fecha.getDate() + "/" + months[fecha.getMonth()] + "/" + fecha.getFullYear()
                    }

                    html += `
                    <tr>
                        <td>${fecha_inicio}</td>
                        <td>${fecha_fin}</td>
                        <td>${item.Descripcion}</td>
                        <td>${estado}</td>
                        <td>${item.Nombre +" "+ item.Apellidos}</td>
                        <td>$${total}</td>
                        <td>${prioridad}</td>
                        <td class="text-nowrap" id="${item.id}">
                            <a href="/cotizaciones/modificar/${item.id}" data-toggle="tooltip" data-original-title="Editar"> <i class="icon-pencil text-inverse m-r-10"></i></a>
                            <a class="detalleCotizacion" href="#" data-toggle="tooltip" data-original-title="Ver detalles"><i class="icon-eye m-r-10"></i></a>
                            ${cambiarEstado}
                        </td>
                    </tr>`

                    if(item.Estado == 4){
                        htmlTermiado += html;
                    }else if(item.Estado == 0){
                        htmlRecha += html;
                    }else {
                        htmlActivo += html;
                    }
                });
                $("#cotizaciones tbody").empty().append(htmlActivo);
                $("#cotizacionesTerminadas tbody").empty().append(htmlTermiado);
                $("#cotizacionesRechazadas tbody").empty().append(htmlRecha);
            }

            $("#cotizacionesTerminadas").DataTable({
              dom: 'Bfrtip',
              buttons: ['excel', 'pdf', 'print']
            });

            $("#cotizacionesRechazadas").DataTable({
              dom: 'Bfrtip',
              buttons: ['excel', 'pdf', 'print']
            });

            $("#cotizaciones").DataTable({
              dom: 'Bfrtip',
              buttons: ['excel', 'pdf', 'print']
            });

        }
    });
}


// ----------------------------------------------------------------------------------------------------------------------------------------------------
                                                                        /*Funciones de cambiar estado cotización*/
// -------------------------------------------------------------------------------------------------------------------------------------------------

$("body").on("click", ".cambiarEstado", function(e){
    e.preventDefault();
    var id = $(this).parent().attr("id");
    var estado  = $(this).attr("estado");

    $("#selectEstadoCotizacion").val(estado)
    $("#botonModalEstadoCotizacion").attr("onclick", "cambiarEstadoCotizacion("+id+")");
    $("#modalEstado").modal("show")
})

function cambiarEstadoCotizacion(id){
    var titulo = "Cambiar estado"
    if(!id){
        mensaje(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
        return;
    }

    var datos = new FormData(document.querySelector('#formEstadoCotizacion'));
    datos.append("idUsuario", "1");

    $.ajax({
        type: 'POST',
        processData: false,
        contentType: false,
        cache: false,
        data: datos,
        dataType: false,
        enctype: 'multipart/form-data',
        url: base_url+'/cotizaciones/cambiarEstado/'+id,
        success: function(msg){
            var data = JSON.parse(msg)
            if(data == 0){
                $('#modalEstado').modal('hide')
                mensaje(titulo, "Se ha actualizado el estado con éxito.", "success");
                datosCotizaciones();
            }else{
                mensaje(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
            }
        }, error: function(error) {
            mensaje(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
        }
    });
}

// ----------------------------------------------------------------------------------------------------------------------------------------------------
                                                                        /*Funciones de modificar datos*/
// -------------------------------------------------------------------------------------------------------------------------------------------------

function datos_cotizacion_especifica(id){
    $.ajax({
        type: "GET",
        dataType: "json",
        enctype: "multipart/form-data",
        url: base_url+'/cotizaciones/cotizacion/'+id,
        success: function (msg) {
            var data = JSON.parse(msg)

            $("#selectPrioridad").val(data.Prioridad)
            $("#fechaInicio").val(data.fecha_inicio)
            $("#fechaFin").val(data.fecha_fin)
            $("#descripcion").val(data.Descripcion)

            cargarClientes(data.Clientes_idCliente);
            cargarRecomendados(data.Recomendacion_idRecomendacion);
            datos_cotizacion_productos(id);
        }
    });
}

function datos_cotizacion_productos(id){
    $.ajax({
        type: "GET",
        dataType: "json",
        enctype: "multipart/form-data",
        url: base_url+'/cotizaciones/cotizacionDetalle/'+id,
        success: function (msg) {
            var data = JSON.parse(msg)

            for (var i = 0; i < data.length; i++) {
                var materia = [];
                for (var j = 0; j < data[i].materiales.length; j++) {
                    materia.push( {
                        idMateria: data[i].materiales[j].id,
                        materia:  data[i].materiales[j].Descripcion
                    })
                }

                tablaProductos.push({
                    idProducto: data[i].idProducto,
                    producto: data[i].nombreProducto,
                    descripcion: data[i].descripcion,
                    cantidad: data[i].Cantidad,
                    subtotal: data[i].subtotal,
                    iva: data[i].iva,
                    total: data[i].total,
                    materia: materia
                })

            }
            llenarTablaProductos();
        }
    });
}

function actualizar_Cotizacion(id){
    var costo = 0;
    for (var i = 0; i < tablaProductos.length; i++) {
        costo  += parseFloat(tablaProductos[i].total);
    }

    var datos = new FormData();
    datos.append("idCliente",$("#selectCliente").val());
    datos.append("descripcion",$("#descripcion").val());
    datos.append("prioridad",$("#selectPrioridad").val());
    datos.append("costo",costo);
    datos.append("documento","proximamenteModificado.docx");
    datos.append("fecha_inicio", $("#fechaInicio").val());
    datos.append("fecha_fin", $("#fechaFin").val());
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
                url: base_url+'/cotizaciones/modificarCotizacion/'+id,
                data: datos,
                contentType: false,
                processData: false,
            })
            .done(function(resp) {
                Swal.close()
                var data = JSON.parse(resp)
                if(data == 0) {
                    mensaje("Actualizar cotización", "Se ha actuzalizado la cotización con éxito", "success");
                    reset_form('.validation-wizard');
                    datos_cotizacion_especifica(id);
                } else if(data == -1){
                   mensaje("Actualizar cotización", "Ha ocurrido un error al actualizar los productos, inténtelo más tarde.", "error");
               }else if(data == 1){
                   mensaje("Actualizar cotización", "Ha ocurrido un error, inténtelo más tarde.", "error");
               }else if(data == -2){
                   mensaje("Actualizar cotización", "Ha ocurrido un error al guardar los productos, inténtelo más tarde.", "error");
               }
            })
            .fail(function(err) {
                mensaje("Actualizar cotización", "Ha ocurrido un error, inténtelo más tarde.", "error");
            });
        }
    })
}

// ----------------------------------------------------------------------------------------------------------------------------------------------------
                                                                /*Funciones de crear documento de cotización*/
// -------------------------------------------------------------------------------------------------------------------------------------------------

function generarDoc(){
    console.log("a");
    // var doc = new jsPDF();

    var imgData = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAQIAAADZCAIAAABEo6lfAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAALssSURBVHhe7P0HfBTXmiaMgySwfe+kvTuzO5tn99sw+/03zO7sfru/GRtJnbsVAKmzJEQOxgYbJ3C2SVKnquogiZxzzjkZMDmYnDMCJBAoS530f95zqlstIWHs67kmvRxK1VWnzjl1zvu84aTq0vKKfjpF2TESjdA5+xEO0zmI34riajQaCQWb62prHtx7WH7x5okDJ7esObxi3r4p0kbXt8u/+mDBx0Pmjew7f9TA2e8WSv1y547su+DDwXNH9F34yeC1X32wSZi4f+6kI2tWXDp6pPLalZr7FU31tUgw2hKJsMRZFjjlGcaJX2938RX9CL2CwU8mcFk4HJYZHgfGicR9jCKRSLCxuu5e+ZGtm75bMHv5+K8mvz2orH+Bt9BSZDUUmTMmmHTFJq0DwaJ1m9Uei9ZFR53HqHUZNR6z1mNC0Almdteq8xRk+wfapowastTxze7Z047v2nT38tmmhoZIMMjZnWVLZaGSJQIgfp548RV1RK9g8HMIAlk+43ogEq59eL+q/NaZ73fsmTNpwWfvCYVmodDosOhdRrVk0ok5GtGoESwayaSXLCrBjHOwuMptVnpMao9Z5zGl4yeuu0xK0aaR8vQ+s7LUli6Z0n02pWhWSGaNiGi5Koctw9knJzBywPdLpl859cOj+xWhpsZoJAwAMHDGiLP+KwA8Hb2Cwc8hJoABhWhjbfWlHw7uWDJnwfgxpW8XuuzZHrNeNKtFm85nVXlMKq9d47Eq3ValBP42pvtMCq9VRecmhWBSuI0Kj1HlMqlEAoBaNAMYQIWasGFRSTaty6J2G1WiSS0gTbNWMGm9FrXPqhVNBpclQ+xvLv1o2Gqh6MjaFXWVt8MwmRK5/xUGnppeweAnUyQcbqqvq7x15djqBZM/G1HcL7fIYnCBQa2Q+grRooaRA5522cHEKsGq8ZpVEoJJKdhUglEh5KQLRsAAWkLtNTFIWNRCrsJrAlRUHqMS8X0Whc9sEHLB/XrRavBaMnCCIFkyvEY8ki4CGzaDZNGLOVqPUe+1ZpUO7btv3tTbly8GmxpfAeCn0isY/AgRQ8WYKhoN3b184fvFC5aO/aZsoN1lyYQR7yZzRc2MnHSPJR1im2weEwIYXes1ar25Oq9R54G8t9B1OAMUx6QRTVpm6kDMk7AXzNAJsIvYOWkGNd01qQQKUBEqyoK8CA05D0iKIqs8ZgWekixKxHEY9ZMG568qHntm57bGRw9Q4EhE9mFIe9HZK3h0TK9g8ESiviBinVCo+da5Y0s93zr657otmWKO3mdUBXI13lxlwApWVnrMZPk4rSpoAA/jVzC6lKv15Wj9uVq/EWaMFhoDHrCbnGBm9rAA9n08MHZXwZryWBUem0Kw4UjpO2xqh11TbNPgxG1FHERWiXA/cqEigByN1Fvtz9XDXvKPHHD6u+1N1VWEXeYzyIYSXPhXWHiMXsGgAyLDPyJ3gIIqr1/eOGOSNNAuWPRkw0AGW1VOC2S/CqwpQsDL7AtPV48ToAJBgIQmSEBgw+KHfQ//GCJcVh1ui8oFF5lhhrRH2wCGxpGwZFHBZIImAYpEo04yarxQMuB7oxoJ4iL1LJl1bouelBIvmwWA0bhsOqGvceFnHx3fvvXR/cpoKIQXicha4RW1p1cw6IA4rwAJ9dWP9i+bWTLY7CATRe0zqcqMGjFXARPfbVGCg+HRghfB1syY4UzJVAEzb/g5MOAig4dSYB4wN3JIlsciPxaQoJwmBWAJYBAtBA9IfcAJScWgooF6ccNSIjOJOqDcZqXLqgjYM5CR06IrtqpLRvS9ffJwc2MDM4xeAaEDegWDjikcar555uiSsV+4bRlOSH3YHhad36qXYAKRiQ97BtKXmFgkeU+SGz9Zlw7YsZWD4yHO7jFP4ImBXIvEdGLnhA1CVMKteOB+BfW6QofgHJ4JkOC1aNy5upJCyzLntxePHgg310MpvKJ29AoGj1E0GmxsPLhuqbvQRN2d4GArDHoa2PLCHDeS0GWGDfBA/ZsyX8ZsG0juVq5lASDhj3D2ZT/5SWucxwKg1RqBW1ZkbjHPOx6N0uQ/kXsMNjymYFULuWpgwJebGTDpfL2VbnP6BKthVcnEmntXouQ6v6JWellhANMfxkGCA0AzI6gnJXr92OElE75x5WWLNr1kTqe+ThhCXNLz8CMc/OuHhOIBNmSnCeY0ryVdMsGW04mD8ncvmBVsqOfmEfwgXgOc+AyRl41eShhQZ0lCY7OZOZFwONzU+P3cac68bIm5sB6T0mfWleTCH+UmCrOFGJM94zCgPlZ24raoHVYljDo2gE3DcDRinQM/2zD/q88rrlymt4+5CuQ1vKx+w8upDXhjsyOXiJFwze2bG0tET0Ev0aqW7KkQnJJVK+Zm+CwGeKVxDiOTI3b+PAS4NEqJvGety6R3mzJEq55ZcbCyMmd+POLc/t2R5qZ2AEjsJXtJ6KWEAWd9GQwkBa+dOhEYVOiwZhVZ1U5LutibpjzQLAar1pPLhShx1XOgB3ggV4FO4Dx4yZXXuU06wZLhNWd4c0mzOS0K0ZjqtOvG99b9sHU9qgAKsc2UpJeMXlrfACggIISamo5/t9339iCnTS+aFSWWTJ8pQ7DysWFIzVQvTf5pdWoRyE+I+bvPaGCdrSghTV/Fu1j0oknrNakQmB6gvlfJkuYzq3zmTHGAfd/SBeQqxJRAomZ4SeglgAFrVDatoFUDxGnvigVOWzbv8JGHdVnHTgJXPV9W0NMFk1rK1UkmncdC498Oo3bXvOmRUBAV8ngVvQz0kmgDyDlm/zKBxzqFonWPKnfPmumx5cJm8FjlHkli+gRP4AUONPGb1IUCwWvVSQU566eVVFfeQ/2QNmBmEtUVLfJ58YHx4sMATRoOU8PiHI1KBCM4Gt5QIk4wGaReMBhUgkXJFIKGZi68DDBgM/PYtAuFYEkXjOl+s9ZhzFzu/Kah9hEqK+4nvCTK4WXxDbhI401aX1W53DVRNPf0WrWileYjsKlpZDS3Z5cXOcAc4lNClH6LusSihS/htmqXFH9TVX6TSY42E6tebHopYNCmDyQY2lQqidasErPWZUx32mEVqH1GtdfYjkte8MAHpNk0EK1kzRSMCp9d46VR8Mxpo4bWPShnZtHL4im8wDCQG5DsXNm6jdQ+rNrqd4t5ubSSy6yWaGUMYKDiC7uoCwUswj2EVo5JdJdfkCDSdFQdXlkw6T1mPXWF2TI8JpVoVXtzECFr+lcf3791kypOrjpGL65+eFmMIrQfpNu2aT6HWSdQIObmnZ4ei4ZNGZLZ/WUwjagvlSGfVikA9iaaHOWGX2QBPFRAhWjtOX/8Fw01NWB9XntxjUo1mYiNF4JeChig2YKNjQdWLnLl9xLtOo9ZJYIDaCmMBnqAGQYIMou8JB4Crf6hWahskbRZSR4zw4aLVk6r/CaDkGfaNW1yU2N9OBziSoDphhcOAYxeeBig1UiXn9y6wlPYy22CI8iNH4i9uLXDVkW+kOMDnYZWS4+NEiLI1+E3e6w0qdabq3Xbso4un98SpiU7XC28qL7CCwmDdk0VvfbDscA7fYpztKIFlgC3f8D0cb5v5YmXJDBBQNyf8O6yPhShH+gi/GboCr13UN7F/d/JauDF1AREL742uH/jmv/9gV5LBrU6LYenWRIcBjERyPHwEoGB+QZcHPArcYlAMKBqsdNwiseictsypOF9H1y9wCvzlYv8HFGr0Gqqq13k+la0ZTEJR6wvWX9xdv+HxQ8X0p0H5P57F4DNQeIrh2jrF9aXysSEwm1SFlk1C7756P6dcl6vLyQSXkxtEA5Ti4WDoU3zJrvs2fAC3Ralw4p21XhffCe4VbT/9AAA0F4vHjIdUV3poilNIG9Bu9RTFAoFX2mD54bkzoxI5OKRvUWFRo9RI1lVwIDDTlOmpRcNBq3a4Bd6LyUDg5Y6UmkTpDS2BE9T3C/nxKb1kXCIOp5fOEf5hfUN6h49mP35ey4TiX/WujrYu2xDlN9HWPJAxlUstLv1DxKeyN+JhaHwe4LBYwEM4CFQhzJSc1sVNOnQqBGshmnvDXhw64pcvy8WvZjaINTUuHfhXI89y2dViJZ0waTxGfVeC4MBWy2Q2PA/GhC/7SOJ5jhnvvitXyZ0VsKOSgJmpcBu/VwYJMwmZFOvCQYi7bSndlvZpEOLrsSsduUbFk78qqm+Tq7oF4heEBiQzdranRe9cfywkGeUbHxojNiUqXgEjWQEJDS0eSi7zpiGFmS5Tem01Q8caCuLyba+EkzpkkVL+wLRQJuK9mIxQp8ATghgERjNNNiERGBMC2xrugSEdBrAsrS2gWJyf5QepJmtbEzXa9b4zUpaBWpGkWjTX7yCB44NLZqhCdI068Gi8yAvq06wGHAiWgx+q0E0qtlMQbbdHWwbvAJ/i8cK8HQh8UU0HqsCBROthu+XL3jxNrZ4IWAQAwDv2w7W1y53fAtORft5wJoxPuBikvgVjSp3hrAADqPVWDpwPMEGLG7VemkDXYPPrHeDQa0G2kmXoql8VpXXqPDxkVfwKO9jQSAmpukJ8s8fCwQDghaT7kxBgX1pRoNZ48IVK2CpJw1mzgDnua0QzFqnlTYJ9tgUbspaI9i1tKedSekFGHJVHmDepnFZ1JJJ7WP7eZEsZxuKtcv6ZwRajGpRETjN+pJ3+1dck00j1PuL4SW8OEYRDfAwPFw6ss/dL8eXn0lba6EV+da5XPbTlhNsEhF9XIMJTrql8FpJDPsABhL5XPbDqaAto5nQhYRWSBaV16L0m9U+s5ptKw1xSz436Zk4ophiiZ0/OXAc0r5GZIdQwInaZQEra912oC7LY87wmAyCDezOcMt0GlydUpvKa1ayjeNRqnR3bjoMP2eB1mEjoEpmLdQdrSUy6wDp2Bj57xW8QBdqxqgQrSpXXq/tsyeFY+qX1/nzTi8CDBLnUTdVP5w+ZoTLpqN95qxaHy2pacOXBAzG/S4zbbsLgQr+JnsDzGSGdFfCrnCRMFbjSB+bMYNB02kzXfA9m4AkGuE+6mg+kgyDBMWC8NQwYCXh0hoQhcFDZgxlh2LYkZHSY1PBrS+2qJ02ncem9/fpFejTs6xPjr/A6OvTW7BlC3adw6IWbVBfpOLoRQhOpFLIUqKZc2waaWumPzeYNF4jpc/2w1N5h+bfPHOcAYAh4flXCc89DNAYcAx4f3YoGDy2bYOQ1xtCEQIevgF4mu31yZsTopdcQMmihDinwHbhddm0Ey06oTDH0zd30sh+C74YtXLiFxu84zd4Jqwu/nrxtx+VjejvGmB29ckZZ9I7wHNGnQD30UQfZWLJxnQCO4/l9aMBMVEwAJI+9wQgAbE+I6wOeCM099tl10l9e04eWbjS/eX3C6ec+W7T+f27L/1w4Mrx49eOH710eN/ZnZsPLZmzsvibKe8Pc/W1wHyi/pw8vcdK/gneWoIGI/fgKWH5pAC9GqAXBD6RpgL6aqHjy/raGvD/i7GfxYugDeJiqbG6ataY92HHQ4k76csaMX+Xj48yGDjhPtqUMC18Rp2UkyEVmKaMHrFiknBo+6Yb58+FG2ojTfXhcFMkFKJtvOiDTpFwU2P17esndmzZMt0366PhYp9MF43HkQEjkEdBO2HxvYzIMX1aJHAYQHjrBZMezOoDFE1qBwDQJ3PqR4P2L5tz/fiRxpqH4eamlmgY/+IvKxPtrhSOBoPhxvpbp04eWrlo8dgx0gCzx9qTeepa0QYLEPqNYNDqw/ysQO+Yq/HCPEOt0jZ+Stcgy7UfjnCDiMug55peKN/g/N6d/r5GL5xakvpoP8haMorg+5I2NwIPsPUV8AoccHkHmDf7PdeOHKyuvNvcVB/nLzm5RKLLNMkeeHhUcfvC3q3LHJ87+mY54DhadS6wms0gGpG+0gcZ3Ao8CtwvbxckOB42HZwWL3O7yZ2Fm2vNKLJnz/5i1MldW6or74SDTXLuT0MME001D2+fOr7O7/L0s7isBidsJDt1FjG8aZGRE3IBRlR7b+EpcQtrjbwXqFMaVjNplnuKw2ynxw7r7PmiF8I3YJv319dWTR3zrmDSQTDDA/YwdiSLCGYPqXWtD7Y+GQkGb6FlhVh0+dQRkvc8iR9rS7R2IkJCzY0Xd2+c/F5fVx4cWT10ix82DPXkpIPvudHPmI+fEJ/hOkGCfboGEhosJVrVbm6423VOqy7wbt/Da5bWNdUR5uR8npb4e9CBHg6Vnz2xRPhW6NObvhZlMUhWQJQ4mDQD9RRzcHLuf0oMEPcTBli/gmAiGDjzjTfOnGBZP7Hungd6IbQBdZNGLx7Z7TZC5sG00EPQus1wAOjTL6LZ4IaTYKfNqtxWg3tw3g/bNjXX18eZDexNzMM0+xPAQIuuwG8sGk4j4VBV+fVNUyQYIbQrqFkPK1+yZHotfPSAOB7GAwL4nmOA3Gug1KgNWNQOu8JtVZXZDH6zEm7AYue3D27fQPJxjkKRQDihDVd/jHhkPs2BU2Nt9cWD+3zDB3nNWVQYezpK4qbJEXoXfW0WnP2TYMDGImgQg8YuoGDhlBdZtetLxjfXVcuFeJ7pBfENoBDWTfVSpx55vRkwhd3mdA4Dt1nrzdOK5jSvWRMY0e/Cgb2h+BcjuQRFCk/088BeDDE8Kh1DbCUKYSLUdHTLullj3hXtWUjfa1YwJaChDnuYYdSVRGsaSQkQwwEhtIGcH3rAqJAgXHMzPAXGnbMnBRvqWdqc5Kz4BX72tMTiy8Nb0ej98htzv/ms2N5TzFVKpjQ/fX9NJ5ozyaf/mTDgSNAIdrXTpvEPsZdfOEN5Pef0gsDg4b3ykpGDPDRCrJWMBjZAC9EL7oc1DM841WPROAtzLh7cg+j8EZnVOKPJ7NYx1+Eqvxthn8KXn+PXQZHwg6vnV7q+dtGnKZUC9fMoXVaVk76KoPUQ68d8aFr1jwCuUvpyAVdVUV7PbYtmRYLBWGnI+iKtw8+f3vVk5WBlYr/kK0R11VWHls1xWLMklCQHKgi5o5bUKBLU1FPDAEYRmVX0CO8mhtmJKrXrd86dTlk+5/Q8wkDmknibhyORk5vWSAW5glXjN2q8uWwHUpK7OFGKVvoCscvec4XPHQk3swfbEJf1nPdoQztGYCB2pHNiR8ZSyItff5yqK24tLf662JoJqcl4S+WFeWYxCHY4DzQqBxiIRhp2cFg1XrtG6p0OBbIi4GioeSQn0Uos69gxjhCWeWvunZVEpvhdxGt8tLFU9OT39IKPLRo2EI7CMPOGFZXP42jH920CwwAAjEegDdgnp2h4XrTqZox5L1xXI5fsyUV6hulF0AbBhrrZX30sWqEE1D6IOjZPQTAa6Jt81nTRmu616aZ+/E7jw0fUWB3NhwGjt29B+SdvXCIGBvbvMaJko9Hahw+2L5zjLsgGx/uteqG3WrTqXeAz6shnnjEMNoummPqXwEaG+Z99UFd9X06iI2rNixWOF5HnRccYJZ7HqP2V5vq6tX63YM0uIfYFZ/Phc3JXSG3G2J2f8FttAzzj1uvs42sKL9sC1Z2Xe+XQbpThCfXz7NMLAIPotZNHxb69SMvDDWC9+DQgZcygydXWdBgqDnPmofWrKWoHHBO3PWTeYs3JoUJ7PsoU67YPhzowVMg5ZYkEm5tW+l3FtmwhRxuAx0z9p1onRCmVjZhJYLM5XFZdcY7m5NYNeOTJw0/IlbienxCrsT+sLDxT+UeHJN/ij0Yrb16VhheKuVqICTbhnHssMmfzQMI+BoYnBBifXoAZvhAQbtSvKXFHErp3n1SkZ5WeWxjE6hre8YFl8125aV4rGpV6MAT4qTR0asBPyaSAfvAPKCi/dB6RH5P5jIhJOFOBreRNC8Mt0fpwXbAlUh+hfZ4ZM/5I67JkovX3763xOp0FORCZMEJclnTYIdR3RD3uZFVLuXCgDb5RQxurHyCnzpLlYjX2knQSikZh0tVFQ6FoJBgDD8+UnydQ/ApO2DkiRcJXjuyXBttEO3VkMS+ZBtHpHMydaBd1aCDhFaiLiT0LrWvV+2yEJb9ZPeOTEdWVd1h2zys999qgua5+4Ref+Mk3TSPn2Kb0WNLRxrQZG82BU3iNusC7Q0N1NVzudix9ic+In6AIrjZU+I+tGr6jJHflOOvaceP3zlt9eV95XVVzGHzYyl+JxNOM3wwHGzaVSa58GGlKtw1GkRIMR5sEW2hg2w/nOD/7+JaVXOcwCf8kCraEqkMNZx9dn3Z8nbBvWdGBRWXH1264cfRi7Z2a5vow3PbOelSpuK2JE+AikW3zpzhsBvAxKU8oBFp5TJDgNg9OBCPNfm3l/nig/i7a14P9pN3+AGzJqvDlqsWC3CvHDyMLFIbn9dzRcwkDEn9cBEZbqsuvlbxd6DQZBKNGJPeUPsrNxBsJYPpIh8Uws/irmEvQCccwCkbC+ypPvTlr2BsuRYqg6OZUpLjT33Cn/85r+L+zB886ubE6TJ/Ng65gHEZJtcMFLxT+NNZVr5/qE23ZPpPWy6bxSTady6Qkm82oLh1Z2FB5lSJ2Uh5KnaXV0FK77doe66ov/t0U2x87Va+7015zpr0uKP6xL+v/nZxnXf7NglOby5uqaY/uGPGStfm4G34yPYhb1VWV0z98F0aa16x1Q1WaYOJDuquKbRqnTe03qnw00NbeWHo8oIYJMzQ5XCHZMvcsnIOK4WWmfJ43eu61wdXvdrgKejutejeJMQXtVE4+H+wQEsBek9Jl1m+ZP5M4gbPvYxSKmfunHlz/74F+f+RUJItpXbzpyWJ6V19qku+tPxLTfuNS/qnYe8Aa97XGB0iiVf52lCC/CD9hiTBBMGaD4bywH2i5DPVcSfmZC7/6qLmpWX6yoxT4uHhduHFL+dH/LOb+xqPqIqR1E5VJ3rQkKpLiNfz0qP/Uo//z4izV9OELr31XH26CXddRaVpNwRCzwe5fORcYnufJVUl2nZRHs8fhJNAEb6vcsUsdo4/xfWJgvjKcbGgGwEDpMWkWfjU6GibrsVPV9GzTcwgDCLo460QiG2B+mHWiWS8ZIcPYwllaQEi99TTPlKZDZuxbsYAe+xGKjjs4/3WPJsUPGKQmiWnJUnpXSZEsKFK8SgYJ9W+kzNQ57++rOB+KEptSk8tSuw3hCl2ORhseVawrEyVrdmkvNQ2W2TRuk8Zty1juGhcNE0d2wjR0ET7K2msH/rqkoLug6upXJPmUKQLKk57sUXR1K5NKFV39aV39qd2E1Dck9V+UZhesGXuo6kpzq0iWX5gfqSM4oaDHtqwVCnPgsUDwO22wIWHbaLxG+to+PPgf6TxlgfQtO5LqMGldA/If3b4uK6LHa+SZp+fUKJIrurmuds6Y91wwcKmDCGIp3U0w0Il8PQAzigCD7xbP4PGJGx4ntF4kerf+wd/NHNalTJMsvpUkpSZ507uB9aX0JH96Spk22Zee5O3R1duju0/3Xyf3O1B9SZ5VxlNoS+FQq4lSV10x86MRglUXsOrF3HSwjtOiXz8pQK/AWKYz6fkoVJ+z+tskQdE1oOoSSAMgu7sVKQFlV58SAOgSSE8qTUvx9UgS3kqW3uzuU6U41X83dfClhtss3VbCj0SwcQnSXFM9f8I3DpPOZVSIdo1gUcBj8ecSDFxPBQO5jxVHGiw3a4utvY5v2YjX4XrsuaPn1CiS5e3tC2cDg20wUqHKvdAG8qc6aFZPAgwMOxbMYtE74Tiyi0Jrru/+nUOf7EtL8r7VNdCjK7gf0ldM7wLlEFAmBVKTpbeSS1MBjD9yqv925sDdFWcjLZ14hIztKDv8j0RunDnmebuf26r3wvg2pUFTbZ83gxWnI0wyAjgO3Tv3bwLm5ID6NSkthWAJdwVlS0XBuuJcRHnSkoQeSf4eyV5FN3d6iqR8TdT8/dRhR+9foMx5OvzIf1FxZEjgtO7e3WmjR0KLwrBxWMmw4Xsbt2X3HwkEAzpq3NbMlQFPS4h3MfNsnyd6/mAgNy07nv1u23g2HiTmsjU0pKNp9kSCb6BwmnU7FsoD/jJ3tCVwSUMkMu6HOX/qUHUH03ve6uJP7VKSDj7rCltcUqZ4UpOFt5LKIIN7JAs9YIckS5r/OqnwbP3tjtVLAgWZxRyqejB9zHuC3YDy+KzKHXOnc9bE/8eLxK/MO7fpL9yZ4PsUb2o3sUdXKQ3m2WsC+S1d/T26+lRdYbaVwltQQ1HQ0acCYrt5ValT374ZfhTmWIylRn5RnGJZXjq031VgpNXPVpWbdnflHUE0uNGO3dsFJmtIaZBRZKZdDuBpzPvmo2BdLaGbp/5c0fOpDVhVR8KhPfNmFjEY0FQF1jYuGhiCl0wzwAQrHD5ykbcvmN4BuyVQY0t40DbXb9zKFK+iqwDjhyQuBH9XKRXnKSJBAu5pVx8FMpCE1BSXUjn97R8eXOE9JJw6RAXdCEcfXL8yefS7LrsORsj22VNxjd9jUdoTrk48NP9PnTDGlF29QF1qF5+iCxQUlABz39sFKjDsN29al5LU7oL6vU2B2mgjT6oNAGJERQ1HIsHmfctmT7QZBKPSY4FFpJXMWrZ47cd7ihICTdzyG1VTPxhWXXFXzuB5o+dQGzDWgVoPNjctdX7Lxwe4OQspRaYqrQuh7nBaZ/x0MGiIhgo3TuzmUXXxpXeBEiAAcPaKsb6kSIHQ9cExTe9a2uN1d2pySdrrHp1+8ft3m2rjnEbs1RHbMcZuab5/e+6XI5z5GTsXzgozit1pT7AtPts/63W3BsUA6ydJaZD0KFtXH/BAfgIvIVQEAVVKTYbSQExE872JYv+51HPx6e9RRZ0UJoFCzStdX0gWgx82m13nteol2vQlkcsRgAoe2l3nAeChDW+8A+13rtAY5fNIzyMMZNZpqHk0h6xbQ5tWifV5c6MIMHA+DQwiwT7rxkKOdvGmdoEhBMODWEpBOoHEbVoXoIIBAyHJrwLPQSonlaR396p7L/3sXPVNMvSZL9BhRvwajrcunhFGDlkUEGPagNwAOmlLkZbIF/umvSHpwPRQPkAmaQMUABjghWlVBVAOVFoKVHKor7TkgOr/TB1w6MFFeVzvsSLx37gOun3uZMngPuT12mjSh8+qE9vsdoz6ZKMx7WFAvaWxiyrarKlP76vHj7JX7eCNnnF6/mBA7MboUcW9KSMH0eYLbZqnDQy8BAPdU2gDwGDc6wwGMjMxO4TkLliN+I8Fxn9dmVTu5lN2g7lSqvnjIrV58afXozRJLhgMPc5znOKCuf5B5frFc2En8Z8dyutQS/Tz76e9IehYnxX4mzz1Ll4oBOCB+J6FOBJwK0GJ+VO7uRS/daszZ4y+0/SkNTE06ItiRSLnv9vszMsUjQqv3eAxqdnKIT46Fq/SOMfHQxsYuKxKIb/X2Z1bGQZeweAPQkzsRu9dvuAfZPW2h0EstMLgaYyiYMGG8a8LZBSBk8gNJQEMa5uZ3QAAZzgGBlIRPkWylxzT7iJF6CapbSvGXq0ly7hjGPBrMUnZWFMTZb1MnUTG1cgX+2e84dEgOzgGyBEwQKZtub81ME9GAW+eqa80eNXJouJPBMPXe+eEaA5I+1xiA210wN1oOEjL6Ow0CwtVR/Oo28DgyUFLa0ppK42MQyuXsjQ7eqlnm55PF5lphKtHvhf75HY4TZI6MWJG0dP6BuvHvyYouaCFLc5h0AYD8UD2CThS1VVSdfOmJ3t7JJUq3/Dr+6yaeD8E/ibiuQGu7PxJWXdGn++f9ppLg+yYamKZktSn4iUUJnaO8gAGorKbB0hIT/L9fRcpFe7+X4rZayuOBxOHODopS3VF+fRRQ10WnRfczzDAP3RAe0XS3hadyBoKqGeNZKMPgmyeMYXS+jmv+yvTcwgDVsuQZmd3bBL79PQ+1tX9C8OglefkQLfI9lACBsxJeKtbAGiB9M16e73nVkNlkM1f4vmFIj9zOIlg4AYMuIXWGQx4wHU6YWMLyiQpPak0NcXf4zUh7TVB9TfThhyikQTSADzlDohVzvkDewJDC9myDRp4ITzQXF0aJH4yDHCkzcUsmvU+N6ys5xAFz6c2QE2jrg8umyfSusd2rfIPAgN+IkOC6YeuPmUXGCE496f+xtPjdbgKkuoNr+GdzUJFpIYPI3GK/mh3TUf0xYHprwMGPhSGOm2fCANWMOY2wDRKgZ0m9uhemtYd4JHSuvn0fddNqA/Xc9XUoaymiRYocDR8dP0aIS/bbc3wWLS0YbBRSVKG9K2es3tHgdlRRgUUyHLHt1HaVelJVf1s0nOpDXiLbp1a4rHq2GqbNg3zS8IATmec22LWEbG+RDOOkmiiEUVIkRSvi4pu1KOa/ju3/v2d/mvND0jGMuaS8/iJ1DkMYuWRA11HOVm0VDqn8qBUPVJ86Sl+ZbJP8WceXdGeWfWRIBQC7fDVUZGopHDfHz5YOO5zhzXDadELFtQhmFvJ5l1DGzwBBiqfWSkZNYu/HhNpkscrni96Xn0DNNwy1wTBSLsDtWuYXwYGYhsYMD6L/SSOxElaFz79TlR0DSheD+iSPDDH01MCij9zqcfsnlpL/T0/EwOgL/Z3CINWAOAiK5tcmBTxzRTpLebJKJIlRXevsgtNu0hLLlEledL+lde4/tphJkI6xUAkFMZZTfn1KSMHOgADI/nKXr4jy5MCzS9iMFDP++qT5vpanubzRc8nDNBy4dDibz8Hu6Op2jXMLwwDsstTk8XU7kKPFCGtqz+9S+lbSYE3k3w9EKebwCafelXJHuVrIhtMYMNtf+LRj9k9834zTS6Q8/iJ9CXBQP04DHAOQCb7U3E9ifwBaCSK0016M1lEqRTkIYhKGukrwd1UAoM/LcmvUC9872rtfeojYkXqsGC8V/fMrh3iAJPHRjs7+WgzYKiC9io3IbAZ11Ydqn326Hcbn8+PgDyvMGhpbl767acwW39xGLBxAzZKBY6njhpF8iRlkvetJF9qioRbqm5gNb8SljdZRGQ+qRCZpj1D9MrTLtQpgup3To24b1GIeYzBIFvJySgYfCqn+cv9M153qRgmezAoxmEARu/RhTi7R7JPnezXdhc1v3UpgcPufmWSOzUZpYKCIuQQZqibNZD+G4/yj92aPus9FcFWNu3MYIsEm9eUeYrgGdvUtK+9PGGxk2ChJa+0IbFZPeuT4c2vYPAHI0iycKh54befimaNh5YZtGmYX0AbxMcNxPQUQZEcIBmf7FO+7tX/jxlD0pZ99B/K8roLym5eFYnkALgtFRqjSyA1WQDXQiekdvOrkkXVvxBzphxfWxtsoMxRZrbGQM7yx+jLAzNed6uYNmgHAzb3O5CeFFC8Ien/Y2lB4WbnsK3C/5059HVBmxJQJaMwYo9kqQcbCiR1keJNewNXvOndJ6j9x9eG2aABApf9HRap7tGjed+OdlsyBRt90wCV2a6SW4MF/oPWzWHw8TtNta9g8AekUKR5wfhPgQHarbFtw/wy2oDBgAQqZL+PkAAR+zfT+p9oKq8NNn7/8Kxu3vvJzjTwVnKpGv4oOI9P+OkCAEjK12m0qwf0xp8JPcuOrwW/0UR/cNzToqDlqwMzYzCIdZgSEmiGH7ze5BJoJM2/LjEuuvr9/UhjXbjxaN2t/zZ9SDe/NgWw8b7ZxfcmKTRRxcYTenQPoHg9kgKq/1ja50j1xXA0Guq8/5RKGW25ceakq3+uQF8ASvfy9Rtt61kODAaoZJhGs0a/01D7yjf4wxGx1LKJX8EwdT822Pn7awMY/cRD0AZSeopHkUKqIC3Fpeq55ItmtlNLYzB4rPra388c1l3UdYOElt7q4nsLOoFsJJ8qKaCEAMb1pJLUJL/63/ptK67urg/TFiZPj4OvDs583QPfgHUBxWFAPVQwh4DSHnBL/u/0t6813g+xIgUj4Uk/rP0Ttx7ITPL+PcGApl2ou3iVtJTU+1ZyoEc3v+I1t0oxa9TZmtt4REZmJ6ZRuLnp0PKFgi2DPnlG6zdYxT4eCAYapg008z4f2dzwShv8AQnNt7ToG7eJf4SmTcP8stogSaJZpWSEeBS58z8LcwjSXIjw8QdX/s/koSmChjkJPYCZ7p70JAFyWpEspHfxv5kUIHeiu0f9rwXjvFObGztbptMRAQZvMBjQZIqYUQR8pojAJM1ogk74++kjbwcfyg/Akgk1Dt8gvCaoSGMwo6iLn/qLYETRmDeUlfR33SUVXI7hW4TaEGDZaaVwuIaam9f7in2WLA9by9GunuVAvoHWYyEYLP76w0hTB/sCPvv0fMKAtd7GgFuwwSL6hWGAQPP7SRvAnAD3p8PpTPGld3Mos+Z/Wk8yFMSOLdHv7pz+fycVdhPgNyuTEOBPe2kcl3xr6jJKBUJeE5UQ4X9dYl94/bu6aLMMI2aad16m6NeHZr8haJKQNZAJTNLUOvLIicVpeQ2wquwx653ypgfyE6xSLj26lTp9ODRYMnMk4M8kE7ChRlRdJRSMfAY8++duw6zzO+phGVFZWkuRWB5cRwGrblwtfXeAx6ajiUYWrWShrfh4xxGfdOShFf3wDQyCXbe2+EsaRX5iVT+b9Hy6yKyRvps7TbJqaQn5Lw4Dmr/AYECcB22ghB/8uhMwGF3PN3phiaEMsLC3VRz7L/68lBJtsl+dTHKX8R+QQIMMfLFOj+4lxJf/yt1z49VDURpOIAhREiwRfpJIMNu/OTznDY+K+j25NvDTtDk+xTUJ5RFhFClUc9+tCNIcUu7sgkKR8Iare/5CyKblaV4l/Ps3vKmk0HzqJAneM1wdGG9vJftU/9lr3XnvFOXNisILkXAas5gikdO7N7kKaHd4r13nsSklG5s6wawghgclzbywZrhNuo3SBBhT7PHnjJ5PGLCWOrx8sWCTJVNi+OVgQF3ysK0h12HodxeUvRZ/QR2fxMWtK1qao+E11w/8dWmfFGgDCRY5sV2ySP338loZMT2lBMZV2msB9f+Y0n/j7UPNfGOLhP2x2xArquPQnN8IaojzbuRyAAYKggEVD444wKBEFuo5b99tquIPEQuzB4MtEdfRhX8qZoHXyT8RqI+L3oK0AV+vA3Aqkt3pvRZ8fK3+Pn8qkThESVlxrRcJr5tW6s3rJVjVLmu625qOGvaYM2jdJlQxTTqiD7cBFRun+hO3I3iO6Hn1DUBnN23wFGRJRsUvDwMSwAwG+CkpwTpkSwiq3gs/ayZuo0doYgJBgXEeGOX2oX/vM3enYd1UCF3IbBp2gF0uKrqJKvBfCiwZKf0Nt/Y/+PO23jnJwYRnOc+1pyhgMPe3kg7WFLxzrg3YYFkq9UqBif2aFK/irVmDy5sJBkiJ98aCULAHobrey7+kQbQAzKdUlIFSIFcH+oTw0BUOjJj2jwTDZ1snVzPfPZH4CyKl+I+ayntzvxrjtGi90AZ28D00AM0yos9AkRhS0SdorZm7Vi7hL/Xc0XMMg9tHDomF2f8Q4wat2gDcLKlSyMhOTXYrey9i2oB4o5XYhZamYOOcUxv/jdfczacmHUJqhODUjbbZIkuJ9AmN/qpSPJq/mzP8yL1LtGoej3dUMEjUsTCK4BsASAlGEYcB9dIiHUmVNnvo7aDsG8QKQ7BCuocqL/yXKf1SBFWKT8NSoNdhA4KkVbp51clAiKD4ncsw/8z2YGwNECimCnhqsk5A6pePH/QO6wv7hxtFcAxoYy95p2vaD8pjzTq2fTOVoKM3esbpOYQBr+VotOLqFd8As0f+oF3i+A534DgMVD8XBqybiHwDaANaFJ/sUvRa+Fmwk2QghBsi4cXX9v5VwEQusp86c7oLPbr7ejBUsGU6gVRcB7S6uzX/xdvnu3L6ToysVGKJcB4Kt0S/PTz7Dbc6KQAlIA+fgX1JOzFt0AUGmKDoMWvIneDDNmwXO28OhzbcOvyv/SbqxSpJ6xogJHQVU7sEaICZrCOoCH8qEvmbqX2O1t/kkyziJWlHSBX3jm7b7Moz0rC9Kd1L+x6gkrUSm4PtMSp9BbkXDn4vP/C80fMHA+IU1tjV9+9Neqdvgm/Q5uT31gY/AQb8Ghipubl50g8r/7nYE6IaMrub1CPJ+yY4j2QwJUj9/eBjMGKyW/HmtHePVV3gvUVchjPRSy+IX0XkG5A2YD1FHcFABAwGt4dBjJBWMBz6YvuU33i0MI2ox0lKfZ3GQ1K7ltDSHJqPDRXno+mAmkWf8U0peVJUiMcIZWuqrV3hcUrWbChbIMFjU0kWndeipUFMk0oqtN66cObJ9fzM0vMKA1B9ddX0j9+FQKJWIe6HQuB9F/QzAQZPsxb599UGxMHspD7YOOn4mr8MmLoG1PQgmNhPHUfk4PoUKSKNCnfx9Xh9kuq3TtX/KRl88N75ughZ52G+wTUvZzTqPDz3N5KuK0wXiPOfCIMQ2zoORbpZf18za+RvPOqkUlWykPZbkfb56loCTCppQBBIkP4+CSeS5vPdMxpCzUgpHOzAx8V1CpHIo8p7kz4a6bFqPHkad77G21tHI2sWtdeqnTy83/1b11jkJ1X1s0nPo1Eky8xgQ/2Cbz6hFSG0NCSOhF8BBvGGh0LAsS4SmrBn7j92GpK8yqQyBc0you1HIYNpH1Iai/DTvqhveFUpzlT9vE/OPSpvDpPvLSfC/o4/OhfaABZ8yk+HAa6wizhE9lee+Z+l/WACpfiV3cVU6AQyk/BeNLqsoH4kvK+g+JelOetuHWhka+ViiG5DLEE6nj+02/t2nhv+gFkpWTQ+s0E0K7023dyPRzY85P56B48/4/R8usisoiOR8LYZZS4j5376+ArzjPETSKB9iv5gRlECMes+Gq1ubvjy+6l/7NIitRSa98/2ufCqkoEBNipHw8AwlkreekMwZM75+Fp1RatdznatGHtsLqR4cgkA85ONIlyJeRvRUCQ86fSaPxUzk3wqplh6sHlKtHaZTSDXpHioeADDf5re78jts1T6GCDjJJeN7kVDwcatc8qcOZqAkX3+jCpcK5m0iyd8EW1uCjPTjj30PNFzaRTxk0g4fHj9GodZT11DZoPHBLWgpc3q2KY6MRj8gVzkOPHiRVqiNeGGD7aX/dahhyHU1f9WVz/kriZFUKZACUiKbgKzlPxpQEUXt9K4/IvL9ffCsaVhkMnfHiFtkBRI+zm+QdznZseqSGPBGsdv3fok/98nef+OulAlvCnUlOJ1gTkJ3jT44r/xKM3rvqhk43GJxJOnnliuiAHyB/cXuye4TXAM1AJVstpjMeycP4ciPrGen1l6jl1knJ09fKA4L4v1kOoEM+xUEv/AANvenYwi8Q+tDWSiEkaj95uqx+ya8rqoSfKqusFAgmnkQ2rkLpOTQJqBwPCGoH7Do++59IuL1eX8QdC4o3N/K2rJcCcAUF8ns2TS4Ff8OAzaElIsb3ikWvJhEu3d8uZrrjeTJBWDQTqtGUJ5AunJAVU3QfEXkn7i/lkhwIh5FyzljpO/c/l8yTv9xTzaLhZyx2k2XDm8h9/60fI8g/RcwoAbr/hfefPGtJEDPMZ06qygj9KRBmCOgewb/CowYFJTlsdXmx/0XV/8ulsLrn2NTcpILk3r4gcrUxaQx1ALsNe7+bVJHv2ATc47jWDrlkgoOv7IvN+6SBskiW8xGBAYnlYbPEbhSGTF1e//sT8H7kF3yppWpUHDAIqAAd6UnJCAorug/Etvz5XXvw9GSC91ljI1QSh4cP3yCfZM0gZmhTTAVHP3Jt1ijttzR8+vUYRmagkHm1YUf00cb4V2VrottFrKY6ItNSUj7cwMG+nX0AYUCcyMTMPRyI26Stvycb+RMsDHyRDqbFYPLdOhITaS8ZD33bxpr/k1v5H0BWsm3Gp8EI6Gxx+dzSZTUE8RmFU2iqSfCQPEaQgHpROr/9hpSCFQvdnVT+5KkkTrhLoAkAGmpnzpcEj+79y3zzbcJTDDxegs8XA42Fi3plRw2DO8JuWCL96LsqXMuNOhh/2M03PsGzA/MHp4zSKPPYN28DWlu60at0UDX5lg8Cv5BpyokPhPiovUwt3mOvvqr98QdeQfs8EEmhPhY3M/wdwlbO60961uorK7Qz1oi/tuqParYzTROtmX1k2AQiCPlllTPxMGIEhp8GmftRNT3MouAeRO21gk08cT8I5pXeG1l6q7UhfWW294dbZ14yqD7DPSnRBuINRV3J31yTsui27TJDFC3+lkt56uPM8UPX8wkIl4jLjs3rmT4kCbw6yk8XwLrf9gG5TTgI74k3a0/sVhwHUCyxcseKH6pn7+R90lXReYH0IPGELICO4psqCPGPh6JMOHBlMKin8sZL+3MzDiRNnrkoaWOkj0sbMuIhv3/blGESfEPHr/0r8TTGzEANnR1xLgnEA/UN+uj6bc4XoK7DePRji8pDlMHsLjxHPktt+Fg9+LgwuP79jAPx399IV5pui5hUGMaqoelH0wzGnV+4j14R5kCGYDYcAEM+lXg0GHdKXhgW7Bx6+7aelmkr9Hktijqzc1ya/sRlu3w0QhMwlM+Zqg+I1T9Vdz7G/49V1pkItGncH6NAOCOl5/Jgy4egq3hJdf3fvvAubukgqoo2TJTmMTlmh7AZoPS0saxPS/npy/+fYxJN0m/bZZUYLh0NGNG+9ducR+kuoja/V5o+ceBqHm5pU+d7FJBws1YNa7jRm0IJBgQNqAfwnzGYEBinCq6ur/9vXt7lOn+NO7Q8z7EWhVA40nIEdyW2kL6xQhtbub8u1aooSWoMJwo4iKR8bMT/YNGMuCIL+bo+Ev9878rUOZDNkfUCQHkCmySINjgHcnJPjSXvenJrsVfzdnxKVH1HnFiacUG5IgCofhe0eioRAdw2E53lOU51mj5x4G0MxntqxxmQy0DIpWQulcZnjJrLPo2YBBW7aIXmq6998n9U/2adkuL7SxBdgaLE7CniaBQt6/leJLhXVEeyKhAGBNpg04DEgh/DyjiMXiXzy401SlnvPBn7q1ySU9kifR/A4YQl3JC8ebQvn0SAmogM8uLsV7W8TaUAN/ijxmHPG3s9rkl5+yPM8SPf8waGl5dPN62fB+NGRmVNJni8z0DS+JOkyfERiwI2NDnIejkS23jv/PQN7rojrJ/2aKxBbTsEUFKQItNYY26AINQMt30uGz0kZDKAyQgJ8/FwbQAnREzGg0xJYmHK++8V+nDyDfwPdmd4EWUuN9oQeAAWTRTWATvH1p/0rsPfPEJtrTJZYJnbJ02A/5QJcY0Sm/+lzRcw8DXvtLhW/dFp2fpr8rafE4MMBg8Oz4BlyUgiBZQ5Hw8YYr/zFgT/ZndCtRcxjAHKKPHHvSuwk0MRu6gj5yI6bRkaAS1wwo4U+GAe+w4rXF/rSEgsFppzf8xpvdXVR0F98i1OHFYRr58dZK+oSUX/Wa1CNFUP+H0ryDjy4R4zNi6bQhXOLX6dhJnGecXgRtgHq/cGC3tzBXMivoy0Xsu+00iMZGdmQYPFFE/SIwQDHA63Em4PKzQ9HILkVXXfv+rwLWJBHWP23o0pVWJrCvu4oq2i4bvM5sIVYkpg0o4JxpAy9gkP7WrCF3mh8hY5Zqe6KSJNzCaYJVTz+rw43vbhH+yKmhbTXoi7epUE2AmawZ/GndxB60HaVHnbHggxt1FfQUf5hOOs20s1vPMr0gMGiqfTT3s1EuI7RBukgwoJl2fzgYxCV9JHym4npdiC3VpF6UDiYtcwqHws0t4TW3Dv/nQN5rNEyW3rVUkVwCGYwcYQXRNluyLcRhgHP6Cc0AGNBkVTBoj5kEA2K8thROeNlISC7y4904eLCysUa/+JMUr4J6S0veTPKkviFounlVtEaC5of3SBF7AG9/JGhGbQ/URpvxgnG1hqTgJ/Dz551eBBiAIuHw7mULJpgzBPgDRgVcZDf/UKwMgxloczlqR/R7w4B6YMBVDaHmTzaUTDu2tjbcSIOpLPLj0lE2tGGmt0Tnnd72Vy5LN58O2XUL8G1dIJIpMAzETygk+AY0D6LHzKHlHRpFuMQolhH+tfIu/ZBZme6uubr/3/vMKaKyW6kqma3ySZZovT/ruWJrPqX0ZK/yL8Vei05v4XvdUdLsWTqPnTzX9ELAAJZuJHTn6mVhSB/BqBGN6R62UcIfDgYxaow09dk84Z8XGSadXF/dTOuWY3OLOiBurze3hOae2/qv3DnJAg1d0VZfrFMopgoICXSUr8CTRtkYDKT01FlD4Rs8+dU4/yfEYKcEWhmmUB2zzm36nTMjyduju1/dpZSUQHdyUdKT/OSxUGeuV9lNUP3t9IFHHl4Lhlq3Jeba4AVAwguiDSCewsHGdaU+yWygSaYWpcdCa/P/MDDg9gYI2qBg/dcprrR/U5Y379ruIOMPEp1tiQOAZCoxY6QpGp50bNU/F3rSFi9832wayUJJWvUAOyfDHdqAykZDDYq0GUPLmzt2kVnSpKCC4SBb08OvIl+KzRmXFwMFaGxp6r95YjdRS31TJW/RGAJlhBqQ0QiNlCKquvt0OSu+vhuqpsQpndbAUn+O6cXQBqxlW1oeXD0fGJzvh39soS/1wkuWTH8YGMhXG8PBPmu++i15mcp/Odm2pvxwlE0xeJzgNshPsUNTJOQ7tOIvi7KSvSpkSkY5zYKm7qBkAUcK+AnBDJeApmBIitddGtXU4Xeaq+K5x6n1SjS6/srhlSd28BmjsWs8XzrKHaktLScf3fxPJXmwf5Jof7seSdJb1GnLRjO6BJBvarKH1q91FdM/3+Gri7bZ0+UF8BBeEBeZjjRJPrhz5mRHb41oVblMpBACVrXLZNg+f9qTJdYvZRQ1hJvz13+bLECip3cT1f91Sv8td0/KDMeOndlIENx1LeGi3fPz1xflbZhYuHZcn7XjC9ZNKFg3MX/dBAR2jpOJeesm2tdNsK2fWLiueNyOGQ+bax6HQSJtvH4ktWQorWSIzU6PdZ62oeZoePHFPf++xJTkBw5R/jdpQ3ng2aeGQsAJHAbUxutC6r8L5Ky7cgBOAu8AeHLuzwu9IEaRzGrh8L2rV6aMGOIxppZY1QBDwKhw5Wr/kDCwrxuf5FNCrL4R0CZ7lP/WZ95791yYVrL8CLuAnyCzGyOhJhYVP0M0BagFWgPmOw9wqVmgl2mORmCkh9nWd0+gdTeP/JMJPXvO/KAiWNVZHaDecGiMNEsHl/5WzGbzi/7uNZE2dEkOqKB8upQCD+mvCalvBGjBWvqkd27UVMoPvxD0osAgJuTCkdDexfOEPL1gVIpWTWmO0mPU7Zw/jXFOp/SLucih5vy1E5IEZVcYEt60br707l61av5H1+orUTwy1jsqBzieEZUff+SL7DI7YecJIS7O2e/H02tDK28d/p0r48+cCv+JpeEQMCVfb090I3qz/r5l+RevedRkHbHtlWAUkYtMa9/Skr2pUBSvC+qP9kyuhUfD0qJOpx8pwnNAL4qLnCAUayruBt4pEGwGh0k9Jc/gMRl2/KFg0BAO2tZPSHIpu/mUtIrA/2YXv7K7S9Vr7odXa+/JkR4T38TvnD1xYEqDvldJLi75uHS9LSVeY492ECdOK24d/rNiXffS9L8uyT1cdZkuPRZd7lfFSSR6qe7Wfyvt00VMo+3gSxgGaGgvras/FV4yfJ6/ntb3FPs8AovfcQmfO3ohfAN+ZHyDkwhN/V010ZbtseppEaZRD6Oog8ZPoF9MG0SC9g3juruhBJRd/KnJ/h6QoCkQqE61ffW3N0MPwwmuahvCNXa5zT2KCi5jnN6GGPv9mJXFacONw7/zZCQJb3aX1Ibp79+qr2ybh0yUP6EBllh43vnt/8TTM5nma7BNf+mDbqm0bFpQ/JFTX3ZmdRPtCM/KxjBAxXzO6cUxiuIEKARD4RXFE4ttmYJZ5zLpdsydEjckOqSGSLDfRsBARUuEvensMx8EA1gCtJWvN7WbNy3Fnd574acdr0OJUWO4uWDdt109NPJK/Yy+9BRPWjcptYv01m/c6oKV4+6Faigel6D88A/JQmDTzbcP/6lD161M19Wv/K1b+dV3U+GnxO92WC2N0dCwrZ4/KlZ198C6S0vy0Gy/blJad0GXv2p83WNb/74A9ALCAIQGri2/Nfm9QaJFW2Q1bJ0/Xe4noZbvYIIDtEHfDRNeE2iWG8GAd9sTDNK78M8CAAkeFWDQ4bdcKFnGzvAy8zeOTfKkJotsXrRPkSKkdxPTUgKpKX7lHzlUI3YEqqLyB+vpyCQqS+OXJJ4iUoZ833Dr8D8uMiT7VUl+FXzf/xgwbys/Ht+7V5bmbQmFutVU1XPZ6G4+bYqXffMqkNpNUv7nSYWHKs798sV9BugFhAFnsnA4fGLr+uI+urEF+q1zpse5rUOua4gGC9aPfd1DO7CDV/j4kTxuRdqAjONkQZ21eHRnMOAnNG6wYXyKO5W0Aa1focU0AEN3Ghd7K2my6o+KNGN3Ta5tCTKlhVLCvGZP/rKU8I5ryw//I4/hty5t10A6wm/cyv/u73+lgebJEbGNWDqi6LabZ/7KaweeXxPTX5Pe/I1DU7x3QYiESEc1+JzTiwiDmK5vqn202TvRbc3cO3s6b7rORG8dpPiGcW+4GQykxLFbCslsPUp3t7r3ws8b5SfaE8deY7gpb8O3MRgAPHAtaDMi6nKhBcfpKaLit8U64eBSksakCqhMLIFfnvjLrr91+M+d+u4BJZCcVJL2mkf5G4dh1DZffYQQ/YTJf/Bzpp9c90+l3kwhKHJWfF0erKWdKojkOC8MvYAwCIXIgePUWFUxfcz7e+dO5z85sz5ODS0h28bx0AakCrgeYBzMYAADib4X9ptiTfbcD2vp2wOdUkO4OW89GUX0qRsypZg2oJlCmhQ/TX/o5td086v+mdck7VrQxBRC+B9EHciEt91w8+CfOzRJkjqlVNXF99ZrPth4yr8I5Gy8fYi9CVi6gzrh8GgMh0Zu8/+RM+u/Te6/+94FPkbxoyMVzyO9mL6B3LIkbqOnD+1fv3Tuzdrb1xrv3aqrvN3w8FbD/ZsJ4UbD/Yv1d3M2ft1dpM8i0ewdkt8MBoQEWqMIbLzmVGjmvH+66d6N+orrDRV4Kp7ObSRST+Fy3Z3eG77qKpCfLc/GYaZRVxHJss/VsJlqwMNfenNKT224UVdxq761JL9YqK9EYW42PLjeWDnr8vY/cWppKbM/NVno0V1M60LfTFD9r0mDTz26xhRSexhwaY8jTLaTD29kT/9k9YXdoWiIDXvQdR7hRaIXFAYJ1BRuXvrDNu3sd/77nPz/Pfvt/zuz39/O6Pe/eJje/28Rphb+z5kD/2lZz9f8ajaL5q24ICf7njpMAQzaEuKP/Bn/v3n9/2Zm//8+q9//mNn/f80YQI/PGPA/Zw/431P6/u8Z/f52Zr9/MSVH/qwynuWJ0FJ3pAM9g3NK5zXwopD2O1/O/5489P+bOhDl+T2D/Dqx8D9n9/vb6f3+vxkoW7+/nlnQTaAPscHvTxH5xjCpybRBnarf5okNkQa5moi/4bDE+DvWkRCMhM4+vNUYbIKhiZ8htuX1i0cvPgxA9cG6IWsmvOaGJFYliYquAtuGJB5od9G0FI+CRn8lJX1LWIYBrX7sSl/Yxk/mJQcUXd1p3T1pKe4e1Kcu0hfEkgTatx1sDY7HOQUGgHYwYIhCXqn0VVYhtRseRF4+jVyedkH8aaH1XXigHb6QHa1mZsVQ0JZEdDE1mXqE6dMeXYQef16WM/XMxiZwPGN+LuNjR/kEFGFLbVq72thNfuuFoZcCBqAr9eW5yz5Lcam6BXTg7K4+dRcEYnF1F48qyathi0vAr4ouQipYB9YRcTMFJS0I9qXCnkkCimhLH5yzvYPYR1e7elVdqVNV14X6W1U074BbVsAAgwHFpMjQA+Q600bqPlpkjAS7lNKmLChM+4AS/h4h2avpIqq6SLCFkC/r+WXvQlO1cULDYYoUqAgh/V8Iln33zkdo4hLjbMbmceJuQJzp5dHJ2LDDi0QvAQxYI0Ki3W54YFr2OX1EnglseXCAvo7KTsgHYH4t2yQiAQZsLJnkKB9M4OqC+IkLeB5oawkwvY8+ZB9fP8lhQBjAsxDD4HvCA0wU+mB4stiDNmgRCXW/Z4gXQy4MzQwlP4Rtu5IGpqft6Hy0WIfwiZ9+RTe4y/CFBLV91biqplpib0YEBFqeJsOBOt3aOvFtgPKi0EuhDULUdKTML1WV/39zBr/mVtNSL/ArWNBLQrqrQDsykPUCX5btDiQH2axnbi5NKFASo8eHFCgw+cqkO6UgQrozLMUfJ6ZsDbiOpGRdgQdlBLaJ8/sHPvSRgiPhgc0QIcCzu3gR9lJJkrYbYgZSfydm+E+sbmrt/5H5nx05Knjl0aH1xotFLwUM5BZkbXmy/qZx6ad/4tBCJHcNsEljfD0XYw7iFX7y4gdSC11oupTiX0rGjTePELvHLJ+XjV58GCRKL5yHI6GLtbdVM0f8kagnpg+8lSLCYWVdnJCUbRjlRQ5kwtFYIZ2nSArdwpF3m2i+EwfDy0YvjTaIe3gR6vS40HhHt3BUN4+GZlBKaQQDYgjWp/lSBLwp+eu0zhOugq/Hb72azw/PfhRq7T99qegl0AZMvMWFHE4Ag1A0fPr+Vf38995wa+kD9LSdLTHHY+zywga45qxLgGYTJgXe6i4p/0YqPF5x+QnTK15geim0ASMZDAAAQYLQ0HLl0c2sBWNep69vsN2kCQbU4dOOY17IwIbGUyECkiTlGy71/5g+cHP58cZwEPXyEiLh5YFBK8WtX/w9X33bum7sn7o0KTTZgbqP6PNHPpqI1lVUQkUQQjjrMDMaoSuhhcwnblhTPwyP8OsHKpjcL4SfKDlKyDuyJDbNCbZfACVXJvnpC81dS9KS/Gm/dWjU8z/6/t75Rjb7mn+l/GWjlxEGIOYgEBrC0cj9cO3YnZP/iZgJTzHJm57sxZH1u/sVyQFFMk3TJyZjPiUfpgWTtbL+M6I94sWQy0m9sTHoEiqUtDk2zD8PfR48yafs5qW1EL8V0gZucl6tpwWifPYoq56Xjl5SGIBifjOdN4abp1/b/n9mDv5jQZ3i65HkfzOZPk+mSPHRh1NpoMAHYLAVWLRNEI15PSPc3xp8sHBSqbNLVCTT7ka0mp5sPJrvjevQdWndAQY+aEhj2Ip/57MIRxaWNz2genhpEcDoJYUBOQcJHeSwhpujTQcrL5qWfPo7f/ZrJcpkn+J1KY32yWoraGkcjYbS4hbRMxHA2bRamiwfyH5usNGRZlJ405J9ymQhlb40BWB7014XNX8i6XQzR628uudRtCEUic2kYGDA8SVExMsIA9pThDkGcSOAHaPhSKQqWOM/vvrflFiSBVU3iH/aqIdMiyS+oSLBQAHJSm4DYMDHGZ6B4TYUg3azY/M+6ArUApu+kSz2ADZShLTubBs8mmMnKP8fr3HMdn9FQ1VzJAj8UyXEFirx+uB68qWil1Ub8PaO7azIf3JqaAl/d/+0Yd5HfyZo6TPGAdg/sqwl3mKGNW2oSDCgGQp8bsIzEVASFI9ZQXCLk7yp3YUeKUJqip/t2w6Lzq9JnTty5ZV9jbQKNFYJ7PhCTph7enp5fYPOCLIQzuLV2nuBU6v+ZubgFK+qawBMn/aaP72bn+ardZXeIgeUz1TjtkciI/4axhLKQPNVaXIrYADcwr1JTSLTLj3Jk9YtoEz2KP6lkD1m95RLtbfkedWvKIFewaBjgowMRiM/VF3tt674r3ymN7wZKT4lfZkPhlAgtUsJmRy02tgf651E+HW8Bcqd9eHSTNLX3IrXPIruftb5y7yC1/yGPw9k91702aHK03gpLvtfUTt6BYMOKG4oRyPRmlDDlltHbSvG/U7K6upm21dJUAKAAa3VpGmnieMGMhISrvyBAjCQnsK/9Q2F4Fcn+VS/EbR/6TAoZn8w/cLWh811fMiQE3/NVxSnVzBoT3JHKn0tkk6CzWG4EA3R4JqL39tXffOvAzmve5RJgpJ9wZKJYZrEz3iROQnUidTKnbHr/wD+A3KJZxQ/oU5SmmKt/Auhl3rmyFnnN9VGaul16M2IgGz57BUl0CsYdEQxkUl+Ah9no9/RR8G6beVH3t4i/VXAnlKc1k0iR5mzIHE/rSOj5fZQF4AHN1Ri3fntA5vdzY5swQMF+ppTa2C3oHOYYoktl4mNE3PWZ4YZopFDTFMDk0RlikP5rySjZc34Wee3l9dXBWnT6wRXgF6CXkb++Ypi9AoGP40iLZHqaMPOOyc/2FXyX0v6/hMh53VBnyKqyXOAvVRC3fPs08Kwy9MhlZOplya9i59WKlMvU0BBPUsIcn8rCW/qbiLXVg7E3yKukxfO1nPS3AfaVwJg8PeAB0zdVj62nyRMIFpymZbiU/yJN+PfluQN3SJsv3v8UUsT5/RX/P6U9AoGT0XcUopzVTgcbgg3X66+u+zSvlG7Jv3fqUP/mZTT3a1K9kNCEx8nB9K6+/ETDiu8VUII+PU1SZUiqPGTdsLzc+lO37SkoS5SICoe6EMbPjXbEYNd8RGQknxpKQH6TmY3QhRN90j2qbu5lL9zZ/0/Plv26s9nnNhw4v7VR+EGZszJpWXC/xUWfpxeweDHKc5JtHQ9gavAb7R6IRqpitSuvPTd0K2e/1TS589Ew29cqtdFDTRAcomqi+/N5BJlN0Hd3avoDiPKT1+VJDuK1kODockcYpP5FPwbrKzfCaYOfR6cPjAjpjMUKV+T1CmetCQ3TZFI8av/tKznv5Bye60eO/Ps5jNV15vZJmKyIccKmDgO8AoJP0qvYPDjxJkozkqM2+gXQMAkL4XmcPhhqO7Coxtrrx3w7F/Qf23R384a9s8CptfcWsjsP4bpIirA7klk5ZMVBAykiLRjCm0IAFRAjdA22uRL0Nw+MpNoL3VyOQRFN7e6e7Hqz305/3lqf+OqL7/eP2f11X0nH1x50FwXoa/gcG+e879cPJSJrrMxEHb5FT2JXsHgqSguXFt5qi13gfkY/7HTlpaGULghGj5RfXnG0VVf7ptuW/9V2uL3/mZKn38dsPzLQM7vpOw/8er/2Gv4rVf/hkf7hlv7hqD9E4/hz4SMfyRm/LmQ+U+92f/M3/Ofe3v+l7KCXivGfLjLL+5fuOnGkRuRR4009E3/+KxAPjFEJlYGUlCx0vGRMhb7FT2JnlEYsJZubTzOYZ01Jmv39kTPR+URAPabxWmXboz4lQ5uMKKH2p7EiJerleK/cYLIfH/SUDRSF26saHp0u+HB2YfX9t0+tf7awUUXds87t23SibXewyt8h1b4Dy2be2rLvHNbl53ftfra3nXXD564f+Vi1e3y+vsPgjWNtLcGTxSMnfAG8ezYPRD/KRO7yk/laki4L9dMu0fakHxPPsbSxyH+UOxK7LdMckxO9IP94n/5j8ePvy49czBoUyVMtsmn/E6crWOESqRb9IdHkGu24x1nE2qcr7GSn+LJcMKzsaUnlDRLm/8E4YwXKXat/VotuZwy0Xk4thFiPB2cACH8R6glEoqVRJbs7Ab/Lg7F4vGiUURLLElban3ZxFzoGGIQwgnLMFZ4dovOY5F5vbFzZBzrJpaTjbSWUL4SP5dzY+chtk08JS5fjZU9lot8nR3lhEhhxe7+evQsagO57sjiJULL4YgrOImzVCJRBHZk5+wZqmXGQ1Tn1F6JdY0LLMSJrvEH2d1YzHY/+Tn7icjIjudIV0ExMFAcRixzOZFQkPrvKX5ranTCI8tlY8nECRdi6ctF5xfZmfyXE4/PX4gVSn41fiMWSf7bjigyC/SDnqDH2R1Q4jN0jnQRQ042lnZiJP4sv4Ejn75KiGJ3ca01cXqciJ/ya78iPYswYJXFKhr1CM6HXASTxWqtE4pGQkH6chchJRQNB1twxFkwlNhQ1JA8faSN+EiZhTBEJj3IsRNjIxkblDMeibV8NBhqZrHoQdpEns4oFs9CfoAfkWAsC7oip0BD1BSTFRUHSj0il5xKwuI8RkiQpcPe67FAb9TBczxTFod91gyPByk7qtg4uzNCLKoZug6iOgoFEZ9/jJAlHksdegm1KhMlTm8RwYsw9RUrPyXC8yeKknZjlQylRtEScm9N+dejZ9I3CIfvXbl4cN2yLTMnb53i2zpN2jRH2rdu8e0rF1HdcpwEQj2Cp2+dOr57wYytM0q3TPdvniptnl12cP3KipuXI+xbXah/OsptE92ybOGWmWU7Z3i3TfNumxHYPL1k0+TJ22ZMPbNr08M7NxENcUDEe/SPCJfqH1WdP7hrx8I5myaXbZs+edv0sm2zJp3Zu7X2fiU1PpN/VCA8gCTCocOb1m+eMWnTjJKd82dV3b3LbpGaotRaIoc3b9w0y4tybplRtnVa6RYUY6Zvx/yp5/Z+V1N1HxyIaPwREM4PrV+9aWZgywz/5um+LdO9m2dIG2f61s8MbMCDs8q+W7W0sa6WRaSn+KMNtTWn9+7csWjOlln+7dN8W2aKW6aXbJ05aeu0qXuWLw810UdL4rnU3K/cuWTuupmlmxFhFpVn2wzv1hllOxbPuXr8UFPtw3jiIG4m1VRVbp0/a/PMsjXT/d9vXElcTq9O0TjMQqHmuzdvHFy/dMMs37ap0vZZvq1TJ21bNO/WuR+CjY0sHhKU0/wV6ZmDQSTUvH3BrKI+piJThtOaJRSaPH16Om268VbVxH45GxbNCzIDI5HCTU07Zkxy2Xo5cg0ee25x31xnQS+nPbvIqp9YaNy1eikkEVoFR/mBlpbAh+94zAa/We0zapz2XFdBfnG/Ape593hTpvBe39snDiaKK0bRisuXZ3w6crxR6zFmugvzxHyru49VMGdNNOk87wyquXZZfkTmwmiouXnO2M+LCwzjLRm+gfl3Ll2gJpfvUsSFRV878zIc5nSPUS/kZ0n5Jndhtt+ocxhVgZH97l87D/FJkRlucDKzuGhcP5ujr1m09fQaNX6jymPWOfN6uvuYHIXWKV9/UfOAPtlNnMXSf3T75vQvP5qYh2rMnFiQJfQ3TyzMduVnFNs0RSbd7C8/CdfVyJoPT7VE79+86Rte6LFr3SalNy/DnWcQ+/YS8zJFm85h1cz59hPghNKNEZ6ruHFDHNrHYTdMKOg9bexn0aCMK1YVkE2hoxvWTiywuGzZTqvW08foLMx15pmL7Zlj7T3XT/dFmhpZSX99etZgEL1x8oi7wChaMhymjM1T/Q9vXq+5eX1XWZlg0okWpTQ4/86503JcRqj0I2uWuSwZHpNasuecXr/mYfmNR7evL/70ffCKx57pe29wfU0d4vHI7NgyZdTbHmDAqvQUGK4f2g2Oqb17a8m4T1wF2mKrdt7oD2oqYl8HA6Fdw5E1LofLZHDZlWUDzXdO7Ku5e7Pi/NFpHw52Ww0TbZlzvhgTrK2W44MIBo2LvvxYtGsFs6pskPXexfPyLUYow+JxnwpGhWhSlvW33zx2pKb81rWTB0qHFXjMKo9Nu8T1LeRlLDIVu7bqQfWdW4/u3DyyevFEo140Zkj5vQ8uX1BdfhPPVldWyAYMfyQcWi5OcFg0Hotm8rA+9y6eeXjj2oPL56aNGOC2aNwW1dzP32+urYnHB1XevDZpWL5kTHUbFXO+HPXoxoWHd65d2r/L2zdHMCuLzLp9q5ZxGR+nyhtXy4baBLPaadbPHfdZSxACXr4Fqrh20fdOH59ZJ1iyNpd4q+/ceHTnxvdzpiCy26yfmNfrwv49MRfqV6ZnBwa8OqJXjux2FmRJVo3Dpt80bzpJxGh054LZQq5WMmmK+5puHDnAYlIfDTtG9i+aIxnTPTaV097r4oE9aIloc2jFN6PLLFpP7pu+wfm1D+7zR0B0N9oy+cMhHivi652F+oqbt8Hn0UhwjXOsy6aUzJqpAwuqb90kqz2BFn0+OmDSOixvTX0nv/IafWe7rrpqxpjhDpPCZdOWvTeo/kEFVA7PBXmEGxsWff2J36qWTIpJgyztYICkl4z9VDIqBaPKP2Rg5Y3ruHi//Nbkd4dIJpXfrp716Yjm+jpcZJnLtcONrjP7t40366UcjdSn9w+bN7I7rSQbZuHwzE/e8ZrS/cZUaZCtvpY2Zgw2N8z8+F3RqnOZFDO//CDYQJNP43T/5rWpw/J8pjRPrnbxuC9bgmRM3r143ldo95lVotWwaoovwXEiqrxxbfJQsx8KzaxdMO5TPBK7Q3Tv6hl3P6OUqxTzem6YPYNfPLl91cTeal+uwtlbdXjtSnJXngEgPAswkE0Ffrx8ZI+7T5bPonYY1TsWTAuHmlBTJ3ZuXFD0xfyib+a6i27F+Ik3BuTTvgXzPCaNZE0X7b2uHvgeF0Ph5sXjPvcZFX6zxjvY9ugeE+0J9T3p/QGiWS3m6oXCzIrym0gFN9cVjQVfeizKqYP7VV67imik3HmzR6OLx3/qMaW7rYpZwwdU376Duw3Vj2Z/ONxrUrtt2pkfvd3AbAakw/MJNTUt+eYTj0WNBP1DbDCK6GqMCAbjPhdNGrdZIQ0uuH/zFkzqh3euT3unn2hSOa3KmV9/0FTHNhXlD8TeF3/O7tk+1pzusyg8+YZj29fy/HCXcyjOwKy4Mu2jET6bxmd6s+yd/GADCf5wJLRuWmCR85slxV9tnD2tsb6+NVnSBjdK3umDF3SZ9QvHfdXSRDAov3je28/mtmk8RtXWOZMZ18ZL1FJx43rZMJtkVrnMhvljP29pbgODuzCZBpp9FqXbmrF97iS6FA4f27Rqok0fMKvcOYqjG1dTRSQ+8yvRs6ENuGZk1XHt4F6X1QB7RjQZds6fybsaqXeBUbyTHnXH1TMsgf3zZ3pNPSRTD7FfzuX937HLLbO+Hi3l6YWcNO9Aa8192oMExM135DPtg4E+qBerRizIqAKDUltE108c5wL88tID7wx8WH6LNw/1+hFQWxZ984lkQ3sr5gwffJ8JbyQ776v3YUK4bKoZHwxvfCDnwilY17B47BiBdIXGOzTvMRi0LBr7uWDUwSgqHWh/cJM+Q1ZVfm3asIJSk9phMsz94qMmcnlb2ZSf4HBh986JRp3XpHT36X1k2wbGSawyYjGJoi1zxnzkyVVJNsOktwc31JD3LN9h/VShRrZdKSBDf4igkUqG94MR5c7VQlNFaT/T6J3zp0rhCFl0HpNh44wA9THFmgBUceNaYJhdNGuc5ox54z4nBRJLDjEf3LomDerlsaU7+xhWz5jGOf4oYGDSS2alM1d5cN0qKnNCqX8tejZgQO0nhyuH9oiFPcVcpSdXuWv+TOYmUj1RFSY0c/wMEfYunOWETLVoJXvPK4f20c1IaN74jyDv0aj+gcaaygp6lj9OJ+FJ772NWwLumhWLJ4xZ4yte53NMGmxzmzJmvD/o0qH9EfmDwbEso5HF334imtQui2bKyEKYuUiwoaZq1kcjJAu0gar0gyH19++15kIWSNOSiZ8KVo3LqvETDNr7BkvGjZaMWhHO7uB8GCS4UnX7xqR3CmGVCWb9vC8+lLUBeDzG6PgDOr1rWzH0mE0l2Huf2rEZV+RbMZzjiF/TPnxHtMDfNUj9e22WvtnkLVrnFy+fOA4G5ZF5UeXigqdvXit5ux/qBNK9bGDuWnHcKp9j2djR3vwMyW7YPslTU1kODPDE+SN3b1z3D8+TzGq3RQffIMrsKE6IUX79onegOWBSuWxZO+bOokyj0R/WrXQZdeROGNWH1q9iUeNF+NXoWfEN5JqItlw8+J2zX47Hpi42aXYsngMuf7ySeGNzgpr+bt60iXlqNzzL/IwrB7ZFaK1J85LxH7pzNODakoG5tZUJ/i5Ve3TSqHccFq1oQ3uovCMHloz+sGz0u74BxiKTYdEXI6ounqNoMYuIP7Tg24+cVpXHqJz5tq36+qVIJNR078a8Me+IVu1Ek7Zk9Ij6h221QXPz4olj3EaVYNaWDLbfbQsD0NJxHxNQYbYNtVfeJBvsQfmtkhF9BFg7Fu3cz0cFmW/wOJ2HNsjRCFa1x559cuumzsTplFFDARVnTrqvf+/pHw+d/uGIwCcjTny/IxhqimvFRAIMSocXgqFRk/4+Pad9MGLy+6Omvz/cm58t5WXumuFviQTZg61QhzbwDcvzouYtGgYD6gPlt3ACB1rqn4sanpBn2DbXC9mEm8fXLRVztECa26g/vBEw6Ljwf2D69WFAsk4+o79XjuwV+uY4bOqJVsOOhbPDZBRBFMLab4w2NoYb5U8yxlsCONm9YOZEmDcWNYycWR8NWTz+m0Vff1Y20OgzQ5XD5DDXVrbp6QOVjhrmsUKgqr0FWXfPna6vqw3WVi/5+gN3nn6iVTvz81E1lfd4BvF2nT/2YwcEsElVas9Y+M0X88aOXfjtGKmPyW3LnPrpyPLTkLIEGxaXjqQNxkOBqNwmTclgWzsYQCIvHT/aa9bCufQOAwyu4SKHgceqcFu0czqHwZnd2xy9NFT4/F7Htq6RryYSFTo65RNoA3WpWTdpcGF15d3mutrGhsZgfUMk2BRpbJSNogQuJBi8U+ix6Bxm1cKvP2h4UNnY0HDl6EFhQC6wUZzXc9fyxWiJeIWAAAM/YGAiqCfCgDsnd29cFQeYRUu6O0898/3+8yd8Ov+bLyZ/MEQ0AQZKt1F7eMMrGCRSvGbDkUtHvnP3yfRCafbWbl4wKxgMRiNwkbfNLfp6qfObxT73rctkZMcVAlCxa8GMYqvab1aVGNXzRo9YOWH82uKv53/Q12PLgkIv7Wesq2ztKeI044MRopl8A3d+dvl1YsFwc9PycWOcOWnuPhpff1PVjeuJOge04NuP4bnClPcXZC4ZN3aFo3hl0dhtZZ7Tu7c01DxqFxnU3FC/6OtRolGBjEofgwFafwnsDZPWY9J6h9i4NqgqvzVpRB/iGwjXLzqFwYU9Oyb0Vkg2hZifdWb7psSlBXECO84c/a5gVpaYFJPf6ddUXYcSgk23zCxb6vp6uWfcpjlTG+vJ6IrTvZvXJr1d4DdpxN7KxWM/joboM/rXzp705Vsm5WidJvXGGaW8dy5OgEHJ0Dy/US2aYBR9nqgNQBW3bkj9jP7cVJhAk/pYVjq+Wln07WyUqrdKNKe7c1UEg4T4vyI9A9ogsSKi0UtHdnvyDGW5an9v/c75s9lAfWTnnNkwV9wmdXFe7tXDsP5jrh1kUySyd9HsYovKZ9b67Bmnt2+AWQ+Bt2WyR7Rnuk3a0oHWunbaAEbRu4MEswJB7Jt9/ybj+Gh0xVjquoEwnjKkoOrmdbmFYqVb8vVHXotSMiqnDrc8uH4h2Ez4hJZC+SF6qTj0V46OYyjYvHTip5JF4zFpSmEUtR83iC4bP0aAG2DR+YfY7sdgMPndPhL1Pz4JBmd37ygyaoQ8jcuWcXzrmscZibo1I9Fpo97xmnWSKa1kWF5jfS1yrG+sn/rRMIdV78jVTf/846aamvjbge7duFb2dh8U2GVWLZswJtrcjEeunzou9Mv1mdWCRbtlRhkfmgDxRyoJBvl+FMakbwcD/Ll37ap/gCVADrRm6cSvIvW1qJTjW1bBY/GYla5c9SsYdESsRs4d+b6oL+pd5+2t3Tt3WiTYHA0F982d7rEaAhZNsS372pH9iMalL0m4SGT34hlFxjTJqJbsWad3bUFLhMPBLTMktzXTY80Ek9Xcb6MNwpHw9A+GCuDpfK2rIKPyOrFgMNi4vOgrwaST7Mopb9ury2/xyOBwOgAGX30M5xUMOvmDfNgPMGv4fU68/4Tm7sS6FEPNzQsmfOqyqF3WDN/Q/HYucijSsmTCZ16bwWXWe4fIRtHD8tuT3+kLheMy62Z/8UFnMMA7Fhkz3HlKd37PI9vWdchJKMPi4m8clgyhINM3pE9tdQWsRzjHc0a/6+mt9RoN8z4d1VT7iF4vZpPChikZDs9EW2xTzp34SYhpg6tnTrkG5MIUdJq0m6aWUk0kuMjMN8iHkeM2Z8we90UcBvxw68JxXz+zZNELOdnLPE40JXI7umuNO7en06pxGPWHXhlFjxOvwdpHVeum+J19TS74nSP7z/l2zOxvPykd3m8iMVPBusmB+qoH8WYAEQwWzhpHMkwr5GWfifWcbJrqKc7LKrJneAdbq+9XxsQ0o2ik5L2hsL+LrTpHYa/7txjHRyKrS4Risx4ub+mwvvevX03MBTT/24+LLdoJZk3pe32rWE8RtTbF4YG3vfwWUFIw5xY7vvJY1UVWg3dYwZ3LF+l2K0UXTvzUbdU6LDpxWB7EKi5V3b41eUQ/t0lZbNbMfpKLvGuCSeewaJz5Wcd2bJKvtiEqw63TP5R8NGx8v17wtZZ//cHiCZ8sHvuJryBXMqoAztljRgbrauVCM7oLQ//tfoJRX2zULBz/aaSZRhXKL1/0DLCKZj2KumVGCTf65ZqJRituXpeGFbjNOtTb7PGtMOBUfu2q2N8sGjUTbIZFzgktQZIUJ3ZuGp+jL8KLmzIObVjNi/qr07OkDRiReA8FLxzYuXWasHT8Z0vHfr5s4mdrXZ/tmje5/MJpLqISCRLuxNYNy8Z9vHTC6IXFn18+eRgtAS2xe+WC5RM/X/T1eyvcX9U8ktubd5nDktk2w7/a+eUqz5drPBMe3LvLu7Tv37wyc8wohz1bGD7g4Z3biXZwuDm0fcG0hcUfL504ZqO/qPpOTFdQAeSTVmJ5hUPBHfOmrC8as3LC5yscY6tu32R3qGx8PcOexdOXj/t42dcfrnSPfXjvLrKrrapa5ytaO/6TZRNGb58e6AwGN06fWfjlh0snfrC6+MvrR4/KVx+jaGNddcWt09vXrnOMW/zFh3O/GjX7mw/nf/7hws8+mPfV+5snC6E6NnwWY8Sayrsbyzxr3V8tc321Z/lc0sPRaKipYf/K2Y6B5m9smWumlnIlHKeqe3dWesevGT962fjRm+dNjVJfEBHdi0Yf3r27zD12SdH7c4o/2bpsHiwiXL5y/NCib8cg/ooJH188uLeds/Fr0TMHAxCvSJq7G2wOB5thXaA5eG+3HKMt0exkxAkH4eaSjmdam806pUnF1NfEmA+XYq2IdKJ4DHhAJiwykqbb4WDjjVMnTuzbU11Vxa9RbCIGz2YUJohI/CId2dOUZFviD+AYbqZXQDZ0MfYUp2iICKlRPxgMNVhTlEkQTkW4OYiMKA4jHj9OlDZcJjzb1Ey5xPi4HdGDdIdsROgmqskQCoMTSjxIXo3M0zwLlIDihoKUchivSeWnu9SFdePM/r3njx9DBPYEJ6pPFBXvSDUZZBhg1S+3AH41N4WRE9LkNUCXwi2hEJ5qbqR+W9Bj7/cr0LMIgzixWpObmdq0kwpDtdNQL48We4qeIyw9Lqtl4sny+4kp83Piifg5JSinDK+DrrOLOHkCIXI8BvgKR+4/gNid9o/z+AQF/hx7ATrvSN3E/tI6sVAn8hTs3j6PtiRnRMkhCzrnV6jSYrdArDLpSmuVxrhcjsDei78dLlKEjogakO7HnmrN4denZw4G8XqUq4kdcc7ZrrMqlquXHel5/nDskRjLypHi7AjiYCA2Z3/oyOPFisGeZtdx5Dfi0eg3+9+WcIUEIuVKqchX+XX51eIkX2SnLIsY4Y588lj6IFICHDAd3UWKcnqx7NjlBIpdYSmwk1g5cQWEIsWKGrvEE0w4tv6kWOyEPcJeR74rR4glzgkFpydYBPabDr8uPYswkGuHEZ2zgEusfjutM34HBx5H5hJ2hR6km0SsdXGH32o9QnPTbbpHx7hs4z/5OTuyc/YIp0RQtSP54XgS7EFwME54MegKezk5ZowYl7O7/Pdj1PaRzmLxaPJ5IvGrqKL4eeIJCOdxbMapnfggSmiRxJP4OYjrCv7WRPxWm4R/ferCS8yPnENYC8Xeir0unTDi7BTnJLqVcLdDojj8yOLjBzvQc/HGjlcK/xuP0/oXhDP6wcNPpp/zzE+kNlnE6g1vyC/8QYjyYhmyTHFAIfjv+Ens5tMQf4Sn+JNIfjB2Ev/5OOHWE+4+PSENOEz8hCeII588xfm5QyJgs9gJ2iBemoTHOJQ50QY5LHV6MBaZJfIjJMdhyaJMXKhw+cwSo5LSD04scptEnyKLpyQwZYdjrr8n4Q3oiPRZT1Qbqdl5G/yCxAsAQmaxwrRWWvyMC+8nqK84IRp7iv62JvRTKPHFO0sD18Go+CP//v2I1oUnvjXXdQlX2lG8HhAvrg34FTrBv1BTU+XNG+XnT18+euD897vO7Ntx6fD+8gtnHpTfDDVQLx5VJyP+1BOIl4MLxXiZIuFQzb275RfPXT6y//j2zUc3rjq4YfXhresvHthTfv7Ug3vlkdhKy1Zzhuf1FDl2SMj6wd3yu5fP37l4/s6ls3cunUMoZ8c7F89SoIs4wU92kULsYrsgxz9z9+LpexdO37t45s7lC7cvX2xq4LN0UMbYawLzTY13rly4d+X8vcsX7165cPfKxTtXLt6jcKkC4epFBP6zTbjaaah47ApCxbXL965fuXv96t1rVypwpCtX7l2/eufa5fu3bjy6e7upribKen5QpKdpNfYSFA31Vv/w/tUfjt04eey6HI7K4dQRBFyncIIdY+c3T/1w89jBm6eOXD19oi5hzVOc6h49vHT8yPUfjlw/dvDasQNXjx28iuNRhINXjh4E110+grD/UixcPNwu7OPhwuHvLxzeB+bExVsXL3Gc85KDWOEfXD5BKVNqh/ddPrwX4dKR788fP9KAOokxZJcQ72iIPRlqbPhh55ZFfod/ZD+xb45UkC3YDR5bhlCY5Ss0Tnt/0GJxAiJE2GpuUDzLzojfl6OhGaIt969fXje9ZMYX77kLeor52ZI1U7DpJJtBsOndtixXv5wZn72zeWZJ+aUzEdYPTQ/+fsRnAGyfP3PigDyxX47UN8tbmIkgFWZJhdks8CtZvj49fX16eQt5wEWE7HaBP+KjCsn0FWT5CnoJhaayD4ffv0WLEHiB44W+e/msa1CeUNhb6tNL7NNT6tNT7INEskSWNeXSp5dU2DMh4Ge7K/GLsYKhhG1Cb6mwd2CgpXSQpXSoNTDYVDLUWjLIUjbYVjbINn3E4Gnvv7Pc+c2uRdMfXrtKHbhxM/1JBA6hALbatWB+UV6uUJArIeT3kvKp1cSCLKEgUyzIkPKzvPwKuyjSompcx93eQl5vT6F597J5UA1yqjF6cOume8TbrgKjv6CnByG/t0CJ4PFsIT9LQAos4ETIY8GeJbIg5GWJeVmSHSFTysvEOe6KedmufOMyn6eFDysl8MyVY4fcw+2ugmw3ypaX6bMbJLvOnadzDSt4cP0Sj4PYpA04hZoazh76fsGXH+IFPBaNy6YUrEq3WSVS0Ag0UzJdNCvcpjSxIHPBVx+c3LGliS3texriWZSfP7M54PENMbvtKo8xDWkKZrVopMmhgkmN7ESr2mVTuS0qp0kFjlkfmHD77PFEI+1nE3LfNnea05rhsqrdyNSkQvCYNB6TzkOznZU8CCYEmkbKAv+JsuH12weWgsKDRCw6t8kwaWi/+2xCBCd6W3ZSee2Cw9aT1qCZkZ1KMitRh4JF4aaA19cJKACbYEcl6SQgzpODRGVQsRfRSlatx6gSLDqIFcGqoyzMWpdN67Bq/INyd8wMJC5J/VGquV9RNnKgy6hBIh6Llr04ak9Bb2FOR2D1oPWYNWyJsxovhTcVrRoBkc0ayaid+f6QOrZXQCJB22+eOdllQcnTJBtNHkGjCHL9KyiYkQXqClVETCKZ1F6TWqI4FNgEdSWu+HL1eGvwarFFt8w9Idos72gfl0PQTsWFZpcVzYQENV7UlQnlVLj759TevsZbCUfZKApHQt8tm+fqa3eZDZIRnJEuGVVei9abq/YadTRDy6gVaX038atkMbjBT31zl3omVN++SeAjB4VybWcKM26gK5Fg097VS6Xh+U6r3oV6pJUlWhHBpJWMGr9F5zUiWa1gVAtGPdoVleK0aYptBu/gwoNrV/FVs7yoCcSzZKdPQTvmTHda8WrIWsOqmOb6U+vmImuNiPc16/HuEmoAJ7l4ZR2YCZXAqz4eUHhUvWhBCjThFO0EzigbVnifTYhoRw+uXnDaeqKBIVAYfvDKeFxJj1tVEAE0u641cf6zNaCEtDyoNUJiaI1GC0qNGikXbEfs4jVr/bloKZ0vV+02ZohmnQP8alUC9u78HO8HI8ovti6Fa+3D6Yiu/HBM7Gfy5EICKtH6xPRoIxIfJE1c4HvISovCZUVIRxAQuLhECS0Kb45CtPa8fOywnFycItHKa1f8A80B41teG6pU5zXpwVeiUYv6RxV5TQYxV0ssQdyCRDRugM2idEBAW9Ueowb5AhVoJsKeXeEwqZa5J0IbxHmEc8u1Uycc/Y1MqKU7wb1mPdWYSentm/vw+iWZozgMGhvqts+e7jT39FoyABcILSektQUMqveZMrxWhgETuEHvAtNYM0RLlhsFpffUTh019OKRA3EOxd92bIkLNN9z6iQn9JFF47cqILo8JoPTlAEhClHnNWp8eFWjEtclAqseF5ER6hGyDXGc+dk7pkn1VRVk1wJmyIECazzKrV2GndKOOdAGBAMWSMYggINRKnCPaNG7zVqvVU9yFDVuh5jReC0ojJrWeSUEsK8HAVoLfGxResAHdlXp8D4VHcHg/pXzHAaUo4neiIS3Xes2pvognm00875d+q3B+tiVzgKVBMJSgwCUSiaV1wYMANg6HxKxaJ2IYFZC4njNGUXm7DXeiaH6ZpJeVH0dVGC8ObfNmizk9ZQgFs0KyaT0gYGABA5RqCA0JdVGumCBWlB4jUqfUenNRRwFrdSz4ahwWjXb5s0gVxjpsS4EOfVoZM7Xo0WbvjQX2iBNtOgABonqXy1aDW5kgXOrzm9S+czAtlKyKtx2rWBVSza9BzoHNW9RuUgLqSRTusesWyZM5Du+xN8H+dy4cMbTLw8yTjIpHDaNCzBAixsV/v6Whlu04g8EvuoSDAZP7tnhLDAFcnRlFj0tr7ame2iSI54BBKl+0dioSg80HewqSGtzBgSDz5heAkaxZXnfLoDq4ZlzjxasD3+MTqBnmkOrJpXAei41qv2mVC8xBLQezax0MF4X8UowtPBW9Kpa0aZFRfiBjVyqa6dFhTgldsMKx9c1d26xTNj7tTt5Cto+Z5rLirqG8OatiFdTsNYFwrUomA9XwEB5YE1S+qIxlZcKrZ4YCDz0OMqp9ROW0CTq0mEFcFLlnBKIwaAXt6/IDDMDh2hpAAzNScYDqXs0c7tgSfxJEicxoI1YICMBgS7SykkqEliT1g2Dn0jTKv02VB2QTHPpgGfRBK4CDrX+gab6ctqVTC5lxxRtrH00dfS7EBDAKowKGCpk2gHPEKtk/JA6hbIiKwgAM2qZyUGViQKIRgWsXJIRZs2MMSOjIXn1JrUYazX83LdyWbEly2dUB+wZgo3Uo8eUTqaHHfxGpiOskoAJOKEa8Fv1gBYBLFftI+lJex04ENOcXpIL7WpY6hxHLitLnLIhaRm9eeFsUUEuiYNclRPsBBuSTCN1aaG59hrbOYpRl0hT08wvP/JYDYAdGbu0dpbUvWAEiwBq9CZoLTAEtY1RGWB84LaSKPWhrnP0xdbMGV+8W37lfDxRGRLs58ldWyb0zfZAsZgJ1h7SM4AjSSwBicO+RKaWdK8Vzan0AQaQXmSSQbSgclH7GslOhrjblrHK62yqZ3uK0EvGwlMThwEYiMx9IJDBAO9F3liBGdaCWNBLgr8LJ6xPLnUP9M112TI81ky3pU1wWTNdtiynLdtlzZbMmS5LhsOaWTZ8IJ8l2q5IHAbgSBbw7gQDka3/dNkMxQUGhy3LbX48ZCO4zFkdBje0cZuQjVI5LYZiq8FhpcK4iKsyPVBl4E64B+R3EfJhzEjEwQpPnm7nskUoXmuTdUDR8/v2uuGgw6WBMILotaidcABgkwADYHFyD8gmJEEALcecELdF62LLr+l9YQrCXsLdvjm3Tx1FTpw78ZcmLEUity+eK+qfLxVahP657j45vkIjNUEhWsEY6MuaoCBH6mPy9LM6++V6+vbyF2YFrHovBCV5HchXCWOMdFSuVrD1XBYQo2w6IBuO4hS5c/lM8YAciC1YiYRbYnKNkKMvHVBQV966sqrLvXPHhH5GD/BE+isdFeSCwWPUlMBOMCvgxKC9fYPsYl5vl1HnM8GAUUnAgFXjNAL0aNEMp1FVnG+Y/dXHD2/fxDvS7Bvkz1IPhYILvv3QbTNQM8CgzMtwkaWr8kIrGRVijsKdC9Mi01PQ02HPKjLCkIUSJ+w5rHhDJSQKQ4sa7OuGgWvL2rN8fph6A2KNx22kpyMYRXgd5tuhRshGhIrHsWxw3qVdW84fP3Tph6PnDu7H8dKxoxeO7r9w4uip7/ec2L7x1I4NPJxkgU6208mJ7RtObaXzUzvXn9y+sbHmIXJpJ2JbYQBUEwzAhdQl4DSpN5c5j29aeWLLmpNb1rYPmxHWnNi8Wg6bVslhI4UfNrQPJzasPLlhOYX1FE6sWXZk1by1rrGuQSYBRiwzlqBUEWAdoWKL7ZqVUybLnNLJQEpzU9Nq33g0LoQ6uRy5OgTynUyQ+uSBwJQFMzAzCcYSvFj4V3AbIFnSRUsPmOMAD8lTC8Cg3zxZjDbTNGzuilDGsBRCzZd/OHbx2JFLRw5eOnbw3OGDl48fu3j06KXjh6/i5NiRiz8cwZXLh/dcPb772onvtonfuOxaCe6+nVws8AYUAmVqNkz5aMTDB3dlZqDUqWs4HA5+t2wm7X0IhYn6typ91D+hLjJlzPvis6C8DJWidzk8f5rDngE+o34S1JRNR7uG4DGIkPzsJeO+Or1r65XDhy7s3/394rlTP3zXY8+At0fvzOagOyAbrBraVshqmP7JiMrr1GkYp6ob170DbGRtw4/J18Gwg/qmrgba50zjG2hd5R7//YrFx7Zv+m7V8r3L568Qi0uG9y2GSLPBUqdK9MNnoFLBUoQE0klD8q4d3sfeloWnxgAoAQbgCQNgCTQ6TaqSUYMaH7Z2njDdLZ8z2fVUWXBWSsQAa+iW+1fPcRjA+8eLM0uMujiKzapL3++KR/vFqLXo0Wio8eTubZ4BRkho6t4gHcjMGBTDlrlQcj8554prV7xD+qDJmDzSwGb2064wOp8tK9DP5O9n9ve3Bfpbff0t3gEWYaDNPdAu4mc/I/wrP+2/pPEZNQwDsG3UU94dVHXzalxM8yxiFU1QlNVErLbb1WM4VHt2+2phkA0gdMF3hVdNr6PxoHgWnW9In2unjpCGYX00PIlIsPn09jVSIVQ6Xpm6QCC+fUaYFVppRN/yMydoPmasLF22lbjcVjA0uf9wheEWS1YS3kUWw5KJX9bRTmysSIgfCT28e2ddqeDMz5FytUgRrAn1BxaHa+s366CX5479jG8DgafwklcO7hbsvWCZASpOK2Cm8OUqWR3pXUPtFw/ubap+QEVHPVD6EQC08ua1bTMmS4MLRKPBS12K6Wy1JBmjMK/dJt20D4fX0sZYeI6Fp6Yds6e7rNCnpMdhvEKJw9sDDPyjBtc/vE+JyRX4E9LsjFjRKL0H1845yDeAO4SWY31EcFVNqiKj6vz38pZKvwDF2qhdhYRDwT3TfU7m6LOOb7Qy+QbQ4RtmTIm9b8d0YusGd0G2y6J0wgU36WAYg+HGWrSby1y3zxwpP3+k/OLZ25fO37p4/uaFM7cunrt9+cLtC+dunjm+IeCeaAJHZZSAr4B/O/S5xmk2nNm5jecnD1U9kdqV7MqpHzyD+0qWjFKjtsSohVAX4SrAOrJrPANMp7bRyls5KlUDno5CXQv9TVCDXjO0k4rM7HyNM0c16b1+dy+cBTOzqHKFddnmd8Le4P0Y0NpwrdxAjEXjKMy9duIQq1i5SDT0hZptatgxc5Zgy5asKtGe7gYMcjU+K0x/6lBz2TULv/34YWwF48V93wl5vWImo5aUTC6zy626ddOnJspOWTCwK8jz7L7vA0MLvWYgoYfbkgZ8ekzwkKAHFbCdNvgc4aY2C52ehhgMwP1MKpvheWu5aAmMGtj46Cd0pTNC1p3nTi/GX6Tlwd17DuopgkSE2QmxRLyIAhQZFef3/XIwiBOvE3bkXH5p6xq4CtTxQtIErUxGPLzeJ8AA8igaCi2f+IXbpvTQzjc6MIZo16DtxELT3fOn44/FuIhylOfItLRcOLDHbcsScqH8tS6Lwl9ggL/nNio2+hy8ycgQewoiA4pkY7jixtUpn4wQqMcSDiS5phLZQlrwt7tf1verllBBKD4RE7/Ryhunyt4p8JgNTjhjeeQdsZ2PVe4BpuPb1vH0OXEm7LLVX0ydHuTokNXO+hOgyHST3h8aqqG1qkT8CUb4Vf/o4cZSj8tugLnisasFm451I6hFm8YN6Of1XDRhXO2DByjRxf3fuftkUfbUD2ugXldiQZ2vT8+bp08kJEw1z1qFvQ+bC310+0aHPZtMNT5KRcWDJQaIqr39TMe3rOdPyvh5Ctoxm1xkSgT+BoGWBi7cMIre79/AYcBalSXHSxIPP5nir1ZTXi4WmKDHPJZ0yFQ24ACRrC7OTT+/j4yin0WJZeMhgVjW8QKc37jcAUcfLhn1naOhEeDa6Z6sDe5euVw6rMBnp05hiQSQSrSRzl867vNwMGEBYCwvbonwTJuq7k8aOcBnyRLJh+QOtBr1XPZ2IZQ/RUsQf50RJcVShXUw4+uPHTbq4vOaVRC4MF4YuyodFu3aMqGxrpblSwDAMRwJP7p1Y8onw10WPfwi+O6+AgMe9Fq1noLe362YE2qiNXe85PSXlZzDAMyBdCGnSVb57DQEuN5XxGUzOBLZcKKHmE4INTes93n9eTnQG8XWtyQ4LmRKEeBoaNaSvWj8N3UVty/s2e7pAwcF11H7JM4JBnZ96dt5D2/eoFLwGomXibKgc/Y/tKrUBcalXQot6dRPDNSxsSSnResblld+6UKiPvlRSoQBG54kGEAblIzq10BGkVyGp6DEmB09JSdFSdZU3PL3s1MNQFKY9FCYHAYOgsE/gDYA8QpkR/DRseXznPZM1D+MY9i9DAZwtHQbAYNOXhk26t4VS5wmvZeG+TQSOVQaN9R4YfbRTWtad9JsJZZjPNNoZOfMSU5bBiS3x6rw5ug9Nj1y9+Rln9q1EXE6y7c9RaNNNRVLJnxelGdwWwAAJbk38ARgDuWCB9Rzxn/WHNtFHGkywzraUF21uPhLtymDvBo2VOKjrh3tRHPW5tnTWiINxMIQuiwyryr8j8GABCTJWqgCZCbl6TeWSVwr8QdYXjLhCo4NDx+uK5WKqF8/3W/TSVbYGFALbCQFdW3LWuv4+tK2VZ68THIQyR5ASxATgBcDg/Ma7tNuuDwp9hZyLq3HaPTBnRtTPxkBPSDJndbwh7Q44ickzbwJn9U/rKI0no5iRhHrqyX1AhjoXCZ16Shog/gy/7av2ikh1pMiyqlFW6pvXocfCe5HzYhUPwQ/wMCZk3Y+tt3qU7/BE+lxgcIS3rtgOvQ26pB0ILUC6+m3PQkGjTWPpnz6AcSWn/WU0GA/Pa4pe6///RsdjI3wxkJaspiPttw4c5L2pDArJGO6m8YlM3wmNeznBWPHBBvqOss3TpReS7SprnalbwI1mUXpM6skLkFseug0XJw+enjltXhh5AQjwdD6KR4g0Gcy+GhQRUu+gQU2uX7BxG/YBiXInEWmv1RsOo3BgIbWEGhEk3QC2Tnr/SLFfgJFW5qqq1a6vhbtGX6jodSUIeVSn5TTmkbDq0aly6Sf+/4gwJc3AMuCxl+KzdqS4QWN9+8+oTZQxHAYBnb4ysnDvkE27laiYG6bHimUmtN85nRnfs8Dq1fy1ZL0CP8T//sY7ZjDXWTOEHhTshDIKBrVv/4R24wa/8ORH3Zs21IqbJ3s3jTVvXWSuGWStIWObcKOSdK2MnFzibhrydwmMh07pUeVFb5+VhohicGA+alttAFeNq7Wmuvqty2cva1M2loqstxx9CZmHQvSljIRYTMFYfMk6eyhfdSuj73+3jmTnFYOAwgjcswIDGQUTY7XP/1lz6IYqPSbp37wDs2HNAxYwEbUrUfFtmpXFI/lH8jhxJ9unx+j5vqG+V9+6LUoYL57bRmCOdOXmw5jwVfY6/alM/H35QXAT070g/3EMRQK7lq6QLRnSbQzPmceFUQt6VW7LjDMeu/8KRLqTAXwB0PNTfuXz3XCk4G6Q8kRctU+eJW2XrM+f6+uqgrvh2gdFrhjGIiAQeBHYIDsUY7aijsLvvnMbcn0WTL9uZSCw6YoNqdTnzGNYMO1JVuLFDHzOlCtxWZdyduFDXzj206IJw4Kh0JH1i4T+vQUYA6hFmiUXhGgMWyly5YpDLSe+/67aFje5xTxn5BmZzAoe39QfVXr3K/Vk/wuc5bTpJpgTYeu8NBohiYxIAU3OClXM9GqnvTRu4010Eid0qPKe/6ngAEvNo61DyrF9wYXo/Fy+Xw7ZkYaNYkBZeBHHly5apdRv3XhXJ4IUqFjjHbPKHVawYhaWRvAUAFb29rAADwZOydO2T1nsgcVZaWeQ3qE5hBoHBb96W2bWEmJ+xCdqYBoiHaMZU8y4ueQTXsWz0HT+y0qF17BYvAa9aJV4TBpD21YhWbi0fgD7Dn5hF8MNTfvXblE6Gf10UxBFFsvWgywNaiTNM9QPCDn3J5NKAWi8vh0jEQu7NnhG2yRjCqYQAELTV2TrBqvNUMa0u/6GTiiLKNY1u2oAxhQV0bnMODvwPPmyKq5Xznjy9GO/AyvReVlFe20widWBMxqR+900Yp6JCeJOR4Q6oCBNgAYVP4IDOQzpP/w/uxvx7jtmTQBDu4H7ArqkNaKNurn9b0/5AHb++TJGAB1qg0+6MvGDVjrRqObJgk0x86scNloqIVqhqqlNbABFo0vV4HUpn40oqmu421UOD0VDOIKDWLlwe3AyL7IwsdGYVkPAYRIu4AC8CMPCrdFvX3hTNr04TFht2OKz2UzdAiDxLhkhrBqDzc3zhzzrteY6rahnHoJJo0VMFCXDC2ouncbkRCHU0P1o8MbV+xaMOOHXVtwlfNXPMmLxw66Cnq54dfZNDTsYFLBwYNBP//rz6mciVnHW01uwejZ3dtdfYw+W4bbpvOiuvLgmehpyoJF5bBnHlyzJEyfe+RPEDui3q4dOejsk+U2GySAFnnRGDN5kq4BpqtHaX+3GCVknEAdw0Cw69Z2rg04w/HSs0Pk/q0bs8d94LDpS4w68KjLpPTatBDYol1P0zHIb+Y6gSYUOAGDYX0aKmEUdVym+NYgMmdHo/euXZz28XAXTWFiM09s2W5LlpfUX7qYl72xRJDXlOB/J2mCOoNB4P1+TY9iH0CIRjdO8tD4iVnptJEJR5NeCcOtARaqCB8dPp8xY8onw5trEr719Bg9DQzihPetu19eMqKQ7XyqBHPTaAn5FW0DGhgqgvrc2HAYCmnTbVk0K24fJtKWMurTI0eImgC6hWAA9lo3Y1JiVcVhcOXQAUdedsCSBp6jqV/IjubtabdP8wIjcoOzw5nvdo63ZrmsmVM+G8U/i4bmwpHfbW6om/L+UPipTiveRS/kajx5KilX7x3Sp/rKZR4nFpf+4ozTpcP7AkP70EwqmsSqd1mpn9drVQfMBsGavXPO5HBDPcWLrbDEw3evXJw2apDHpPCaDDDCPTY0q4HMobzMY5uXRluoWigyMovGCtmWOoYBzK81TzSK6KN6LOX4e1RcuTjp4xFeqyZgUbjB7rBHTTpfDjwkcD84j3pjIbdg0rihs4YVPAEGIN4flRjh9N6d0uA8mhEAMWlV+Y26SSZgTAEBI9myT2xZA/OJ4nWaZOdG0ajB9VU05EfvE41smuqTjLoAvHk0ABsB5UNO8eBhHyUI4K5VPfnjoU2PnrTo4imNIvmkJdpQeWfyyL6+XJqqydmdJjjirRMCiZX4kUEFEnf7wukym7at1Y0BJ7QB9U+Y2CxJ0i2Q0Lq1M1thwP/SpwtCzRv8ExxmPeKXmbQlJih2RZFNVVpghLhlsYjwYHNTw2q/g/Qz2tre6+K+PeBIzmG4izP82b9ogWjSF6EObWq/VQvZ7ENJ7Fk7F0FxyTYFP+EUDYXuXL4w+YMhDhtNqEHTTDJleEwZoh2KUeEyqxeM/ayxpiZMfZfyI6FwuLqyYsFXo1EJvl7ICG0K9lD7aJZh7y1zyprZJDRWNjkjylNWXa3UiTZANZVIPAavVioxTojtKQk+VsKvyyctLQ9uXp31+Ui3EZaPBvJDgD6lKVlIUEvjX0jWgltKVHFgaEF9RSsMKN1YUrALg/V18hW6SYRbkebGHXMnO2wZIpwEmlsL2aaF3+y1KF3WDP87fa+fPiFHltPDU+x3jDqDQen7/eRxA0YrSyW3pacnR19s0habdA6wgrFNcMBbMGmdRtU4s75k9Lv1j2gqUWdUzWFgVnisgAHrMO1IG7C6peI2Vt2XRgyeaNS5yeJXuXKVLOBEDjQLC34RbslHOkFRdy6cG28Uoti7r/MUuVlPERNDNHsShXFZdetmlcUqmR1Z7pXl1/xD7W4SYYaAWe83KaANHDbdnE/ebah6kFihgHfpyAGweN2mdNirGwMeNpeB0uKxkGDVrZtlg/OLaeokm/kDCYICWDMC7w+tfSBPNeAx6QGkead85hefeAqyaVYvLSfQsIn3CEC7bvaXH/LJi1RTjPB4Y+2jJc5vXDa934YX1LksWjLh4DKZszZP9obr6VNXMjcwSniDNvTjMOCP8seRc8X5U+smizfOn4xfhiFB78Nyu3Plon/YAL+V5h157Ar2JZhEGIB9CQb+Ia0w4McQ+9RfQ/WDXXOnL3CNv3P1ckwhyDWFHCKNNbO/+cRFU9JVbrvWYVNBGpWYMgE5Z55+1fjP6mIfdwLFXzh+0qk2+KB/46MqVnzK89iuLesCwnqfe23AtdqPo3N9wJ0YNk8W1vkdG8pcq8vEzYtmhZpbO08ep6eEAYhLq8aauvXzZqwOiMhoXcC1zs9CwMHDegrFG/2OTQlho8+xocR56sAePE6tTpVFJ5RcNLLZ66CPsdLLkm/GtAFp+02zpuA+5CLN52FZ44ELu3cK+b3QWA6YhWBxo8Jr1haZ9Vtm+eAzUCSSgJT25UMHXIW9aWicTfr39cuvvRFbxcKKAUwGGxsXjf2UVs+R00j9JWSVEWgzLh89xGNSuxNFGqruzv7sI8HcS6LhZ00pjCJjmsOSBm9zsjmj7N0h99iG/hQVqTMKB4Ob5pY5rFqvTQUjygU7lmYo6x1mw5xPP6y9X9k6wyLOBJ3QU8AAxFJBxrUPH8z4YhQswpIPhsIH4hY5u8XcdpxGIrfPnp758btOY7pEc1HSWMPLMIBJIGuDBBjwlHGGmtuzapm7j8lpzZ7y0bs1DypxGQCjhOVcohWXzk19f4hg1DtR+3nUGRUwGUSb1mVFRrrDi+cE237ymih23qk2+HBQw8NKOQNWuaHmpjDt09gUC42JobmxIRJsDjXWh5oaw83yl2M6I6jsH4UBy5aJEvaDZ4qU48fE8PgVBDAc/0gcVSPVl5wq/qx1jnWThQDrBVkzhUDta1g/NcCiy8QeDK32u9y2bBGNZVK64NfRhzT1TnvPm6cOx9Olk1Bo4xTBbc30WzXUkUC1mnFo6cLWCGSB0wzP/SsXO3JhF9BYDbwp6Ba4sO5c3dZZU6lDnOIS54Qa6td6JzrzstCykP1ekzJA0zdhvMEN04j5xnPf7WKcwIi4LIJX3r9mubt/T8mukXLTRJPWS2aC0mnST/1w+N3LF9nb8xdjJ0+kjmCA83YwiNHDynuTPhjoppgZjr62m6eO4WKrJoYsZVlePnm89J1C2Gc+sw52EYMB66CQYaBpZxRxwrutmVJSDAvHBDWS+d2cqc20U6IcSz62tPywc6tgz5XMJDNQVBdpW+j6NMmm9vQ3XjpI3eck4yjBNul3CoNR/eO+AY/5oxSmjUXikX8cBp4f1wb89RhnPE27PU6ovtj7sgpgSUWiMz4eJpCByjzpeIBRNJlgwN6CJDceqCm/M+WdAR4rHBgaCS2yKbw2WhO76NsvgjX0IXE58Zboo/Krk4f3p4nDcOVpNSn0vH7uh2833K9MMMso9TsXzgkDbLDcwFpeo9oBu8iigBU387NRzfHNR1paDq5fV2QyAKtuq6Yknwaa4AEG7PoSs8pdaDyyeTWVEiGGBLzdzX27nH1yCOEmVKxBhA5hU84CQwtvnSDQ8sSfkp4OBixRFBcW4eT3+weMSvhPgtkgjRhw48JJOctYxtQA0ej14wenjRwC3FMPtFlLX+qOw8CoKRmW3w4G9HLhMKwRxIcnVwr319bzhx3rI1G5skC8AiCnd86aCuMP6k+yqt18YBh8ZlZ6rPqpn46ovc8++McfSRDVnRtFA7hvEHuqtVRPIP6acebojGoqK3z9bbRC5cd8A7w/FSChTn4S8ccICglUW3FXGmiFa85elmNAAxsdNvRC91jkyB6ipyCb969a4LFmSLkasvhplIYtGMjPPbaZzUXjZUM20eipTaudNF2HVs8hQR9bae3rk3sNBoIcB7Go5iNNjXO+/sQFB52medJXfCCw4S66BlhuHj+AfElyRqN3z5+dNNDuMKqc+RqnDQmqRJsOLStaszZNn9zUUI8kqcIZodi3zx0vHWJHZfosOghECE3BmgX/x9uv9/lt62mvZTQMLwov9o/Rj8OAkiP2o7QeVlZMfm+w30LdDsTWeXrv24WVCTsycGIFiJw/uE8YbHVQTREMqIuDbMT2MJCPCMGmraWSZM+kcTejVszVCMPzK6+e5RF4RxDOQbWPHsz64j0XTSLXCPZ0eAie3Ax4SGgYl1m7TBgHjQlQIX4idQaDkg8GNrBRZN4kPPKTiQw1VmY6T0Da4/T0MJDPnoYei0zshDYKh5prHzY21DbXVjVU3H507eJycYLbpqdhFt6sCPT6WpdJt8DzLd8tgVOwvn7KhyOdZlUpJAsULAQWcyQC7/R9WE7DMiBeyKb6ukXjPkNrOmm2gkrIMXitao85zZeXuWPWVB6TE49/dstqpwUWS5obgb5GpwZmimyG1eKEcLABMYhZQ8FFX3/s7pPhoq4e8uOhGYrzs5dM+IJ/pZwnxV4y8vDe3bKP3/ZbDJIVzUeKjiYsWXSOfj2/XzaPZ8yP9Ief/xg9AQYeOUoCPaq4N+W9IW6zhsZWLOneXFgvWTM+/aji8nl5B4oEnkCJrxze430732vL9NMHUZQui9JvoxX3gaH5dRXlcjl5bDwbDm2QXKKFPu5Ec/Vo6oth5rjR1fcreSQuYPjZ7bPHS97u4zVpfbRZCByvTDAZWoVWQRTkHN+xKUouN68H9nAkuGP2ZAgYn9UAViAM07ADrcore38A+QaMWOKxB+kvEV38aRR7vCVSU3EHMECteqwKgZxF3nnfIQzoqWBTE+20deHUnfOn75w7VY5w9tSN0ydunPzhOsIPx64dP1p+8SLLAM/E/hKLREINdRtmeMWBeWVD8ycNttM6RqtGsum9Fp1oROOyryTSK6vdFv2uZTTqjPZiEKJZQMWFFlrTnAuTSS/Y1WRgWHSLir5sZhu0ccIjFbeuBwblC0a1ixaR67xGWKcQ3kow7rT336m7e5vemxWMordE0dCTBts8NrUTgoCG/7WCHcyglQbmVZXfINnDYh5ds9iV35NM/Fyll6orc+aXo6rvyUzCCaZbTcW9BV9/5rJm0KwCsog0Ei3MSoVE3jijpIF9Qvdn0E+GwdT3BpBupfhKtlaY1hPO+Kjvw1v06SSqWZraQDzA6/fUvl1uk55WbxbqaAGHxeAxZQSG5tVV3I61H0uaYBDcUOpymTNoYIjMTdoNociu3zx3ClQBj4wDiQRKPHrx+12eQhMsThSYPilJk9HVyMhtzpDetlbduBSBC89gybqhmvcsLHHQmgdafumCGUrr1vGsKvDewPjqM7ksCVUfu/QTKL4rMKzuR5X3xYEWVJdIM0ypxxAmbDsYtNZAJNJYU136fv/iXulFvRQTeykm9KTg7Kl29FRP7K2emKuckJvmGWB8ePMilZJ4mIkGfoy2PLx9c/Lbg8CaMNndNhq+FHLVgIFg1wm5WrawHdyjFgfkPLx2mR5hhES+X7bQV5gNI9tH4zy6iZCydkVxjvrIuhWUEQjvRaPU4ZPb1ovWbHAzhLqbDeq7bTANNN5cCMeeB9cskZtIFohAZ2jZhK+LYbjaNWIuLbEvgu9hTXPl6k9v28irGtHvXrvkHNwXlRMwpUO0+0cOuHUtNoOYWp1OmuprFhZ97qBxG1rUHrAoSixZMIocNsMKcRzBhGKz+D+RfioM7sI3YHHA0NTnADsPbo3Tpl1Y9NX9m62TGlAS+o+fwebDa5YKA02QB140gEnrhD33dn5tDAYUk70kHlxX4oKcEC1UxYJJ4TPB6NRKQ/IvHNjDLGdy5vAERY62BBuq15cKHjMEA0k7gJONLoG/NXDFZnz5Sc39+wRIVsvgyO+WL3DkZaLMXrLolG7YVHgLo7L0vYEND9kiOGrmlpsXzsAnO7p57dHN649uWXNs67ojPxYOb6FwhIWjW9Yf37Lh6NaNB7duOL5l7YGlM72FObT6jFa9sPUGHfUU4RhmuT+6XzFlxEC2HQZNYWAWgspLViJZ9mw3FFWxzbBw4rdNraPXrK5J5kRpCtbGVc68bIlGf2kWFm1FAVsftWrXw+73mXUTzFnLpfER+kATPYxqD4eC8779WIRjAH1FGzLoPWaDYFMGBlsfxHad4YWMRILLHd/4jHqaP0ZzxvAuKJiathQxw5o3TP9sVGPtQ9QlTxxHqKmDqyDpsyAx/VZ6fVqqRY61YZ3k5LYrEg81Ni4c96U7V1kCn2Sg9doPR/Gg/FospVBz0+5Fc119sgFpZMe29gD20l0W3azP368qv47IPCpVyE+kzmCgXVvilqMkEGAwaVR/NjCMFqJHSDfZ2Fp7s2relx/WJOxPJosDUCh4bMuaz40GP7CeSxNLPG/3qYkZRSD2tuFINLTK50RVeu165lhrAhZtAOZ7rq5keN9HJP8oZpzws/nh/emff0hftCadQMKpGArHnOE363z5WXsWz2bJg8VYXUcis754H56J15QuWNLIpTYpXCaFf8TgxNVnG6ZOnmjPKDJriiy6Yrt6ok1fZNS1DdrHQuxWLoJhvClrvCVrol0/zqabSCyFIincFtStjvkGpEvbGUWcwJG11ffLhg8g14XiE5MRwmlSFkoLt0rpyVUFTDqHvefJrWvgpNM/3pNPz9MxHA4u8YxzQVrTnDaaywjRU2SjjhRv30yHNWOO48ua+/cQkyEfz0RhEXn65wpGrc+mcedoaSlVrlq0Z67xF1EGrNpZ/JY71y5LQwugrlFCHEUjbH0CgMeq99vTqdt+sOXWmZOIzAmPRELhe5dOF9kzYJ65zQoRTIwiGSGzdCXvDAqSAILCoMmRP2xdOxF1nvXWDxuWo2B4PMh6k9jwdujg6iWeAqMnV+vLIw+eVkFYVU5j6tRR/e9fl3dFwVOtXPdT6KfC4N7k9wcABnyGFuuHpr4CPOWlYX/9KsfY5ppqYlLibNaXwijU1Hho1WJPn+wAW1gsDutbe+8O7iJN+s8qGpJ+Q6kbcKKZFxZY8Hov7auh9EMKWqBtPm2sfYRocmy0DygSuXXulPftPojvN8KdUDhsapcJBqjei1YfYLt07AC0MkVmKurW2ROevkaGXgXxFs37UMBFbnxEs0QpRkvL1il+warj2xZJplTRxHaq+pEAbkOgc9QDWYBsoyG2UiQN8psEOeQfbeADFdqBb4DMeQPWPLw/dSRgQB1f3Iug5jDCoOKDX3QxYNXCC/IPK7h/TRYN7MhSoTqHaXRr8sghtEjAmOaxaySr2g88QG9bNLvnTQ41NtGbxvglHGzeMs1fbNKhzGQv2WjQt8Rq8Pc1XznyPSXICofk0UKH1iyZaNW7aN+QdCcVzwCXzGs0SCaNy0qrw7wmw65ZM1obiZUr2FC78NvRcI28JoXbpvGb4dEpaZ5BXs6ZnVt4FtBJDXWPpnz6/u4F06AZ2JVWjj57YLcwJB+axE/KBx4pMR4tJxhguXKMCknMBqI8W1/t6ekJRlEn2uD9/hBp5GLSEDcBgB4hCUe14DRr54wf3czmHqM8vLeGT/kKNtTtWTp9XO80IVc/9d3B1eW36V4CIdr6gAv+MVukBhcCwgMtx3Z9sqS57PofVi1i6bWlaOT7lQsmGLN9OQbaVAYC3qpxwBU2wsfQuEfk1dy/i1hoRl5Tp3dsnJiX5baqJYvWm6MEjwZGDaiLwQBMtGO6n6/Vgv9Hk9uAW+pZenJQIkg0fKFy4yfxn4LxBG18Jhg1og1+v8pHe9Sh0gBUlTtHcWHfbuRJr5BAtVX3J43oj9TggMIypK/cosltkNBkUHlNevimAJvTnOa0qxdP/CbItpFFyfnjIBKI4fDhzSsn9lL5rdpi5I4q7aXx29QQpetLilrzZE/VlN8ODO8PM8OXkwYjygHY29RijnLGhyNrH9AH4ChxMs4jDdWPpo0eVWzKKLJqiq3wCfUuY6YnB4E+numivVM1Yo5uxqiRIZrFwPOALCdP6diGVS5rli8HRp3eC4VGU/2UTqN22cQvwmwncB796J69TY3kkcffCFZC5Y0r7gF2yCZILkiEAHUMpqOqi62ZJ7bKHz79Peknw2DKe/1pziOziDgM2Jo12kMT4splSXfaM9b6XcEaap7YynTIYnocUmHvgjlCgcU7pLC2InH1GREaj/kGBAPSszCHzCoXTcyiPYski760r+3yvu8iIepBA7H3p0NjXc2myT7Bki3k6sgmtmnp47AQFXg8X7e81E2ZMIlBmUVbts+ZOjE/2016XO82ppdCGzysJK+DJbh1eimsalqpbKTVg9TVTbD88UBinpQk7RpCnSfgWvKFVFDfAkxti0KyZdAkfugKm85pUl6Irz5LIMBgMmBgJCOKwwDpQAQIhVlumBOQoCYtMCzalD6r3pPX8+i2dfQRQZScvRw/orqbqh9t8Au00yaMFtrDmQaGqW8jv9fp7zZF2UcpKWIkcmLXNldBDnUl0eQ/moMtWlROq27z9Enc3KLEGdU9enhk/ZqDq5YcXLUA4dDKRYdXLD28aunh1UsOrVu+n67MO75m8YH1q+sewiuLl4g0ce3d2/6Rg3zEMFqUnCbk08RVtbNPTvkZeY0/YlJfiOxbEuHinSsXZ3/2IXQOfaLcqhSs0LHU/eUu7LVnydxQE9NsCVz08+gnw2Dae/3JtmNKgIMBJyzQiL3HqPJalUWmjBVeV7ipniQT01D8lfjJhhlTXHCR75E24Hc5QYitLXUxVQtpqiUOIBM5nfZLBUcatX6LYfL7g6rv0bYXfBiBPYUUojUPKko/Gupki6FhjcAjBBsFqPtC5SnIObmdrd9HTFaOmqrK0lFvu82Zfnj5VoXvvQH11FOEe1SYbdPK3LSjCVCURWtuKCnWE9B5cIFTKVMKMOpcRhivJO1QjbhOmtMCs14hWuCDqugKDMhceRFmvGY41REMYBSpoAaRmpfNSHP1zd7s/XJcrs5lyhDzdG4Cmz5g0wg5Gv87BQ+vnOdmQLyK2Xn00a0r/rcLPXbacNZl0YC5y0x60aqbWGi5e/EUi04xdyxZ6LRmwyKSUFd4HdiTZtVXRuXV44ceZy9Y6fLZY0QNEQ1DmLX+lInAhsZdJhWLeeAT6ugktrGTmSdZNHsWL0jYXqVNjk11NcudYyH1YaP6jakQJW5LxgRIOotuXZlEE14INu0L+TPoJ8Ng6nv9OQYQH+1EphHZu7QSnyYD0popDVxPwZ6xZcbkYFOr5EZNcAO9/lHV3nWLax+bv8C1AcwqpADdQvYAGcQ0LEC9nCikUe2x6taXeZpqq+lJepj9pwaIXDqy1znYDKakqbbQBrDFTVrylSF+hrB5H0ws4Yi8Hly+OGnkEAm8ThOteYepXJLvVy+dM2b43DHvLPh81JxPhs37ZCiOPxYQJyHa6GHzxoxY8OVHcz8bNf/z9+aNHj7/k7dnjR46d/R7c0YPn/fZqLmj35k9esS10z/wHBOJwWAgapWsQRPBgADZP+fOD7vXSeNclp4u8jp0PlQ1vVoa9MOy4q8bq1mvUawy5aqJRA5uWDHBoufLbry0mkwlWXXj7LqlRZ81s9mXiFt1++a094eJdg2CRA496atZX7xXX12FKmFJUbLxIz95jOhinPWRdSyaHBk/j2xd7bbS0jA32x2dembz0t256sVffhZqju12QWYpayMo+fq6TVMkRy5tsewkTUX7NIoWvSMva/H4T+sqE+YK8D+/B/1kGFCHKfelCAB4CqoNkkYj0IIbVKLaaVNKdthw6aI9Z9eCsmBTq6nHujtRWdRE9KJ0HQeZIuHIer/HDfMXTAwzg8tR6HGrmn1aAVJEVWpVwu4/sn4ptAHXnfLDLIvdKxY54IVTR5MKphRDkZaGFMyaxUVjGhtoZw6SS6wYR/fsKLKpgZOyEUPrWc8JJ9wOBoPNTU30feKmZpyHQ08X2CeHWaAvNdMUPUqhCbeagw3sJwWkTXFoJKQDyVpXVTVlxGDaHouGAmm0HlXtG5BTeeWHyivX/EMHiORwK/3mXl5LJtTvJJPSa+51eN0qVhm8SuU6gVEerK9bUTS2yGJw9lHAXSntkwVjj6af5KuPrVwE7xjR0Bw3T+x39+sl2FSlMDbyengsWXuXLmYyi1JrTTAm6R+neByccKMGp/IVAgVJ7MqbVz19M720ioO2BZBscCfSYbiW9c+/ff4snuSpsBQoiZ3zp/kKM2jtCk0N1EI++kyq0vysKR8Mf3jvLm9EEJuh9/vST3eRR/VnY1ssGqkFskOYDAab6jy0RzT1mUD1F1t17oLc/WtW8I/Cg/14IlxmUFXF6g6EU8BgY4noApy4tc11DnO+RQucQqXHrAgYaTdjaXjhzbNsdQFPhacTjTbX1y33fEszWKA3qZC0LAsiH7Z4UV7WroVzQo2tm3w1N9VtnV7itBnK3hvcVEUdpqh7HOMRfh+KF6n1+BjxOFwccMKV2odVU94diLZn+xnDHlO5rVpvYa+Kq+egWvcvW+Aw6f1GmnLjsigFu8YLVWnNmDRiYNXN6/Q80iSlR1KGUeTRretlIwd6bRkwVmniPpQ2YIC2Hph3+SjMHsbskfAabzGZtcQDaaVDCh7cYF/u4cXiRWUpUhV1hF4Qy429EX8v/GKDnjwRyibUtOjbj8HTEulqOH6w9RXs8xGZ+5bT7FQelR4Jhw9uXisOK4TV5CeZS0NJ1NNl1k0ZOfD2qeMUJ1YkOrAsfh/66TB4fwBpAzNZLMSjNLGE5gvBYoFpLhRoaddrI8kwJ1lHWv+AvCNbNgYTvgtGJZd/yH85RSPhdT6XQBqcA4BKQjqHOlvS3HaVO18r5qr8vTWCLXPW56PqqipZtcvEWihafftGYHB/2NNw+AS7ln2fQu3plSYW9B5n6XX5wD6KGiW9hOiQlrPGfyyOHBSqlneX4GXjhfyDEctYzrq+unraqEFuaxptr0/2jMpl03n75VbcuAgh2VhdM2vMB157pj83TcxXOSzprrxMr4m2nV3sGttc/QivRaklUjR6YuNaRzbt5uswpcFpoa3LzVrRnD3n8w8bammhRSQUvnXhvDSgwGVK9+ZlLB47BvKCLM14YtHotZPHZzkmrJ7k37Zg9uZ5M7ctmrM9IWxbOGd7u7B4xul9O5ECqjmWSMulg7udEO05adSstN2OinYzMeqnjnmHf4OH53jy+92O/ha8Pswn2k3UrPbn0fp6qZ/t+g9HeaX9VKKkWeAHyoayYyfR6O8NA3CqWeMryCgtyPLk6R1WGk/wGWmvPNZzAq9L5+5rPLRpVaIUaa1eHnjhIpE1Xhf7HkkrDAQ+VElJwctElen8Fl2AZqJrV/mLm+vJzom/DD+/evSgb5DdbQdalPCA/Vad36yHd+EwG2aPfqf+YevSHMS+fubELNcEtoMNuxBP7Q9LPFPoyZqHDya9M8BNH49RwD6keTtmbWk/UyXN2iK6fOSAMMDK5GiqxwovnOx+mBZQa8c2r2EJtSk/AE8b/hR9w5cr+SwK1quro4lDZv3m6SLfcwVG2q5Fs1wFmY4c5bGNa2AZIiUiqpNosLlxa5nLCW1v1nnYrvFui6FNsLYJrjzDuDz9zC8/gh9IhYhxXm3Vw8nvDfTn0aIC/tUFuCteo67IrLt4+HtW/USXju8VC3Og+SUL/PUsD9lF6eCrPTMmtXoRvwTxpsbh5/gGtFgbth04lRQWDBitv1/PnaVFDlOm25rpQkVYSCdIRiWtxzelu4wasZ/13Pc7KV+eMzvjf+hAZ9RgK/yiiz4HJusBDgP4BrCLvLkKnLusMAYUPhKWqUJf08mdtGUIe7qVouHQtoVTx+aQQem1qAO0TYjGnQtUAKW65Z7xkcYGbpiBkGlVxb0m5sojpbjl9msQGQ4QitPfG0ojMxbCPMAPRpnSx1h5hX2vLhINBxvXT/cWGxUlual+I9pL4wTgTQqvXVs2YmBNFc0RZKnJO+byN6q8daPk/SHwkUpNauq1tGqdvZWiTeXN6332ux0sDq19WfD1B9Kg/AfXLrfWKs6iLTVVFVNH9oW9RB+7gIKlKaUKmjYbC/xn/IqXVg6ofP1MFVfYjlosNfzHG67wTfCwrVbcNLOL9iDCCzpylRunS3ChEC0UCtU9vDtjZD+v2UCTCUwG2kYRJqItY7VnYoRg8Et4A5x4wX6GNpjy3gCYGQhcG8AxIHenX/bt0wdPbtzg75tHn5wg7we3aOKdBK6l73TonX3t5/buitDMT/YadCQpgbcKR2g6aCQcWjtZctA0CmgSBgPqJ6Gpe9CkNK08l8Zo6NNXtPxS6bRmlQ3ve/MMOQm82ajJ6G9L3aMHK3xOB32fCpY0dTZLFh1N4rCr3fkZhzasZpPuqBgs+3Ckuakl2BhpaqCZNs2NkbaBNuZ/YmgXv11oFxkh0tQmRBGCDdHGhmhTfWPFjSnD+lHHABkMtK8HhPeUPr0rL8oTzlFPD+/dnvzxCK9ROwntRc4DrYQE5znNuoWeCeBmqgImgGOPEHwOrFrqsPeiyT8MBiL13KvLcnWzPxzxoJw+YAf5f3bP7nWl/ihfyMYfZnT5yH6pbw5seqgmGrsg5UyBdeLxARMaqIkHGlCCBLTrT2/fwFPg0w2hc87s2+Gy94Rij40PUneIz6ae/uGwhodsKAklCTZtm1XqgZKx0TQNiFra5sdq8L874O6ls6Ha6ua6Ggr1TxuacKyrCdbWBOtqmmqrqVFicpDTz4BBf6hgBgOyW9zQbhaNf0DOzXMnIIYPLJ5fbM1y0DarSnIYcqFADd5e6ZI1g77xNjhv55zJe5bP27V47p5lc3Ytm79r2Zw9K2fvWz73uwXzdyyet/DLkaId9aiUh+SQvlVTbFYFBuWWDjBTgjASrPRVQsFqEK16j10z4/ORdbBzYm1Gjceo5k55YORg0UZjcD4TfDK+Ogf2cXrJu4XV92/Dj+QLYUONwU3zZ6/wT1zpdaz0F6+QJq7wFv3DBqlNWCZNWOmdsE4qXuMZu7hojDcvGw2Bogq5ECh4X0Vpn94Vl07z9+JveWLvLrc9l7rCrAonTZQwiNCidq0zv+fpXRt5PbCYrSeNNVXzJnw2kWlIr1EjWTLA1mwDjuyl7m+aamkbhHA49LCcBt1bH2eyd+ukgN+WjTr00ucvCEIIJMhjgV+JBxrENGmhbTaUOHhqnHD+6M4N5wC7aNJ6bLQvLbjORWP2aqmg57UT+3lUPHH94rlJg/M89OGcNBqGN6K5s4pt+rmjhy6b+NUSx9eLHF8tcv6EsHji50uKvl7m+GZh8Vc7Fs6ONDJhQS9IpeqyzV8EGwYMTR0yNLGR+A8Vura0s/UGAwAANoJGYID/Clh7B+bcOn8KEUKNDd/NnuIvzAHcEUeyZMWWPsG8gWBTC2DrPO3EPD1eyWHLcloziqnTQOux9nTYsyHVJPYdRfCBSAsJaPlFkUW9dMJHx1bNcffpRZ3HxjTJZJCMtAGM25wKkfP9otl8/AUCntc1SfpI5MR3WyYWZEOD4xGRxrPY13rMKpdJOevbD7jZSkohEj1z4KDY3wrb1w1H36ThgfaEy9XConvqgMg/Kb7GSYvf9Q4TjGMtsisyaSaQMkSgvgfYA7Tk2pbuK+xZefkMSitTNNpUW7vSU+Q0qjz2dLclnT5CY8ygKVLWtMkfDqyuIFZmMeVmptNI5GH55TKaC0M7r5BgMut8bM/3YqPu8JrFYT60zCqQo4DxZLSuqnLqe0NocI0m87DVpLTfjEK0qtxk/EDe4Sc4B2JRSf1RpMHYnFOTesYngyPNtK0QH3ejPqxg0wZPEW37Z0ulbwOYNfAeYfd7zdqNvqII/7Ax2qWpeZXzW+ort6bT8I4R5aSNTgSjwmPUwM2D6oMIdqGZKEAc8xMELTwfdmwNLBqJbJdZU2Q1jLX2PLBuOc3YQ6nYq3bZHhhH3/igeicYQNJLRpjR0AYCL1AiEQzgGyAOKQ0GAwhsmzYwyHSDzSuEZROsr982vcxpy5GM8JXpPQEwRKMsYEfhnEZSWbFouoSWL+SjOQImaFIalAXM4GQTEmARmtLxwosnfNrUWL2keAKy9lrSBfpobJbHCEsp1WV6y9On9/k93xE7w2IgAPBGbAkHG/bMnwZdFzArnMCPNQNqARJUsqgmmtN20MY+RBQzHD6zdZPTBi8fGoPmcjpN0MUwYflmQWwH3CcFMt5az/mUih8LeGt2Qh9/gBHMawPnODKPS0OvSWuPUr19e1VePsveiYjz6f0bV/zDCiW73mXku+vhQZhSaS6japXjm+ba2pYwQM5rAo9wARE9tGn1N+Ysv0UNcYAsgAGvhT7sMml4YfXd26Gg3KsjVwvbOO3yoZ0uaxZpGxP73qs5zW/XeXLVRTm6Yot+LM3A1QJIkk1PQ9FWWoUD94N9Fy/d1Ten8toZvmEWKpmnfev4IU9eT8kO/CigSXwWPZAJrphWaK+5dQkNGKaO2fDRzSs8+VACuEWBPo5Kw89UM2wcnVc7/WxtAsaQvG7bBJoGy+ULTDjaPE4amH/7fKtk6bLdV0STy2kPez3rnCJBK1gzOlySz7TBILZ1DItME+AMbmOGt5/x1tnTMbnT0vCoaoVY7LJn+W069pUnlJ469Wh+C82pQmlwrhORL7LDLZqoSHMV+ddgUQB/bgbOUW7qOzcZlhR9A4V95+KJ0nchzIBYvBhTMswspr7/kcMqLtMGIZyoEOykvvrRrC8+dNhof2PBCt0C/FBnrgviZ5D10tEDYA8uD0JNzXsWznYV9iLjkFYtQtWgnIReMs+ePjBpwoKCB+mxwIbG2wQJniW/Syfp3Dr1sBoDZ/sKeyfCgBPe7uCqZa78bC83Zali9e5cjQgDqdB6bu/u/3971+EV1ZXG/cs2AZGheaLCNCA2GI0aFbC7UVGUEWaYhlhhwJJgAcUWd6OYNTEWXI3mkBw12DWIyPQGA8P+fve+aZi4ySa7Obp+55s379132/vu/dp7t9DjkvGkJBYyIjA0uK9mlZk7/SBJtkOXi4SWGZlmfUGnZUtIvEZDTEhKqUZGh0dONjXUQ8uhJhBYavjB2UZ0D9vWq8eOXDpy8Nrxjkudh3q6jny9f8+ORR/W8S2imNSv4w6RddqpX3cdQpbIihIKZ2Nj8F5aVy3itx2KJJpYqL+xNAty+sa5U6gmogH6H/Q55hZzHVJ0ISl2iSQy2ihBcAhNmmHihDKO+Ap5uUEbTiBYMx3q9x1FXG26qaLM/fQhaoYqTeqGNkCFpKiG3SJMnddoAzHtBtFAesbkeAouUzPt8Q+3EmyAk5DH3WkzQpHBSZUOH5EKBI4RRKzwrYksGp40jX48KrdbRAfKcsCvFZtOW9SZkAHtxjVCr472fnXe/GEhTEboYjukoGYyzBi7bqpFP7WrfmM04JONh4aUFcHZozu9VkMx91DTC/1TLFwumLAa1Y7KBe5+ZWMeJAn7/e21Gy36Ansh3y/Z5EwXtVhF9Dcgtzl7PUIaSWdMQYTARpe3xBHVgwEAaxPksmsyHLMKB/vuyHpKwPNFo6Mhn2ff+iroVS72KGfQU8dmbtFntq2eHx54BmJAPyO+0gUFDN3/ftdSA2dm4uk40gn9lYyELnuubcdYdAQ6RH6jRxLfwPNdSwwwgSzclT57xwyYFgWWhWWun56Qu+RnCnjX1L2R07ttJgjHQnAXNxqDh2DVFrSsWxWNpC9jE4udbd5uUxfAy7fruXIP4jeqMxqnZ542GYcjAZY8Bj82cLC62so5xxD2ICxolUpnmhUiPIEJkqaeE8Xsdppq0BvkHNBZl7NVpwKHR8RcZ/gGteBddgugaAAuq6TLPdX0S2xggBThxFYx4NuqyaULX6Z+ertXfLtkNxQUjHkHftq3aY2Jsy5ZNuKLzMVRSU7eBXHBxxBO4khmoKLkYr2wC8kk9UV5HcYNkG1omUgoeGqbrR711PxFLIKUZ6NSgnWUadZmXz36GdcOin9mB7CpYrG+S922kg8awWC6HHNxDpi8sYjfL836/JO77HL/KML4+IjP275xZYMuD6Yw9/ykXMhBEb8WqVTpRP4b5BtDHJPIVOkn4HMz97fLsugzHbOKXtxLYwPB7Ogqo3d7LppmF5FidIHgVeeY4eEgrSbrhHmz3EyAPVqai0rTjF//e9dWzi9TNeinIH8r5KUuq744xzFf9+xWD7MmoC1j925cMc2ZZtG+31CcCRN354wplsL8E9ut/LDAKLT2ldhwxs6c3lxUYIPDoM2wlcr5faptC2YOPnlEoyyFE76/fKGO2+nmmjSTTdwFOcOqnwzLcPeiOb7nD5gZPPPYeO+Zz82FBTRVuBt3rjCGBRaKc4G8lYqCgDZO1EzFbHQtdDwL95pROcRmnjBH60sLrpw+NhqNTjq7rQ7eDJUpOyITEIvzTqYYRYLmBA9Xpii3gOJJhgPPqBxzpqfPOVJSeF8M7F/7MexXlg0LR0zVE/0+ocUU1ZZEDtOHNqB+4Ihi9om8Q7Vr+U5fUNz15FEzhxu87yiZbC/M2aaG2QoR9R4SNs3V/3jtUkwaA4C4foWEO7PD5Cgkg3EdHjUX4qW/pcu2z1J/+/mJ8WgsGmeegXs/NFaWb9WjC7JjsVGF0nstpsWB2cYZulzOTSI65UTkAgVpl0o0nPAW2I/SFIYiPIQpTXM0Az/elj2YVlwKwBfrPths0hc0cMIDN+jmyHDNew64krOmfXfhnEylpI3DsHeoq2YtPDRrCUiX4dCD/eAW5sJW3Lu8wu9yyRHycA0utDWj/zVpOaEeRs72wuzGkqIbZ07IJk5kK3ntae+3TbO1oBgXbAX3FmXs4lpd0x9evyobArFlEl//s6b5sxzqvCZOllI1zoDlw5EvjaVF1091irhk8kB//66FpVa9JC9IRB+XjmUKtVPRDLeTmEZbUpVDUzO4naE2G8hxKJx3lVmvyzKW6W9f/XrSuRb7nsry5qo5ziqDs2Jua2W5s6K8dfm8c58dYHeOyVH4nP2Ao2dwsL12nXOZobVKYKXBWTmvpcLQ9klFv/y+A0iQho8cc/X1Old81LZ84Z4lhrYlZfuWohQW0QKsLHsVnZVlbRWGvUvnM+eq8ral5c1Lyk8327j4TBzufHXeWq42aXOadHmOGXQ/8Eji7Ztq14rFvsH+VMHDSozFfC/621ZXQszDo6BU4LpR8BbAxtn2mRqOUKK0Em0fjd69deUz6+ZPN64+snV9p/GTjom47hVMBK4XuKGjdkPnf4pHa6s76zZ2GauPbt3csaXm8OaVR81G93NO3SaQEUSLCIhGo0F4Ytushzctb1uxaO/qj51V8/YvM+xfsaB55YIOW91w+GfWlkTTeB49PGaqaTeuPbhpTWfdhqN1NV111Z1b17XXbOm98CUYAEp1bCTS1djQunyxs2pBK3BZ+b6KRa2fVA0+iLd1CqAyoZeDR82bmyvn7125UMT/qKXS0LJi8c0vvkCNEUHG43E0evFg+55lS5wrFjkrF+1ftXzfssUtFfNbKhefbt0NhyRuRI3944DzSM2aTuM6YHor/CyuFzSsTqUn0VjdaZTHms7aGpwcras+Yaw5btzYYdx4cX/bpJDfG3C7/J6XAY8r4H4BmuLE73UPBwMkF0CQW9SJJmbY7w163aE4Bj3ugHvINzQIzYKay3hMIDWx6FtI4ncNBd1ueGDwnuE2KJiSTxryrgfeLQvyuFClUMCLnGX2EFTRcKj7QHN9IRwPYQlwSDYXPINrAQuto3bdsM+jKGsh46OchxkbfPh4x5LZNj31noVSCtYLlxau16sObVkbFPOEpKpHnSOhUNDtCQd8kWBwOPTrMfT7cSQUgu03HAxGggFRuh+BkfhuGhIEYUle8dZvNBIKhPw+uAoBrzfkdYGGAY/H73V53Rws/SqADcZGRofDoZDfg4aWlccjo8RwIADOQZ6MMzYW8vsDrsGA1+13v5RNE/R4eTeFFeOABLEguxPieNAxgj53EJXxeFB/NAZyE0UTcD4SCQfdrrDPHfa6QHxQO+h56UdIMMjCRSVxHIlESA2FOJLIr8EkGdMwLHBCoIgPauN5J5GY4nFwYMmymsofb8gTQPxOMmQCKBnEQZzKhxdJZOBvByVR/A8/ZDnidu1bW2HidiYZwtPgGw9odkdRlqN0+s2zZ9BUSpJkwtiNk4c4IBwKlPuvwISADsmshxNS8sH1E4dHhyOi0jKySMML5fx/DEmbGxiXKTIEIC8T70MlUEwgjnyAlMivAiJF0ZOVfpmMKQtNpGUZjMAKxK+Ve/F/JSw1kwQwGEdxCz8ZQwbyRCQVAQT0E3mHF/G44vhfgZQK82QS/1kuLlJuCYBeFOEKgBRyyPQvgXjNTGWKc/lMfCSZg7ycUMCvA7ZWohoyH4aMP7nda5lXzLmIGu5LAt9gm5gOb9JN2WbQ3795mRGFXIGiIuuMxyBiD9fVmLT5jdyXLtOhy7FP5xgNjuOdNfX7C2chXUUxrDmOyheWPxHk86YcpViJVy/ZHKIbKc+bCEdzJBdNSgHGFPGj/DCglJKEeHEiGo8yWAFcMmEaodiyE6KJW2QfESyLG4mvW5oA6YTIMiSpeS6yAvEZIX75x0Mi19j4JJaRXoqougyK30hInV+uUGo+4hwXvJZhiWS/55GQFqlBT3k1NjLy5YE99XouYNZAbzuria8CsvhhRZcLk3To6WNJ2STEYsO+IedfK+BXOMTb/QYdrSO4CvAsd1fN84utqBKgpPpTAIWLKhDJ+MkuQpBRAKkPKIPj1ZZJJlJAQFoqXMbbR+SXvJVyztqI/zQQt5Ig85HhqTcnxES2qXFkZeLNqhSaMsUnLe0fBUqVcBT/1AZvIqDyoJd/aABOnkmb21jIRY34GYFv+qfY1BwSfGaXeNmV0gZ4eFzc/bbHNFcHj8LKT29ZdZwPpaovBv/kd9stHF2nRCdMaMJ38FbCG8kGUPTs0MJk7r/73Y6Fs5s0Uy0zMqwzs63FU+R3a4suxzprxp1zZ0cTw1QohAQnxMYunOhoKJm+Xct1500lYBsokEy7JstcqLr1t2OxUbj7iiRMSKl38BbDG6sNJIzHRkeGr3QcsKinWTW55lIVx3jx44PKoud6bzvLZvaLMX9CqrND8398fDgcPm43NUzPb4QFVTTZylEPWXbdZLsuy7Gw9AU3VlE4hmnfwdsObyQb8BOmfJEiumnA4z5ev8lU8kGdNsOq4/dpq4ZTFOAzbNfkH960JhLwI2ri3QsEPTzDgft925eUW9U5Dp3KocnmignFWVYdMHf/lnV+tytuQL/jhLcf3kg2SBfTdOsGHz/YWWkwazlv1S6WsLUX5XMZZ322SZ933rmTE2viQL2A5LHYg5v/tJVrxSA/2EW54usvh5fW6ad2f+rkNkrvtMH/B7ypRlEqkCnGoj90n7RwoeNsi57DRezqfHjJcHzNepW9VHPn8jeSdRiZjCOVyeiX7c220gKO8OMiuzncXkSdYdPlNBqK76VtK/0O3mZ4S9gAx7FI5HHvjb6ei3093+B47yqPPxK/uXf10vP7fQnBLuPLY9jvvX+jp6/nkkx4T6a9dvHutcvPxNaLMto7eJthfPxfwalMeRGave8AAAAASUVORK5CYII='

    // var elementHTML = $('#contentPDF').html();
    // var specialElementHandlers = {
    //     '#elementH': function (element, renderer) {
    //         return true;
    //     }
    // };
    // doc.fromHTML(elementHTML, 15, 15, {
    //     'width': 170,
    //     'elementHandlers': specialElementHandlers
    // });

    var doc = new jsPDF()

    doc.setFontSize(40)
    doc.text(35, 25, 'Paranyan loves jsPDF')
    doc.addImage(imgData, 'PNG', 50, 50, 40, 33)
    // Save the PDF
    doc.save('sample-document.pdf');
}
