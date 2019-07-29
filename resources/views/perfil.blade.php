@extends('footer')
@extends('breadcrumbs')
@extends('sidebar')
@extends('header')

@section('header')
@parent
	<div id="main-wrapper">
		@section('sidebar')
		@parent
		<div class="page-wrapper">
			<div class="container-fluid">
        <div class="card">
          <div class="table-responsive2 m-t-20 no-wrap">
            <div class="card-body">
                <div class="d-flex">
                    <h4 class="card-title"><span class="lstick"></span>Perfil de usuario</h4>
                    <div class="btn-group ml-auto m-t-10">
                        <a href="JavaScript:void(0)" class="icon-options-vertical link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="javascript:void(0)">Editar perfil</a>
                        </div>
                    </div>
                </div>
              <h6 class="text-muted"></h6>
            </div>

                <div class="activity-item">
                    <div class="m-t-10">
                        <h5 class="m-b-0 font-medium"><span class="fa fa-address-card-o" aria-hidden="true" style="margin: 0  6px   0   12px;"></span>DATOS PERSONALES</h5>
                        <table class="table vm b-0 m-b-0">
                            <tr>
															<td class="title tablesaw-cell-persist"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Nombre completo</font></font></td>
															<td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Jesús Alfredo Vizcarra Valdes</font></font></td>
                            </tr>
														<tr>
															<td class="title tablesaw-cell-persist"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Usuario</font></font></td>
															<td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">jesusacu98</font></font></td>
														</tr>
														<tr>
															<td class="title tablesaw-cell-persist"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Teléfono</font></font></td>
															<td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">6692727479</font></font></td>
														</tr>
														<tr>
															<td class="title tablesaw-cell-persist"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Teléfono alternativo</font></font></td>
															<td><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">6692681026</font></font></td>
														</tr>
                        </table>
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
