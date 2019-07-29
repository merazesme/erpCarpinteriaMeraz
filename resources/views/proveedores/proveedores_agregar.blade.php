@extends('footer')
@extends('sidebar')
@extends('header')

@section('header')
@parent
<div class="preloader">
    <div class="loader">
        <div class="loader__figure"></div>
        <p class="loader__label">Carpintería Meraz</p>
    </div>
</div>
<div id="main-wrapper">
    @section('sidebar')
    @parent
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row ">
                <div class="col-lg-10 col-md-10 col-sm-9 col-xs-9"></div>
                <div class="col-lg-2 col-md-2 col-sm-3 col-xs-3">
                    <button type="button" onclick="regresar()" class="btn btn-dark ">
                        <i class="mdi mdi-arrow-left"></i>
                        Regresar
                    </button>

                </div>
            </div>

            <div class="row" id="validation">
                <div class="col-12">
                    <div class="card wizard-content">
                        <div class="card-body">
                            <h4 class="card-title">{{$modulo}}</h4>
                            <form action="#" id="proveedor_form" class="validation-wizard wizard-circle">
                                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                <!-- Step 1 -->
                                <h6>Identificación</h6>
                                <section>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="proveedor_nombre">Nombre de proveedor <span class="danger">*</span> </label>
                                                <input type="text" class="form-control required" id="proveedor_nombre" name="proveedor_nombre" placeholder="Nombre de proveedor">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="proveedor_rfc">RFC: <span class="danger">*</span> </label>
                                                <input type="text" class="form-control required" id="proveedor_rfc" name="proveedor_rfc" placeholder="XXX-XXX-XXX-XXX">
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <!-- Step 2 -->
                                <h6>Contacto</h6>
                                <section>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="proveedor_correo">Correo electrónico <span class="danger">*</span> </label>
                                                <input type="text" class="form-control required" id="proveedor_correo" name="proveedor_correo" placeholder="ejemplo@correo.com">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="proveedor_telefono">Teléfono: <span class="danger">*</span> </label>
                                                <input type="text" class="form-control required" id="proveedor_telefono" name="proveedor_telefono" placeholder="xxx-xxx-xxx">
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
@section('footer')
@parent
<script src="{{asset('plugins/sweetalert/sweetalert_2/sweetalert2.all.min.js')}}"></script>
<script src="{{asset('plugins/sweetalert/sweetalert_2/sweetalert2.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('plugins/sweetalert/sweetalert_2/sweetalert2.min.css')}}">

<script src="{{asset('js/mask.js')}}"></script>
<script src="{{asset('modulos/proveedores.js')}}"></script>
</div>
@endsection
@endsection
@endsection
