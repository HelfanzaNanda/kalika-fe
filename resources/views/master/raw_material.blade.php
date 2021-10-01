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
				<th class="border-b-2 text-center whitespace-no-wrap">Name</th>
				<th class="border-b-2 text-center whitespace-no-wrap">Supplier</th>
				<th class="border-b-2 text-center whitespace-no-wrap">Price</th>
				<th class="border-b-2 text-center whitespace-no-wrap">Unit</th>
				<th class="border-b-2 text-center whitespace-no-wrap">Smallest Unit</th>
				<th class="border-b-2 text-center whitespace-no-wrap">Stock</th>
				<th class="border-b-2 text-center whitespace-no-wrap">Store</th>
				<th class="border-b-2 whitespace-no-wrap">Action</th>
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
					<label>Supplier</label>
					<select name="supplier_id" id="input-supplier-id" class="single-select input w-full border mt-2 flex-1"></select>
				</div>
				<div class="col-span-12 sm:col-span-6">
					<label>Price</label>
					<input type="number" name="price" class="input w-full border mt-2 flex-1" id="input-price">
				</div>
				<div class="col-span-12 sm:col-span-6">
					<label>Unit</label>
					<select name="unit_id" id="input-unit-id" class="single-select input w-full border mt-2 flex-1"></select>
				</div>
				<div class="col-span-12 sm:col-span-6">
					<label>Smallest Unit</label>
					<select name="smallest_unit_id" id="input-smallest-unit-id" class="single-select input w-full border mt-2 flex-1"></select>
				</div>
				<div class="col-span-12 sm:col-span-6">
					<label>Stock</label>
					<input type="number" name="stock" class="input w-full border mt-2 flex-1" id="input-stock">
				</div>
				<div class="col-span-12 sm:col-span-6">
					<label>Store</label>
					<select name="store_id" id="input-store-id" class="single-select input w-full border mt-2 flex-1"></select>
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
	drawDatatable();

    $(document).on("click","button#add-button",function() {
		resetAllInputOnForm('#main-form')
		getSuppliers();
		getUnits();
		getStores();
        $('h2#modal-title').text('Tambah {{$title}}')
        $('#main-modal').modal('show');
    });

    $(document).on("click", "button#edit-data",function(e) {
      e.preventDefault();
	  resetAllInputOnForm('#main-form')
      let id = $(this).data('id');
	  	getSuppliers()
		getUnits()
		getStores()
		$.ajax({
			url: API_URL+"/api/raw_materials/"+id,
			type: 'GET',
			headers: { 'Authorization': 'Bearer '+TOKEN },
			dataType: 'JSON',
			success: function(res, textStatus, jqXHR){
			$('#input-id').val(res.data.id);
			$('#input-name').val(res.data.name);
			$('#input-price').val(res.data.price);
			$('#input-stock').val(res.data.stock);
			$('#input-supplier-id').val(res.data.supplier_id);
			$('#input-unit-id').val(res.data.unit_id);
			$('#input-smallest-unit-id').val(res.data.smallest_unit_id);
			$('#input-store-id').val(res.data.store_id);
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
			const arrInt = ['id', 'supplier_id', 'price', 'unit_id', 
			'smallest_unit_id', 'stock', 'store_id']
			if (arrInt.includes(pair[0])) {
				data[pair[0]] = parseInt(pair[1])
			}else{	
				data[pair[0]] = pair[1]
			}
		}
        $.ajax({
            type: 'post',
            url: API_URL+"/api/raw_materials",
            headers: { 'Authorization': 'Bearer '+TOKEN },
            data: JSON.stringify(data),
			contentType: 'application/json',
			dataType: 'JSON',
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
                "url": API_URL+"/api/raw_material_datatables",
                "headers": { 'Authorization': 'Bearer '+TOKEN },
                "dataType": "json",
                "type": "POST",
                "data":function(d) { 
                  
                },
            },
            "columns": [
                {data: 'id', name: 'id', width: '5%', "visible": false },
                {data: 'name', name: 'name', className: 'text-center border-b'},
                {data: 'supplier_name', name: 'supplier_name', className: 'text-center border-b'},
                {data: 'price', name: 'price', className: 'text-center border-b'},
                {data: 'unit_name', name: 'unit_name', className: 'text-center border-b'},
                {data: 'smallest_unit_name', name: 'smallest_unit_name', className: 'text-center border-b'},
                {data: 'stock', name: 'stock', className: 'text-center border-b'},
                {data: 'store_name', name: 'store_name', className: 'text-center border-b'},
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
                url: API_URL+"/api/raw_materials/"+id,
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

	function getSuppliers() {
		$.ajax({
			url: API_URL+"/api/suppliers",
			type: 'GET',
			headers: { 'Authorization': 'Bearer '+TOKEN },
			dataType: 'JSON',
			success: function(res, textStatus, jqXHR){
				let opt = ''
				$.each(res.data, function (index, item) {  
					opt += '<option value="'+item.id+'">'+item.name+'</option>'
				})
				$('#input-supplier-id').html(opt)
			},
			error: function(jqXHR, textStatus, errorThrown){

			},
		})
	}
	function getUnits() {
		$.ajax({
			url: API_URL+"/api/units",
			type: 'GET',
			headers: { 'Authorization': 'Bearer '+TOKEN },
			dataType: 'JSON',
			success: function(res, textStatus, jqXHR){
				let opt = ''
				$.each(res.data, function (index, item) {  
					opt += '<option value="'+item.id+'">'+item.name+'</option>'
				})
				$('#input-unit-id').html(opt)
				$('#input-smallest-unit-id').html(opt)
			},
			error: function(jqXHR, textStatus, errorThrown){

			},
		})
	}

	function getStores() {
		$.ajax({
			url: API_URL+"/api/stores",
			type: 'GET',
			headers: { 'Authorization': 'Bearer '+TOKEN },
			dataType: 'JSON',
			success: function(res, textStatus, jqXHR){
				let opt = ''
				$.each(res.data, function (index, item) {  
					opt += '<option value="'+item.id+'">'+item.name+'</option>'
				})
				$('#input-store-id').html(opt)
			},
			error: function(jqXHR, textStatus, errorThrown){

			},
		})
	}
</script>
@endsection