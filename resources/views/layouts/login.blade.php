@extends('layouts.master')

@section('master-title')
@yield('title') - {{env('PROJECT_TITLE')}}
@endsection

@push('header')
	<!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="{{asset('/public/backend/bootstrap/css/bootstrap.min.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('/public/backend/dist/css/font-awesome-4.6.3/css/font-awesome.min.css')}}">
  
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{asset('/public/backend/dist/css/ionicons-2.0.1/css/ionicons.min.css')}}">
  <!-- Ionicons -->
  
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('/public/backend/dist/css/AdminLTE.min.css')}}">
  <link rel="stylesheet" href="{{asset('/public/backend/plugins/iCheck/square/blue.css')}}">

@endpush
@section('master-body-class')
	@yield('body-class')
@endsection

@section('master-content')
	<div class="wrapper ">
		@yield('content')
	</div>
@endsection

@push('footer')
	<script src="{{asset('/public/backend/plugins/jQuery/jquery-2.2.3.min.js')}}"></script>
	<!-- jQuery UI 1.11.4 -->
	<!-- <script src="{{asset('/backend/plugins/jQuery/jquery-ui-1.11.4.min.js')}}"></script> -->
	<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
	
	<!-- Bootstrap 3.3.6 -->
	<script src="{{asset('/public/backend/bootstrap/js/bootstrap.min.js')}}"></script>

	<!-- AdminLTE App -->
	<script src="{{asset('/public/backend/dist/js/app.min.js')}}"></script>
	<!-- iCheck -->
	<script src="{{asset('/public/backend/plugins/iCheck/icheck.min.js')}}"></script>
	<script>
	  $(function () {
	  	$('input').iCheck({
	      checkboxClass: 'icheckbox_square-blue',
	      radioClass: 'iradio_square-blue',
	      increaseArea: '20%' // optional
	    });
	  });
	</script>
@endpush