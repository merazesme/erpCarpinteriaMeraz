@section('sidebar')
<aside class="left-sidebar">
  <!-- Sidebar scroll-->
  <div class="scroll-sidebar">
      <!-- Sidebar navigation-->
      <nav class="sidebar-nav">
          <ul id="sidebarnav">
              <li class="user-profile">
                  <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><img src="{{asset('images/users/profile.png')}}" alt="user" /><span class="hide-menu">Toluco Santana</span></a>
                  <ul aria-expanded="false" class="collapse">
                      <li><a href="javascript:void()">Mi Perfil</a></li>
                      <li><a href="javascript:void()">Cerrar Sesión</a></li>
                  </ul>
              </li>
              <li class="nav-devider"></li>
              <li>
                <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                  <i class="mdi mdi-gauge"></i>
                  <span class="hide-menu">Nómina
                    <!-- <span class="label label-rouded label-themecolor pull-right">4</span> -->
                  </span>
                </a>
                <ul aria-expanded="false" class="collapse">
                    <li><a href="nominaSemanal">Semanal</a></li>
                    <li><a href="nominaUtilidad">Utilidades</a></li>
                    <li><a href="nominaAguinaldo">Aguinaldo</a></li>
                    <li><a href="nominaVacacional">Vacaciones</a></li>
                </ul>
              </li>
              <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-bullseye"></i><span class="hide-menu">Trabajadores</span></a>
                  <ul aria-expanded="false" class="collapse">
                      <li><a href="/trabajadores">Listado</a></li>
                      <li><a href="/prestamos">Prestamos</a></li>
                  </ul>
              </li>
              <li> <a href="/cajachica" aria-expanded="false"><i class="mdi mdi-email"></i><span class="hide-menu">Caja chica</span></a>
              </li>
              <li>
                <a href="clientes" aria-expanded="false"><i class="mdi mdi-chart-bubble"></i>
                  <span class="hide-menu">Clientes
                    <!-- <span class="label label-rouded label-danger pull-right">25</span> -->
                  </span>
                </a>
              </li>
              <!-- <li class="nav-small-cap">FORMS, TABLE &amp; WIDGETS</li> -->
              <li> <a href="cotizaciones" aria-expanded="false"><i class="mdi mdi-file"></i><span class="hide-menu">Cotizaciones</span></a>
              </li>
              <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-table"></i><span class="hide-menu">Inventario</span></a>
                  <ul aria-expanded="false" class="collapse">
                      <li><a href="/materiales">Materiales</a></li>
                      <li><a href="/orden_compra">Orden de Compra</a></li>
                      <li><a href="/orden_salida">Orden de Salida</a></li>
                  </ul>
              </li>
              <li> <a href="/movimientos" aria-expanded="false"><i class="mdi mdi-widgets"></i><span class="hide-menu">Movimientos</span></a>
              </li>
              <li>
                <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                  <i class="mdi mdi-book-multiple"></i>
                  <span class="hide-menu">Proveedores</span>
                </a>
                <ul aria-expanded="false" class="collapse">
                    <li><a href="/proveedores/lista">Listado</a></li>
                    <li><a href="/proveedores/gasolina">Gasolina</a></li>
                </ul>
              </li>
              <li>
                <a class="waves-effect waves-dark" href="/pagosdelmes_lista" aria-expanded="false">
                  <i class="mdi mdi-book-open-variant"></i>
                  <span class="hide-menu">Pagos del mes
                  </span>
                </a>
              </li>
              <li>
                  <a href="/facturas_sobrantes/lista" aria-expanded="false"><i class="mdi mdi-file-chart"></i><span class="hide-menu">Facturas sobrantes</span></a>
              </li>
              <li>
                  <a href="/configuracion" aria-expanded="false"><i class="fa fa-cog"></i><span class="hide-menu">Configuraciones</span></a>
              </li>
          </ul>
      </nav>
      <!-- End Sidebar navigation -->
  </div>
  <!-- End Sidebar scroll-->
</aside>
@show
