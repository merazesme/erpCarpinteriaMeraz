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
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-9">
                                        <h3 class="card-title">Configuraciones</h3>
                                        <h6 class="card-subtitle">Configuraciones generales</h6>
                                    </div>
                                    <div class="col-lg-3">
                                        <button type="button" class="btn waves-effect waves-light btn-block btn-primary" href="#modalConfiguracion" data-toggle="modal"><i class="fa fa-edit"></i> Actualizar datos</button>
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 2%">
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-lg-7">
                                                        <h4 class="card-title">IVA</h4>
                                                        <h6 class="card-subtitle">Porcentaje del IVA</h6>
                                                    </div>
                                                    <div class="col-lg-5">
                                                        <h2 class="card-title text-info">16%</h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-lg-7">
                                                        <h4 class="card-title">Caja chica </h4>
                                                        <h6 class="card-subtitle">Dinero mínimo en caja chica</h6>
                                                    </div>
                                                    <div class="col-lg-5">
                                                        <h2 class="card-title text-info">$4000.00</h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- /.modal -->
                                 <div class="modal fade" id="modalConfiguracion" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Agregar registro</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"> <span aria-hidden="true">&times;</span> </button>
                                            </div>
                                            <div class="modal-body">
                                                <form>
                                                    <div class="form-group">
                                                        <label>IVA (%):</label>
                                                        <input class="form-control" type="number" id="ivaConfig" min="1" value="16">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Mínimo de caja chica:</label>
                                                        <input class="form-control" type="number" id="cajaConfig"  min="1" value="4000">
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-success" data-dismiss="modal"><i class="fa fa-save"></i> Aceptar</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        @section('footer')
        @parent
    </div>
@endsection
@endsection
@endsection
