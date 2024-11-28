<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>PMS - @yield('title')</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('public/admin/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/admin/vendors/css/vendor.bundle.base.css') }}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ asset('public/admin/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('public/admin/css/developer.css') }}">
    <!-- End layout styles -->
    <link rel="icon" type="image/x-icon" href="{{ asset('public/admin/logo.png')}}">
    <link rel="stylesheet" href="{{ asset('public/admin/css/toastr.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js">
    
    
    
    
   
    <script src="{{ asset('public/admin/js/jquery.cookie.js') }}" type="text/javascript"></script>
    

    
    <script src="{{ asset('public/admin/js/todolist.js') }}"></script>
    <script src="{{ asset('public/admin/js/toastr.js') }}"></script>
  </head>
  <body>
    <div class="container-scroller">
     
      <!-- partial:partials/_navbar.html -->
      @include('admin.elements.header')
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        @include('admin.elements.sidebar')
        <!-- partial -->
        <div class="main-panel">
          @yield('content')
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
        
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    
    <!-- End custom js for this page -->
    @include('admin.elements.flash')
    <script src="{{ asset('public/admin/vendors/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('public/admin/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('public/admin/js/off-canvas.js') }}"></script>
    <script src="{{ asset('public/admin/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('public/admin/js/misc.js') }}"></script>
    <script src="{{ asset('public/admin/js/dashboard.js') }}"></script>
    <script src="{{ asset('public/admin/js/file-upload.js') }}"></script>
  </body>
</html>