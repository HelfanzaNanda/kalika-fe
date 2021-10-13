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
				<th class="border-b-2 text-center whitespace-no-wrap">Min. Stok</th>
				<th class="border-b-2 text-center whitespace-no-wrap">Min. Produksi</th>
				<th class="border-b-2 text-center whitespace-no-wrap">Divisi</th>
				<th class="border-b-2 text-center whitespace-no-wrap">Kategori</th>
				<th class="border-b-2 text-center whitespace-no-wrap">Tipe Cake</th>
				<th class="border-b-2 text-center whitespace-no-wrap">Variant Cake</th>
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
				<input type="hidden" name="id" id="input-id" value="0">
				<div class="col-span-12 sm:col-span-6">
					<label>Name</label>
					<input type="text" name="name" class="input w-full border mt-2 flex-1" id="input-name">
				</div>
				<div class="col-span-12 sm:col-span-6">
					<label>Stock Minimum</label>
					<input type="number" name="stock_minimum" class="input w-full border mt-2 flex-1" id="input-stock-minimum">
				</div>
				<div class="col-span-12 sm:col-span-6">
					<label>Production Minimum</label>
					<input type="number" name="production_minimum" class="input w-full border mt-2 flex-1" id="input-production-minimum">
				</div>
				<div class="col-span-12 sm:col-span-6">
					<label>Division</label>
					<select name="division_id" id="input-division-id" class="single-select input w-full border mt-2 flex-1"></select>
				</div>
				<div class="col-span-12 sm:col-span-6">
					<label>Category</label>
					<select name="category_id" id="input-category-id" class="single-select input w-full border mt-2 flex-1"></select>
				</div>
				<div class="col-span-12 sm:col-span-6">
					<label>Cake Type</label>
					<select name="cake_type_id" id="input-cake-type-id" class="single-select input w-full border mt-2 flex-1"></select>
				</div>
				<div class="col-span-12 sm:col-span-6">
					<label>Cake Variant</label>
					<select name="cake_variant_id" id="input-cake-variant-id" class="single-select input w-full border mt-2 flex-1"></select>
				</div>
				<div class="col-span-12 sm:col-span-6"> 
                    <div class="flex items-center text-gray-700 dark:text-gray-500 mt-5">
						<input type="checkbox" name="active" id="input-active" class="input border mr-2">
						<label class="cursor-pointer select-none" for="input-active">Aktif</label>
					</div>
                </div>
				<div class="col-span-12 sm:col-span-6"> 
                    <div class="flex items-center text-gray-700 dark:text-gray-500 mt-5">
						<input type="checkbox" name="is_custom_price" id="input-is-custom-price" class="input border mr-2">
						<label class="cursor-pointer select-none" for="input-is-custom-price">Is Custom Price</label>
					</div>
                </div>
				<div class="col-span-12 sm:col-span-6"> 
                    <div class="flex items-center text-gray-700 dark:text-gray-500 mt-5">
						<input type="checkbox" name="is_custom_product" id="input-is-custom-product" class="input border mr-2">
						<label class="cursor-pointer select-none" for="input-is-custom-product">Is Custom Product</label>
					</div>
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
	initSelect2()
	function initSelect2(){
		$(".single-select").select2({
			placeholder: "Select a state",
			allowClear: true
		});
	}
    $(document).on("click","button#add-button",function() {
		resetAllInputOnForm('#main-form')
		getDivisions()
		getCategories()
		getCakeTypes()
		getCakeVariants()
        $('h2#modal-title').text('Tambah {{$title}}')
        $('#main-modal').modal('show');
    });

    $(document).on("click", "button#edit-data",function(e) {
		e.preventDefault();
		resetAllInputOnForm('#main-form')
		let id = $(this).data('id');
		getDivisions()
		getCategories()
		getCakeTypes()
		getCakeVariants()
		$.ajax({
			url: API_URL+"/api/products/"+id,
			type: 'GET',
			headers: { 'Authorization': 'Bearer '+TOKEN },
			dataType: 'JSON',
			success: function(res, textStatus, jqXHR){
			$('#input-id').val(res.data.id)
			$('#input-name').val(res.data.name)
			$('#input-stock-minimum').val(res.data.stock_minimum)
			$('#input-production-minimum').val(res.data.production_minimum)
			$('#input-division-id').val(res.data.division_id).trigger('change')
			$('#input-category-id').val(res.data.category_id).trigger('change')
			$('#input-cake-type-id').val(res.data.cake_type_id).trigger('change')
			$('#input-cake-variant-id').val(res.data.cake_variant_id).trigger('change')
			$("#input-active").prop("checked",  res.data.active ? true : false);
			$("#input-is-custom-price").prop("checked",  res.data.is_custom_price ? true : false);
			$("#input-is-custom-product").prop("checked",  res.data.is_custom_product ? true : false);
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
			const arrInt = ['id', 'stock_minimum', 'production_minimum', 
				'division_id', 'category_id', 'cake_type_id', 'cake_variant_id']
			if (arrInt.includes(pair[0])) {
				data[pair[0]] = parseInt(pair[1])
			}else{	
				data[pair[0]] = pair[1]
			}
		}
		data['active'] = $('#input-active').is(':checked') ? true : false
		data['is_custom_price'] = $('#input-is-custom-price').is(':checked') ? true : false
		data['is_custom_product'] = $('#input-is-custom-product').is(':checked') ? true : false
        $.ajax({
            type: 'POST',
            url: API_URL+"/api/products",
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
                "url": API_URL+"/api/product_datatables",
                "headers": { 'Authorization': 'Bearer '+TOKEN },
                "dataType": "json",
                "type": "POST",
                "data":function(d) { 
                  
                },
            },
            "columns": [
                {data: 'id', name: 'id', width: '5%', "visible": false },
                {data: 'name', name: 'name', className: 'text-center border-b'},
                {data: 'stock_minimum', name: 'stock_minimum', className: 'text-center border-b'},
                {data: 'production_minimum', name: 'production_minimum', className: 'text-center border-b'},
                {data: 'division_name', name: 'division_name', className: 'text-center border-b'},
                {data: 'category_name', name: 'category_name', className: 'text-center border-b'},
                {data: 'cake_type_name', name: 'cake_type_name', className: 'text-center border-b'},
                {data: 'cake_variant_name', name: 'cake_variant_name', className: 'text-center border-b'},
				{
                    data: 'active', 
                    name: 'active', 
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
                url: API_URL+"/api/products/"+id,
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


	function getDivisions() {
		$.ajax({
			url: API_URL+"/api/divisions",
			type: 'GET',
			headers: { 'Authorization': 'Bearer '+TOKEN },
			dataType: 'JSON',
			success: function(res, textStatus, jqXHR){
				let opt = ''
				$.each(res.data, function (index, item) {  
					opt += '<option value="'+item.id+'">'+item.name+'</option>'
				})
				$('#input-division-id').html(opt)
			},
			error: function(jqXHR, textStatus, errorThrown){

			},
		})
	}

	function getCategories() {
		$.ajax({
			url: API_URL+"/api/categories",
			type: 'GET',
			headers: { 'Authorization': 'Bearer '+TOKEN },
			dataType: 'JSON',
			success: function(res, textStatus, jqXHR){
				let opt = ''
				$.each(res.data, function (index, item) {  
					opt += '<option value="'+item.id+'">'+item.name+'</option>'
				})
				$('#input-category-id').html(opt)
			},
			error: function(jqXHR, textStatus, errorThrown){

			},
		})
	}

	function getCakeTypes() {
		$.ajax({
			url: API_URL+"/api/cake_types",
			type: 'GET',
			headers: { 'Authorization': 'Bearer '+TOKEN },
			dataType: 'JSON',
			success: function(res, textStatus, jqXHR){
				let opt = ''
				$.each(res.data, function (index, item) {  
					opt += '<option value="'+item.id+'">'+item.name+'</option>'
				})
				$('#input-cake-type-id').html(opt)
			},
			error: function(jqXHR, textStatus, errorThrown){

			},
		})
	}

	function getCakeVariants() {
		$.ajax({
			url: API_URL+"/api/cake_variants",
			type: 'GET',
			headers: { 'Authorization': 'Bearer '+TOKEN },
			dataType: 'JSON',
			success: function(res, textStatus, jqXHR){
				let opt = ''
				$.each(res.data, function (index, item) {  
					opt += '<option value="'+item.id+'">'+item.name+'</option>'
				})
				$('#input-cake-variant-id').html(opt)
			},
			error: function(jqXHR, textStatus, errorThrown){

			},
		})
	}
</script>
@endsection