<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Admin Panel | Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"> -->
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('adminassets/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <!-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> -->
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{ asset('adminassets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('adminassets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{ asset('adminassets/plugins/jqvmap/jqvmap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('adminassets/dist/css/adminlte.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('adminassets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('adminassets/plugins/daterangepicker/daterangepicker.css') }}">
  <!-- Summernote -->
  <link rel="stylesheet" href="{{ asset('adminassets/plugins/summernote/summernote-bs4.min.css') }}">

  <!-- Yajra DataTables -->
 <!-- ✅ Latest Bootstrap 5 CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">

<!-- ✅ Latest DataTables Bootstrap 5 CSS -->
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">

<!-- ✅ Latest jQuery (v3.7.1) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- ✅ Latest DataTables Core JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<!-- ✅ Latest DataTables Bootstrap 5 JS -->
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>



  <link rel="stylesheet" href="{{ asset('adminassets/css/style.css') }}">


</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="/adminassets/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">

    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="/admin/dashboard" class="nav-link">Home</a>
        </li>
       
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
    
        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
            <i class="fas fa-th-large"></i>
          </a>
        </li>
        <li class="nav-item">
          <form id="logout-form" action="{{ route('auth.logout') }}" method="POST">
            @csrf
            <button type="submit" class="nav-link" style="background: none; border: none; cursor: pointer;">
              <i class="fas fa-sign-out-alt" style="font-size: larger;"></i>
            </button>
          </form>
        </li>

      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="{{ url('/admin/dashboard') }}" class="brand-link">
        <img src="{{asset('/adminassets/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">

        <span class="brand-text font-weight-light">Admin Panel</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="{{asset('/adminassets/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">

          </div>
          <div class="info">
            <a href="#" class="d-block"> @if(Auth::user()->name) {{ Auth::user()->name }} @endif </a>
          </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
          <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
              </button>
            </div>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item ">
              <a href="/admin/dashboard" class="nav-link  {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Dashboard
                  <i class="right fas fa-home"></i>
                </p>
              </a>
             

            </li>
            @if(Auth::user()->HasRole('Super Admin'))
            <li class="nav-item">
              <a href="/admin/index" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>
                  Add Admins
                  <i class="right fas fa-user-friends"></i>
                  <!-- <span class="right badge badge-danger">New</span> -->
                </p>
              </a>
            </li>
            @endif
            <li class="nav-item ">
              <a href="/admin/cars" class="nav-link {{ request()->is('admin/cars') ? 'active' : '' }}">
                <i class="nav-icon fas fa-th"></i>
                <p>
                  Car Management
                  <i class="right fas fa-taxi"></i>
                  <!-- <span class="right badge badge-danger">New</span> -->
                </p>
              </a>
            </li>
            <li class="nav-item"><a href="/admin/drivers" class="nav-link {{ request()->is('admin/drivers') ? 'active' : '' }}">
                <i class="nav-icon fas fa-th"></i>
                <p>
                  Driver Management
                  <i class="right fas fa-user-tie"></i>
                  <!-- <span class="right badge badge-danger">New</span> -->
                </p>
              </a>
            </li>
            <li class="nav-item"><a href="/admin/driver-requests" class="nav-link {{ request()->is('admin/driver-requests') ? 'active' : '' }}">
                <i class="nav-icon fas fa-th"></i>
                <p>
                  Driver Requests
                  <i class="right fas fa-hand-paper"></i>
                  <!-- <span class="right badge badge-danger">New</span> -->
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/admin/fixed-pricing" class="nav-link {{ request()->is('admin/fixed-pricing') ? 'active' : '' }}">
                <i class="nav-icon fas fa-th"></i>
                <p>
                  Tour Pricing
                  <i class="right fas fa-tag"></i>
                  <!-- <span class="right badge badge-danger">New</span> -->
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/admin/trip-type" class="nav-link {{ request()->is('admin/trip-type') ? 'active' : '' }}">
                <i class="nav-icon fas fa-th"></i>
                <p>
                  Trip Categories
                  <i class="right fas fa-table"></i>
                  <!-- <span class="right badge badge-danger">New</span> -->
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/admin/customers" class="nav-link {{ request()->is('admin/customers') ? 'active' : '' }}">
                <i class="nav-icon fas fa-th"></i>
                <p>
                  Customers
                  <i class="right fas fa-users"></i>
                  <!-- <span class="right badge badge-danger">New</span> -->
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/admin/bookings" class="nav-link {{ request()->is('admin/bookings') ? 'active' : '' }}">
                <i class="nav-icon fas fa-th"></i>
                <p>
                  Bookings
                  <i class="right fas fa-cubes"></i>
                  <!-- <span class="right badge badge-danger">New</span> -->
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/admin/transactions" class="nav-link {{ request()->is('admin/transactions') ? 'active' : '' }}">
                <i class="nav-icon fas fa-th"></i>
                <p>
                  Transactions
                  <i class="right fas fa-rupee-sign"></i>
                  <!-- <span class="right badge badge-danger">New</span> -->
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/admin/verify-payments" class="nav-link {{ request()->is('admin/verify-payments') ? 'active' : '' }}">
                <i class="nav-icon fas fa-th"></i>
                <p>
                  Verify Payments
                  <i class="right fas fa-check-circle"></i>
                  <!-- <span class="right badge badge-danger">New</span> -->
                </p>
              </a>
            </li>
      </div>
      <!-- /.sidebar -->
    </aside>

    @yield('content')

    <!-- /.content-wrapper -->
    <footer class="main-footer">
      <strong>Copyright &copy; 2024-2025 <a href="#">Tour</a>.</strong>
      All rights reserved.
      <!-- <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 3.1.0
      </div> -->
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->
  <!-- jQuery -->

  </div>
  <!-- ./wrapper -->
  <!-- jQuery -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script src="{{ asset('adminassets/plugins/jquery/jquery.min.js') }}"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="{{ asset('adminassets/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button);
  </script>
  <!-- Bootstrap 4 -->
  <script src="{{ asset('adminassets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <!-- ChartJS -->
  <script src="{{ asset('adminassets/plugins/chart.js/Chart.min.js') }}"></script>
  <!-- Sparkline -->
  <script src="{{ asset('adminassets/plugins/sparklines/sparkline.js') }}"></script>
  <!-- JQVMap -->
  <script src="{{ asset('adminassets/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
  <script src="{{ asset('adminassets/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
  <!-- jQuery Knob Chart -->
  <script src="{{ asset('adminassets/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
  <!-- daterangepicker -->
  <script src="{{ asset('adminassets/plugins/moment/moment.min.js') }}"></script>
  <script src="{{ asset('adminassets/plugins/daterangepicker/daterangepicker.js') }}"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="{{ asset('adminassets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
  <!-- Summernote -->
  <script src="{{ asset('adminassets/plugins/summernote/summernote-bs4.min.js') }}"></script>
  <!-- overlayScrollbars -->
  <script src="{{ asset('adminassets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('adminassets/dist/js/adminlte.js') }}"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="{{ asset('adminassets/dist/js/demo.js') }}"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="{{ asset('adminassets/dist/js/pages/dashboard.js') }}"></script>
  <script src="{{ asset('adminassets/js/script.js') }}"></script>
  <!-- Cars JS Files -->

  @php
  $scripts = glob(public_path('adminassets/js/cars/*.js'));
  @endphp

  @foreach ($scripts as $script)
  <script src="{{ asset('adminassets/js/cars/' . basename($script)) }}"></script>
  @endforeach
  <!-- Drivers JS Files -->

  @php
  $scripts = glob(public_path('adminassets/js/drivers/*.js'));
  @endphp

  @foreach ($scripts as $script)
  <script src="{{ asset('adminassets/js/drivers/' . basename($script)) }}"></script>
  @endforeach
  <!-- Fixed Pricing JS Files -->

  @php
  $scripts = glob(public_path('adminassets/js/pricing/*.js'));
  @endphp

  @foreach ($scripts as $script)
  <script src="{{ asset('adminassets/js/pricing/' . basename($script)) }}"></script>
  @endforeach

  <!-- Trip Type JS Files -->
  @php
  $scripts = glob(public_path('adminassets/js/tripType/*.js'));
  @endphp

  @foreach ($scripts as $script)
  <script src="{{ asset('adminassets/js/tripType/' . basename($script)) }}"></script>
  @endforeach

  <!-- Customers JS Files -->
  @php
  $scripts = glob(public_path('adminassets/js/customers/*.js'));
  @endphp

  @foreach ($scripts as $script)
  <script src="{{ asset('adminassets/js/customers/' . basename($script)) }}"></script>
  @endforeach

  <!-- Bookings JS Files -->
  @php
  $scripts = glob(public_path('adminassets/js/bookings/*.js'));
  @endphp

  @foreach ($scripts as $script)
  <script src="{{ asset('adminassets/js/bookings/' . basename($script)) }}"></script>
  @endforeach

  <!-- Transactions JS Files -->
  @php
  $scripts = glob(public_path('adminassets/js/transactions/*.js'));
  @endphp

  @foreach ($scripts as $script)
  <script src="{{ asset('adminassets/js/transactions/' . basename($script)) }}"></script>
  @endforeach

  <!-- Transactions JS Files -->
  @php
  $scripts = glob(public_path('adminassets/js/verifyPayment/*.js'));
  @endphp

  @foreach ($scripts as $script)
  <script src="{{ asset('adminassets/js/verifyPayment/' . basename($script)) }}"></script>
  @endforeach

  <!-- Transactions JS Files -->
  @php
  $scripts = glob(public_path('adminassets/js/driverRequests/*.js'));
  @endphp

  @foreach ($scripts as $script)
  <script src="{{ asset('adminassets/js/driverRequests/' . basename($script)) }}"></script>
  @endforeach

</body>

</html>