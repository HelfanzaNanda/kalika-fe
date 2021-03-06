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
				<label>Kustomer </label> 
				<select name="customer_id" id="input-customer-id" class="single-select input w-full border mt-2 flex-1"></select>
			</div>
			<div class="col-span-12 sm:col-span-6"> 
				<label>Toko Konsinyasi </label> 
				<select name="store_consignment_id" id="input-store-consignment-id" class="single-select input w-full border mt-2 flex-1"></select>
			</div>
		</div>
		<div class="px-5">
			<table class="table table-report table-report--bordered display w-full" id="details-table">
				<thead>
					<tr>
						<th class="border-b-2 text-center whitespace-no-wrap">Produk</th>
						<th class="border-b-2 text-center whitespace-no-wrap">Qty</th>
						<th class="border-b-2 text-center whitespace-no-wrap">Total</th>
						<th class="border-b-2 text-center whitespace-no-wrap">Aksi</th>
					</tr>
				</thead>
				<tbody>
					<tr class="item-0">
						<td>
							<select name="product_id[]" id="input-product-id-0" class="product_id input w-full border mt-2 flex-1" data-row-id="0"></select>
						</td>
						<td>
							<input type="number" name="qty[]" id="input-qty-0" class="qty input w-full border mt-2 flex-1"/>
						</td>
						<td>
							<select name="total[]" id="input-subtotal-0" class="subtotal input w-full border mt-2 flex-1"></select>
						</td>
						<td>
							<button style="display: none" type="button" class="w-6 h-6 rounded flex text-white font-semibold justify-center items-center btn-remove-item bg-theme-6 text-white">
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x mx-auto"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
							</button>
						</td>
					</tr>
				</tbody>
				<tfoot>
					<tr class="font-semibold">
						{{-- <td colspan="2">Total</td> --}}
						{{-- <td class="total-qty">6</td> --}}
						{{-- <td class="total">0</td> --}}
					</tr>
				</tfoot>
			</table>
		</div>
		<div class="flex px-5 justify-between mb-2">
			<button type="button" class="button btn-add-item w-30 bg-theme-1 text-white">Tambah Item Retur</button>
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
	let index = 0
	getCustomers()
	getStoreConsignments()
	setNameCurrentUser()
    getProducts()
	initSelect2()

	function initSelect2(){
		$("#input-product-id-"+index).select2({
			placeholder: "Silahkan Pilih"
		});
		$(".single-select").select2({
			placeholder: "Silahkan Pilih"
		});
		$(".subtotal").select2({
			placeholder: "Silahkan Pilih"
		});
	}

	function setNameCurrentUser() {  
		const currentUser = localStorage.getItem('_r')
		if (currentUser !== null) {
			const user = JSON.parse(currentUser)
			$('#input-name').val(user.name)
		}
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
		html += '		<select name="product_id[]" id="input-product-id-'+index+'" class="product_id input w-full border mt-2 flex-1" data-row-id="'+index+'"></select>'
		html += '	</td>'
		html += '	<td>'
		html += '		<input type="number" name="qty[]" id="input-qty-'+index+'" class="qty input w-full border mt-2 flex-1"/>'
		html += '	</td>'
		html += '	<td>'
		html += '		<select name="total[]" id="input-subtotal-'+index+'" class="subtotal input w-full border mt-2 flex-1"></select>'
		html += '	</td>'
		html += '	<td>'
		html += '		<button data-key="'+index+'" type="button" class="w-6 h-6 rounded flex text-white font-semibold justify-center items-center btn-remove-item bg-theme-6 text-white">'
		html += '			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x mx-auto"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>'
		html += '		</button>'
		html += '	</td>'
		html += '</tr>'

		return html
	}

	$(document).on('keyup', '.qty', function (e) {  
		e.preventDefault();
		countTotal();
	})
	$(document).on('keyup', '.subtotal', function (e) {  
		e.preventDefault();
		countTotal();
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
				'product_id' : parseInt($(this).find('.product_id').val()),
				'qty' : parseInt($(this).find('.qty').val()),
				'unit_price' : parseInt($(this).find('.subtotal').val()),
			}
			data.sales_return_details.push(item)
		})

        $.ajax({
            type: 'POST',
            url: API_URL+"/api/sales_returns",
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


	
    function getProducts() {
        $.ajax({
            url: API_URL+"/api/products",
            type: 'GET',
            headers: { 'Authorization': 'Bearer '+TOKEN },
            dataType: 'JSON',
            success: function(res, textStatus, jqXHR){
                let opt = ''
                opt += '<option value=""> - Pilih Product - </option>'
                $.each(res.data, function (index, item) {  
                    opt += '<option value="'+item.id+'">'+item.name+'</option>'
                })
                $('#input-product-id-'+index).html(opt)
            },
            error: function(jqXHR, textStatus, errorThrown){

            },
        })
    }
    
	function getCustomers() {
        $.ajax({
            url: API_URL+"/api/customers",
            type: 'GET',
            headers: { 'Authorization': 'Bearer '+TOKEN },
            dataType: 'JSON',
            success: function(res, textStatus, jqXHR){
                let opt = ''
                opt += '<option value=""> - Pilih Kustomer - </option>'
                $.each(res.data, function (index, item) {  
                    opt += '<option value="'+item.id+'">'+item.name+'</option>'
                })
                $('#input-customer-id').html(opt)
            },
            error: function(jqXHR, textStatus, errorThrown){

            },
        })
    }
	
	function getStoreConsignments() {
        $.ajax({
            url: API_URL+"/api/store_consignments",
            type: 'GET',
            headers: { 'Authorization': 'Bearer '+TOKEN },
            dataType: 'JSON',
            success: function(res, textStatus, jqXHR){
                let opt = ''
                opt += '<option value=""> - Pilih Konsiyasi - </option>'
                $.each(res.data, function (index, item) {  
                    opt += '<option value="'+item.id+'">'+item.store_name+'</option>'
                })
                $('#input-store-consignment-id').html(opt)
            },
            error: function(jqXHR, textStatus, errorThrown){

            },
        });
    }

    $(document).on('change', 'select[id^="input-product-id-"]', function() {
      	let rowId = $(this).data('row-id');
      	let val = $(this).find(':selected').val();

      	console.log(rowId);

	    $.ajax({
	        url: API_URL+"/api/product_prices?product_id="+val,
	        type: 'GET',
	        headers: { 'Authorization': 'Bearer '+TOKEN },
	        dataType: 'JSON',
	        success: function(res, textStatus, jqXHR){
	            let opt = ''
	            opt += '<option value=""> - Pilih Harga - </option>'
	            $.each(res.data, function (index, item) {  
	                opt += '<option value="'+item.price+'">'+item.name+' ('+item.price+')</option>'
	            })
	            $('#input-subtotal-'+rowId).html(opt)
	        },
	        error: function(jqXHR, textStatus, errorThrown){

	        },
	    });
    });

    $(document).on('change', 'select[id^="input-subtotal-"]', function() {
		countTotal();
    });
</script>
@endsection