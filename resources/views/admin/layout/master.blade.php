<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title','Dashbord3')</title>
  
  @include('admin.layout.css')
  <!-- Google Font: Source Sans Pro -->  
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <!-- <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div> -->
  
  <div id="pageloader" style="display: none;">
    <i class="fa fa-spinner fa-spin fa-5x fa-fw" style="color: #28282B;"></i>
    <span class="sr-only">Loading...</span>
  </div>


  <!-- Navbar -->
  @include('admin.layout.header') 
  
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  @include('admin.layout.sidebar')
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   @yield('content')
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @include('admin.layout.footer')

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark" style="overflow-y:auto">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<!-- <div id="loader">
    <div class="spinner"></div>
</div> -->

@include('admin.layout.script')

</body>
</html>
