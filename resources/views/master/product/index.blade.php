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
		<a href={{ route('product.create') }} class="button text-white bg-theme-1 shadow-md mr-2" id="add-button">Tambah {{$title}}</a>
	</div>
</div>
<div class="intro-y datatable-wrapper box p-5 mt-5">
	<table class="table table-report table-report--bordered display datatable w-full" id="main-table">
		<thead>
			<tr>
				<th>Id</th>
				<th class="border-b-2 text-center whitespace-no-wrap">Nama</th>
				<th class="border-b-2 text-center whitespace-no-wrap">Min. Stok</th>
				<th class="border-b-2 text-center whitespace-no-wrap">Min. Produksi</th>
				<th class="border-b-2 text-center whitespace-no-wrap">Divisi</th>
				<th class="border-b-2 text-center whitespace-no-wrap">Kategori</th>
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

    $(document).on("click", "button#edit-data",function(e) {
		e.preventDefault();
		let id = $(this).data('id');
	  	window.location.replace(BASE_URL+`/master/products/edit/${id}`)
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
</script>
@endsection