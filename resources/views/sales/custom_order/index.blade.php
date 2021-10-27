@extends('layouts.main')

@section('title', $title)

@section('additionalFileCSS')

@endsection

@section('content')
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Data {{$title}}
    </h2>
    <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
        <a href="{{ route('custom.order.create') }}" class="button text-white bg-theme-1 shadow-md mr-2" id="add-button">Tambah {{$title}}</a>
    </div>
</div>
<div class="intro-y datatable-wrapper box p-5 mt-5">
    <table class="table table-report table-report--bordered display datatable w-full" id="main-table">
        <thead>
            <tr>
                <th>Id</th>
                <th class="border-b-2 text-center whitespace-no-wrap">No. Ref</th>
                <th class="border-b-2 text-center whitespace-no-wrap">Dibuat Pada</th>
                <th class="border-b-2 text-center whitespace-no-wrap">Nama Pemesan</th>
                <th class="border-b-2 text-center whitespace-no-wrap">Produk</th>
                <th class="border-b-2 text-center whitespace-no-wrap">Dipesan Untuk Tanggal</th>
                <th class="border-b-2 text-center whitespace-no-wrap">Pembayaran</th>
                <th class="border-b-2 text-center whitespace-no-wrap">Dibuat Oleh</th>
                <th class="border-b-2 whitespace-no-wrap">Aksi</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>
</div>
<div class="modal" id="print-modal">
   <div class="modal__content modal__content--lg">
        <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
            <h2 class="font-medium text-base mr-auto" id="modal-title"></h2>
        </div>
        <div class="p-5">
            <div class="preview flex flex-wrap">
                <button class="button w-full mr-2 mb-2 flex items-center justify-center bg-theme-1 text-white" id="print-nota-pengambilan">  
                    <i data-feather="printer" class="w-4 h-4 mr-2"></i> Nota Pengambilan 
                </button>

                <button class="button w-full mr-2 mb-2 flex items-center justify-center border text-gray-700 dark:border-dark-5 dark:text-gray-300" id="print-faktur">  
                    <i data-feather="printer" class="w-4 h-4 mr-2"></i> Faktur 
                </button>

                <button class="button w-full mr-2 mb-2 flex items-center justify-center bg-theme-9 text-white" id="print-tanda-terima">  
                    <i data-feather="printer" class="w-4 h-4 mr-2"></i> Tanda Terima 
                </button>

                <button class="button w-full mr-2 mb-2 flex items-center justify-center bg-theme-12 text-white" id="print-pesanan-produksi">  
                    <i data-feather="printer" class="w-4 h-4 mr-2"></i> Pesanan Produksi 
                </button>

                <button class="button w-full mr-2 mb-2 flex items-center justify-center bg-theme-6 text-white" id="print-topper">  
                    <i data-feather="printer" class="w-4 h-4 mr-2"></i> Topper / Nama / Foto 
                </button>

                <button class="button w-full mr-2 mb-2 flex items-center justify-center bg-gray-200 text-gray-600" id="print-tanda-terima-kasir">  
                    <i data-feather="printer" class="w-4 h-4 mr-2"></i> Tanda terima di kasir 
                </button> 

            </div>
        </div>
        <div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5"> 
            <button type="button" class="modal-close button w-20 border text-gray-700 dark:border-dark-5 dark:text-gray-300 mr-1" data-id="print-modal">Cancel</button> 
        </div>
   </div>
</div>
@endsection

@section('additionalFileJS')

@endsection

@section('additionalScriptJS')
<script type="text/javascript">
    currentIdPrintModal = 0;

    drawDatatable();

    $(document).on("click", "button#edit-data",function(e) {
      e.preventDefault();
      let id = $(this).data('id')
      window.location.replace(BASE_URL+`/sales/custom_orders/edit/${id}`)
    });

    $(document).on("click", "button#print-data",function(e) {
      e.preventDefault();
      let id = $(this).data('id');
      currentIdPrintModal = id;
      $('#print-modal').modal('show');
    });

    $(document).on("click", "button#print-nota-pengambilan", function(e) {
        e.preventDefault();
        window.open(BASE_URL+`/sales/custom_orders/print/nota-pengambilan/${currentIdPrintModal}`, '_blank');
    })

    $(document).on("click", "button#print-faktur", function(e) {
        e.preventDefault();
        window.open(BASE_URL+`/sales/custom_orders/print/faktur/${currentIdPrintModal}`, '_blank');
    })

    $(document).on("click", "button#print-tanda-terima", function(e) {
        e.preventDefault();
        window.open(BASE_URL+`/sales/custom_orders/print/tanda-terima/${currentIdPrintModal}`, '_blank');
    })

    $(document).on("click", "button#print-pesanan-produksi", function(e) {
        e.preventDefault();
        window.open(BASE_URL+`/sales/custom_orders/print/pesanan-produksi/${currentIdPrintModal}`, '_blank');
    })

    $(document).on("click", "button#print-topper", function(e) {
        e.preventDefault();
        window.open(BASE_URL+`/sales/custom_orders/print/topper/${currentIdPrintModal}`, '_blank');
    })

    $(document).on("click", "button#print-tanda-terima-kasir", function(e) {
        e.preventDefault();
        window.open(BASE_URL+`/sales/custom_orders/print/tanda-terima-kasir/${currentIdPrintModal}`, '_blank');
    })


    function drawDatatable() {
        $("#main-table").DataTable({
            "destroy": true,
            "pageLength": 10,
            "processing": true,
            "serverSide": true,
            "ajax":{
                "url": API_URL+"/api/custom_order_datatables",
                "headers": { 'Authorization': 'Bearer '+TOKEN },
                "dataType": "json",
                "type": "POST",
                "data":function(d) { 
                  
                },
            },
            "columns": [
                {data: 'id', name: 'id', width: '5%', "visible": false },
                {data: 'number', name: 'number', className: 'text-center border-b'},
                {
                    data: 'created_at', 
                    name: 'created_at', 
                    className: 'text-center border-b',
                    render: function ( data, type, row ) {
                        return moment(data).format('DD MMM YYYY hh:mm:ss')
                    }
                },
                {data: 'customer_name', name: 'customer_name', className: 'text-center border-b'},
                {
                    data: 'product_id', 
                    name: 'product_id', 
                    className: 'text-center border-b',
                    render: function ( data, type, row ) {
                        return row.product_name + " \n("+row.cake_character+")";
                    }
                },
                {
                    data: 'delivery_date', 
                    name: 'delivery_date', 
                    className: 'text-center border-b',
                    render: function ( data, type, row ) {
                        let deliveryDate = moment(data).format('DD MMM YYYY hh:mm');
                        return deliveryDate + " \n("+shipmentType(row.shipment_type)+")";
                    }
                },
                {
                    data: 'down_payment', 
                    name: 'down_payment', 
                    className: 'text-center border-b',
                    render: function ( data, type, row ) {
                        let total = parseFloat(row.total);
                        let downPayment = parseFloat(row.down_payment);

                        if (total > downPayment) {
                            return "Piutang "+(total - downPayment);
                        } else {
                            return "Lunas";
                        }
                    }
                },
                {data: 'created_by_name', name: 'created_by_name', className: 'text-center border-b'},
                {data: 'action', name: 'action', orderable: false, className: 'border-b w-5'}
            ],
            "order": [0, 'desc'],
            "initComplete": function(settings, json) {
                feather.replace();
            }
        });
    }

    $(document).on('click', 'button#delete-data', function( e ) {
        e.preventDefault();
        let id = $(this).data('id');

        Swal.fire({
          title: "Apakah anda yakin?",
          text: "Anda tidak bisa memulihkan data ini",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
                type: 'DELETE',
                url: API_URL+"/api/custom_orders/"+id,
                headers: {
                  'Authorization': 'Bearer '+TOKEN
                },
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                beforeSend: function() {
                    $('.loading-area').show();
                },
                success: function(res) {
                    Swal.fire(
                      'Terhapus!',
                      'Data anda telah dihapus.',
                      'success'
                    )
                    $('#main-table').DataTable().ajax.reload( function ( json ) {
                        feather.replace();
                    } );
                }
            })
          }
        })
    });
</script>
@endsection