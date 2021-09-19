<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <link href="dist/images/logo.svg" rel="shortcut icon">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Midone admin is super flexible, powerful, clean & modern responsive tailwind admin template with unlimited possibilities.">
        <meta name="keywords" content="admin template, Midone admin template, dashboard template, flat admin template, responsive admin template, web app">
        <meta name="author" content="LEFT4CODE">
        <title>Pendaftaran - Sedata</title>
        <!-- BEGIN: CSS Assets-->
        <link rel="stylesheet" href="{{ asset('templates/midone/css/app.css') }}" />
        <!-- END: CSS Assets-->
    </head>
    <!-- END: Head -->
    <script type="text/javascript">
      var BASE_URL = '{{ url('/') }}'
    </script>
    <style type="text/css">
        .select2-container {
            margin-top: 4px;
        }
    </style>
    <body class="login">
        <div class="container sm:px-10">
            <div class="block xl:grid grid-cols-2 gap-4">
                <!-- BEGIN: Register Info -->
                <div class="hidden xl:flex flex-col min-h-screen">
                    <a href="{{ url('/') }}" class="-intro-x flex items-center pt-5">
                        <img alt="Midone Tailwind HTML Admin Template" class="w-6" src="{{asset('templates/midone/images/logo.svg')}}">
                        <span class="text-white text-lg ml-3"> Se<span class="font-medium">Data</span> </span>
                    </a>
                    <div class="my-auto">
                        <img alt="Midone Tailwind HTML Admin Template" class="-intro-x w-1/2 -mt-16" src="{{asset('templates/midone/images/illustration.svg')}}">
                        <div class="-intro-x text-white font-medium text-4xl leading-tight mt-10">
                            A few more clicks to 
                            <br>
                            sign up to your account.
                        </div>
                        <div class="-intro-x mt-5 text-lg text-white dark:text-gray-500">Manage all your e-commerce accounts in one place</div>
                    </div>
                </div>
                <!-- END: Register Info -->
                <!-- BEGIN: Register Form -->
                <form class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0" method="post" id="main-form-credentials">
                    {{ csrf_field() }}
                    <div class="my-auto mx-auto xl:ml-20 bg-white xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
                        <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
                            Account
                        </h2>
                        <div class="intro-x mt-2 text-gray-500 dark:text-gray-500 xl:hidden text-center">A few more clicks to sign in to your account. Manage all your e-commerce accounts in one place</div>
                        <div class="intro-x mt-8">
                                <label>Name</label>
                                <input type="text" class="intro-x login__input input input--lg border border-gray-300 block" placeholder="Name" id="input-name" name="name">
                            <div class="mt-4">
                                <label>Email</label>
                                <input type="text" class="intro-x login__input input input--lg border border-gray-300 block" placeholder="Email" id="input-email" name="email">
                            </div>
                            <div class="mt-4">
                                <label>Password</label>
                                <input type="password" class="intro-x login__input input input--lg border border-gray-300 block" placeholder="Password" id="input-password" name="password">
                            </div>
                            <div class="mt-4">
                                <label>Confirm Password</label>
                                <input type="password" class="intro-x login__input input input--lg border border-gray-300 block" placeholder="Password Confirmation" id="input-password-confirmation">
                            </div>
                            <div class="mt-4">
                                <label>Phone</label>
                                <input type="text" class="intro-x login__input input input--lg border border-gray-300 block" placeholder="081xxxx" id="input-phone" name="phone">
                            </div>
                        </div>

                        <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                            <button type="submit" class="button button--lg w-full xl:w-32 text-white bg-theme-1 xl:mr-3">Register</button>
                            {{-- <a href="{{url('/login')}}" class="button button--lg w-full xl:w-32 text-gray-700 border border-gray-300 dark:border-dark-5 dark:text-gray-300 mt-3 xl:mt-0">Sign in</a> --}}
                        </div>
                    </div>
                </form>
                <form class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0" action="" method="post" id="main-form-company" style="display: none;">
                    {{ csrf_field() }}
                    <div class="my-auto mx-auto xl:ml-20 bg-white xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
                        <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
                            Company
                        </h2>
                        <div class="intro-x mt-2 text-gray-500 dark:text-gray-500 xl:hidden text-center">A few more clicks to sign in to your account. Manage all your e-commerce accounts in one place</div>
                        <div class="intro-x mt-8">
                            <label>Company Name</label>
                            <input type="text" class="intro-x login__input input input--lg border border-gray-300 block" placeholder="Company Name" name="company_name" id="input-company-name">
                            <div class="mt-4">
                                <label>City</label>
                                <select id="input-city" class="intro-x login__input input input--lg border border-gray-300 block mt-4" style="z-index: 9999;">
                                  <option value=""> - Select City - </option>
                                </select>
                            </div>
                            <div class="mt-4">
                                <label>Business Type</label>
                                <select id="input-business-type" class="intro-x login__input input input--lg border border-gray-300 block mt-4" style="z-index: 9999;">
                                  <option value=""> - Select Business Type - </option>
                                </select>
                            </div>
                        </div>
                        <div class="intro-x flex items-center text-gray-700 dark:text-gray-600 mt-4 text-xs sm:text-sm">
                            <input type="checkbox" class="input border mr-2" id="remember-me">
                            <label class="cursor-pointer select-none" for="remember-me">I agree to Terms and Condition</label>
                            <a class="text-theme-1 dark:text-theme-10 ml-1" href="#">Privacy Policy</a>. 
                        </div>
                        <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                            <button type="submit" class="button button--lg w-full xl:w-32 text-white bg-theme-1 xl:mr-3">Register</button>
                            {{-- <a href="{{url('/login')}}" class="button button--lg w-full xl:w-32 text-gray-700 border border-gray-300 dark:border-dark-5 dark:text-gray-300 mt-3 xl:mt-0">Sign in</a> --}}
                        </div>
                    </div>
                </form>
                <!-- END: Register Form -->
            </div>
        </div>
        <!-- BEGIN: Dark Mode Switcher-->
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
        <!-- END: Dark Mode Switcher-->
        <!-- BEGIN: JS Assets-->
        <script src="{{ asset('templates/midone/js/app.js') }}"></script>
        <!-- END: JS Assets-->
        <script type="text/javascript">
            $("#dismiss-success-modal").on('click',function() {
                $('#success-modal').modal('hide');
                setTimeout(function() {
                    window.location.replace(BASE_URL);
                }, 500); 
            });

            $("#dismiss-fail-modal").on('click',function() {
                $('#fail-modal').modal('hide');
            });

            $("form#main-form-credentials").submit( function( e ) {
                e.preventDefault();
                $("form#main-form-credentials").hide();
                $("form#main-form-company").show();
            });

            $("form#main-form-company").submit( function( e ) {
                e.preventDefault();
                $.ajax({
                    type: 'post',
                    url: BASE_URL+'/registration',
                    data: {
                        _token: "{{csrf_token()}}",
                        name: $("#input-name").val(),
                        email: $("#input-email").val(),
                        password: $("#input-password").val(),
                        phone: $("#input-phone").val(),
                        company: $("#input-company-name").val(),
                        city: $("#input-city").val(),
                        business: $("#input-business-type").val(),
                    },
                    beforeSend: function() {
                        $('#fail').hide();
                    },
                    success: function(data) {
                        if(data.status == 'success'){
                            $('#success-modal').modal('show');
                            $('#success-msg').text(data.message);
                        } else {
                            $('#fail-modal').modal('show');
                            $('#err-msg').text(data.message);
                        }
                    }
                });
            });

            $("#input-city").select2({
                width: '100%',
                minimumInputLength: 2,
                minimumResultsForSearch: '',
                ajax: {
                    url: BASE_URL+'/reference/cities',
                    dataType: "json",
                    type: "GET",
                    data: function (params) {
                      var queryParameters = {
                        term: params.term,
                      }
                      return queryParameters
                    },
                    processResults: function (data) {
                      return {
                        results: $.map(data.data, function (item) {
                          return {
                            text: item.type + ' ' + item.name,
                            id: item.id
                          }
                        })
                      }
                    }
                }
            });

            $("#input-business-type").select2({
                width: '100%',
                minimumInputLength: 2,
                minimumResultsForSearch: '',
                ajax: {
                    url: BASE_URL+'/reference/business_types',
                    dataType: "json",
                    type: "GET",
                    data: function (params) {
                      var queryParameters = {
                        term: params.term,
                      }
                      return queryParameters
                    },
                    processResults: function (data) {
                      return {
                        results: $.map(data.data, function (item) {
                          return {
                            text: item.name,
                            id: item.id
                          }
                        })
                      }
                    }
                }
            });

            // $("#step-one").on('click',function() {
            //     ("form#main-form-credentials").hide();
            //     ("form#main-form-company").show();
            // });

            // $( 'form#main_form' ).submit( function( e ) {
            //     e.preventDefault();
            //     var form_data   = new FormData( this );
            //     $.ajax({
            //         type: 'post',
            //         url: BASE_URL+'/login',
            //         data: form_data,
            //         cache: false,
            //         contentType: false,
            //         processData: false,
            //         dataType: 'json',
            //         beforeSend: function() {
            //             $('#fail').hide();
            //         },
            //         success: function(data) {
            //             if(data.status == 'success'){
            //                 $('#success-modal').modal('show');
            //                 $('#success-msg').text(data.message);
            //             } else {
            //                 $('#fail-modal').modal('show');
            //                 $('#err-msg').text(data.message);
            //             }
            //         }
            //     })
            // });
        </script>
    </body>
</html>