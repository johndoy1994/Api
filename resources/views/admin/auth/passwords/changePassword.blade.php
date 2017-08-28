@extends('layouts.backend')

@section('title','Change Password')

@section('body-class','hold-transition skin-blue sidebar-mini')

@section('content')
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Change Password
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Change-Password</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- right column -->
        <div class="col-md-6 col-md-offset-3">
          <!-- Horizontal Form -->
          <hr>
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Reset your new password here</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            {{Form::open(array('url'=>route('postAdminChangePassword'),'method' => 'post','role'=>'form','class'=>'form-horizontal'))}}
              <div class="box-body">
                <!-- Error Part-->
                <div class="box-body">
                  @include('admin.myerrorSection')
                </div>
                
                {{Form::hidden('email',Auth::user()->email)}}
                <div class="form-group">
                  {{ Form::label('old_password', 'Current Password',array('class'=>'col-sm-4 control-label')) }}
                  <div class="col-sm-8">
                    {{ Form::password('old_password',array('placeholder' => 'Current Password','class'=>'form-control','required'=>'required')) }}
                  </div>
                </div>
                <div class="form-group">
                  {{ Form::label('password', 'New Password',array('class'=>'col-sm-4 control-label')) }}
                  <div class="col-sm-8">
                    {{ Form::password('password', array('placeholder' => 'New Password','class'=>'form-control','required'=>'required')) }}
                  </div>
                </div>
                <div class="form-group">
                  {{ Form::label('password_confirmation', 'Confirm New Password',array('class'=>'col-sm-4 control-label')) }}
                  <div class="col-sm-8">
                    {{ Form::password('password_confirmation',array('placeholder' => 'Confirm New Password','class'=>'form-control','required'=>'required')) }}
                  </div>
                </div>
              <!-- /.box-body -->
              <div class="box-footer col-md-12">
                {{Form::submit('Change Password',array('class'=>'btn btn-info col-md-offset-3'))}}
                <a href="{{route('dashboard')}}" class="btn btn-default col-md-offset-1">Cancel</a>
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