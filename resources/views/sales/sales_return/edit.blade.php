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
				<label>Nama </label> 
				<input type="text" readonly name="name" id="input-name" class="input w-full border mt-2 flex-1"/>
			</div>
			<div class="col-span-12 sm:col-span-6"> 
				<label>Kustomer </label> 
				<select name="customer_id" id="input-customer-id" class="single-select input w-full border mt-2 flex-1"></select>
			</div>
			<div class="col-span-12 sm:col-span-6"> 
				<label>konsiyasi </label> 
				<select name="store_consignment_id" id="input-store-consignment-id" class="single-select input w-full border mt-2 flex-1"></select>
			</div>
			
		</div>
		<div class="px-5">
			<table class="table table-report table-report--bordered display w-full" id="details-table">
				<thead>
					<tr>
						<th class="border-b-2 text-center whitespace-no-wrap">Product</th>
						<th class="border-b-2 text-center whitespace-no-wrap">Qty</th>
						<th class="border-b-2 text-center whitespace-no-wrap">Total</th>
						<th class="border-b-2 text-center whitespace-no-wrap">Aksi</th>
					</tr>
				</thead>
				<tbody></tbody>
				<tfoot>
					<tr class="font-semibold">
						<td colspan="2">Total</td>
						{{-- <td class="total-qty">6</td> --}}
						<td class="total">1000</td>
					</tr>
				</tfoot>
			</table>
		</div>
		<div class="flex px-5 justify-between mb-2">
			<button type="button" class="button btn-add-item w-20 bg-theme-1 text-white">Add Row</button> 
		</div>
		<div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5"> 
			<a href="{{ route('sales_return.index') }}" type="button" class="modal-close button w-20 border text-gray-700 dark:border-dark-5 dark:text-gray-300 mr-1" data-id="main-modal">Kembali</a> 
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
	setNameCurrentUser()
	getSalesReturn()

	function initSelect2(){
		$("#input-product-id-"+index).select2({
			placeholder: "Choose One",
			allowClear: true
		});
		$(".single-select").select2({
			placeholder: "Choose One",
			allowClear: true
		});
	}

	function setNameCurrentUser() {  
		const currentUser = localStorage.getItem('_r')
		if (currentUser !== null) {
			const user = JSON.parse(currentUser)
			$('#input-name').val(user.name)
		}
	}

	function getSalesReturn() {
        $.ajax({
            url: API_URL+"/api/sales_returns/"+id,
            type: 'GET',
            headers: { 'Authorization': 'Bearer '+TOKEN },
            dataType: 'JSON',
            success: function(res, textStatus, jqXHR){
				getCustomers(res.data.customer_id)
				getStoreConsignments(res.data.store_consignment_id)
				$('.total').html(formatRupiah(res.data.total.toString(), 'Rp '))
				res.data.sales_return_details.forEach((item, key) => {
					index = key
					$('#details-table tbody').append(setHtmlItemEdit(item))
					initSelect2()
					getProducts(item.product_id, key)
				})
					 
            },
            error: function(jqXHR, textStatus, errorThrown){

            },
        })
    }

	$(document).on('click', '.btn-add-item', function (e) {  
		e.preventDefault()
		index++
		$('#details-table tbody').append(setHtmlItem())
		initSelect2()
		getProducts()
	})

	$(document).on('click', '.btn-remove-item', function (e) {  
		e.preventDefault()
		const key = $(this).data('key')
		$('.item-'+key).remove()
	})

	function setHtmlItem() {  
		let html = ''
		html += '<tr class="item-'+index+'">'
		html += '	<td>'
		html += '		<select name="product_id[]" id="input-product-id-'+index+'" class="input w-full border mt-2 flex-1"></select>'
		html += '	</td>'
		html += '	<td>'
		html += '		<input type="number" name="qty[]" id="input-qty-'+index+'" class="qty input w-full border mt-2 flex-1"/>'
		html += '	</td>'
		html += '	<td>'
		html += '		<input type="number" name="total[]" id="input-subtotal-'+index+'" class="subtotal input w-full border mt-2 flex-1"/>'
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
		html += '		<select value="'+(item ? item.product_id : '')+'" name="product_id[]" id="input-product-id-'+index+'" class="input w-full border mt-2 flex-1"></select>'
		html += '	</td>'
		html += '	<td>'
		html += '		<input value="'+(item ? item.qty : '')+'" type="number" name="qty[]" id="input-qty-'+index+'" class="qty input w-full border mt-2 flex-1"/>'
		html += '	</td>'
		html += '	<td>'
		html += '		<input value="'+(item ? item.total : '')+'" type="number" name="total[]" id="input-subtotal-'+index+'" class="subtotal input w-full border mt-2 flex-1"/>'
		html += '	</td>'
		if (index > 0) {
			html += '	<td>'
			html += '		<button data-key="'+index+'" type="button" class="w-6 h-6 rounded flex text-white font-semibold justify-center items-center btn-remove-item bg-theme-6 text-white">'
			html += '			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x mx-auto"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>'
			html += '		</button>'
			html += '	</td>'
		}
		html += '</tr>'
		return html
	}

	$(document).on('keyup', '.qty', function (e) {  
		e.preventDefault()
		//countSubtotal()
		//countTotal()
	})

	$(document).on('keyup', '.subtotal', function (e) {  
		e.preventDefault()
		//countSubtotal()
		countTotal()
	})

	function countSubtotal() {  
		let subtotal = 0
		$('.qty').each(function (index, element) {  
			subtotal += parseInt($(this).val())
		})
		if (isNaN(subtotal)) {
			subtotal = 0
		}
		$('.subtotal').html(formatRupiah(subtotal.toString(), 'Rp '))
		countTotal()
	}

	function countTotal() {  
		let total = 0
		$('.subtotal').each(function (index, element) {  
			total += parseInt($(this).val())
		})
		if (isNaN(total)) {
			total = 0
		}
		$('.total').html(formatRupiah(total.toString(), 'Rp '))
	}

    $( 'form#main-form' ).submit( function( e ) {
        e.preventDefault();
		const data = {
			'customer_id' : parseInt($('#input-customer-id').val()),
			'store_consignment_id' : parseInt($('#input-store-consignment-id').val()),
			"sales_return_details" : []
		}
		
		$('#details-table tbody > tr').each(function (index, element) {  
			let item = {
				'product_id' : parseInt($(this).find('select').val()),
				'qty' : parseInt($(this).find('.qty').val()),
				'total' : parseInt($(this).find('.subtotal').val()),
			}
			data.sales_return_details.push(item)
		})
        $.ajax({
            type: 'PUT',
            url: API_URL+"/api/sales_returns/"+id,
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
					  window.location.href = "{{ route('sales_return.index') }}"
                  }
                });
            },
			error: function(jqXHR, textStatus, errorThrown){
				console.log(jqXHR.responseJSON);
			},
        })
    });

	function getProducts(product_id = null, key = null) {
        $.ajax({
            url: API_URL+"/api/products",
            type: 'GET',
            headers: { 'Authorization': 'Bearer '+TOKEN },
            dataType: 'JSON',
            success: function(res, textStatus, jqXHR){
                let opt = ''
                opt += '<option value=""> - Pilih Produk - </option>'
				res.data.forEach((item, index) => {
					if (product_id) {
                    	opt += '<option value="'+item.id+'" '+(product_id === item.id ? 'selected' : '')+'>'+item.name+'</option>'
					} else {
                    	opt += '<option value="'+item.id+'">'+item.name+'</option>'
					}
				})
                $('#input-product-id-'+(key != null ? key : index)).html(opt)
            },
            error: function(jqXHR, textStatus, errorThrown){

            },
        })
    }

	function getCustomers(customer_id = null) {
        $.ajax({
            url: API_URL+"/api/customers",
            type: 'GET',
            headers: { 'Authorization': 'Bearer '+TOKEN },
            dataType: 'JSON',
            success: function(res, textStatus, jqXHR){
                let opt = ''
                opt += '<option value=""> - Pilih Kustomer - </option>'
                $.each(res.data, function (index, item) {
					if (customer_id) {
						opt += '<option value="'+item.id+'" '+(customer_id == item.id ? 'selected' : '')+'>'+item.name+'</option>'
					}else{
                    	opt += '<option value="'+item.id+'">'+item.name+'</option>'
					}
                })
                $('#input-customer-id').html(opt)
            },
            error: function(jqXHR, textStatus, errorThrown){

            },
        })
    }
	
	function getStoreConsignments(store_consignment_id = null) {
        $.ajax({
            url: API_URL+"/api/store_consignments",
            type: 'GET',
            headers: { 'Authorization': 'Bearer '+TOKEN },
            dataType: 'JSON',
            success: function(res, textStatus, jqXHR){
                let opt = ''
                opt += '<option value=""> - Pilih Konsiyasi - </option>'
                $.each(res.data, function (index, item) {  
					if (store_consignment_id) {
						opt += '<option value="'+item.id+'" '+(store_consignment_id ==  item.id ? 'selected' : '')+'>'+item.store_name+'</option>'
					}else{
                    	opt += '<option value="'+item.id+'">'+item.store_name+'</option>'
					}
                })
                $('#input-store-consignment-id').html(opt)
            },
            error: function(jqXHR, textStatus, errorThrown){

            },
        })
    }
</script>
@endsection