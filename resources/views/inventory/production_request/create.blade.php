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
		<div class="px-5 py-3 grid grid-cols-12 gap-4 row-gap-3">
			<div class="col-span-12 sm:col-span-6">
				<label>Divisi</label>
				<select name="division_id" id="input-division-id" class="select2 input w-full border flex-1"></select>
			</div>
			<div class="col-span-12 sm:col-span-6">
				<label>Tanggal</label>
				<input name="date" id="input-date" class="datepicker input w-full border flex-1">
			</div>
		</div>
		<div class="px-5">
		     <table class="table">
		         <thead>
		             <tr class="bg-gray-700 dark:bg-dark-1 text-white">
		                 <th class="whitespace-no-wrap">#</th>
		                 <th class="whitespace-no-wrap">Nama Produk</th>
		                 <th class="whitespace-no-wrap">Kategori</th>
		                 <th class="whitespace-no-wrap">Sisa</th>
		                 <th class="whitespace-no-wrap">Prod</th>
		                 <th class="whitespace-no-wrap">Hasil</th>
		             </tr>
		         </thead>
		         <tbody id="product-items">

		         </tbody>
		     </table>
		</div>
		<div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5"> 
			<a href="{{ route('expense.index') }}" type="button" class="modal-close button w-20 border text-gray-700 dark:border-dark-5 dark:text-gray-300 mr-1" data-id="main-modal">Kembali</a> 
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
	let divisionId = 0;
	let storeId = 1;
	getDivisions();

	function setNameCurrentUser() {  
		const currentUser = localStorage.getItem('_r')
		if (currentUser !== null) {
			const user = JSON.parse(currentUser)
			$('#input-name').val(user.name)
		}
	}

	function getDivisions() {
		$.ajax({
			url: API_URL+"/api/divisions",
			type: 'GET',
			headers: { 'Authorization': 'Bearer '+TOKEN },
			dataType: 'JSON',
			success: function(res, textStatus, jqXHR){
				let opt = ''
				opt += '<option value=""> - Pilih Divisi - </option>'
				$.each(res.data, function (index, item) {  
					opt += '<option value="'+item.id+'">'+item.name+'</option>'
				})
				$('#input-division-id').html(opt)
			},
			error: function(jqXHR, textStatus, errorThrown){

			},
		})
	}

	function getProductLocation() {
		$.ajax({
			url: API_URL+"/api/product_locations?model=Product&store_id=1&categories.division_id="+divisionId,
			type: 'GET',
			headers: { 'Authorization': 'Bearer '+TOKEN },
			dataType: 'JSON',
			async: false,
			success: function(res, textStatus, jqXHR){
				let html = '';
				$.each(res.data, function (index, item) {  
		             html += '<tr>';
		             html += '    <td class="border-b dark:border-dark-5">'+(index+1)+'</td>';
		             html += '    <td class="border-b dark:border-dark-5"><input type="hidden" class="product_id" value="'+item.product_id+'">'+item.product.name+'</td>';
		             html += '    <td class="border-b dark:border-dark-5"><input type="hidden" class="category_id" value="'+item.product.category_id+'">'+item.product.category.name+'</td>';
		             html += '    <td class="border-b dark:border-dark-5" id="quantity-'+index+'"><input type="hidden" class="current_stock" value="'+item.quantity+'">'+item.quantity+'</td>';
		             html += '    <td class="border-b dark:border-dark-5"><input type="number" id="input-production-qty" class="production_qty input w-full border flex-1" data-index="'+index+'" value="0"></td>';
		             html += '    <td class="border-b dark:border-dark-5" id="difference-'+index+'">0</td>';
		             html += '</tr>';
				});

				$('#product-items').html(html);
			},
			error: function(jqXHR, textStatus, errorThrown){

			},
		})
	}

	function diff(num1, num2) {
		if (num1 > num2) {
		  return parseFloat(num1) - parseFloat(num2)
		} else {
		  return parseFloat(num2) - parseFloat(num1)
		}
	}

	$(document).on('keyup', '#input-production-qty', function (e) {  
		e.preventDefault()
		let id = $(this).data('index');
		let value = parseFloat($(this).val());
		let bookQuantity = parseFloat($('td#quantity-'+id).text());
		
		// $('td#difference-'+id).text(diff(bookQuantity, value));
		$('td#difference-'+id).text(value);
	});

	$(document).on('change', '#input-division-id', function (e) {  
		e.preventDefault()
		divisionId = parseInt($(this).find(':selected').val());
		getProductLocation();
	})

    $( 'form#main-form' ).submit( function( e ) {
        e.preventDefault();
		const data = {
			"store_id": storeId,
			"division_id": divisionId,
			"note": "-",
			"production_request_details" : []
		}
		
		$('#product-items > tr').each(function (index, element) {  
			let item = {
				'product_id': parseInt($(this).find('.product_id').val()),
				'category_id': parseInt($(this).find('.category_id').val()),
				'current_stock': parseInt($(this).find('.current_stock').val()),
				'production_qty': parseInt($(this).find('.production_qty').val()),
			}
			data.production_request_details.push(item)
		})

        $.ajax({
            type: 'POST',
            url: API_URL+"/api/production_requests",
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
					  window.location.href = "{{ url('/inventory/production_requests') }}"
                  }
                });
            },
			error: function(jqXHR, textStatus, errorThrown){
				console.log(jqXHR.responseJSON);
			},
        })
    });
</script>
@endsection