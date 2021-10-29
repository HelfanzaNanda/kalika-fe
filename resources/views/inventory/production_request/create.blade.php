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
		         <tbody>
		             <tr>
		                 <td class="border-b dark:border-dark-5">1</td>
		                 <td class="border-b dark:border-dark-5">Angelina</td>
		                 <td class="border-b dark:border-dark-5">Jolie</td>
		                 <td class="border-b dark:border-dark-5">@angelinajolie</td>
		                 <td class="border-b dark:border-dark-5">@angelinajolie</td>
		                 <td class="border-b dark:border-dark-5">@angelinajolie</td>
		             </tr>
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
			url: API_URL+"/api/product_locations?store_id="+storeId,
			type: 'GET',
			headers: { 'Authorization': 'Bearer '+TOKEN },
			dataType: 'JSON',
			async: false,
			success: function(res, textStatus, jqXHR){
				let html = '';
				$.each(res.data, function (index, item) {  
					html += '<tr class="item-'+index+'">'
					html += '	<td>'
					html += '		<input type="hidden" value="'+item.product_id+'" name="product_id" id="input-product_id"><label>'+item.product.name+'</label>'
					html += '	</td>'
					html += '	<td>'
					html += '		<label>'+item.product.category.name+'</label>'
					html += '	</td>'
					html += '	<td>'
					html += '		<input type="hidden" value="'+item.quantity+'" name="stock_on_book" id="input-stock_on_book"> <label id="quantity-'+index+'">'+item.quantity+'</label>'
					html += '	</td>'
					html += '	<td>'
					html += '		<input type="text" name="stock_on_physic" id="input-stock_on_physic" class="input w-full border mt-2 flex-1" value="0" data-index="'+index+'">'
					html += '	</td>'
					html += '	<td>'
					html += '		<label id="difference-'+index+'">0</label>'
					html += '	</td>'
					html += '</tr>'
				});

				$('#stock-opname-items').html(html);
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

	$(document).on('keyup', '#input-stock_on_physic', function (e) {  
		e.preventDefault()
		let id = $(this).data('index');
		let value = parseFloat($(this).val());
		let bookQuantity = parseFloat($('label#quantity-'+id).text());
		
		$('label#difference-'+id).text(diff(bookQuantity, value));
	});

	$(document).on('change', '#input-store-id', function (e) {  
		e.preventDefault()
		storeId = parseInt($(this).find(':selected').val());
		getProductLocation();
	})

    $( 'form#main-form' ).submit( function( e ) {
        e.preventDefault();
		const data = {
			"store_id": parseInt($('#input-store-id').find(':selected').val()),
			"note": "-",
			"type": "product",
			"stock_opname_details" : []
		}
		
		$('#stock-opname-items > tr').each(function (index, element) {  
			let item = {
				'product_id' : parseInt($(this).find('#input-product_id').val()),
				'stock_on_book' : parseInt($(this).find('#input-stock_on_book').val()),
				'stock_on_physic' : parseInt($(this).find('#input-stock_on_physic').val()),
			}
			data.stock_opname_details.push(item)
		})

        $.ajax({
            type: 'POST',
            url: API_URL+"/api/stock_opnames",
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
					  window.location.href = "{{ route('stock_opname.index') }}"
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