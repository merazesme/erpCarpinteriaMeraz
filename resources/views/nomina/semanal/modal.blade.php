@section('modal')
<!-- sample modal content -->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
          <h4 class="modal-title" id="myLargeModalLabel"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <div class="modal-body">
        <div class="container">
          <input type="text" name="" value="" hidden id="posic">
          <div class="row" >
            <div class="col-md-12 col-lg-4">
              <table class="table .table-bordered">
                <thead>
                  <tr>
                    <th colspan="2" class="text-center"> <strong><p id="nombre"><p></strong></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Dias trabajados</td>
                    <td> <input type="text" name="" value="" class="form-control" id="diasTrabajados"> </td>
                  </tr>
                  <tr>
                    <td>Faltas sin justicar</td>
                    <td> <input type="text" name="" value="" class="form-control" id="faltasSinJustificar"> </td>
                  </tr>
                  <tr>
                    <td>Dias de descanso</td>
                    <td> <input type="text" name="" value="" class="form-control" id="diasDescanso"> </td>
                  </tr>
                  <tr>
                    <td>Horas sábado</td>
                    <td> <input type="text" name="" value="" class="form-control" id="horasSabado"> </td>
                  </tr>
                  <tr>
                    <td>Horas extra</td>
                    <td> <input type="text" name="" value="" class="form-control" id="horasExtras"> </td>
                  </tr>
                  <tr id="totalPrestamotr">
                    <td>Total prestamos</td>
                    <td> <input type="text" name="" value="" class="form-control" id="totalPrestamo"> </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="col-md-12 col-lg-4">
              <table class="table .table-bordered">
                <thead>
                  <tr>
                    <th colspan="2" class="text-center">Percepciones</th>
                  </tr>
                  <tr>
                    <th>Concepto</th>
                    <th>Importe</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Sueldo Base</td>
                    <td> <input type="text" name="" value="" class="form-control" id="sueldoBase"> </td>
                  </tr>
                  <tr>
                    <td>Hrs. Extra</td>
                    <td> <input type="text" name="" value="" class="form-control" id="horasExtrasMonto"> </td>
                  </tr>
                  <tr>
                    <td>Bono P y A</td>
                    <td> <input type="text" name="" value="" class="form-control" id="bonopya"> </td>
                  </tr>
                  <tr>
                    <td>Bono Extra</td>
                    <td> <input type="text" name="" value="" class="form-control" id="bonoExtra"> </td>
                  </tr>
                  <tr>
                    <th><strong>Total</strong></th>
                    <th><strong><input type="text" name="" value="" class="form-control" id="totalPercepciones"></strong></th>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="col-md-12 col-lg-4">
              <table class="table .table-bordered">
                <thead>
                  <tr>
                    <th colspan="2" class="text-center">Deducciones</th>
                  </tr>
                  <tr>
                    <th>Concepto</th>
                    <th>Importe</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Abono prestamo</td>
                    <td> <input type="number" name="" min="0" value="" class="form-control" id="abonoPrestamo"> </td>
                  </tr>
                  <tr>
                    <td>Infonavit</td>
                    <td><input type="text" name="" value="" class="form-control" id="infonavit"> </td>
                  </tr>
                  <tr>
                    <th><strong>Total</strong></th>
                    <th><strong><input type="text" name="" value="" class="form-control" id="totalDeducciones"></strong></th>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="form-group row">
              <div class="col-8"></div>
              <label for="total" class="col-2 col-form-label" style="font-weight: bold;">Total</label>
              <div class="col-2">
                  <input class="form-control" type="text" value="" id="total"  style="font-weight: bold;">
              </div>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <span id="ver">
          <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cerrar</button>
        </span>
        <span id="editar">
          <button type="button" class="btn btn-secondary waves-effect"  data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
          <button type="button" id="guardarDatos" class="btn btn-success waves-effect" data-dismiss="modal"><i class="mdi mdi-content-save"></i> Aceptar</button>
        </span>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@show
