@section('footer')
	<script>
		var base_url ="{{url('/')}}";
        var token = "{{csrf_token()}}";
	</script>

    {{-- Global functions --}}
    <script src="{{asset('js/global.js')}}"></script>

		<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>

    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{asset('plugins/bootstrap/js/popper.min.js')}}"></script>
    <script src="{{asset('plugins/bootstrap/js/bootstrap.min.js')}}"></script>

    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{{asset('js/perfect-scrollbar.jquery.min.js')}}"></script>

    <!--Wave Effects -->
    <script src="{{asset('js/waves.js')}}"></script>

    <!--Menu sidebar -->
    <script src="{{asset('js/sidebarmenu.js')}}"></script>

    <!--stickey kit -->
    <script src="{{asset('plugins/sticky-kit-master/dist/sticky-kit.min.js')}}"></script>
    <script src="{{asset('plugins/sparkline/jquery.sparkline.min.js')}}"></script>

    <!--Custom JavaScript -->
    <script src="{{asset('js/custom.min.js')}}"></script>
		<script src="{{asset('js/jasny-bootstrap.js')}}"></script>
		<script src="{{asset('plugins/toast-master/js/jquery.toast.js')}}"></script>
		<script src="{{asset('js/toastr.js')}}"></script>

	<!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="{{asset('plugins/styleswitcher/jQuery.style.switcher.js')}}"></script>
		<script src="{{asset('plugins/moment/min/moment.min.js')}}"></script>
    {{-- <script src="{{asset('plugins/wizard/jquery.steps.min.js')}}"></script> --}}
    <script src="{{asset('plugins/wizard/jquery.steps.js')}}"></script>
    <script src="{{asset('plugins/wizard/jquery.validate.min.js')}}"></script>

	<!-- This is data table -->
    <script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <!-- start - This is for export functionality only -->
    <script src="{{asset('plugins/datatables/plugin/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('plugins/datatables/plugin/buttons.flash.min.js')}}"></script>
		<script src="{{asset('plugins/datatables/plugin/buttons.html5.min.js')}}"></script>
    <script src="{{asset('plugins/datatables/plugin/buttons.print.min.js')}}"></script>
    <script src="{{asset('plugins/datatables/plugin/jszip.min.js')}}"></script>
    <script src="{{asset('plugins/datatables/plugin/pdfmake.min.js')}}"></script>
    <script src="{{asset('plugins/datatables/plugin/vfs_fonts.js')}}"></script>
    <!-- end data table -->

	<!-- Sweet-Alert  -->
    <script src="{{asset('plugins/sweetalert/sweetalert.min.js')}}"></script>
    <script src="{{asset('plugins/sweetalert/jquery.sweet-alert.custom.js')}}"></script>
		<script src="{{asset('plugins/wizard/steps.js')}}"></script>

	<!-- ============================================================== -->
    <!-- Select 2 -->
    <!-- ============================================================== -->
    <script src="{{asset('plugins/switchery/dist/switchery.min.js')}}"></script>
    <script src="{{asset('plugins/select2/dist/js/select2.full.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('plugins/bootstrap-select/bootstrap-select.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js')}}"></script>
    <script src="{{asset('plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js')}}" type="text/javascript"></script>
    <script type="text/javascript" src="{{asset('plugins/multiselect/js/jquery.multi-select.js')}}"></script>

	<!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="{{asset('plugins/styleswitcher/jQuery.style.switcher.js')}}"></script>
		<script src="{{asset('plugins/footable/js/footable.all.min.js')}}"></script>

    <!--FooTable init-->
    <script src="{{asset('js/footable-init.js')}}"></script>
		<script src="{{asset('plugins/switchery/dist/switchery.min.js')}}"></script>

	<!-- icheck -->
	<script src="{{asset('plugins/icheck/icheck.min.js')}}"></script>
	<script src="{{asset('plugins/icheck/icheck.init.js')}}"></script>
	<!-- =============================================================== -->

	<!-- Mask  -->
	<!-- <script src="{{asset('js/mask.js')}}"></script> -->

	<!-- Clock Plugin JavaScript -->
    <script src="{{asset('plugins/clockpicker/dist/jquery-clockpicker.min.js')}}"></script>

				<!-- FAVOR DE PONER ==AQUI== LOS JS DE LOS MODULOS -->
	<!-- ======================= JS de los módulos ===================================== -->
				<!-- FAVOR DE PONER ==AQUI== LOS JS DE LOS MODULOS -->
	@yield('java')
	<!-- <script src="{{asset('modulos/materiales.js')}}"></script> -->
	<!-- <script src="{{asset('js/modulos/dashboard.js')}}"></script> -->

	@if(Request::segment(1) == "clientes")
		<script src="{{asset('modulos/clientes.js')}}"></script>
	@endif

	@if(Request::segment(1) == "cotizaciones")
		<script src="{{asset('plugins/sweetalert/sweetalert_2/sweetalert2.all.min.js')}}"></script>
		<script src="{{asset('plugins/sweetalert/sweetalert_2/sweetalert2.min.js')}}"></script>
		<link rel="stylesheet" href="{{asset('plugins/sweetalert/sweetalert_2/sweetalert2.min.css')}}">

		<script src="{{asset('modulos/cotizaciones.js')}}"></script>
	@endif

	@if(Request::segment(1) == "configuraciones")
		<script src="{{asset('modulos/configuraciones.js')}}"></script>
	@endif

	@if(Request::segment(1) == "inventario")
		<script src="{{asset('modulos/materiales.js')}}"></script>
	@endif
</body>
</html>
@show
