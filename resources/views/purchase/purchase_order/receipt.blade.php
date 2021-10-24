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
<div class="intro-y box mt-5">
	<div class="p-5">
		<table>
			<tr>
				<td class="p-2">No. Ref</td>
				<td class="p-2">: <span id="reference-number">Loading...</span></td>
			</tr>
			<tr>
				<td class="p-2">Supplier</td>
				<td class="p-2">: <span id="supplier-name">Loading...</span></td>
			</tr>
			<tr>
				<td class="p-2">Status</td>
				<td class="p-2">: <span id="status">Loading...</span></td>
			</tr>
		</table>
	</div>
</div>
<div class="intro-y box mt-5">
    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200">
        <h2 class="font-medium text-base mr-auto">
            Barang Yang Diorder
        </h2>
    </div>
    <div class="p-5" id="striped-rows-table">
        <div class="preview">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="border-b-2 dark:border-dark-5 whitespace-no-wrap">#</th>
                            <th class="border-b-2 dark:border-dark-5 whitespace-no-wrap">Bahan</th>
                            <th class="border-b-2 dark:border-dark-5 whitespace-no-wrap">Total Qty Dipesan</th>
                            <th class="border-b-2 dark:border-dark-5 whitespace-no-wrap">Total Qty Diterima</th>
                        </tr>
                    </thead>
                    <tbody id="purchase-order-data">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="intro-y box mt-3">
	<form id="main-form">
	    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200">
	        <h2 class="font-medium text-base mr-auto">
	            Masukkan Penerimaan
	        </h2>
	    </div>
		<div class="px-5 py-3 grid grid-cols-12 gap-4 row-gap-3">
			<div class="col-span-12 sm:col-span-6"> 
				<label>Tanggal</label> 
				<input type="text" name="date" id="input-date" class="datepicker input w-full border mt-2 flex-1"> 
			</div>
		</div>
	    <div class="p-5" id="striped-rows-table">
	        <div class="preview">
	            <div class="overflow-x-auto">
	                <table class="table">
	                    <thead>
	                        <tr>
	                            <th class="border-b-2 dark:border-dark-5 whitespace-no-wrap">#</th>
	                            <th class="border-b-2 dark:border-dark-5 whitespace-no-wrap">Bahan</th>
	                            <th class="border-b-2 dark:border-dark-5 whitespace-no-wrap">Qty Diterima</th>
	                        </tr>
	                    </thead>
	                    <tbody id="purchase-order-receipt-data">

	                    </tbody>
	                </table>
	            </div>
	        </div>
	    </div>
		<div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5"> 
			<a href="{{ url('/purchase/purchase_orders') }}" type="button" class="modal-close button w-20 border text-gray-700 dark:border-dark-5 dark:text-gray-300 mr-1" data-id="main-modal">Kembali</a> 
			<button type="submit" class="button w-20 bg-theme-1 text-white">Submit</button> 
		</div>
	</form>
</div>
@endsection

@section('additionalFileJS')

@endsection

@section('additionalScriptJS')
<script type="text/javascript">
	let purchaseOrderId = '{{$id}}';
	getPOById(purchaseOrderId);

    function getPOById(poId) {
        $.ajax({
            url: API_URL+"/api/purchase_orders/"+poId,
            type: 'GET',
            headers: { 'Authorization': 'Bearer '+TOKEN },
            dataType: 'JSON',
            async: false,
            beforeSend: function() {

            },
            success: function(res, textStatus, jqXHR){
				$('#reference-number').text(res.data.number);
				getSupplierById(res.data.supplier_id);
				$('#status').text(res.data.status);

                let html = '';
                let htmlReceipt = '';

                $.each(res.data.purchase_order_details, function (index, item) {
                    if (index % 2 == 0) {
                        html += '<tr class="bg-gray-200 dark:bg-dark-1">';
                        htmlReceipt += '<tr class="bg-gray-200 dark:bg-dark-1">';
                    } else {
                        html += '<tr>';
                        htmlReceipt += '<tr>';
                    }
                    html += '    <td class="border-b dark:border-dark-5">'+(index+1)+'</td>';
                    html += '    <td class="border-b dark:border-dark-5">'+item.raw_material.name+'</td>';
                    html += '    <td class="border-b dark:border-dark-5">'+item.qty+'</td>';
                    html += '    <td class="border-b dark:border-dark-5">'+item.delivered_qty+'</td>';
                    html += '</tr>';

                    htmlReceipt += '    <td class="border-b dark:border-dark-5">'+(index+1)+'</td>';
                    htmlReceipt += '    <td class="border-b dark:border-dark-5"><input type="hidden" name="raw_material_id[]" class="raw_material_id" value="'+item.raw_material.id+'" />'+item.raw_material.name+'</td>';
                    htmlReceipt += '    <td class="border-b dark:border-dark-5"><input type="text" name="delivered_qty[]" id="input-delivered-qty" class="delivered_qty input w-full border mt-2 flex-1" value="0" /></td>';
                    htmlReceipt += '</tr>';
                });

                $('#purchase-order-data').html(html)
                $('#purchase-order-receipt-data').html(htmlReceipt)
            },
            error: function(jqXHR, textStatus, errorThrown){

            },
        });
    }

    function getSupplierById(supplierId) {
        $.ajax({
            url: API_URL+"/api/suppliers/"+supplierId,
            type: 'GET',
            headers: { 'Authorization': 'Bearer '+TOKEN },
            dataType: 'JSON',
            async: false,
            beforeSend: function() {

            },
            success: function(res, textStatus, jqXHR){
				$('#supplier-name').text(res.data.name);
            },
            error: function(jqXHR, textStatus, errorThrown){

            },
        });
    }

    $( 'form#main-form' ).submit( function( e ) {
        e.preventDefault();

		const data = {
			"date" : $('#input-date').val(),
			"purchase_order_id": parseInt(purchaseOrderId),
			"purchase_order_delivery_details" : []
		}
		
		$('#purchase-order-receipt-data > tr').each(function (index, element) {  
			let item = {
				'raw_material_id': parseInt($(this).find('.raw_material_id').val()),
				'delivered_qty': parseInt($(this).find('.delivered_qty').val())
			}
			data.purchase_order_delivery_details.push(item)
		})
		
		data["date"] = moment(data["date"]).format();

        $.ajax({
            type: 'POST',
            url: API_URL+"/api/purchase_order_deliveries",
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
					  getPOById(purchaseOrderId);
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