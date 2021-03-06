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
        <a href="{{ url('/purchase/purchase_orders/create') }}" class="button text-white bg-theme-1 shadow-md mr-2" id="add-button">Tambah {{$title}}</a>
    </div>
</div>
<div class="intro-y datatable-wrapper box p-5 mt-5">
    <table class="table table-report table-report--bordered display datatable w-full" id="main-table">
        <thead>
            <tr>
                <th>Id</th>
                <th class="border-b-2 text-center whitespace-no-wrap">No Ref.</th>
                <th class="border-b-2 text-center whitespace-no-wrap">Supplier</th>
                <th class="border-b-2 text-center whitespace-no-wrap">Status</th>
                <th class="border-b-2 text-center whitespace-no-wrap">Total</th>
                <th class="border-b-2 text-center whitespace-no-wrap">Dibuat Oleh</th>
                <th class="border-b-2 text-center whitespace-no-wrap">Dibuat Pada</th>
                <th class="border-b-2 whitespace-no-wrap">Action</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>
</div>
<div class="modal" id="main-modal">
   <div class="modal__content modal__content--xl">
   </div>
</div>
@endsection

@section('additionalFileJS')

@endsection

@section('additionalScriptJS')
<script type="text/javascript">
    drawDatatable()

    $(document).on("click", "button#edit-data",function(e) {
      e.preventDefault();
      let id = $(this).data('id')
      window.location.replace(BASE_URL+`/purchase/purchase_orders/create?edit=${id}`)
    });

    $(document).on("click", "button#receipt-data",function(e) {
      e.preventDefault();
      let id = $(this).data('id')
      window.location.replace(BASE_URL+`/purchase/purchase_orders/receipt/${id}`)
    });

    function drawDatatable() {
        $("#main-table").DataTable({
            "destroy": true,
            "pageLength": 10,
            "processing": true,
            "serverSide": true,
            "ajax":{
                "url": API_URL+"/api/purchase_order_datatables",
                "headers": { 'Authorization': 'Bearer '+TOKEN },
                "dataType": "json",
                "type": "POST",
                "data":function(d) { 
                  
                },
            },
            "columns": [
                {data: 'id', name: 'id', width: '5%', "visible": false },
                {data: 'number', name: 'number', className: 'text-center border-b'},
                {data: 'supplier_name', name: 'supplier_name', className: 'text-center border-b'},
                {data: 'status', name: 'status', className: 'text-center border-b'},
                {
					data: 'total', name: 'total', 
					className: 'text-center border-b',
					render : data => formatRupiah(data.toString(), 'Rp ')
				},
                {data: 'created_by_name', name: 'created_by_name', className: 'text-center border-b'},
                {
					data: 'created_at', name: 'created_at', 
					className: 'text-center border-b',
					render : data => moment(data || '').format('DD MMM YYYY hh:mm:ss')
				},
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
                url: API_URL+"/api/purchase_orders/"+id,
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