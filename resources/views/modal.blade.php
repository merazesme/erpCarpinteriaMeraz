@extends('footer')
@extends('breadcrumbs')
@extends('sidebar')
@extends('header')

	<div id="main-wrapper">
		@section('header')
		@parent
		@section('sidebar')
		@parent
		<div class="page-wrapper">
			<div class="container-fluid">
				@section('breadcrumbs')
				@parent
				<!-- BOTONES -->
        <div class="button-box">
            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#agregar" data-whatever="@mdo">Agregar</button>
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#editar" data-whatever="@fat">Editar</button>
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#eliminar" id="sa-warning">Eliminar</button>
        </div>
				<!-- MODAL AGREGAR -->
				<div class="modal fade" id="agregar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
	          <div class="modal-dialog" role="document">
	              <div class="modal-content">
	                  <div class="modal-header">
	                      <h4 class="modal-title" id="exampleModalLabel1">Agregar nuevo producto</h4>
	                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                  </div>
	                  <div class="modal-body">
	                      <form>
	                          <div class="form-group">
	                              <label for="recipient-name" class="control-label">Descripción:</label>
	                              <input type="text" class="form-control" id="recipient-name1">
	                          </div>
	                          <div class="form-group">
	                              <label for="message-text" class="control-label">Cantidad:</label>
	                              <textarea class="form-control" id="message-text1"></textarea>
	                          </div>
	                      </form>
	                  </div>
	                  <div class="modal-footer">
	                      <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
	                      <button type="button" class="btn btn-info">Guardar</button>
	                  </div>
	              </div>
	          </div>
	      </div>
	      <!-- /.MODAL AGREGAR -->
				<!-- MODAL EDITAR -->
				<div class="modal fade" id="agregar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
	          <div class="modal-dialog" role="document">
	              <div class="modal-content">
	                  <div class="modal-header">
	                      <h4 class="modal-title" id="exampleModalLabel1">Editar producto</h4>
	                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                  </div>
	                  <div class="modal-body">
	                      <form>
	                          <div class="form-group">
	                              <label for="recipient-name" class="control-label">Descripción:</label>
	                              <input type="text" class="form-control" id="recipient-name1">
	                          </div>
	                          <div class="form-group">
	                              <label for="message-text" class="control-label">Cantidad:</label>
	                              <textarea class="form-control" id="message-text1"></textarea>
	                          </div>
	                      </form>
	                  </div>
	                  <div class="modal-footer">
	                      <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
	                      <button type="button" class="btn btn-info">Guardar</button>
	                  </div>
	              </div>
	          </div>
	      </div>
	      <!-- /.MODAL EDITAR -->
			</div>
		</div>
		@section('footer')
		@parent
	</div>
@endsection
@endsection
@endsection
@endsection
