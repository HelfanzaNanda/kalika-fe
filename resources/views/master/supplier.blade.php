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
				<th class="border-b-2 text-center whitespace-no-wrap">No. Telp.</th>
				<th class="border-b-2 text-center whitespace-no-wrap">Nama Sales</th>
				<th class="border-b-2 text-center whitespace-no-wrap">Telp. Sales</th>
				<th class="border-b-2 text-center whitespace-no-wrap">TOP</th>
				<th class="border-b-2 whitespace-no-wrap">Aksi</th>
			</tr>
		</thead>
		<tbody>

		</tbody>
	</table>
</div>
<div class="modal" id="main-modal">
	<div class="modal__content modal__content--lg">
		<form id="main-form">
			<div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
				<h2 class="font-medium text-base mr-auto" id="modal-title"></h2>
			</div>
			<div class="p-5 grid grid-cols-12 gap-4 row-gap-3">
				<input type="hidden" name="id" id="input-id" value="0">
				<div class="col-span-12">
					<label>Nama</label>
					<input type="text" name="name" class="input w-full border mt-2 flex-1" id="input-name">
				</div>
				<div class="col-span-12">
					<label>No. Telp.</label>
					<input type="text" name="phone" class="input w-full border mt-2 flex-1" id="input-phone">
				</div>
				<div class="col-span-12">
					<label>Nama Sales</label>
					<input type="text" name="sales_name" class="input w-full border mt-2 flex-1" id="input-sales-name">
				</div>
				<div class="col-span-12">
					<label>Telp. Sales</label>
					<input type="text" name="sales_phone" class="input w-full border mt-2 flex-1"
						id="input-sales-phone">
				</div>
				<div class="col-span-12">
					<label>Deskripsi</label>
					<textarea name="description" id="input-description" cols="30" rows="3"
						class="input w-full border mt-2 flex-1"></textarea>
				</div>
				<div class="col-span-12">
					<label>Term Of Payment</label>
					<input type="number" name="term_of_payment" class="input w-full border mt-2 flex-1"
						id="input-term-of-payment">
				</div>
			</div>
			<div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5">
				<button type="button"
					class="modal-close button w-20 border text-gray-700 dark:border-dark-5 dark:text-gray-300 mr-1"
					data-id="main-modal">Cancel</button>
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
        url: API_URL+"/api/suppliers/"+id,
        type: 'GET',
        headers: { 'Authorization': 'Bearer '+TOKEN },
        dataType: 'JSON',
        success: function(res, textStatus, jqXHR){
          $('#input-id').val(res.data.id)
          $('#input-name').val(res.data.name)
          $('#input-phone').val(res.data.phone)
          $('#input-sales-name').val(res.data.sales_name)
          $('#input-sales-phone').val(res.data.sales_phone)
          $('#input-description').val(res.data.description)
          $('#input-term-of-payment').val(res.data.term_of_payment)
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
			if (['id', 'term_of_payment'].includes(pair[0])) {
				data[pair[0]] = parseInt(pair[1])
			}else{	
				data[pair[0]] = pair[1]
			}
		}
        $.ajax({
            type: 'POST',
            url: API_URL+"/api/suppliers",
            headers: { 'Authorization': 'Bearer '+TOKEN },
            data: JSON.stringify(data),
			contentType: 'application/json',
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
                "url": API_URL+"/api/supplier_datatables",
                "headers": { 'Authorization': 'Bearer '+TOKEN },
                "dataType": "json",
                "type": "POST",
                "data":function(d) { 
                  
                },
            },
            "columns": [
                {data: 'id', name: 'id', width: '5%', "visible": false },
                {data: 'name', name: 'name', className: 'text-center border-b'},
                {data: 'phone', name: 'phone', className: 'text-center border-b'},
                {data: 'sales_name', name: 'sales_name', className: 'text-center border-b'},
                {data: 'sales_phone', name: 'sales_phone', className: 'text-center border-b'},
                {data: 'term_of_payment', name: 'term_of_payment', className: 'text-center border-b'},
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
                url: API_URL+"/api/suppliers/"+id,
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