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
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{asset('/public/backend/dist/css/skins/_all-skins.min.css')}}">
  <link rel="stylesheet" href="{{asset('/public/backend/custom/css/style.css')}}">
@endpush
@section('master-body-class')
	@yield('body-class')
@endsection

@section('master-content')
	<div class="wrapper ">
		@include('layouts.includes.admin_header')
		@include('layouts.includes.admin_navbar')

		@yield('content')
		@include('layouts.includes.admin_footer')
	</div>
@endsection

@push('footer')
	<script src="{{asset('/public/backend/plugins/jQuery/jquery-2.2.3.min.js')}}"></script>
	<!-- jQuery UI 1.11.4 -->
	<script src="{{asset('/public/backend/plugins/jQuery/jquery-ui-1.11.4.min.js')}}"></script>
	<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
	<script>
	  $.widget.bridge('uibutton', $.ui.button);
	</script>
	<!-- Bootstrap 3.3.6 -->
	<script src="{{asset('/public/backend/bootstrap/js/bootstrap.min.js')}}"></script>

	<!-- AdminLTE App -->
	<script src="{{asset('/public/backend/dist/js/app.min.js')}}"></script>

	<script type="text/javascript">

		$(document).ready(function() {

			$("body").ready(function(){
				$('.loader').hide();
			});
			
			$('.selectall').click(function(event) {
		       var id=$(this).data('class');
		        if(this.checked)
		        { 
		          $(".userRow").prop('checked', true);
		        }
		        else
		        {
		          $(".userRow").prop('checked', false);      
		        }
		    });
			
	        $("#recordsPerPage").change(function() {
	            var target = $(this).attr('data-target');
	            var value = $(this).val();
	            $.ajax({
	                url:  "{{route('api-public-recordPerPage')}}",
	                data: {
	                    target: target,
	                    value: value
	                },
	                success: function(msg){
	                   if(msg['success']){
	                    document.location = "{{route(Route::getCurrentRoute()->getName(), array_merge(Request::all(), ['page'=>1]))}}";
	                   }else{
	                    alert('Please try again!');
	                   }
	                }
	            });
	        });
	        // Get Category level-2
	        $(".category_box").on("change",function(){
			    var parentId = $(this).val();
			    var getRefSubCategoryId = $(this).data('ref-id');
			    $('#'+getRefSubCategoryId).empty();
			    $('.sub_model').not(this).html($('<option selected="selected">').text("Select model").attr('value',""));
			    	
			    if(parentId != "")
			    {
			    	$.ajax({
			          url       : "{{route('getAdminModelByAjax')}}",
			          data      : {'parentId':parentId },
			          dataType  :'json',
			          success: function(data)
			          {
			              $.each(data, function(i, value) {
			                  $('#'+getRefSubCategoryId).append($('<option>').text(value).attr('value', i));
			              });
			          }
			        });
			    }
			});

	        $("#bulkSubmit").on("click",function(e){
	        	var bulkAction = $("#bulkaction").val();
	        	if(bulkAction == "")
	        	{
	        		alert('Please select any action');
	        		e.preventDefault();
	        	}
	        });

	        $(document).on('click','.btn-status',function() {
		        var rawId = $(this).data("row_id");
		        var currentStatus = $(this).data("status");
		        var tableName = $(this).data("table_name");
		        var Mythis = $(this);
		        $.ajax({
		            url: "{{route('api-public-change-status')}}",
		            data:{
		            	'rawId' : rawId,
		            	'status': currentStatus,
		            	'table_name' : tableName
		            },
		            success:function(data){
		            var html = "";
		              if(data == "1")
		              {
		                  html = '<button type="button" class="btn btn-secondary bg-green btn-xs btn-status" data-toggle="tooltip" data-placement="top" title="Click to Inactivate" data-status="'+data+'" data-row_id="'+rawId+'" data-table_name="'+tableName+'">Active</button>';
		              }else{
		              	html = '<button type="button" class="btn btn-secondary bg-red btn-xs btn-status" data-toggle="tooltip" data-placement="top" title="Click to Activate" data-status="'+data+'" data-row_id="'+rawId+'" data-table_name="'+tableName+'">Inactive</button>';
		              }
		              Mythis.parent().html(html);
		            }
		        });
		    });

	        

	    });
    </script>
@endpush