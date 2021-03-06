<!DOCTYPE html>
<html lang="en">
    <head>
      <meta charset="utf-8">
      <link href="{{ asset('templates/midone/images/logo.svg') }}" rel="shortcut icon">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="Sedata is Future Business Helper.">
      <meta name="keywords" content="business, startup">
      <meta name="author" content="SEDATA">
      <!-- BEGIN: CSS Assets-->
      <link rel="stylesheet" href="{{ asset('templates/midone/css/app.css') }}" />
      <link rel="stylesheet" href="{{ asset('templates/midone/vendor/sweetalert/sweetalert2.min.css') }}" />
      {{-- <link rel="stylesheet" href="{{ asset('templates/midone/vendor/datepicker/bootstrap-datepicker.min.css') }}" /> --}}
      {{-- <link rel="stylesheet" href="{{ asset('templates/midone/vendor/select2/css/select2.min.css') }}" /> --}}

      
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <title>@yield('title')</title>
      <!-- plugins:css -->
      @yield('additionalFileCSS')
    </head>
    <script type="text/javascript">
      var API_URL = '{{ env('API_URL') }}';
      var BASE_URL = '{{ url('/') }}';
      var TOKEN = '';
      
      let loggedUser = localStorage.getItem('_r');
      let userPermissions = localStorage.getItem('_p');

      if (loggedUser == null || userPermissions == null) {
        window.location.replace(BASE_URL+'/login');
      }
      
      var ROLE_ID = JSON.parse(loggedUser)['role_id'];
      var STORE_ID = JSON.parse(loggedUser)['role_id'];
      TOKEN = JSON.parse(loggedUser)['token'];
    </script>
    <body class="app">
      <!-- BEGIN: Mobile Menu -->
      <div class="mobile-menu md:hidden">
        @include('layouts.menu.mobile')
      </div>
      
      <div class="flex">
        @if (Request::is('sales/pos'))
          <nav class="side-nav side-nav--simple">
            <a href="#" class="intro-x flex items-center pl-5 pt-4">
                <img alt="Kalika" class="w-6" src="{{ asset('templates/midone/images/logo.svg') }}">
            </a>
        @else
          <nav class="side-nav">
            <a href="#" class="intro-x flex items-center pl-5 pt-4">
                <img alt="Kalika" class="w-6" src="{{ asset('templates/midone/images/logo.svg') }}">
                <span class="hidden xl:block text-white text-lg ml-3"> Ka<span class="font-medium">lika</span> </span>
            </a>
        @endif
            <div class="side-nav__devider my-6"></div>
            @include('layouts.menu.web')
          </nav>

        <div class="content">
          <div class="top-bar">
            <div class="-intro-x breadcrumb mr-auto hidden sm:flex"> 
              @yield('breadcrumb')
            </div>
            @include('layouts.header')
          </div>

          @yield('content')
        </div>
      </div>
      
      <script src="{{ asset('templates/midone/vendor/jquery/jquery-3.6.0.min.js') }}"></script>
      <script src="{{ asset('templates/midone/js/app.js') }}"></script>
      <script src="{{ asset('templates/midone/js/custom.js') }}"></script>
      <script src="{{ asset('templates/midone/vendor/sweetalert/sweetalert2.min.js') }}"></script>
      <script src="{{ asset('templates/midone/vendor/moment/moment.min.js') }}"></script>
      <script src="{{ asset('templates/midone/vendor/moment/moment-with-locales.min.js') }}"></script>
      {{-- <script src="{{ asset('templates/midone/vendor/datepicker/bootstrap-datepicker.min.js') }}"></script> --}}
      {{-- <script src="{{ asset('templates/midone/vendor/select2/js/select2.min.js') }}"></script> --}}
	  

      @yield('additionalFileJS')
      <script type="text/javascript">
        let getUrl = $(location).attr('href');

        buildMenu(userPermissions, getUrl);
        
        $(document).on("click",".modal-close",function() {
            let id = $(this).data('id');
            $('#'+id).modal('hide');
        });

        $(document).on("click","#logout",function() {
            localStorage.removeItem("_r");
            localStorage.removeItem("_p");
            window.location.replace(BASE_URL);
        });

        function checkCashRegister() {
          $.ajax({
            url: API_URL+"/api/cash_registers?store_id="+STORE_ID+"&status=open",
            type: 'GET',
            headers: { 'Authorization': 'Bearer '+TOKEN },
            dataType: 'JSON',
            success: function(res, textStatus, jqXHR){
              
            },
            error: function(jqXHR, textStatus, errorThrown){

            },
          }); 
        }
      </script>
      @yield('additionalScriptJS')
  </body>
</html>