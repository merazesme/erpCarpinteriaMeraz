var tablaProductos = [];
var iva = 0;

$(document).ready(function() {
    $("body").tooltip({ selector: '[data-toggle="tooltip"]' });
    // console.log("puto el que lo lea");

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

$('#modalRecomendado').on('hidden.bs.modal', function (e){
    $("#formRecomendado")[0].reset();
    $("#porcentajeReco").parent().removeClass("error");
    $("#nombreReco").parent().removeClass("error");
})

$('#modalProducto').on('hidden.bs.modal', function (e) {
    $("#formProducto")[0].reset();
    $("#descripcionProducto").parent().removeClass("error");
    $("#subtotalProducto").parent().removeClass("error");
    $("#ivaProducto").text("$0.00");
    $("#totalProducto").text("$0.00");
    var materia = [];
    $("#selectMateriaPrima").val(materia).trigger("change");
    $("#selectMateriaPrima-error").hide();
})

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
                if(data[item].Apellidos == null){
                    data[item].Apellidos = ""
                }
                html += `<option value="${data[item].id}">${data[item].Nombre} ${data[item].Apellidos}</option>`
            }
            $("#selectCliente").empty().append(html).trigger('change');

            if(id){
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
        timer: 1500,
        showConfirmButton: false
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
        costo  += parseFloat(tablaProductos[i].total*tablaProductos[i].cantidad);
    }

    var datos = new FormData();
    datos.append("idCliente",$("#selectCliente").val());
    datos.append("descripcion",$("#descripcion").val());
    datos.append("prioridad",$("#selectPrioridad").val());
    datos.append("costo",costo);
    // datos.append("documento","proximamente.docx");
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
                if(data == -1){
                   mensaje("Nueva cotización", "Ha ocurrido un error al guardar los productos, inténtelo más tarde.", "error");
               }else if(data == -2){
                   mensaje("Nueva cotización", "Ha ocurrido un error, inténtelo más tarde.", "error");
               }else{
                   generarDocumento(data, 1);
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
      title: "¿Desea eliminar el producto de la cotización?",
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
            console.log(data);
            var html = "";
            for (var i = 0; i < data.length; i++) {
                // var costo = parseFloat(data[i].costo).toFixed(2);

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
            console.log(data);
            var htmlActivo = "";
            var htmlTermiado = "";
            var htmlRecha = "";
            if(data.length > 0){
                $("#cotizaciones").DataTable().destroy();
                $("#cotizacionesTerminadas").DataTable().destroy();
                $("#cotizacionesRechazadas").DataTable().destroy();
                const month = ["Ene", "Feb", "Mar","Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"];

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
                        estado = `<span class="badge badge-secondary">Por confirmar</span>`
                        mensaje = "Cambiar estado"
                    }else if(item.Estado == 4){
                        estado = `<span class="badge badge-info">Terminado</span>`
                    }

                    var cambiarEstado = `<a class="cambiarEstado" estado="${item.Estado}" href="#" data-toggle="tooltip" data-original-title="${mensaje}"><i class="text-success icon-note m-r-10"></i></a>`
                    if(item.Estado == 4){
                        cambiarEstado="";
                    }

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
                        fecha_inicio = fecha.getDate() + "/" + month[fecha.getMonth()] + "/" + fecha.getFullYear()
                    }

                    if(item.fecha_fin){
                        let fecha = new Date(item.fecha_fin)
                        fecha_fin = fecha.getDate() + "/" + month[fecha.getMonth()] + "/" + fecha.getFullYear()
                    }

                    if(item.Apellidos == null){
                        item.Apellidos = "";
                    }

                    var url_documento = `<a class="documentoCotizacion" href="${base_url+"/documentos/cotizaciones/"+item.Documento}" download="${item.Documento}" data-toggle="tooltip" data-original-title="Descargar Documento"><i class="icon-doc"></i></a>`
                    if(item.Documento == null){
                        url_documento = "";
                    }

                    html += `
                    <tr>
                        <td>${fecha_inicio}</td>
                        <td>${fecha_fin}</td>
                        <td>${item.Descripcion}</td>
                        <td>${estado}</td>
                        <td>${item.Nombre +" "+ item.Apellidos}</td>
                        <td>${prioridad}</td>
                        <td class="text-nowrap" id="${item.id}">
                            <a href="/cotizaciones/modificar/${item.id}" data-toggle="tooltip" data-original-title="Editar"> <i class="icon-pencil text-inverse m-r-10"></i></a>
                            <a class="detalleCotizacion" href="#" data-toggle="tooltip" data-original-title="Ver detalles"><i class="icon-eye m-r-10"></i></a>
                            ${cambiarEstado}
                            ${url_documento}
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

            console.log(data.Clientes_idCliente);
            cargarClientes(data.Clientes_idCliente);
            cargarRecomendados(data.Recomendacion_idRecomendacion);
            datos_cotizacion_productos(id);

            $("#generarDoc").empty().append(`<button type="button" name="button" class="btn btn-primary float-right" onclick="generarDocumento(${id}, 3)">Generar documento</button>`)
            $("#generarDoc").append(`<button type="button" name="button" class="btn btn-primary float-right mr-2" onclick="enviarCorreo(${id})">Enviar correo</button>`)
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
        costo  += parseFloat(tablaProductos[i].total*tablaProductos[i].cantidad);
    }

    var datos = new FormData();
    console.log($("#selectCliente").val());
    datos.append("idCliente",$("#selectCliente").val());
    datos.append("descripcion",$("#descripcion").val());
    datos.append("prioridad",$("#selectPrioridad").val());
    datos.append("costo",costo);
    // datos.append("documento","proximamenteModificado.docx");
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
                    //peticion ajax para generar documento
                    generarDocumento(id, 2)
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

function generarDocumento(id, opcion){
    var data="";
    console.log(id);
    if(id && opcion){
        console.log("a");
        $.ajax({
            type: "GET",
            dataType: "json",
            enctype: "multipart/form-data",
            url: base_url+'/cotizaciones/imprimir/'+id,
            success: function (msg) {
                data = JSON.parse(msg);
                console.log(data);
                if(data == -1){
                    mensaje("Actualizar cotización", "Ha ocurrido un error, inténtelo más tarde.", "error");
                }else if(data == -2){
                    mensaje("Actualizar cotización", "Ha ocurrido un error al guardar el documento, inténtelo más tarde.", "error");
                }else{
                    reset_form('.validation-wizard');
                    if(opcion == 2){
                        mensaje("Actualizar cotización", "Se ha actuzalizado la cotización con éxito. En unos momentos se generará el documento.", "success");
                        datos_cotizacion_especifica(id);
                    }else if(opcion == 1){
                        mensaje("Nueva cotización", "Se ha agregado la nueva cotización con éxito. En unos momentos se generará el documento.", "success");
                    }else{
                        mensaje("Generando Documento", "El documento se generará en unos momentos.", "success");
                        datos_cotizacion_especifica(id);
                    }
                }
            }
        }).done(function() {
            window.open(base_url+"/documentos/cotizaciones/"+data);
            if(opcion == 2 || opcion == 3){
                Swal.fire({
                    title: "¿Desea mandar el correo electrónico con la cotización nuevamente?",
                    type: "question",
                    showCancelButton: true,
                    confirmButtonColor: '#068f66',
                    confirmButtonText: "Enviar",
                    cancelButtonText: "Cancelar",
                }).then((result) => {
                    if (result.value) {
                        enviarCorreo(id);
                    }
                })
            }else{
                enviarCorreo(id);
            }
        });
    }else{
        console.log("b");
        mensaje("Actualizar cotización", "Ha ocurrido un error, inténtelo más tarde.", "error");
    }
}

function enviarCorreo(id){
    console.log(id);
    if(id){
        $.ajax({
            type: "GET",
            dataType: "json",
            enctype: "multipart/form-data",
            url: base_url+'/cotizaciones/correo/'+id,
            success: function (msg) {
                data = JSON.parse(msg);
                console.log(data);
                if(data == 0){
                    mensaje("Correo enviado", "Se ha enviado el correo correctamente.", "success");
                }else if(data == 1){
                    mensaje("Cotización", "Ha ocurrido un error al enviar la cotización, inténtelo más tarde.", "error");
                }
            }
        })
    }else {
        mensaje("Actualizar cotización", "Ha ocurrido un error, inténtelo más tarde.", "error");
    }
}
