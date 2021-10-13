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
				<label>Toko</label> 
				<select name="store_id" id="input-store-id" class="single-select input w-full border mt-2 flex-1"></select>
			</div>
			<div class="col-span-12 sm:col-span-6"> 
				<label>Produk</label> 
				<select name="product_id" id="input-product-id" class="single-select input w-full border mt-2 flex-1"></select>
			</div>
			<div class="col-span-12 sm:col-span-6"> 
				<label>Karakter Cake</label> 
				<input type="text" name="cake_character" id="input-cake-character" class="input w-full border mt-2 flex-1"> 
			</div>
			<div class="col-span-12 sm:col-span-6"> 
				<label>Bentuk Cake</label> 
				<input type="text" name="cake_shape" id="input-cake-shape" class="input w-full border mt-2 flex-1"> 
			</div>
			<div class="col-span-12 sm:col-span-6"> 
				<label>Ukuran Cake</label> 
				<input type="number" name="cake_size" id="input-cake-size" class="input w-full border mt-2 flex-1"> 
			</div>
			<div class="col-span-12 sm:col-span-6"> 
				<label>Delivery Date</label> 
				<input type="text" name="delivery_date" id="input-delivery-date" class="datepicker input w-full border mt-2 flex-1"> 
			</div>

			<div class="col-span-12 sm:col-span-6"> 
				<label>Harga</label> 
				<input type="number" name="price" id="input-price" class="input w-full border mt-2 flex-1"> 
			</div>
			<div class="col-span-12 sm:col-span-6"> 
				<label>Tambahan Harga</label> 
				<input type="number" name="additional_price" id="input-additional-price" class="input w-full border mt-2 flex-1"> 
			</div>
			<div class="col-span-12 sm:col-span-6"> 
				<label>Other</label> 
				<textarea name="other" id="input-other" class="input w-full border mt-2 flex-1" rows="3"></textarea>
			</div>
			<div class="col-span-12 sm:col-span-6"> 
				<label>Nama Custom Cake</label> 
				<input type="text" name="cake_custom_name" id="input-cake-custom-name" class="input w-full border mt-2 flex-1"> 
			</div>
			<div class="col-span-12 sm:col-span-6"> 
				<label>Lilin</label> 
				<input type="text" name="candle" id="input-candle" class="input w-full border mt-2 flex-1"> 
			</div>
			<div class="col-span-12 sm:col-span-6"> 
				<label>Diskon</label> 
				<input type="number" name="discount" id="input-discount" class="input w-full border mt-2 flex-1"> 
			</div>
			<div class="col-span-12 sm:col-span-6"> 
				<label>Biaya Pengiriman</label> 
				<input type="number" name="delivery_cost" id="input-delivery-cost" class="input w-full border mt-2 flex-1"> 
			</div>
			<div class="col-span-12 sm:col-span-6"> 
				<label>Nama Penerima</label> 
				<input type="text" name="recipient_name" id="input-recipient-name" class="input w-full border mt-2 flex-1"> 
			</div>
			<div class="col-span-12 sm:col-span-6"> 
				<label>Alamat Penerima</label> 
				<textarea name="recipient_address" id="input-recipient-address" class="input w-full border mt-2 flex-1" rows="3"></textarea>
			</div>
			<div class="col-span-12 sm:col-span-6"> 
				<label>Status</label> 
				<select name="recipient_status" id="input-recipient-status" class="single-select input w-full border mt-2 flex-1">
					<option value="pending">Pending</option>
					<option value="on_process">Proses</option>
					<option value="on_delivery">Sedang Dikirim</option>
					<option value="done">Selesai</option>
				</select>
			</div>
			<div class="col-span-12 sm:col-span-6"> 
				<label>Tipe Pengiriman</label> 
				<select name="shipment_type" id="input-shipment-type" class="single-select input w-full border mt-2 flex-1">
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
			<div class="col-span-12 sm:col-span-6"> 
				<label>Note</label> 
				<textarea name="note" id="input-note" class="input w-full border mt-2 flex-1" rows="3"></textarea>
			</div>
			
		</div>
		<div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5"> 
			<a href="{{ route('custom.order.index') }}" type="button" class="modal-close button w-20 border text-gray-700 dark:border-dark-5 dark:text-gray-300 mr-1" data-id="main-modal">Kembali</a> 
			<button type="submit" class="button w-20 bg-theme-1 text-white">Submit</button> 
		</div>
	</form>
</div>
@endsection

@section('additionalFileJS')

@endsection

@section('additionalScriptJS')
<script type="text/javascript">
	initSelect2()
    getStores();
	getProducts()
	initSelect2()
	setTimeout(() => {
		getCustomOrder()
	}, 500);

	function initSelect2(){
		$(".single-select").select2({
			placeholder: "Choose One"
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
                $('#input-store-id').val(res.data.store_id).trigger('change')
                $('#input-product-id').val(res.data.product_id).trigger('change')
                $('#input-cake-character').val(res.data.cake_character)
                $('#input-cake-shape').val(res.data.cake_shape)
                $('#input-cake-size').val(res.data.cake_size)
                $('#input-price').val(res.data.price)
                $('#input-additional-price').val(res.data.additional_price)
                $('#input-other').val(res.data.other)
                $('#input-cake-custom-name').val(res.data.cake_custom_name)
                $('#input-discount-value').val(res.data.discount_value)
                $('#input-candle').val(res.data.candle)
                $('#input-discount').val(res.data.discount)
                $('#input-delivery-cost').val(res.data.delivery_cost)
                $('#input-recipient-name').val(res.data.recipient_name)
                $('#input-recipient-address').val(res.data.recipient_address)
                $('#input-recipient-method').val(res.data.method)
                $('#input-recipient-status').val(res.data.recipient_status).trigger('change');
                $('#input-shipment-type').val(res.data.shipment_type).trigger('change');
                $('#input-note').val(res.data.note)
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
			const arrInt = ['store_id', 'product_id', 'cake_size', 
			'price', 'additional_price', 'discount', 'delivery_cost']
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
					  window.location.href = "{{ route('custom.order.index') }}"
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