<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <link href="dist/images/logo.svg" rel="shortcut icon">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Midone admin is super flexible, powerful, clean & modern responsive tailwind admin template with unlimited possibilities.">
        <meta name="keywords" content="admin template, Midone admin template, dashboard template, flat admin template, responsive admin template, web app">
        <meta name="author" content="KALIKA">
        <title>Login - Kalika</title>
        <!-- BEGIN: CSS Assets-->
        <link rel="stylesheet" href="{{ asset('templates/midone/css/app.css') }}" />
        <link rel="stylesheet" href="{{ asset('templates/midone/vendor/sweetalert/sweetalert2.min.css') }}" />
        <!-- END: CSS Assets-->
    </head>
    <!-- END: Head -->
    <script type="text/javascript">
      var API_URL = '{{ env('API_URL') }}';
      var BASE_URL = '{{ url('/') }}';
    </script>
    <body class="login">
        <div class="container sm:px-10">
            <div class="block xl:grid grid-cols-2 gap-4">
                <!-- BEGIN: Login Info -->
                <div class="hidden xl:flex flex-col min-h-screen">
                    <a href="{{ url('/') }}" class="-intro-x flex items-center pt-5">
                        {{-- <img alt="Midone Tailwind HTML Admin Template" class="w-6" src="{{asset('templates/midone/images/logo_kalika.png')}}"> --}}
                        <span class="text-white text-lg ml-3"> Kalika<span class="font-medium">Cake</span> </span>
                    </a>
                    <div class="my-auto">
                        <img alt="Midone Tailwind HTML Admin Template" class="-intro-x w-1/2 -mt-16" src="{{asset('templates/midone/images/illustration.svg')}}">
{{--                         <div class="-intro-x text-white font-medium text-4xl leading-tight mt-10">
                            A few more clicks to 
                            <br>
                            sign in to your account.
                        </div>
                        <div class="-intro-x mt-5 text-lg text-white dark:text-gray-500">Manage all your e-commerce accounts in one place</div> --}}
                    </div>
                </div>
                <!-- END: Login Info -->
                <!-- BEGIN: Login Form -->
                <form class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0" action="" method="post" id="main_form">
                    {{ csrf_field() }}
                    {{-- <div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0"> --}}
                        <div class="my-auto mx-auto xl:ml-20 bg-white xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
                            <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
                                Sign In
                            </h2>
                            <div class="intro-x mt-2 text-gray-500 xl:hidden text-center">A few more clicks to sign in to your account. Manage all your e-commerce accounts in one place</div>
                            <div class="intro-x mt-8">
                                <input type="text" class="intro-x login__input input input--lg border border-gray-300 block" placeholder="Username" name="username">
                                <input type="password" class="intro-x login__input input input--lg border border-gray-300 block mt-4" placeholder="Password" name="password">
                            </div>
                            <div class="intro-x flex text-gray-700 dark:text-gray-600 text-xs sm:text-sm mt-4">
                                <div class="flex items-center mr-auto">
                                    <input type="checkbox" class="input border mr-2" id="remember-me">
                                    <label class="cursor-pointer select-none" for="remember-me">Remember me</label>
                                </div>
                            </div>
                            <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                                <button class="button button--lg w-full xl:w-32 text-white bg-theme-1 xl:mr-3">Login</button>
                            </div>
                        </div>
                    {{-- </div> --}}
                </form>
                <!-- END: Login Form -->
            </div>

            <div class="modal" id="success-modal">
                <div class="modal__content">
                    <div class="p-5 text-center"> <i data-feather="check-circle" class="w-16 h-16 text-theme-9 mx-auto mt-3"></i>
                        <div class="text-3xl mt-5">Success!</div>
                        <div class="text-gray-600 mt-2" id="success-msg"></div>
                    </div>
                    <div class="px-5 pb-8 text-center"> <button type="button" class="button w-24 bg-theme-1 text-white" id="dismiss-success-modal">Ok</button> </div>
                </div>
            </div>

            <div class="modal" id="fail-modal">
                <div class="modal__content">
                    <div class="p-5 text-center"> <i data-feather="x-circle" class="w-16 h-16 text-theme-6 mx-auto mt-3"></i>
                        <div class="text-3xl mt-5">Failed!</div>
                        <div class="text-gray-600 mt-2" id="err-msg">You clicked the button!</div>
                    </div>
                    <div class="px-5 pb-8 text-center"> <button type="button" class="button w-24 bg-theme-1 text-white" id="dismiss-fail-modal">Ok</button> </div>
                </div>
            </div>
        </div>
        <!-- BEGIN: Dark Mode Switcher-->
        <!-- END: Dark Mode Switcher-->
        <!-- BEGIN: JS Assets-->
        <script src="{{ asset('templates/midone/js/app.js') }}"></script>
        <script src="{{ asset('templates/midone/vendor/sweetalert/sweetalert2.min.js') }}"></script>
        <!-- END: JS Assets-->
        <script type="text/javascript">
            let _r = null;

            if (typeof(Storage) !== "undefined") {
              if (localStorage.getItem('_r') != null) {
                _r = JSON.parse(localStorage.getItem('_r'))
              }
            } else {
                Swal.fire({
                  icon: 'error',
                  title: 'Gagal',
                  text: 'Sorry, your browser does not support Web Storage...'
                }).then((result) => {

                });
            }

            $(".reveal").on('click',function() {
                var $pwd = $(".pwd");
                if ($pwd.attr('type') === 'password') {
                    $pwd.attr('type', 'text');
                } else {
                    $pwd.attr('type', 'password');
                }
            });

            $( 'form#main_form' ).submit( function( e ) {
                e.preventDefault();
                var form_data   = new FormData( this );
                $.ajax({
                    type: 'post',
                    url: API_URL+'/api/login',
                    data: form_data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    beforeSend: function() {
                        
                    },
                    success: function(data) {
                        Swal.fire({
                          icon: 'success',
                          title: 'Sukses',
                          text: 'Login Sukses'
                        }).then((result) => {
                          if (result.isConfirmed) {
                            localStorage.setItem("_r", JSON.stringify(data));
                            getPermission(data.role_id, data.token);
                            window.location.replace(BASE_URL);
                          }
                        });
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        Swal.fire({
                          icon: 'error',
                          title: 'Gagal',
                          text: jqXHR.responseJSON.message
                        }).then((result) => {

                        });
                    }
                })
            });

            function getPermission(roleId, token) {
              $.ajax({
                url: API_URL+"/api/role_has_permissions?role_id="+roleId,
                type: 'GET',
                "headers": {
                  'Authorization': 'Bearer '+token
                },
                dataType: 'JSON',
                success: function(result, textStatus, jqXHR){
                    localStorage.setItem("_p", JSON.stringify(result.data));
                },
                error: function(jqXHR, textStatus, errorThrown){

                },
              });
            }
        </script>
    </body>
</html>