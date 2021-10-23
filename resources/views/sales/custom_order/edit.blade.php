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
<form id="main-form">
	<div class="intro-y box mt-3">
		<div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
			<h2 class="font-medium text-base mr-auto" id="modal-title">Masukkan Detail Pesanan</h2>
		</div>
		<div class="p-5 grid grid-cols-12 gap-4 row-gap-3">
			<div class="col-span-12 sm:col-span-6"> 
				<label>Toko</label> 
				<select name="store_id" id="input-store-id" class="single-select input w-full border flex-1"></select>
			</div>
			<div class="col-span-12 sm:col-span-6"> 
				<label>Produk</label> 
				<select name="product_id" id="input-product-id" class="single-select input w-full border flex-1"></select>
			</div>
			<div class="col-span-12 sm:col-span-6"> 
				<label>Penjual</label> 
				<select name="seller_id" id="input-seller-id" class="single-select input w-full border flex-1"></select>
			</div>
			<div class="col-span-12 sm:col-span-6"> 
				<label>Tipe Cake</label> 
				<select name="type_cake_id" id="input-type-cake-id" class="single-select input w-full border flex-1"></select>
			</div>
			<div class="col-span-12 sm:col-span-6"> 
				<label>Karakter/Kode</label> 
				<input type="text" name="cake_character" id="input-cake-character" class="input w-full border flex-1"> 
			</div>
			<div class="col-span-12 sm:col-span-6"> 
				<label>Bentuk Cake</label> 
				<select name="cake_shape" id="input-cake-shape" class="single-select input w-full border flex-1">
					<option value="Bulat">Bulat</option>
					<option value="Hati">Hati</option>
					<option value="Kotak">Kotak</option>
					<option value="Lain Lain">Lain Lain</option>
				</select>
			</div>
			<div class="col-span-12 sm:col-span-6"> 
				<label>Ukuran Cake</label> 
				<input type="number" name="cake_size" id="input-cake-size" class="input w-full border flex-1"> 
			</div>
			<div class="col-span-12 sm:col-span-6"> 
				<label>Variant Rasa</label> 
				<select name="variant_cake_id" id="input-variant-cake-id" class="single-select input w-full border flex-1"></select>
			</div>
			<div class="col-span-12 sm:col-span-6"> 
				<label>Waktu</label> 
				<input type="text" name="delivery_date" id="input-delivery-date" class="datepicker input w-full border flex-1" data-timepicker="true"> 
			</div>
			<div class="col-span-12 sm:col-span-6"> 
				<label>Lain - lain</label> 
				<input type="text" name="other" id="input-other" class="input w-full border flex-1"> 
			</div>
			<div class="col-span-12 sm:col-span-6"> 
				<label>Nama Pada Kue</label> 
				<input type="text" name="cake_custom_name" id="input-cake-custom-name" class="input w-full border flex-1"> 
			</div>
			<div class="col-span-12 sm:col-span-6"> 
				<label>Lilin</label> 
				<input type="text" name="candle" id="input-candle" class="input w-full border flex-1"> 
			</div>

			<div class="col-span-12 sm:col-span-6"> 
				<label>Tipe Pengiriman</label> 
				<select name="shipment_type" id="input-shipment-type" class="single-select input w-full border flex-1">
					<option value="diambil">DIAMBIL</option>
					<option value="diambil_prama">DIAMBIL PRAMA</option>
					<option value="diambil_tm">DIAMBIL TM</option>
					<option value="order_prama">ORDER PRAMA</option>
					<option value="order_tm">ORDER TM</option>
					<option value="dikirim_kalika">DIKIRIM KALIKA</option>
					<option value="ojol_cash">OJOL CASH</option>
					<option value="ojol_cod">OJOL COD</option>
				</select>
			</div>
{{-- 			<div class="col-span-12 sm:col-span-6"> 
				<label>Status</label> 
				<select name="status" id="input-status" class="single-select input w-full border flex-1">
					<option value="pending">Pending</option>
					<option value="on_process">Proses</option>
					<option value="on_delivery">Sedang Dikirim</option>
					<option value="done">Selesai</option>
				</select>
			</div> --}}
			<div class="col-span-12 sm:col-span-6"> 
				<label>Catatan Produksi</label> 
				<textarea name="production_note" id="input-production-note" class="input w-full border flex-1" rows="3"></textarea>
			</div>
		</div>
	</div>
	<div class="intro-y box mt-3">
		<div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
			<h2 class="font-medium text-base mr-auto" id="modal-title">Masukkan Detail Pemesan</h2>
		</div>
		<div class="p-5 grid grid-cols-12 gap-4 row-gap-3">
			<div class="col-span-12 sm:col-span-6"> 
				<label>Nama Pemesan</label> 
				<input type="text" name="customer_name" id="input-customer-name" class="input w-full border flex-1"> 
			</div>
			<div class="col-span-12 sm:col-span-6"> 
				<label>No. Telp. Pemesan</label> 
				<input type="text" name="customer_phone" id="input-customer-phone" class="input w-full border flex-1">
			</div>
			<div class="col-span-12 sm:col-span-6"> 
				<label>Alamat Pemesan</label> 
				<textarea name="customer_address" id="input-customer-address" class="input w-full border flex-1" rows="3"></textarea>
			</div>
			<div class="col-span-12 sm:col-span-6"> 
				<label>Deskripsi Alamat</label> 
				<textarea name="customer_address_description" id="input-customer-address-description" class="input w-full border flex-1" rows="3"></textarea>
			</div>
		</div>
	</div>
	<div class="intro-y box mt-3">
		<div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
			<h2 class="font-medium text-base mr-auto" id="modal-title">Masukkan Detail Penerima</h2>
		</div>
		<div class="p-5 grid grid-cols-12 gap-4 row-gap-3">
			<div class="col-span-12 sm:col-span-6"> 
				<label>Nama Penerima</label> 
				<input type="text" name="recipient_name" id="input-recipient-name" class="input w-full border flex-1"> 
			</div>
			<div class="col-span-12 sm:col-span-6"> 
				<label>Telp. Penerima</label> 
				<input type="text" name="recipient_phone" id="input-recipient-phone" class="input w-full border flex-1"> 
			</div>
			<div class="col-span-12 sm:col-span-6"> 
				<label>Alamat Penerima</label> 
				<textarea name="recipient_address" id="input-recipient-address" class="input w-full border flex-1" rows="3"></textarea>
			</div>
			<div class="col-span-12 sm:col-span-6"> 
				<label>Deskripsi Alamat Penerima</label> 
				<textarea name="recipient_address_detail" id="input-recipient-address-detail" class="input w-full border flex-1" rows="3"></textarea>
			</div>
		</div>
	</div>
	<div class="intro-y box mt-3">
		<div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
			<h2 class="font-medium text-base mr-auto" id="modal-title">Masukkan Detail Pembayaran</h2>
		</div>
		<div class="p-5 grid grid-cols-12 gap-4 row-gap-3">
			<div class="col-span-12 sm:col-span-6"> 
				<label>Harga</label> 
				<input type="number" name="price" id="input-price" class="input w-full border flex-1" onkeyup="calculateTotal()" onblur="calculateTotal()"> 
			</div>
			<div class="col-span-12 sm:col-span-6"> 
				<label>Harga Lain Lain</label> 
				<input type="number" name="additional_price" id="input-additional-price" class="input w-full border flex-1" onkeyup="calculateTotal()" onblur="calculateTotal()"> 
			</div>
			<div class="col-span-12 sm:col-span-6"> 
				<label>Diskon</label> 
				<input type="number" name="discount" id="input-discount" class="input w-full border flex-1" onkeyup="calculateTotal()" onblur="calculateTotal()"> 
			</div>
			<div class="col-span-12 sm:col-span-6"> 
				<label>Biaya Pengiriman</label> 
				<input type="number" name="delivery_cost" id="input-delivery-cost" class="input w-full border flex-1" onkeyup="calculateTotal()" onblur="calculateTotal()"> 
			</div>
			<div class="col-span-12 sm:col-span-6"> 
				<label>Total</label> 
				<input type="number" name="total" id="input-total" class="input w-full border flex-1 bg-gray-100 cursor-not-allowed" readonly=""> 
			</div>
			<div class="col-span-12 sm:col-span-6"> 
				<label>Metode Pembayaran</label> 
				<select name="payment_method_id" id="input-payment-method-id" class="single-select input w-full border flex-1"></select>
			</div>
			<div class="col-span-12 sm:col-span-6"> 
				<label>Uang Muka</label> 
				<input type="number" name="down_payment" id="input-down-payment" class="input w-full border flex-1"> 
			</div>
			<div class="col-span-12 sm:col-span-6"> 
				<label>Catatan Pembayaran</label> 
				<textarea name="payment_note" id="input-payment-note" class="input w-full border flex-1" rows="3"></textarea>
			</div>
		</div>
		<div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5"> 
			<a href="{{ route('custom.order.index') }}" type="button" class="modal-close button w-20 border text-gray-700 dark:border-dark-5 dark:text-gray-300 mr-1" data-id="main-modal">Kembali</a> 
			<button type="submit" class="button w-20 bg-theme-1 text-white">Submit</button> 
		</div>
	</div>
</form>
@endsection

@section('additionalFileJS')

@endsection

@section('additionalScriptJS')
<script type="text/javascript">
	initSelect2()
    getStores();
	getProducts()
	getSellers();
	getCakeVariants();
	getPaymentMethods();
	getCakeTypes();
	setTimeout(() => {
		getCustomOrder()
	}, 500);

	function initSelect2(){
		$(".single-select").select2({
			placeholder: "Silahkan Pilih"
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
    
    function getPaymentMethods() {
        $.ajax({
            url: API_URL+"/api/payment_methods",
            type: 'GET',
            headers: { 'Authorization': 'Bearer '+TOKEN },
            dataType: 'JSON',
            async: false,
            success: function(res, textStatus, jqXHR){
                let opt = ''
                opt += '<option value=""> - Pilih Metode Pembayaran - </option>'
                $.each(res.data, function (index, item) {  
                    opt += '<option value="'+item.id+'">'+item.name+'</option>'
                })
                $('#input-payment-method-id').html(opt)
            },
            error: function(jqXHR, textStatus, errorThrown){

            },
        })
    }

	function getProducts() {
        $.ajax({
            url: API_URL+"/api/products",
            type: 'GET',
            headers: { 'Authorization': 'Bearer '+TOKEN },
            dataType: 'JSON',
            success: function(res, textStatus, jqXHR){
                let opt = ''
                opt += '<option value=""> - Pilih Produk - </option>'
                $.each(res.data, function (index, item) {  
                    opt += '<option value="'+item.id+'">'+item.name+'</option>'
                })
                $('#input-product-id').html(opt)
            },
            error: function(jqXHR, textStatus, errorThrown){

            },
        })
    }


	function getCustomOrder() {  
		const id = "{{ $id }}"
		$.ajax({
            url: API_URL+"/api/custom_orders/"+id,
            type: 'GET',
            headers: { 'Authorization': 'Bearer '+TOKEN },
            dataType: 'JSON',
            success: function(res, textStatus, jqXHR){
				$('#input-store-id').val(res.data.store_id).trigger('change');
				$('#input-product-id').val(res.data.product_id).trigger('change');
				$('#input-seller-id').val(res.data.seller_id).trigger('change');
				$('#input-type-cake-id').val(res.data.type_cake_id).trigger('change');
				$('#input-cake-character').val(res.data.cake_character);
				$('#input-cake-shape').val(res.data.cake_shape).trigger('change');
				$('#input-cake-size').val(res.data.cake_size);
				$('#input-variant-cake-id').val(res.data.variant_cake_id).trigger('change');
				$('#input-delivery-date').val(moment(res.data.delivery_date).format('DD MMM YYYY hh:mm:ss'));
				$('#input-other').val(res.data.other);
				$('#input-cake-custom-name').val(res.data.cake_custom_name);
				$('#input-candle').val(res.data.candle);
				$('#input-shipment-type').val(res.data.shipment_type).trigger('change');
				$('#input-production-note').val(res.data.production_note);
				$('#input-customer-name').val(res.data.customer_name);
				$('#input-customer-phone').val(res.data.customer_phone);
				$('#input-customer-address').val(res.data.customer_address);
				$('#input-customer-address-description').val(res.data.customer_address_description);
				$('#input-recipient-name').val(res.data.recipient_name);
				$('#input-recipient-phone').val(res.data.recipient_phone);
				$('#input-recipient-address').val(res.data.recipient_address);
				$('#input-recipient-address-detail').val(res.data.recipient_address_detail);
				$('#input-price').val(res.data.price);
				$('#input-additional-price').val(res.data.additional_price);
				$('#input-discount').val(res.data.discount);
				$('#input-delivery-cost').val(res.data.delivery_cost);
				$('#input-total').val(res.data.total);
				$('#input-payment-method-id').val(res.data.payment_method_id).trigger('change');
				$('#input-down-payment').val(res.data.down_payment);
				$('#input-payment-note').val(res.data.payment_note);
            },
            error: function(jqXHR, textStatus, errorThrown){

            },
        })
	}

    $( 'form#main-form' ).submit( function( e ) {
        e.preventDefault();
        var form_data  =  new FormData(this)
		const id = "{{ $id }}"
		let data = {}
		for (var pair of form_data.entries()) {
			const arrInt = [
				'store_id',
				'product_id',
				'seller_id',
				'type_cake_id',
				'variant_cake_id',
				'price',
				'additional_price',
				'discount',
				'delivery_cost',
				'total',
				'payment_method_id',
				'down_payment'
			]
			if (arrInt.includes(pair[0])) {
				data[pair[0]] = parseInt(pair[1])
			} else {	
				data[pair[0]] = pair[1]
			}
		}
		data["delivery_date"] = moment(data["delivery_date"]).format();
        $.ajax({
            type: 'PUT',
            url: API_URL+"/api/custom_orders/"+id,
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
					  window.location.href = "{{ url('/sales/custom_orders') }}"
                  }
                });
            },
			error: function(jqXHR, textStatus, errorThrown){
				console.log(jqXHR.responseJSON);
			},
        })
    });

    function calculateTotal() {
		let price = $('#input-price').val();
		let additionalPrice = $('#input-additional-price').val();
		let discount = $('#input-discount').val();
		let deliveryCost = $('#input-delivery-cost').val();
		let downPayment = $('#input-down-payment').val();
		let calculate = 0;


		calculate = parseFloat(price) + parseFloat(additionalPrice) + parseFloat(deliveryCost) - parseFloat(discount);

		$('#input-total').val(calculate);
    }

    function getSellers() {
        $.ajax({
            url: API_URL+"/api/sellers",
            type: 'GET',
            headers: { 'Authorization': 'Bearer '+TOKEN },
            dataType: 'JSON',
            success: function(res, textStatus, jqXHR){
                let opt = ''
                opt += '<option value=""> - Pilih Penjual - </option>'
                $.each(res.data, function (index, item) {  
                    opt += '<option value="'+item.id+'">'+item.name+'</option>'
                })
                $('#input-seller-id').html(opt)
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
                opt += '<option value=""> - Pilih Variant - </option>'
                $.each(res.data, function (index, item) {  
                    opt += '<option value="'+item.id+'">'+item.name+'</option>'
                })
                $('#input-variant-cake-id').html(opt)
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
                opt += '<option value=""> - Pilih Variant - </option>'
                $.each(res.data, function (index, item) {  
                    opt += '<option value="'+item.id+'">'+item.name+'</option>'
                })
                $('#input-type-cake-id').html(opt)
            },
            error: function(jqXHR, textStatus, errorThrown){

            },
        })
    }
</script>
@endsection