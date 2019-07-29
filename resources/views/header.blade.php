@section('header')
<!DOCTYPE html>
<html>
<head>
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('images/icon.png')}}">

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon icon -->
    <title>Carpintería Meraz</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{asset('plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('plugins/wizard/steps.css')}}" rel="stylesheet">
    <!--alerts CSS -->
    <link href="{{asset('plugins/sweetalert/sweetalert.css')}}" rel="stylesheet" type="text/css">
    <!-- Single select2 CSS -->
    <link href="{{asset('plugins/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('plugins/switchery/dist/switchery.min.css')}}" rel="stylesheet" />
    <link href="{{asset('plugins/bootstrap-select/bootstrap-select.min.css')}}" rel="stylesheet" />
    <link href="{{asset('plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css')}}" rel="stylesheet" />
    <link href="{{asset('plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css')}}" rel="stylesheet" />
    <link href="{{asset('plugins/multiselect/css/multi-select.css')}}" rel="stylesheet" type="text/css" />
    <!-- Custom CSS -->
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <link href="{{asset('css/pages/file-upload.css')}}" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="{{asset('css/pages/tab-page.css')}}" rel="stylesheet">
    <link href="{{asset('css/colors/default-dark.css')}}" id="theme" rel="stylesheet">
    <link href="{{asset('css/pages/footable-page.css')}}" id="theme" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link href="{{asset('css/pages/form-icheck.css')}}" rel="stylesheet">

    <!-- clockpicker css -->
    <link href="{{asset('plugins/clockpicker/dist/jquery-clockpicker.min.css')}}" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body class="fix-header card-no-border fix-sidebar">
	<header class="topbar">
	<nav class="navbar top-navbar navbar-expand-md navbar-light">
	    <!-- ============================================================== -->
	    <!-- Logo -->
	    <!-- ============================================================== -->
	    <div class="navbar-header mx-auto">
	        <a class="navbar-brand" href="/">
	            <!-- Logo icon -->
	                <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
	                <!-- Dark Logo icon -->
	                <img src="{{asset('images/logo-iconC.png')}}" alt="Carpintería Meraz" />
	                <!-- Light Logo icon -->
	                <!-- <img src="{{asset('images/logo-light-icon.png')}}" alt="homepage" class="light-logo" /> -->
	            <!--End Logo icon -->
	            <!-- Logo text -->
	            <span>
	             <!-- dark Logo text -->
	             <img src="{{asset('images/logo-textC.png')}}" alt="homepage" class="dark-logo" />
	             <!-- Light Logo text -->
	             <!-- <img src="{{asset('images/logo-light-text.png')}}" class="light-logo" alt="homepage" /> -->
		         </span>
		     </a>
	    </div>
	    <!-- ============================================================== -->
	    <!-- End Logo -->
	    <!-- ============================================================== -->
	    <div class="navbar-collapse">
	        <!-- ============================================================== -->
	        <!-- toggle and nav items -->
	        <!-- ============================================================== -->
	        <ul class="navbar-nav mr-auto">
	            <!-- This is  -->
	            <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
	            <li class="nav-item"> <a class="nav-link sidebartoggler hidden-sm-down waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
	            <li class="nav-item hidden-sm-down"></li>
	        </ul>
	        <!-- ============================================================== -->
	        <!-- User profile and search -->
	        <!-- ============================================================== -->
	        <ul class="navbar-nav my-lg-0">
	            <!-- ============================================================== -->
	            <!-- Search -->
	            <!-- ============================================================== -->
	            <!-- <li class="nav-item hidden-xs-down search-box"> <a class="nav-link hidden-sm-down waves-effect waves-dark" href="javascript:void(0)"><i class="ti-search"></i></a>
	                <form class="app-search">
	                    <input type="text" class="form-control" placeholder="Search & enter"> <a class="srh-btn"><i class="ti-close"></i></a> </form>
	            </li> -->

	            <!-- ============================================================== -->
	            <!-- caja chica -->
	            <!-- ============================================================== -->
	            <li class="nav-item dropdown">
	                <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" id="2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-cash-multiple"></i>
	                </a>
	                <div class="dropdown-menu mailbox dropdown-menu-right animated bounceInDown" aria-labelledby="2">
	                    <ul>
	                        <li>
	                            <div class="drop-title">Caja chica</div>
	                        </li>
	                        <li>
	                        	<div class="table-responsive">
				                    <table class="table">
				                        <tbody>
				                            <tr>
				                                <td>Oficina</td>
				                                <td><i class="ti-plus" style="color: green"></i></td>
				                                <td>$60.00</td>
				                            </tr>
				                            <tr>
				                                <td>Trabajadores</td>
				                                <td><i class="ti-plus" style="color: green"></i></td>
				                                <td>$100.00</td>
				                            </tr>
				                            <tr>
				                                <td>Caja chica</td>
				                                <td><i class="ti-plus" style="color: green"></i></td>
				                                <td>$3674.50</td>
				                            </tr>
				                            <tr>
				                                <td>Toluco</td>
				                                <td><i class="ti-plus" style="color: green"></i></td>
				                                <td>$200.00</td>
				                            </tr>
				                            <tr>
				                                <td>Debe</td>
				                                <td><i class="ti-minus" style="color: red"></i></td>
				                                <td>$34.50</td>
				                            </tr>
				                            <tr>
				                                <td><b>Total</b></td>
				                                <td></td>
				                                <td><b>$4000.00</b></td>
				                            </tr>
				                        </tbody>
				                    </table>
				                </div>
	                        </li>
	                    </ul>
	                </div>
	            </li>

	            <!-- ============================================================== -->
	            <!-- End caja chica -->
	            <!-- ============================================================== -->
	        </ul>
	    </div>
	</nav>
</header>
@show
