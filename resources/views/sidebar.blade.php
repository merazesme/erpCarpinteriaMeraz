@section('sidebar')
<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="user-profile">
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                        <i class="fa fa-user-o"></i>
                        <span class="hide-menu">
                            @if (session('Usuario'))
                                {{ session('Nombre').', idUsuario: '.session('idUsuario').', idRol: '.session('idRol') }}
                            @else
                                No tiene iniciada la sesión
                            @endif
                        </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="perfil/ver_perfil">Mi Perfil</a></li>
                        <li><a href="#" onclick="cerrar_sesion()">Cerrar Sesión</a></li>
                    </ul>
                </li>
                <li class="nav-devider"></li>

                @if (session('Usuario'))
                    @if (is_array(session('Modulos')))
                        @foreach(session('Modulos') as $modulo)

                            @if(is_object($modulo))

                                <li>
                                    <a href="{!! $modulo->Enlace !!}" aria-expanded="false">
                                        <i class="{!! $modulo->Icono !!}"></i>
                                        <span class="hide-menu">{!! $modulo->nombre_modulo !!}</span>
                                    </a>
                                </li>

                            @elseif(is_array($modulo))

                                <li>
                                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                                        <i class="{!! $modulo[0]->Icono !!}"></i>
                                        <span class="hide-menu">{!! $modulo[0]->nombre_modulo !!}</span>
                                    </a>
                                    <ul aria-expanded="false" class="collapse">
                                @foreach ($modulo[1] as $item)
                                        <li><a href="{!! $item->enlace_submodulo !!}">{!! $item->nombre_submodulo !!}</a></li>
                                @endforeach
                                    </ul>
                                </li>

                            @endif

                        @endforeach
                    @else
                        <p class="text-error"><small>Sin módulos disponibles</small></p>
                    @endif
                @else
                {{-- Este se quitará, solo es de prueba para que cuando no se inicie sesión, se muestren todos --}}
                    <li>
                        <a href="/cajachica" aria-expanded="false">
                            <i class="mdi mdi-cash-usd"></i>
                            <span class="hide-menu">Caja chica</span>
                        </a>
                    </li>
                    <li>
                        <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                            <i class="mdi mdi-worker"></i>
                            <span class="hide-menu">Trabajadores</span>
                        </a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="/trabajadores/lista">Listado</a></li>
                            <li><a href="/trabajadores/asistencia">Asistencia</a></li>
                            <li><a href="/trabajadores/prestamos">Prestamos</a></li>
                        </ul>
                    </li>
                    <li>
                        <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                            <i class="mdi mdi-table"></i>
                            <span class="hide-menu">Inventario</span>
                        </a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="/inventario/materiales">Materiales</a></li>
                            <li><a href="/inventario/orden_compra">Orden de Compra</a></li>
                            <li><a href="/inventario/orden_salida">Orden de Salida</a></li>
                        </ul>
                    </li>
                    <li>
                        <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                            <i class="mdi mdi-file-document"></i>
                            <span class="hide-menu">Nómina
                                <!-- <span class="label label-rouded label-themecolor pull-right">4</span> -->
                            </span>
                        </a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="{{ url('nomina/nominaSemanal') }}">Semanal</a></li>
                            <li><a href="{{ url('nomina/nominaUtilidad') }}">Utilidades</a></li>
                            <li><a href="{{ url('nomina/nominaAguinaldo') }}">Aguinaldo</a></li>
                            <li><a href="{{ url('nomina/nominaVacacional') }}">Vacaciones</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="/clientes" aria-expanded="false">
                            <i class="mdi mdi-account"></i>
                            <span class="hide-menu">Clientes
                                <!-- <span class="label label-rouded label-danger pull-right">25</span> -->
                            </span>
                        </a>
                    </li>
                    <!-- <li class="nav-small-cap">FORMS, TABLE &amp; WIDGETS</li> -->
                    <li>
                        <a href="/cotizaciones" aria-expanded="false">
                            <i class="mdi mdi-file"></i>
                            <span class="hide-menu">Cotizaciones</span>
                        </a>
                    </li>
                    <li>
                        <a class="waves-effect waves-dark" href="/pagosdelmes_lista" aria-expanded="false">
                            <i class="mdi mdi-book-open-variant"></i>
                            <span class="hide-menu">Pagos del mes
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="/movimientos" aria-expanded="false">
                            <i class="mdi mdi-widgets"></i>
                            <span class="hide-menu">Movimientos</span>
                        </a>
                    </li>
                    <li>
                        <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                            <i class="mdi mdi-account-multiple"></i>
                            <span class="hide-menu">Proveedores</span>
                        </a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="/proveedores/lista">Listado</a></li>
                            <li><a href="/proveedores/gasolina">Gasolina</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="/carro" aria-expanded="false">
                            <i class="mdi mdi-car"></i>
                            <span class="hide-menu">Carros
                                <!-- <span class="label label-rouded label-danger pull-right">25</span> -->
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="/facturas_sobrantes/lista" aria-expanded="false">
                            <i class="mdi mdi-file-multiple"></i>
                            <span class="hide-menu">Facturas sobrantes</span>
                        </a>
                    </li>
                    <li>
                        <a href="/roles" aria-expanded="false">
                            <i class="mdi mdi-tag-faces"></i>
                            <span class="hide-menu">Roles</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" aria-expanded="false">
                            <i class="mdi mdi-settings"></i>
                            <span class="hide-menu">Configuraciones</span>
                        </a>
                    </li>

                @endif



            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
@show
