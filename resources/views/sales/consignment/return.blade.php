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
        {{$title}} <span id="store-consignment-name"></span>
    </h2>
</div>
<div class="intro-y box mt-3">
	<form id="main-form">
		<div class="px-5">
			<table class="table table-report table-report--bordered display w-full" id="details-table">
				<thead>
					<tr>
						<th class="border-b-2 text-center whitespace-no-wrap">Produk</th>
						<th class="border-b-2 text-center whitespace-no-wrap">Qty Dipesan</th>
						<th class="border-b-2 text-center whitespace-no-wrap">Harga Per Unit</th>
						<th class="border-b-2 text-center whitespace-no-wrap">Qty Dikembalikan</th>
					</tr>
				</thead>
				<tbody id="return-items">

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
	let id = '{{$id}}';
	let storeConsignmentId = 0;
	initSelect2();
	getSalesConsignmentById(id);
	getSalesReturn();

	function initSelect2(){

	}

    function getSalesConsignmentById(consignmentId) {
        $.ajax({
            url: API_URL+"/api/sales_consignments/"+consignmentId,
            type: 'GET',
            headers: { 'Authorization': 'Bearer '+TOKEN },
            dataType: 'JSON',
            async: false,
            beforeSend: function() {

            },
            success: function(res, textStatus, jqXHR){
		        $.ajax({
		            url: API_URL+"/api/store_consignments/"+res.data.store_consignment_id,
		            type: 'GET',
		            headers: { 'Authorization': 'Bearer '+TOKEN },
		            dataType: 'JSON',
		            async: false,
		            beforeSend: function() {

		            },
		            success: function(res, textStatus, jqXHR){
		            	$('#store-consignment-name').text(res.data.store_name);

		            },
		            error: function(jqXHR, textStatus, errorThrown){

		            },
		        });
				
				storeConsignmentId = res.data.store_consignment_id;

				let html = '';
                $.each(res.data.sales_consignment_details, function (index, item) {
					html += '<tr class="item-'+index+'">'
					html += '	<td>'
					html += item.product.name;
					html += '	<input type="hidden" class="product_id" value="'+item.product_id+'">'
					html += '	</td>'
					html += '	<td>'
					html += item.qty;
					html += '	</td>'
					html += '	<td>'
					html += item.unit_price;
					html += '	<input type="hidden" class="subtotal" value="'+item.unit_price+'">'
					html += '	</td>'
					html += '	<td>'
					html += '		<input type="number" id="input-return-qty-'+item.product_id+'" name="qty[]" class="qty input w-full border mt-2 flex-1" value="0"/>'
					html += '	</td>'
					html += '</tr>'
                });

                $('#return-items').html(html);            
            },
            error: function(jqXHR, textStatus, errorThrown){

            },
        });
    }

    function getSalesReturn() {
	    $.ajax({
	        url: API_URL+"/api/sales_returns?model=SalesConsignment&model_id="+id,
	        type: 'GET',
	        headers: { 'Authorization': 'Bearer '+TOKEN },
	        dataType: 'JSON',
	        async: false,
	        beforeSend: function() {

	        },
	        success: function(res, textStatus, jqXHR){
	        	$.each(res.data[0].sales_return_details, function (index, item) {
					$('#input-return-qty-'+item.product_id).val(item.qty);
	        	});

	        },
	        error: function(jqXHR, textStatus, errorThrown){

	        },
	    });    
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
			'store_consignment_id' : storeConsignmentId,
			'model': 'SalesConsignment',
			'model_id': parseInt(id),
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
</script>
@endsection