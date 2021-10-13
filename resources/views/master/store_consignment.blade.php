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
                <th class="border-b-2 text-center whitespace-no-wrap">Nama Toko</th>
                <th class="border-b-2 text-center whitespace-no-wrap">No. Telp. Toko</th>
                <th class="border-b-2 text-center whitespace-no-wrap">Nama PIC</th>
                <th class="border-b-2 text-center whitespace-no-wrap">No. Telp. PIC</th>
                <th class="border-b-2 text-center whitespace-no-wrap">Diskon</th>
                <th class="border-b-2 text-center whitespace-no-wrap">TOP</th>
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
                <input type="hidden" name="id" id="input-id" value="0"> 
                <div class="col-span-12 sm:col-span-6"> 
                    <label>Nama Toko</label> 
					<input type="text" name="store_name" class="input w-full border mt-2 flex-1" id="input-store-name"> 
                </div>
                <div class="col-span-12 sm:col-span-6"> 
                    <label>No. Telp. Toko</label> 
					<input type="text" name="store_phone" class="input w-full border mt-2 flex-1" id="input-store-phone"> 
                </div>
                <div class="col-span-12 sm:col-span-6"> 
                    <label>Nama PIC</label> 
					<input type="text" name="pic_name" class="input w-full border mt-2 flex-1" id="input-pic-name"> 
                </div>
                <div class="col-span-12 sm:col-span-6"> 
                    <label>No. Telp. PIC</label> 
					<input type="text" name="pic_phone" class="input w-full border mt-2 flex-1" id="input-pic-phone"> 
                </div>
                <div class="col-span-12 sm:col-span-6"> 
                    <label>Diskon</label> 
                    <input type="number" name="discount" class="input w-full border mt-2 flex-1" id="input-discount"> 
                </div>
                <div class="col-span-12 sm:col-span-6"> 
                    <label>Diskon</label> 
                    <input type="number" name="day_of_rules" class="input w-full border mt-2 flex-1" id="input-day-of-rules"> 
                </div>
                <div class="col-span-12 sm:col-span-6"> 
                    <label>TOP</label> 
                    <textarea name="description" id="input-description" cols="30" rows="3" class="input w-full border mt-2 flex-1"></textarea>
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
    drawDatatable()

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
        url: API_URL+"/api/store_consignments/"+id,
        type: 'GET',
        headers: { 'Authorization': 'Bearer '+TOKEN },
        dataType: 'JSON',
        success: function(res, textStatus, jqXHR){
          $('#input-id').val(res.data.id);
          $('#input-store-name').val(res.data.store_name)
          $('#input-store-phone').val(res.data.store_phone)
          $('#input-pic-name').val(res.data.pic_name)
          $('#input-pic-phone').val(res.data.pic_phone)
          $('#input-discount').val(res.data.discount)
          $('#input-day-of-rules').val(res.data.day_of_rules)
          $('#input-location').val(res.data.location)
          $('#input-description').val(res.data.description)
          $('#modal-title').text('Edit {{$title}}');
          $('#main-modal').modal('show');
        },
        error: function(jqXHR, textStatus, errorThrown){

        },
      });
    });

    $( 'form#main-form' ).submit( function( e ) {
        e.preventDefault();
        var form_data  =  new FormData(this)
		let data = {}
		for (var pair of form_data.entries()) {
			if (['id', 'discount', 'day_of_rules'].includes(pair[0])) {
				data[pair[0]] = parseInt(pair[1])
			}else{	
				data[pair[0]] = pair[1]
			}
		}
        $.ajax({
            type: 'POST',
            url: API_URL+"/api/store_consignments",
            headers: { 'Authorization': 'Bearer '+TOKEN },
            data: JSON.stringify(data),
            // cache: false,
			contentType: 'application/json',
            // processData: false,
			dataType: 'JSON',
            beforeSend: function() {
                $('.loading-area').show();
            },
            success: function(res) {
				console.log(res);
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
            },
			error: function(jqXHR, textStatus, errorThrown){
				console.log(jqXHR.responseJSON);
			},
        })
    });

    function drawDatatable() {
        $("#main-table").DataTable({
            "destroy": true,
            "pageLength": 10,
            "processing": true,
            "serverSide": true,
            "ajax":{
                "url": API_URL+"/api/store_consignment_datatables",
                "headers": { 'Authorization': 'Bearer '+TOKEN },
                "dataType": "json",
                "type": "POST",
                "data":function(d) { 
                  
                },
            },
            "columns": [
                {data: 'id', name: 'id', width: '5%', "visible": false },
                {data: 'store_name', name: 'store_name', className: 'text-center border-b'},
                {data: 'store_phone', name: 'store_phone', className: 'text-center border-b'},
                {data: 'pic_name', name: 'pic_name', className: 'text-center border-b'},
                {data: 'pic_phone', name: 'pic_phone', className: 'text-center border-b'},
                {data: 'discount', name: 'discount', className: 'text-center border-b'},
                {data: 'day_of_rules', name: 'day_of_rules', className: 'text-center border-b'},	
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
                url: API_URL+"/api/store_consignments/"+id,
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