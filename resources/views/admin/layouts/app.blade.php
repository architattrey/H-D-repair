<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>LUXMI AGRO BIOTECH | Admin Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->

  <link href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
  <link href="{{ asset('bower_components/Ionicons/css/ionicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('dist/css/AdminLTE.min.css') }}" rel="stylesheet">
  <link href="{{ asset('dist/css/skins/_all-skins.min.css') }}" rel="stylesheet">
  <link href="{{ asset('dist/css/style.css') }}" rel="stylesheet">
  <link href="{{ asset('bower_components/morris.js/morris.css') }}" rel="stylesheet">
  <link href="{{ asset('bower_components/jvectormap/jquery-jvectormap.css') }}" rel="stylesheet">
  <link href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
  <link href="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">
  <link href="{{ asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}" rel="stylesheet">
  <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
  <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/angular-data-table/0.7.1/dataTable.min.css">

  <script>
    var FULL_PATH = "<?=url('/')?>";
     
    
     
  </script>

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">


  @include('admin.layouts.nav') 

  @include('admin.layouts.sidebar') 

  
   @yield('content')

  <!-- <footer class="main-footer">
    <div class="pull-right hidden-xs">
     
    </div>
    <center><strong>Copyright &copy; 2018-{{date('Y')}} </strong> All rights
    reserved.</center>
  </footer> -->

   
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}" rel="stylesheet"></script>
<script src="{{ asset('bower_components/jquery-ui/jquery-ui.min.js') }}" rel="stylesheet"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<script  src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script  src="{{ asset('bower_components/raphael/raphael.min.js') }}" ></script>
<script  src="{{ asset('bower_components/raphael/raphael.min.js') }}" ></script>
<script  src="{{ asset('bower_components/morris.js/morris.min.js') }}" ></script>
<script  src="{{ asset('bower_components/jquery-sparkline/dist/jquery.sparkline.min.js') }}" ></script>
<script  src="{{ asset('plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}" ></script>
<script  src="{{ asset('plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}" ></script>
<script  src="{{ asset('bower_components/jquery-knob/dist/jquery.knob.min.js') }}" ></script>
<script  src="{{ asset('bower_components/moment/min/moment.min.js') }}" ></script>
<script  src="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.js') }}" ></script>
<script  src="{{ asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}" ></script>
<script  src="{{ asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}" ></script>
<script  src="{{ asset('bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}" ></script>
<script  src="{{ asset('bower_components/fastclick/lib/fastclick.js') }}" ></script>
<script  src="{{ asset('dist/js/adminlte.min.js') }}" ></script>
<script  src="{{ asset('dist/js/pages/dashboard.js') }}" ></script>
<script  src="{{ asset('dist/js/demo.js') }}" ></script>

<script  src="{{ asset('dist/js/custom.js') }}" ></script>

<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/angular-data-table/0.7.1/dataTable.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
 


 @yield('script')

</body>
</html>
