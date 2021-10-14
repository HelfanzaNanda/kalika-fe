@extends('layouts.main')

@section('title', 'Dashboard')

@section('additionalFileCSS')

@endsection

@section('content')
<div class="grid grid-cols-12 gap-6">
    <div class="col-span-12 xxl:col-span-9 grid grid-cols-12 gap-6">
        <!-- BEGIN: General Report -->
        <div class="col-span-12 mt-8">
            <div class="intro-y flex items-center h-10">
                <h2 class="text-lg font-medium truncate mr-5">
                    General Report
                </h2>
                <a href="#" class="ml-auto flex text-theme-1 dark:text-theme-10"> <i data-feather="refresh-ccw" class="w-4 h-4 mr-3"></i> Reload Data </a>
            </div>
            <div class="grid grid-cols-12 gap-6 mt-5">
                <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                    <div class="report-box zoom-in">
                        <div class="box p-5">
                            <div class="flex">
                                <i data-feather="shopping-cart" class="report-box__icon text-theme-10"></i> 
                                <div class="ml-auto">
                                    <div class="report-box__indicator bg-theme-9 tooltip cursor-pointer" title="33% Higher than last month"> 33% <i data-feather="chevron-up" class="w-4 h-4"></i> </div>
                                </div>
                            </div>
                            <div class="text-3xl font-bold leading-8 mt-6">128</div>
                            <div class="text-base text-gray-600 mt-1">Kue Terjual</div>
                        </div>
                    </div>
                </div>
                <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                    <div class="report-box zoom-in">
                        <div class="box p-5">
                            <div class="flex">
                                <i data-feather="credit-card" class="report-box__icon text-theme-11"></i> 
                                <div class="ml-auto">
                                    <div class="report-box__indicator bg-theme-6 tooltip cursor-pointer" title="2% Lower than last month"> 2% <i data-feather="chevron-down" class="w-4 h-4"></i> </div>
                                </div>
                            </div>
                            <div class="text-3xl font-bold leading-8 mt-6">10</div>
                            <div class="text-base text-gray-600 mt-1">Pesanan Kue</div>
                        </div>
                    </div>
                </div>
                <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                    <div class="report-box zoom-in">
                        <div class="box p-5">
                            <div class="flex">
                                <i data-feather="monitor" class="report-box__icon text-theme-12"></i> 
                                <div class="ml-auto">
                                    <div class="report-box__indicator bg-theme-9 tooltip cursor-pointer" title="12% Higher than last month"> 12% <i data-feather="chevron-up" class="w-4 h-4"></i> </div>
                                </div>
                            </div>
                            <div class="text-3xl font-bold leading-8 mt-6">125</div>
                            <div class="text-base text-gray-600 mt-1">Macam Kue</div>
                        </div>
                    </div>
                </div>
                <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                    <div class="report-box zoom-in">
                        <div class="box p-5">
                            <div class="flex">
                                <i data-feather="user" class="report-box__icon text-theme-9"></i> 
                                <div class="ml-auto">
                                    <div class="report-box__indicator bg-theme-9 tooltip cursor-pointer" title="22% Higher than last month"> 22% <i data-feather="chevron-up" class="w-4 h-4"></i> </div>
                                </div>
                            </div>
                            <div class="text-3xl font-bold leading-8 mt-6">257</div>
                            <div class="text-base text-gray-600 mt-1">Customer</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: General Report -->
        <!-- BEGIN: Incomes Report -->
        <div class="col-span-12 lg:col-span-6 mt-8">
            <div class="intro-y block sm:flex items-center h-10">
                <h2 class="text-lg font-medium truncate mr-5">
                    Incomes Report
                </h2>
                <div class="sm:ml-auto mt-3 sm:mt-0 relative text-gray-700 dark:text-gray-300">
                    <i data-feather="calendar" class="w-4 h-4 z-10 absolute my-auto inset-y-0 ml-3 left-0"></i> 
                    <input type="text" data-daterange="true" class="datepicker input w-full sm:w-56 box pl-10">
                </div>
            </div>
            <div class="intro-y box p-5 mt-12 sm:mt-5">
                <div class="flex flex-col xl:flex-row xl:items-center">
                    <div class="flex">
                        <div>
                            <div class="text-theme-20 dark:text-gray-300 text-lg xl:text-xl font-bold">Rp 15,000</div>
                            <div class="text-gray-600 dark:text-gray-600">This Month</div>
                        </div>
                        <div class="w-px h-12 border border-r border-dashed border-gray-300 dark:border-dark-5 mx-4 xl:mx-6"></div>
                        <div>
                            <div class="text-gray-600 dark:text-gray-600 text-lg xl:text-xl font-medium">Rp 10,000</div>
                            <div class="text-gray-600 dark:text-gray-600">Last Month</div>
                        </div>
                    </div>
                    <div class="dropdown relative xl:ml-auto mt-5 xl:mt-0">

                    </div>
                </div>
                <div class="report-chart">
                    <canvas id="report-line-chart" height="160" class="mt-6"></canvas>
                </div>
            </div>
        </div>
        <!-- END: Incomes Report -->
        <!-- BEGIN: Weekly Top Seller -->
        <div class="col-span-12 sm:col-span-6 lg:col-span-3 mt-8">
            <div class="intro-y flex items-center h-10">
                <h2 class="text-lg font-medium truncate mr-5">
                    Biaya
                </h2>
                <a href="#" class="ml-auto text-theme-1 dark:text-theme-10 truncate">See all</a> 
            </div>
            <div class="intro-y box p-5 mt-5">
                <canvas class="mt-3" id="report-pie-chart" height="280"></canvas>
                <div class="mt-8">
                    <div class="flex items-center">
                        <div class="w-2 h-2 bg-theme-11 rounded-full mr-3"></div>
                        <span class="truncate">Ongkir</span> 
                        <div class="h-px flex-1 border border-r border-dashed border-gray-300 mx-3 xl:hidden"></div>
                        <span class="font-medium xl:ml-auto">62%</span> 
                    </div>
                    <div class="flex items-center mt-4">
                        <div class="w-2 h-2 bg-theme-1 rounded-full mr-3"></div>
                        <span class="truncate">Kebersihan</span> 
                        <div class="h-px flex-1 border border-r border-dashed border-gray-300 mx-3 xl:hidden"></div>
                        <span class="font-medium xl:ml-auto">33%</span> 
                    </div>
                    <div class="flex items-center mt-4">
                        <div class="w-2 h-2 bg-theme-12 rounded-full mr-3"></div>
                        <span class="truncate">Service Motor</span> 
                        <div class="h-px flex-1 border border-r border-dashed border-gray-300 mx-3 xl:hidden"></div>
                        <span class="font-medium xl:ml-auto">10%</span> 
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Weekly Top Seller -->
        <!-- BEGIN: Incomes Report -->
        <div class="col-span-12 sm:col-span-6 lg:col-span-3 mt-8">
            <div class="intro-y flex items-center h-10">
                <h2 class="text-lg font-medium truncate mr-5">
                    Pendapatan
                </h2>
                <a href="#" class="ml-auto text-theme-1 dark:text-theme-10 truncate">See all</a> 
            </div>
            <div class="intro-y box p-5 mt-5">
                <canvas class="mt-3" id="report-donut-chart" height="280"></canvas>
                <div class="mt-8">
                    <div class="flex items-center">
                        <div class="w-2 h-2 bg-theme-11 rounded-full mr-3"></div>
                        <span class="truncate">Penjualan</span> 
                        <div class="h-px flex-1 border border-r border-dashed border-gray-300 mx-3 xl:hidden"></div>
                        <span class="font-medium xl:ml-auto">62%</span> 
                    </div>
                    <div class="flex items-center mt-4">
                        <div class="w-2 h-2 bg-theme-1 rounded-full mr-3"></div>
                        <span class="truncate">Penjualan Pesanan</span> 
                        <div class="h-px flex-1 border border-r border-dashed border-gray-300 mx-3 xl:hidden"></div>
                        <span class="font-medium xl:ml-auto">33%</span> 
                    </div>
                    <div class="flex items-center mt-4">
                        <div class="w-2 h-2 bg-theme-12 rounded-full mr-3"></div>
                        <span class="truncate">Penjualan Konsinyasi</span> 
                        <div class="h-px flex-1 border border-r border-dashed border-gray-300 mx-3 xl:hidden"></div>
                        <span class="font-medium xl:ml-auto">10%</span> 
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Incomes Report -->
    </div>
    <div class="col-span-12 xxl:col-span-3 xxl:border-l border-theme-5 -mb-10 pb-10">
        <div class="xxl:pl-6 grid grid-cols-12 gap-6">
            <!-- BEGIN: Transactions -->
            <div class="col-span-12 md:col-span-6 xl:col-span-4 xxl:col-span-12 mt-3 xxl:mt-8">
                <div class="intro-x flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">
                        Transaksi
                    </h2>
                </div>
                <div class="mt-5">
                    @for($i = 0; $i < 5; $i++)
                    <div class="intro-x">
                        <div class="box px-5 py-3 mb-3 flex items-center zoom-in">
                            <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                <img alt="Midone Tailwind HTML Admin Template" src="{{ asset('templates/midone/images/profile-12.jpg') }}">
                            </div>
                            <div class="ml-4 mr-auto">
                                <div class="font-medium">Tom Cruise</div>
                                <div class="text-gray-600 text-xs">16 March 2022</div>
                            </div>
                            <div class="text-theme-6">+Rp {{number_format(rand(10000,999999))}}</div>
                        </div>
                    </div>
                    @endfor
                    <a href="#" class="intro-x w-full block text-center rounded-md py-3 border border-dotted border-theme-15 dark:border-dark-5 text-theme-16 dark:text-gray-600">View More</a> 
                </div>
            </div>
            <!-- END: Transactions -->
        </div>
    </div>
</div>
@endsection

@section('additionalFileJS')

@endsection

@section('additionalScriptJS')
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
</script>
@endsection