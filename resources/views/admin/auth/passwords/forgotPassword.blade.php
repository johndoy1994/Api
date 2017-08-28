@extends('layouts.login')

@section('title','Forgot Password')

@section('body-class','hold-transition login-page')
@section('content')
<div class="login-box">
    <div class="login-logo">
        <a href="{{route('dashboard')}}"><b>Correct Belt</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg"><b>Forgot Password ?</b></p>
        <p>Unable to sign in to your account? Enter your email and we'll send you a new password.</p>

        {{Form::open(array('url'=>route('postAdminForgotPassword'),'method'=>'post','role'=>'form','class'=>'form-group '))}}
            {{ csrf_field() }}

            @if(Session::has('message'))
                <div class=" form-group alert {{Session::get('alert-class')}} alert-dismissible">
                    <p>{{ Session::get('message') }}</p>
                </div>
            @endif
            
            @if ($errors->any())
                <div class="form-group alert alert-danger">
                    @foreach($errors->all() as $error) 
                        <li >{{ $error }}</li>
                    @endforeach 
                </div>
            @endif 

            <div class="form-group has-feedback">
                {{ Form::label('email', 'Email Address') }}
                {{ Form::email('email', old('email'), array('placeholder' => 'Email','class'=>'form-control','required'=>'required')) }}
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-4 col-xs-offset-4">
                  {{ Form::submit('Submit',array('class'=>'btn btn-primary btn-block btn-flat')) }}
                </div>
                <!-- /.col -->
            </div>
        <!-- </form> -->
        {{Form::close()}}
        <div class="space"></div>
        Click to <a href="{{route('getLoginPage')}}">login</a> here.<br>

    </div>
  <!-- /.login-box-body -->
</div>
@endsection
