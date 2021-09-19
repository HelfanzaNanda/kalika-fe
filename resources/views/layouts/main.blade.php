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
      
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <title>@yield('title')</title>
      <!-- plugins:css -->
      @yield('additionalFileCSS')
    </head>
    <script type="text/javascript">
      var API_URL = '{{ env('API_URL') }}';
      var BASE_URL = '{{ url('/') }}';
      
      let loggedUser = localStorage.getItem('_r');
      let userPermissions = localStorage.getItem('_p');

      if (loggedUser == null && userPermissions == null) {
        window.location.replace(BASE_URL+'/login');
      }
    </script>
    <body class="app">
      <!-- BEGIN: Mobile Menu -->
      <div class="mobile-menu md:hidden">
        @include('layouts.menu.mobile')
      </div>
      
      <div class="flex">
        {{-- <nav class="side-nav side-nav--simple"> --}}
          <nav class="side-nav">
            <a href="#" class="intro-x flex items-center pl-5 pt-4">
                <img alt="Kalika" class="w-6" src="{{ asset('templates/midone/images/logo.svg') }}">
                <span class="hidden xl:block text-white text-lg ml-3"> Ka<span class="font-medium">lika</span> </span>
            </a>
            {{-- <a href="#" class="intro-x flex items-center pl-5 pt-4">
                <img alt="Kalika" class="w-6" src="{{ asset('templates/midone/images/logo.svg') }}">
            </a> --}}
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
      
      <script src="{{ asset('templates/midone/js/app.js') }}"></script>
      <script src="{{ asset('templates/midone/js/custom.js') }}"></script>
      @yield('additionalFileJS')
      <script type="text/javascript">
        buildMenu(userPermissions);
      </script>
      @yield('additionalScriptJS')
  </body>
</html>