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
		<div class="px-5">
			<table class="table table-report table-report--bordered display w-full" id="details-table">
				<thead>
					<tr>
						<th class="w-1/2 border-b-2 text-center whitespace-no-wrap">Name</th>
						<th class="w-1/4 border-b-2 text-center whitespace-no-wrap">Amount</th>
						<th class="border-b-2 text-center whitespace-no-wrap">Aksi</th>
					</tr>
				</thead>
				<tbody></tbody>
			</table>
		</div>
		<div class="flex px-5 justify-between mb-2">
			<button type="button" class="button btn-add-item w-20 bg-theme-1 text-white">Add Row</button> 
		</div>
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
	let id = "{{ $id }}"
	let index = 0
	getDivisions()
	getCategories()
	getCakeTypes()
	getCakeVariants()
	initSelect2()
	setTimeout(() => {
		getProduct()
	}, 500);

	function initSelect2(){
		$(".single-select").select2({
			placeholder: "Choose One",
			allowClear: true
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
			"product_prices" : []
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
		})
		data['active'] = $('#input-active').is(':checked') ? true : false
		data['is_custom_price'] = $('#input-is-custom-price').is(':checked') ? true : false
		data['is_custom_product'] = $('#input-is-custom-product').is(':checked') ? true : false
		console.log(data);
		//console.log(JSON.stringify(data));
		//return
        $.ajax({
            type: 'PUT',
            url: API_URL+"/api/products/"+id,
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

	function setHtmlItemEdit(item) {  
		let html = ''
		html += '<tr class="item-'+index+'">'
		html += '	<td>'
		html += '		<input type="text" value="'+(item ? item.name : '')+'" name="name[]" id="input-name-'+index+'" class="name input w-full border mt-2 flex-1"/>'
		html += '	</td>'
		html += '	<td>'
		html += '		<input type="number" value="'+(item ? item.price : '')+'" name="amount[]" id="input-amount-'+index+'" class="amount input w-full border mt-2 flex-1"/>'
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

	function getProduct() {
        $.ajax({
            url: API_URL+"/api/products/"+id,
            type: 'GET',
            headers: { 'Authorization': 'Bearer '+TOKEN },
            dataType: 'JSON',
            success: function(res, textStatus, jqXHR){
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
				res.data.product_prices.forEach((item, key) => {
					index = key
					$('#details-table tbody').append(setHtmlItemEdit(item))
				})
					 
            },
            error: function(jqXHR, textStatus, errorThrown){

            },
        })
    }
</script>
@endsection