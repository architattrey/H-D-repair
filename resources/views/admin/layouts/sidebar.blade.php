
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?=url('/')?>/public/dist/img/uphaar_home_logo.png" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info" style="margin-top:-7px;">
        
          <p> {{ucfirst(Auth::User()->name)}}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li class="active treeview">
          <a href="{{route('dashboard')}}">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
           </a>
         
        </li>
        <!-- agents tab -->
        <li class="treeview">
          <a href="#">
            <i class="fa fa-pie-chart"></i>
            <span>Actions</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a> 
          <ul>
            <li><a href="{{route('category')}}"><i class="fa fa-circle-o"></i>&nbsp;Category</a></li>
            <li><a href="{{route('sub-category')}}"><i class="fa fa-circle-o"></i>&nbsp;Sub Category</a></li>
            <li><a href="{{route('service-features')}}"><i class="fa fa-circle-o"></i>&nbsp;Service Features</a></li>
            <li><a href="{{route('service-features-type')}}"><i class="fa fa-circle-o"></i>&nbsp;Service Features Type</a></li>
            <li><a href="{{route('app-users')}}"><i class="fa fa-circle-o"></i>&nbsp;Application Users</a></li>
            <li><a href="{{route('users-transactions')}}"><i class="fa fa-circle-o"></i>&nbsp;Users Transactions</a></li>
            <li><a href="{{route('service-deliveries')}}"><i class="fa fa-circle-o"></i>&nbsp;Users Services Deliveries</a></li>
            <li><a href="{{route('service-providers')}}"><i class="fa fa-circle-o"></i>&nbsp;Users Services Providers</a></li>
            <li><a href="{{route('price-range')}}"><i class="fa fa-circle-o"></i>&nbsp;Add Price Range</a></li>
            <li><a href="{{route('state')}}"><i class="fa fa-circle-o"></i>&nbsp;State</a></li>
            <li><a href="{{route('city')}}"><i class="fa fa-circle-o"></i>&nbsp;City</a></li>
          </ul>
        </li>
        <!-- -->
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>