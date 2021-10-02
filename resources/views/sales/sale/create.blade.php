@extends('layouts.main')

@section('title', $title)

@section('additionalFileCSS')

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
			<div class="col-span-12 sm:col-span-6"> 
				<label>Number</label> 
				<input type="text" name="number" class="input w-full border mt-2 flex-1" id="input-number"> 
			</div>
			<div class="col-span-12 sm:col-span-6"> 
				<label>Toko</label> 
				<select name="store_id" id="input-store-id" class="single-select input w-full border mt-2 flex-1"></select>
			</div>
			<div class="col-span-12 sm:col-span-6"> 
				<label>Uang Kasir</label> 
				<select name="cash_register_id" id="input-cash-register-id" class="single-select input w-full border mt-2 flex-1"></select>
			</div>
			<div class="col-span-12 sm:col-span-6"> 
				<label>Kustomer</label> 
				<select name="customer_id" id="input-customer-id" class="single-select input w-full border mt-2 flex-1"></select>
			</div>
			<div class="col-span-12 sm:col-span-6"> 
				<label>Discount Percentage</label> 
				<input type="number" name="discount_percentage" class="input w-full border mt-2 flex-1" id="input-discount-percentage"> 
			</div>
			<div class="col-span-12 sm:col-span-6"> 
				<label>Discount Value</label> 
				<input type="number" name="discount_value" class="input w-full border mt-2 flex-1" id="input-discount-value"> 
			</div>
			<div class="col-span-12 sm:col-span-6"> 
				<label>Total</label> 
				<input type="number" name="total" id="input-total" class="input w-full border mt-2 flex-1"> 
			</div>
			<div class="col-span-12 sm:col-span-6"> 
				<label>Note</label> 
				<textarea name="note" id="input-note" class="input w-full border mt-2 flex-1" rows="3"></textarea>
			</div>
			<div class="col-span-12 sm:col-span-6"> 
				<label>Customer Pay</label> 
				<input type="number" name="customer_pay" id="input-customer-pay" class="input w-full border mt-2 flex-1"> 
			</div>
			<div class="col-span-12 sm:col-span-6"> 
				<label>Customer Charge</label> 
				<input type="number" name="customer_charge" id="input-customer-charge" class="input w-full border mt-2 flex-1"> 
			</div>
			
		</div>
		<div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5"> 
			<a href="{{ route('sales.index') }}" type="button" class="modal-close button w-20 border text-gray-700 dark:border-dark-5 dark:text-gray-300 mr-1" data-id="main-modal">Kembali</a> 
			<button type="submit" class="button w-20 bg-theme-1 text-white">Submit</button> 
		</div>
	</form>
</div>
@endsection

@section('additionalFileJS')

@endsection

@section('additionalScriptJS')
<script type="text/javascript">
    getStores();
	getCustomers()
	getCashRegisters()

	initSelect2()

	function initSelect2(){
		$(".single-select").select2({
			placeholder: "Choose One",
			allowClear: true
		});
	}

    function getStores() {
        $.ajax({
            url: API_URL+"/api/stores",
            type: 'GET',
            headers: { 'Authorization': 'Bearer '+TOKEN },
            dataType: 'JSON',
            success: function(res, textStatus, jqXHR){
                let opt = ''
                opt += '<option value=""> - Pilih Toko - </option>'
                $.each(res.data, function (index, item) {  
                    opt += '<option value="'+item.id+'">'+item.name+'</option>'
                })
                $('#input-store-id').html(opt)
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

    function getCashRegisters() {
        $.ajax({
            url: API_URL+"/api/cash_registers",
            type: 'GET',
            headers: { 'Authorization': 'Bearer '+TOKEN },
            dataType: 'JSON',
            success: function(res, textStatus, jqXHR){
                let opt = ''
                opt += '<option value=""> - Pilih Uang Kasir - </option>'
                $.each(res.data, function (index, item) {  
                    opt += '<option value="'+item.id+'">'+item.cash_in_hand+'</option>'
                })
                $('#input-cash-register-id').html(opt)
            },
            error: function(jqXHR, textStatus, errorThrown){

            },
        })
    }

    $( 'form#main-form' ).submit( function( e ) {
        e.preventDefault();
        var form_data  =  new FormData(this)
		let data = {}
		for (var pair of form_data.entries()) {
			const arrInt = ['discount_percentage', 'store_id', 'cash_register_id', 
			'customer_id', 'discount_value', 'total', 'customer_pay', 'customer_charge']
			if (arrInt.includes(pair[0])) {
				data[pair[0]] = parseInt(pair[1])
			} else {	
				data[pair[0]] = pair[1]
			}
		}
        console.log(data);
        $.ajax({
            type: 'POST',
            url: API_URL+"/api/sales",
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
					  window.location.href = "{{ route('sales.index') }}"
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