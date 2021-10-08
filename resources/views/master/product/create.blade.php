@extends('layouts.main')

@section('title', $title)

@section('additionalFileCSS')
	<style>
		.select2.select2-container{
			width: 100% !important
		}
	</style>
@endsection

@section('content')
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Data {{$title}}
    </h2>
</div>
<div class="intro-y box mt-3">
	<form id="main-form">
		<div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
			<h2 class="font-medium text-base mr-auto" id="modal-title"></h2>
		</div>
		<div class="p-5 grid grid-cols-12 gap-4 row-gap-3">
			{{-- <input type="hidden" name="id" id="input-id" value="0"> --}}
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
				<div class="flex space-x-5">
					<div class="flex items-center text-gray-700 dark:text-gray-500 mt-5">
						<input type="checkbox" name="active" id="input-active" class="input border mr-2">
						<label class="cursor-pointer select-none" for="input-active">Aktif</label>
					</div>
					<div class="flex items-center text-gray-700 dark:text-gray-500 mt-5">
						<input type="checkbox" name="is_custom_price" id="input-is-custom-price" class="input border mr-2">
						<label class="cursor-pointer select-none" for="input-is-custom-price">Is Custom Price</label>
					</div>
					<div class="flex items-center text-gray-700 dark:text-gray-500 mt-5">
						<input type="checkbox" name="is_custom_product" id="input-is-custom-product" class="input border mr-2">
						<label class="cursor-pointer select-none" for="input-is-custom-product">Is Custom Product</label>
					</div>
				</div>
			</div>
		</div>
</div>
<div class="intro-y box mt-5">
    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200 dark:border-dark-5">
        <h2 class="font-medium text-base mr-auto">
            Tipe Harga
        </h2>
    </div>
	<div class="p-5 grid grid-cols-12 gap-4 row-gap-3">
		<table class="table table-report table-report--bordered display col-span-12 sm:col-span-6" id="details-table">
			<thead>
				<tr>
					<th class="w-1/2 border-b-2 text-center whitespace-no-wrap">Name</th>
					<th class="w-1/4 border-b-2 text-center whitespace-no-wrap">Amount</th>
				</tr>
			</thead>
			<tbody>
				<tr class="item-0">
					<td> <input type="text" name="name[]" id="input-name-0" class="name input w-full border mt-2 flex-1"/> </td>
					<td> <input type="number" name="amount[]" id="input-amount-0" class="amount input w-full border mt-2 flex-1"/> </td>
					<td>
						<button style="display: none" type="button" class="w-6 h-6 rounded flex text-white font-semibold justify-center items-center btn-remove-item bg-theme-6 text-white">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x mx-auto"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
						</button>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="flex px-5 justify-between pb-5">
		<button type="button" class="button btn-add-item w-30 bg-theme-1 text-white">Tambah Tipe Harga</button> 
	</div>
</div>
<div class="intro-y box mt-5">
    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200 dark:border-dark-5">
        <h2 class="font-medium text-base mr-auto">
            Stok
        </h2>
    </div>
	<div class="p-5 grid grid-cols-12 gap-4 row-gap-3">
		<table class="table table-report table-report--bordered display col-span-12 sm:col-span-6">
			<thead>
				<tr>
					<th class="w-1/2 border-b-2 text-center whitespace-no-wrap">Toko</th>
					<th class="w-1/4 border-b-2 text-center whitespace-no-wrap">Quantity</th>
				</tr>
			</thead>
			<tbody id="product-location-list">

			</tbody>
		</table>
	</div>
</div>

<div class="intro-y box mt-5">
		<div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5"> 
			<a href="{{ route('product.index') }}" type="button" class="modal-close button w-20 border text-gray-700 dark:border-dark-5 dark:text-gray-300 mr-1" data-id="main-modal">Kembali</a> 
			<button type="submit" class="button w-20 bg-theme-1 text-white">Submit</button> 
		</div>
	</form>
</div>
@endsection

@section('additionalFileJS')

@endsection

@section('additionalScriptJS')
<script type="text/javascript">
	let index = 0
	getDivisions();
	getCategories();
	getCakeTypes();
	getCakeVariants();
	initSelect2();
	getStores();

	function initSelect2(){
		$(".single-select").select2({
			placeholder: "Choose One"
		});
	}
    

	$(document).on('click', '.btn-add-item', function (e) {  
		e.preventDefault()
		index++
		$('#details-table tbody').append(setHtmlItem())
	})

	$(document).on('click', '.btn-remove-item', function (e) {  
		e.preventDefault()
		const key = $(this).data('key')
		$('.item-'+key).remove()
	})

    $( 'form#main-form' ).submit( function( e ) {
        e.preventDefault();
		var form_data  =  new FormData(this)
		const data = {
			"product_prices" : [],
			"product_locations": []
		}
		for (var pair of form_data.entries()) {
			const arrInt = ['id', 'stock_minimum', 'production_minimum', 
				'division_id', 'category_id', 'cake_type_id', 'cake_variant_id']
			if (arrInt.includes(pair[0])) {
				data[pair[0]] = parseInt(pair[1])
			}else{	
				data[pair[0]] = pair[1]
			}
		}
		
		$('#details-table tbody > tr').each(function (index, element) {  
			let item = {
				'name' : $(this).find('.name').val(),
				'price' : parseInt($(this).find('.amount').val()),
			}
			data.product_prices.push(item)
		});

		$('#product-location-list > tr').each(function (index, element) {
			let item = {
				'store_id' : parseInt($(this).find('.product_location_store_id').val()),
				'quantity' : parseInt($(this).find('.product_location_quantity').val()),
			}
			data.product_locations.push(item)
		});
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
                Swal.fire({
                  icon: 'success',
                  title: 'Sukses',
                  text: res.message
                }).then((result) => {
                  if (result.isConfirmed) {
					  window.location.href = "{{ route('product.index') }}"
                  }
                });
            },
			error: function(jqXHR, textStatus, errorThrown){
				console.log(jqXHR.responseJSON);
			},
        })
    });

	function setHtmlItem() {  
		let html = ''
		html += '<tr class="item-'+index+'">'
		html += '	<td>'
		html += '		<input type="text" name="name[]" id="input-name-'+index+'" class="name input w-full border mt-2 flex-1"/>'
		html += '	</td>'
		html += '	<td>'
		html += '		<input type="number" name="amount[]" id="input-amount-'+index+'" class="amount input w-full border mt-2 flex-1"/>'
		html += '	</td>'
		html += '	<td>'
		html += '		<button data-key="'+index+'" type="button" class="w-6 h-6 rounded flex text-white font-semibold justify-center items-center btn-remove-item bg-theme-6 text-white">'
		html += '			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x mx-auto"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>'
		html += '		</button>'
		html += '	</td>'
		html += '</tr>'
		return html
	}


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

	function getStores() {
		$.ajax({
			url: API_URL+"/api/stores",
			type: 'GET',
			headers: { 'Authorization': 'Bearer '+TOKEN },
			dataType: 'JSON',
			success: function(res, textStatus, jqXHR){
				let opt = ''
				$.each(res.data, function (index, item) {  
					opt += '<tr class="item-0">';
					opt += '	<td class="text-center"> <input type="hidden" name="product_location[store_id][]" class="product_location_store_id" value="'+item.id+'"/> <label>'+item.name+'</label> </td>';
					opt += '	<td> ';
					opt += '		<input type="number" name="product_location[quantity][]" id="input-amount-0" class="product_location_quantity input w-full border mt-2 flex-1" value="0"/> ';
					opt += '	</td>';
					opt += '</tr>';
				})
				$('#product-location-list').html(opt)
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