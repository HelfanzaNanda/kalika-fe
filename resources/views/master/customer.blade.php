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
        <button class="button text-white bg-theme-1 shadow-md mr-2" id="add-button">Tambah {{$title}}</button>
    </div>
</div>
<div class="intro-y datatable-wrapper box p-5 mt-5">
    <table class="table table-report table-report--bordered display datatable w-full" id="main-table">
        <thead>
            <tr>
                <th>Id</th>
                <th class="border-b-2 text-center whitespace-no-wrap">Nama</th>
                <th class="border-b-2 text-center whitespace-no-wrap">Alamat</th>
                <th class="border-b-2 text-center whitespace-no-wrap">No. HP</th>
                <th class="border-b-2 text-center whitespace-no-wrap">Last Order</th>
                <th class="border-b-2 text-center whitespace-no-wrap">Status</th>
                <th class="border-b-2 whitespace-no-wrap">Aksi</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>
</div>
<div class="modal" id="main-modal">
   <div class="modal__content modal__content--xl">
        <form id="main-form">
            <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto" id="modal-title"></h2>
            </div>
            <div class="p-5 grid grid-cols-12 gap-4 row-gap-3">
                <input type="hidden" name="id" id="input-id"> 
                <div class="col-span-12 sm:col-span-6"> 
                    <label>Nama</label> 
                    <input type="text" name="name" class="input w-full border mt-2 flex-1" id="input-name"> 
                </div>
				<div class="col-span-12 sm:col-span-6"> 
                    <label>No. Hp</label> 
                    <input type="number" name="phone" class="input w-full border mt-2 flex-1" id="input-phone"> 
                </div>
				<div class="col-span-12 sm:col-span-6"> 
                    <label>Alamat</label>
					<textarea name="address" class="input w-full border mt-2 flex-1" id="input-address"></textarea>
                </div>
            </div>
            <div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5"> 
                <button type="button" class="modal-close button w-20 border text-gray-700 dark:border-dark-5 dark:text-gray-300 mr-1" data-id="main-modal">Cancel</button> 
                <button type="submit" class="button w-20 bg-theme-1 text-white">Submit</button> 
            </div>
        </form>
   </div>
</div>
@endsection

@section('additionalFileJS')

@endsection

@section('additionalScriptJS')
<script type="text/javascript">
    drawDatatable();

    $(document).on("click","button#add-button",function() {
		resetAllInputOnForm('#main-form')
        $('h2#modal-title').text('Tambah {{$title}}')
        $('#main-modal').modal('show');
    });

    $(document).on("click", "button#edit-data",function(e) {
      e.preventDefault();
	  resetAllInputOnForm('#main-form')
      let id = $(this).data('id');
      $.ajax({
        url: API_URL+"/api/customers/"+id,
        type: 'GET',
        headers: {
          'Authorization': 'Bearer '+TOKEN
        },
        dataType: 'JSON',
        success: function(res, textStatus, jqXHR){
          $('#input-id').val(res.data.id);
          $('#input-name').val(res.data.name);
          $('#input-address').val(res.data.address);
          $('#input-phone').val(res.data.phone);
          $('#modal-title').text('Edit {{$title}}');
          $('#main-modal').modal('show');
        },
        error: function(jqXHR, textStatus, errorThrown){

        },
      });
    });

    $( 'form#main-form' ).submit( function( e ) {
        e.preventDefault();
        var form_data   = new FormData( this );
        $.ajax({
            type: 'post',
            url: API_URL+"/api/customers",
            headers: {
              'Authorization': 'Bearer '+TOKEN
            },
            data: form_data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            beforeSend: function() {
                $('.loading-area').show();
            },
            success: function(res) {
                Swal.fire({
                  icon: 'success',
                  title: 'Sukses',
                  text: res.message
                }).then((result) => {
                  if (result.isConfirmed) {
                    $('#main-modal').modal('hide');
                    $('#main-table').DataTable().ajax.reload( function ( json ) {
                        feather.replace();
                    });
                  }
                });
            }
        })
    });

    function drawDatatable() {
        $("#main-table").DataTable({
            "destroy": true,
            "pageLength": 10,
            "processing": true,
            "serverSide": true,
            "ajax":{
                "url": API_URL+"/api/customer_datatables",
                "headers": { 'Authorization': 'Bearer '+TOKEN },
                "dataType": "json",
                "type": "POST",
                "data":function(d) { 
                  
                },
            },
            "columns": [
                {data: 'id', name: 'id', width: '5%', "visible": false },
                {data: 'name', name: 'name', className: 'text-center border-b'},
                {data: 'address', name: 'address', className: 'text-center border-b'},
                {data: 'phone', name: 'phone', className: 'text-center border-b'},
                {
					data: 'last_order', 
					name: 'last_order', 
					className: 'text-center border-b',
					render: data => moment(data || '').format('DD MMMM YYYY')
				},
                {
                    data: 'status', 
                    name: 'status', 
                    className: 'text-center border-b',
                    render: function ( data, type, row ) {
                        if (data) {
                            return '<div class="flex items-center sm:justify-center text-theme-9">Aktif</div>';
                        } else {
                            return '<div class="flex items-center sm:justify-center text-theme-6">Tidak Aktif</div>';
                        }
                    }
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
                url: API_URL+"/api/customers/"+id,
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