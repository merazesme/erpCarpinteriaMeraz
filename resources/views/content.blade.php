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
				@section('breadcrumbs')
				@parent
				<div class="card">
					<h1>jala</h1>
				</div>
			</div>
		</div>
		@section('footer')
		@parent
	</div>
@endsection
@endsection
@endsection
@endsection
