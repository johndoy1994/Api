<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
        <?php
          $route = Route::currentRouteName();
        ?>
        <li class="{{($route == 'dashboard') ? 'active' : ''}} treeview">
          <a href="{{route('dashboard')}}">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        <li class="{{($route == 'brandslisting' || $route == 'getAdminAddBrand' || $route == 'getAdminEditBrand') ? 'active' : ''}} treeview">
          <a href="{{route('brandslisting')}}">
            <i class="fa fa-user"></i> <span>Brand Management</span>
          </a>
        </li>
        <li class="{{($route == 'modellisting' || $route == 'getAdminAddModel' || $route == 'getAdminEditModel') ? 'active' : ''}} treeview">
          <a href="{{route('modellisting')}}">
            <i class="fa fa-support"></i> <span>Model Management</span>
          </a>
        </li>

        <li class="{{($route == 'modelDetailslisting' || $route == 'getAdminAddModelDetails' || $route == 'getAdminEditModelDetails') ? 'active' : ''}} treeview">
          <a href="{{route('modelDetailslisting')}}">
            <i class="fa fa-bars"></i> <span>Model Details Management</span>
          </a>
        </li>
        
        
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>