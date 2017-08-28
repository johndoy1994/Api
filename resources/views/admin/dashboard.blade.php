@extends('layouts.backend')

@section('title','Dashboard')

@section('body-class','hold-transition skin-blue sidebar-mini')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Dashboard
            <small>Control panel</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <!-- Small boxes (Stat box) -->
          <div class="row">
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3>{{$totalBrands}}</h3>

                  <p>Brand Management</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="{{route('brandslisting')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->

            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h3>{{$totalModels}}</h3>

                  <p>Model Management</p>
                </div>
                <div class="icon">
                  <i class="ion ion-help-buoy"></i>
                </div>
                <a href="{{route('modellisting')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->

            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-blue">
                <div class="inner">
                  <h3>{{$totalModelDetails}}</h3>

                  <p>Model Details Manegement</p>
                </div>
                <div class="icon">
                  <i class="ion ion-drag"></i>
                </div>
                <a href="{{route('modelDetailslisting')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
          </div>
          <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
@endsection

<!-- http://setbootstrap.com/glyphicon/ionicons/ -->