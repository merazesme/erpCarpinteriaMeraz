@extends('footer')
@extends('sidebar')
@extends('header')

@section('header')
@parent
	<div id="main-wrapper">
        <style type="text/css">
            .scroll{
              display: block;
              width: 100%;
              height: 552px;
              overflow-x: auto;
            }
        </style>
		@section('sidebar')
		@parent
		<div class="page-wrapper">
			<div class="container-fluid">
				 <!-- ============================================================== -->
                <!-- Citas y pendientes -->
                <!-- ============================================================== -->
				<div class="row">
                    <div class="col-lg-6">
                        <div class="card scroll">
                            <div class="card-body">
                                <h4 class="card-title"><span class="lstick"></span>Citas</h4>
                            </div>
                            <!-- ============================================================== -->
                            <!-- Comment widgets -->
                            <!-- ============================================================== -->
                            <div class="comment-widgets">
                                <!-- Comment Row -->
                                <div class="d-flex flex-row comment-row">
                                    <div class="p-2"><span class="round"><img src="{{asset('images/users/1.jpg')}}" alt="user" width="50"></span></div>
                                    <div class="comment-text w-100">
                                        <h5>James Anderson</h5>
                                        <p class="m-b-5">Lorem Ipsum is simply dummy text of the printing and type setting industry. Lorem Ipsum has beenorem Ipsum is simply dummy text of the printing and type setting industry.</p>
                                        <div class="comment-footer"> <span class="text-muted pull-right">14 Julio, 2016</span> <span class="label label-rounded label-info">Pendiente</span> <span class="action-icons">
                                                    <a href="javascript:void(0)"><i class="ti-pencil-alt"></i></a>
                                                    <a href="javascript:void(0)"><i class="ti-check"></i></a>
                                                </span> </div>
                                    </div>
                                </div>
                                <!-- Comment Row -->
                                <div class="d-flex flex-row comment-row active">
                                    <div class="p-2"><span class="round"><img src="{{asset('images/users/2.jpg')}}" alt="user" width="50"></span></div>
                                    <div class="comment-text active w-100">
                                        <h5>Michael Jorden</h5>
                                        <p class="m-b-5">Lorem Ipsum is simply dummy text of the printing and type setting industry. Lorem Ipsum has beenorem Ipsum is simply dummy text of the printing and type setting industry..</p>
                                        <div class="comment-footer "> <span class="text-muted pull-right">14 Julio, 2016</span> <span class="label label-success label-rounded">Asistió</span> <span class="action-icons active">
                                                    <a href="javascript:void(0)"><i class="ti-pencil-alt"></i></a>
                                                    <a href="javascript:void(0)"><i class="icon-close"></i></a>
                                                </span> </div>
                                    </div>
                                </div>
                                <!-- Comment Row -->
                                <div class="d-flex flex-row comment-row">
                                    <div class="p-2"><span class="round"><img src="{{asset('images/users/3.jpg')}}" alt="user" width="50"></span></div>
                                    <div class="comment-text w-100">
                                        <h5>Johnathan Doeting</h5>
                                        <p class="m-b-5">Lorem Ipsum is simply dummy text of the printing and type setting industry. Lorem Ipsum has beenorem Ipsum is simply dummy text of the printing and type setting industry.</p>
                                        <div class="comment-footer"> <span class="text-muted pull-right">14 Julio, 2016</span> <span class="label label-rounded label-danger">Cancelada</span> <span class="action-icons">
                                                    <a href="javascript:void(0)"><i class="ti-pencil-alt"></i></a>
                                                    <a href="javascript:void(0)"><i class="ti-check"></i></a>
                                                </span> </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="col-lg-6">
                        <div class="card scroll">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div>
                                        <h4 class="card-title"><span class="lstick"></span>Pendientes</h4>
                                    </div>
                                    <div class="ml-auto">
                                        <button class="pull-right btn btn-circle btn-success" data-toggle="modal" data-target="#myModal"><i class="ti-plus"></i></button>
                                    </div>
                                </div>
                                <!-- ============================================================== -->
                                <!-- To do list widgets -->
                                <!-- ============================================================== -->
                                <div class="to-do-widget m-t-20">
                                    <!-- .modal for add task -->
                                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Añadir pendiente</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form>
                                                        <div class="form-group">
                                                            <label>Nombre del pendiente</label>
                                                            <input type="text" class="form-control" placeholder="Describa el pendiente">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Asigar fecha y hora</label>
                                                            <input class="form-control" type="datetime-local" placeholder="Seleccione una fecha y hora" id="example-datetime-local-input">
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                    <button type="button" class="btn btn-success" data-dismiss="modal">Guardar</button>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <!-- /.modal -->
                                    <ul class="list-task todo-list list-group m-b-0" data-role="tasklist">
                                        <li class="list-group-item" data-role="task">
                                            <div class="checkbox checkbox-info m-b-10">
                                                <input type="checkbox" id="inputSchedule" name="inputCheckboxesSchedule">
                                                <label for="inputSchedule" class=""> <span>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been</span> <span class="label label-rounded label-danger pull-right">Today</span></label>
                                            </div>
                                        </li>
                                        <li class="list-group-item" data-role="task">
                                            <div class="checkbox checkbox-info">
                                                <input type="checkbox" id="inputBook" name="inputCheckboxesBook">
                                                <label for="inputBook" class=""> <span>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been</span><span class="label label-primary label-rounded pull-right">1 week </span> </label>
                                            </div>
                                            <div class="item-date" style="margin-top:3%"> 26 jun 2017</div>
                                        </li>
                                        <li class="list-group-item" data-role="task">
                                            <div class="checkbox checkbox-info">
                                                <input type="checkbox" id="inputCall" name="inputCheckboxesCall">
                                                <label for="inputCall" class=""> <span>Give Purchase report to</span> <span class="label label-info label-rounded pull-right">Yesterday</span> </label>
                                            </div>
                                        </li>
                                        <li class="list-group-item" data-role="task">
                                            <div class="checkbox checkbox-info">
                                                <input type="checkbox" id="inputForward" name="inputCheckboxesForward">
                                                <label for="inputForward" class=""> <span>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been</span> <span class="label label-warning label-rounded pull-right">2 weeks</span> </label>
                                            </div>
                                            <div class="item-date" style="margin-top:3%"> 26 jun 2017</div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- Projects of the month -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div>
                                        <h4 class="card-title"><span class="lstick"></span>Proyectos del mes</h4></div>
                                    <div class="ml-auto">
                                        <select class="custom-select b-0">
                                            <option selected="">Enero</option>
                                            <option value="1">Febrero</option>
                                            <option value="2">Marzo</option>
                                            <option value="3">Abril</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="table-responsive m-t-20 no-wrap">
                                    <table class="table vm no-th-brd pro-of-month">
                                        <thead>
                                            <tr>
                                                <th colspan="2">Cliente</th>
                                                <th>Proyecto</th>
                                                <th>Prioridad</th>
                                                <th>Costo</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="width:50px;"><span class="round">S</span></td>
                                                <td>
                                                    <h6>Sunil Joshi</h6><small class="text-muted">Web Designer</small></td>
                                                <td>Elite Admin</td>
                                                <td><span class="label label-success label-rounded">Low</span></td>
                                                <td>$3.9K</td>
                                            </tr>
                                            <tr class="active">
                                                <td><span class="round"><img src="../assets/images/users/2.jpg" alt="user" width="50"></span></td>
                                                <td>
                                                    <h6>Andrew</h6><small class="text-muted">Project Manager</small></td>
                                                <td>Real Homes</td>
                                                <td><span class="label label-info label-rounded">Medium</span></td>
                                                <td>$23.9K</td>
                                            </tr>
                                            <tr>
                                                <td><span class="round round-success">B</span></td>
                                                <td>
                                                    <h6>Bhavesh patel</h6><small class="text-muted">Developer</small></td>
                                                <td>MedicalPro Theme</td>
                                                <td><span class="label label-primary label-rounded">High</span></td>
                                                <td>$12.9K</td>
                                            </tr>
                                            <tr>
                                                <td><span class="round round-primary">N</span></td>
                                                <td>
                                                    <h6>Nirav Joshi</h6><small class="text-muted">Frontend Eng</small></td>
                                                <td>Elite Admin</td>
                                                <td><span class="label label-danger label-rounded">Low</span></td>
                                                <td>$10.9K</td>
                                            </tr>
                                            <tr>
                                                <td><span class="round round-warning">M</span></td>
                                                <td>
                                                    <h6>Micheal Doe</h6><small class="text-muted">Content Writer</small></td>
                                                <td>Helping Hands</td>
                                                <td><span class="label label-success label-rounded">High</span></td>
                                                <td>$12.9K</td>
                                            </tr>
                                            <tr>
                                                <td><span class="round round-danger">N</span></td>
                                                <td>
                                                    <h6>Johnathan</h6><small class="text-muted">Graphic</small></td>
                                                <td>Digital Agency</td>
                                                <td><span class="label label-info label-rounded">High</span></td>
                                                <td>$2.6K</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- Activity widget find scss into widget folder-->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-lg-12 col-xlg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex no-block">
                                    <h4 class="card-title"><span class="lstick"></span>Reporte del día</h4>
                                    <div class="btn-group ml-auto m-t-10">
                                        <select class="custom-select pull-right">
                                           <option selected="">Todo</option>
                                            <option value="1">Transacciones</option>
                                            <option value="2">Cheques</option>
                                            <option value="3">Facturas</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="activity-box">
                                <div class="date-devider"><span>Today</span></div>
                                <div class="card-body">
                                    <!-- Activity item-->
                                    <div class="activity-item">
                                        <div class="round m-r-20"><img src="{{asset('images/users/2.jpg')}}" alt="user" width="50" /></div>
                                        <div class="m-t-10">
                                            <h5 class="m-b-0 font-medium">Mark Freeman <span class="text-muted font-14 m-l-10">| &nbsp; 6:30 PM</span></h5>
                                            <h6 class="text-muted">uploaded this file </h6>
                                            <table class="table vm b-0 m-b-0">
                                                <tr>
                                                    <td class="m-r-10 b-0"><img src="{{asset('images/users/zip.jpg')}}" alt="user" /></td>
                                                    <td class="b-0">
                                                        <h5 class="m-b-0 font-medium ">Homepage.zip</h5>
                                                        <h6>54 MB</h6></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- Activity item-->
                                    <!-- Activity item-->
                                    <div class="activity-item">
                                        <div class="round m-r-20"><img src="{{asset('images/users/3.jpg')}}" alt="user" width="50" /></div>
                                        <div class="m-t-10">
                                            <h5 class="m-b-5 font-medium">Emma Smith <span class="text-muted font-14 m-l-10">| &nbsp; 6:30 PM</span></h5>
                                            <h6 class="text-muted">joined projectname, and invited <a href="javascript:void(0)">@maxcage, @maxcage, @maxcage, @maxcage, @maxcage,+3</a></h6>
                                            <span class="image-list m-t-10">
                                                <a href="javascript:void(0)"><img src="{{asset('images/users/1.jpg')}}" class="img-circle" alt="user" width="40" /></a>
                                                <a href="javascript:void(0)"><img src="{{asset('images/users/4.jpg')}}" class="img-circle" alt="user" width="40" /></a>
                                                <a href="javascript:void(0)"><img src="{{asset('images/users/5.jpg')}}" class="img-circle" alt="user" width="40" /></a>
                                                <a href="javascript:void(0)"><img src="{{asset('images/users/6.jpg')}}" class="img-circle" alt="user" width="40" /></a>
                                                <a href="javascript:void(0)">+3</a>
                                            </span>
                                        </div>
                                    </div>
                                    <!-- Activity item-->
                                </div>
                                <div class="date-devider"><span>Yesterday</span></div>
                                <div class="card-body">
                                    <!-- Activity item-->
                                    <div class="activity-item">
                                        <div class="round m-r-20"><img src="{{asset('images/users/4.jpg')}}" alt="user" width="50" /></div>
                                        <div class="m-t-10">
                                            <h5 class="m-b-0 font-medium">David R. Jones  <span class="text-muted font-14 m-l-10">| &nbsp; 6:30 PM</span></h5>
                                            <h6 class="text-muted">uploaded this file </h6>
                                            <span>
                                                <a href="javascript:void(0)" class="m-r-10"><img src="{{asset('images/users/1.jpg')}}" alt="user" width="60"></a>
                                                <a href="javascript:void(0)" class="m-r-10"><img src="{{asset('images/users/2.jpg')}}" alt="user" width="60"></a>
                                                <a href="javascript:void(0)" class="m-r-10"><img src="{{asset('images/users/3.jpg')}}" alt="user" width="60"></a>
                                            </span>
                                        </div>
                                    </div>
                                    <!-- Activity item-->
                                    <!-- Activity item-->
                                    <div class="activity-item">
                                        <div class="round m-r-20"><img src="{{asset('images/users/6.jpg')}}" alt="user" width="50" /></div>
                                        <div class="m-t-10">
                                            <h5 class="m-b-5 font-medium">David R. Jones <span class="text-muted font-14 m-l-10">| &nbsp; 6:30 PM</span></h5>
                                            <h6 class="text-muted">Commented on<a href="javascript:void(0)">Test Project</a></h6>
                                            <p class="m-b-0">It has survived not only five centuries, but also the leap into electrotypesetting, remaining essentially unchanged.</p>
                                        </div>
                                    </div>
                                    <!-- Activity item-->
                                    <!-- Activity item-->
                                    <div class="activity-item">
                                        <div class="round m-r-20"><img src="{{asset('images/users/7.jpg')}}" alt="user" width="50" /></div>
                                        <div class="m-t-10">
                                            <h5 class="m-b-0 font-medium">David R. Jones  <span class="text-muted font-14 m-l-10">| &nbsp; 6:30 PM</span></h5>
                                            <h6 class="text-muted">uploaded this file </h6>
                                            <p>It has survived not only five centuries</p>
                                            <span>
                                                <a href="javascript:void(0)" class="m-r-10"><img src="{{asset('images/users/5.jpg')}}" alt="user" width="60"></a>
                                                <a href="javascript:void(0)" class="m-r-10"><img src="{{asset('images/users/6.jpg')}}" alt="user" width="60"></a>
                                                <a href="javascript:void(0)" class="m-r-10"><img src="{{asset('images/users/3.jpg')}}" alt="user" width="60"></a>
                                            </span>
                                        </div>
                                    </div>
                                    <!-- Activity item-->
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
