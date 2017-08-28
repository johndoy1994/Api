@extends('layouts.backend')

@section('title','Add new modeldetails')

@section('body-class','hold-transition skin-blue sidebar-mini')

@push('header')
  <link rel="stylesheet" href="{{asset('/public/backend/plugins/select2/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('/public/backend/plugins/datepicker/datepicker3.css')}}">
@endpush

@section('content')
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Model Details
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#"><i class="fa fa-bars"></i> ModelDetails</a></li>
        <li class="active">Add New</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- right column -->
        <div class="col-md-10 col-md-offset-1">
          <!-- Horizontal Form -->
          <hr>
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Add new modeldetails</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            {{Form::open(array('url'=>route('postAdminAddModelDetails'),'method' => 'post','role'=>'form','class'=>'form-horizontal','files'=>true))}}
              <div class="box-body">
                <!-- Error Part-->
                <div class="box-body">
                  @include('admin.myerrorSection')
                </div>
                <div class="form-group">
                  {{ Form::label('brand_id', 'Brand Name*',array('class'=>'col-sm-3 control-label')) }}
                  <div class="col-sm-6">
                    {{ Form::select('brand_id', $mainBrand, old('brand_id'), array('class' => 'form-control category_box select2', 'required'=>'required','data-ref-id'=>'model_id', 'placeholder' => 'Select Brand')) }}
                  </div>
                </div>
                <div class="form-group" id="div_subcategory_box">
                  {{ Form::label('model_id', 'Model Name *',array('class'=>'col-sm-3 control-label')) }}
                  <div class="col-sm-6">
                    {{ Form::select('model_id', array(), old('model_id'), array('class' => 'form-control sub_model select2', 'required'=>'required', 'placeholder' => 'Select model')) }}
                  </div>
                </div>
                <div class="form-group">
                  {{ Form::label('from_year', 'From *',array('class'=>'col-sm-3 control-label')) }}
                  <div class="col-sm-6">
                    {{ Form::text('from_year',old('from_year'),array('placeholder' => 'From','class'=>'form-control','required'=>'required')) }}
                  </div>
                </div>
                <div class="form-group">
                  {{ Form::label('to_year', 'To *',array('class'=>'col-sm-3 control-label')) }}
                  <div class="col-sm-6">
                    {{ Form::text('to_year',old('to_year'),array('placeholder' => 'to','class'=>'form-control','required'=>'required')) }}
                  </div>
                </div>
                <div class="form-group">
                  {{ Form::label('clyinders', 'Clyinder *',array('class'=>'col-sm-3 control-label')) }}
                  <div class="col-sm-6">
                    {{ Form::text('clyinders',old('clyinders'),array('placeholder' => 'clyinders','class'=>'form-control','required'=>'required')) }}
                  </div>
                </div>
                <div class="form-group">
                  {{ Form::label('litres', 'litres *',array('class'=>'col-sm-3 control-label')) }}
                  <div class="col-sm-6">
                    {{ Form::text('liters',old('liters'),array('placeholder' => 'litres','class'=>'form-control','required'=>'required')) }}
                  </div>
                </div>
                <div class="form-group">
                  {{ Form::label('main_belt', 'Main Belt',array('class'=>'col-sm-3 control-label')) }}
                  <div class="col-sm-6">
                    {{ Form::text('main_belt',old('main_belt'),array('placeholder' => 'main belt','class'=>'form-control')) }}
                  </div>
                </div>
                <div class="form-group">
                  {{ Form::label('power_steering_belt', 'Power Steering Belt',array('class'=>'col-sm-3 control-label')) }}
                  <div class="col-sm-6">
                    {{ Form::text('power_steering_belt',old('power_steering_belt'),array('placeholder' => 'power steering belt','class'=>'form-control')) }}
                  </div>
                </div>
                <div class="form-group">
                  {{ Form::label('alternator_belt', 'Alternator Belt',array('class'=>'col-sm-3 control-label')) }}
                  <div class="col-sm-6">
                    {{ Form::text('alternator_belt',old('alternator_belt'),array('placeholder' => 'alternator belt','class'=>'form-control')) }}
                  </div>
                </div>
                <div class="form-group">
                  {{ Form::label('air_con_belt', 'Air Con Belt',array('class'=>'col-sm-3 control-label')) }}
                  <div class="col-sm-6">
                    {{ Form::text('air_con_belt',old('air_con_belt'),array('placeholder' => 'air con belt','class'=>'form-control')) }}
                  </div>
                </div>
                <div class="form-group">
                  {{ Form::label('image', 'Image',array('class'=>'col-sm-3 control-label')) }}
                  <div class="col-sm-6">
                    {{ Form::file('image',['class'=>'form-control','style'=>'height:auto !important','required'=>'required']) }}
                    <span class="text-red help-block"><b>(Allowed type :</b> jpeg, jpg, png)</span>
                  </div>
                </div>
                <div class="form-group">
                  {{ Form::label('active', 'Status',array('class'=>'col-sm-3 control-label')) }}
                  <div class="col-sm-6">
                    {{ Form::radio('active', 1, true,array('class'=>'')) }} Active
                    {{ Form::radio('active', 0, false,array('class'=>'')) }} Inactive
                  </div>
                </div>
              <!-- /.box-body -->
              <div class="box-footer col-md-12">
                {{Form::submit('Add New',array('class'=>'btn btn-info col-md-offset-3'))}}
                <a href="{{route('modelDetailslisting')}}" class="btn btn-default col-md-offset-1">Cancel</a>
              </div>
              <!-- /.box-footer -->
            {{Form::close()}}
          </div>
          <!-- /.box -->
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
@endsection

@push('footer')
  <script src="{{asset('/public/backend/plugins/select2/select2.full.min.js')}}"></script>
  <script src="{{asset('/public/backend/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
   <script type="text/javascript">
    $(function () {
      $(".select2").select2();
        $("#from_year").datepicker( {
            format: " yyyy", // Notice the Extra space at the beginning
            viewMode: "years", 
            minViewMode: "years"
        });
        $("#to_year").datepicker( {
            format: " yyyy", // Notice the Extra space at the beginning
            viewMode: "years", 
            minViewMode: "years"
        });
    });
  </script>
@endpush