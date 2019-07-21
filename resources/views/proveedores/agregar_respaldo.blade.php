@extends('footer')
@extends('sidebar')
@extends('header')

@section('header')
@parent
<div id="main-wrapper">
    @section('sidebar')
    @parent
    <div class="page-wrapper">
        <div class="container-fluid">
            <button type="button" onclick="regresar()" class="btn btn-dark float-right"> <i class="mdi mdi-arrow-left"></i> Regresar</button>
            <div class="card-body">
                <form action="#" id="form_proveedor">
                    <div class="form-body">

                        <h3 class="card-title">Información de identificación</h3>
                        <hr>
                        <div class="row p-t-20">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Tipo de concepto</label>
                                    <input type="text" id="proveedores_concepto" class="form-control" placeholder="Tipo de concepto">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">RFC</label>
                                    <input type="text" id="proveedores_rfc" class="form-control" placeholder="XXX-XXX-XXX-XXX">
                                </div>
                            </div>
                        </div>

                        <h3 class="card-title">Información de contacto</h3>
                        <hr>
                        <div class="row p-t-20">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Correo electrónico</label>
                                    <input type="text" id="proveedores_correo" class="form-control" placeholder="ejemplo@correo.com">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Teléfono</label>
                                    <input type="text" id="proveedores_telefono" placeholder="" data-mask="(999) 999-9999" class="form-control">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="form-actions">
                        <button type="button" id="btn_guardar" class="btn btn-success float-right"> <i class="fa fa-check"></i> Guardar</button>
                        <button type="button" onclick="cancelar_registro()" class="btn btn-danger float-right m-r-10">Cancelar</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

</div>
@section('footer')
@parent
<script src="{{asset('js/mask.js')}}"></script>
<script>
    /** Scripts */
    function proveedor_guardar() {
        swal("¡Éxito!", "Registro guardado con éxito", "success");
    }
    function proveedor_actualizar() {
        swal("¡Éxito!", "Registro actualizado con éxito", "success");
    }
    function cancelar_registro() {
        $('#form_proveedor')[0].reset();
    }
    function regresar() {
        location.href = "/proveedores/lista";
    }

    var url = (location.href).split("/");
    if(url[url.length - 1] == "agregar") {
        console.log("Agregar")
        $('#btn_guardar').attr('onclick', 'proveedor_guardar()');
    } else {
        /** Cargar los datos de registro específico */
        console.log("Editar")
        $('#btn_guardar').attr('onclick', 'proveedor_actualizar()');
    }
</script>
</div>
@endsection
@endsection
@endsection
