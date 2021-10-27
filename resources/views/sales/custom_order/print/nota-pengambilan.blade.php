<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Nota Pengambilan</title>
	<link rel="stylesheet" href="{{ asset('templates/midone/css/bootstrap.min.css') }}" />
	<style type="text/css">
		body {
		    font-size: 0.75em;
		}

		.boxed {
			border: 1px solid black ;
		}
	</style>
</head>
    <script type="text/javascript">
		var API_URL = '{{ env('API_URL') }}';
		var BASE_URL = '{{ url('/') }}';
		var TOKEN = '';

		let loggedUser = localStorage.getItem('_r');
		let userPermissions = localStorage.getItem('_p');

		if (loggedUser == null || userPermissions == null) {
			window.location.replace(BASE_URL+'/login');
		}

		var ROLE_ID = JSON.parse(loggedUser)['role_id'];
		var STORE_ID = JSON.parse(loggedUser)['role_id'];
		TOKEN = JSON.parse(loggedUser)['token'];
    </script>
<body>
	
	<div class="container">
		<div class="row">
			<div class="col">
				<img src="{{asset('templates/midone/images/logo_kalika.png')}}" height="65">
				<table>
					<tr>
						<td>Telepon</td>
						<td>:</td>
						<td>(022) 5223396</td>
					</tr>
					<tr>
						<td>HP</td>
						<td>:</td>
						<td>0812 2267 3369</td>
					</tr>
				</table>
			</div>
			<div class="col">
				<h3 class="text-center">NOTA PENGAMBILAN</h3>
			</div>
			<div class="col">
				<table align="right">
					<tr>
						<td>No. Nota</td>
						<td>:</td>
						<td id="number">123asd</td>
					</tr>
					<tr>
						<td>Tanggal Pesan</td>
						<td>:</td>
						<td id="order-date">asd</td>
					</tr>
					<tr>
						<td>Pengiriman</td>
						<td>:</td>
						<td id="shipment-type">DIAMBIL</td>
					</tr>
				</table>
			</div>
		</div>

		<div class="boxed">
			<div class="row p-2">
				<div class="col">
					<table width="100%">
						<tr>
							<td width="20%">No. Seller</td>
							<td width="1%">:</td>
							<td width="79%" style="border-bottom: 1px solid #000;" id="seller"></td>
						</tr>
						<tr>
							<td>Pemesan</td>
							<td>:</td>
							<td style="border-bottom: 1px solid #000;" id="customer-name"></td>
						</tr>
						<tr>
							<td>Alamat</td>
							<td>:</td>
							<td style="border-bottom: 1px solid #000;" id="customer-address"></td>
						</tr>
						<tr>
							<td>Telp.</td>
							<td>:</td>
							<td style="border-bottom: 1px solid #000;" id="customer-phone"></td>
						</tr>
						<tr>
							<td>Hari/Tgl</td>
							<td>:</td>
							<td style="border-bottom: 1px solid #000;" id="delivery-date"></td>
						</tr>
						<tr>
							<td>Jam</td>
							<td>:</td>
							<td style="border-bottom: 1px solid #000;" id="delivery-time"></td>
						</tr>
						<tr>
							<td>Nama</td>
							<td>:</td>
							<td style="border-bottom: 1px solid #000;" id="custom-cake-name"></td>
						</tr>
						<tr>
							<td>Umur</td>
							<td>:</td>
							<td style="border-bottom: 1px solid #000;" id="custom-cake-age"></td>
						</tr>
						<tr>
							<td>Deskripsi</td>
							<td>:</td>
							<td style="border-bottom: 1px solid #000;" id="custom-cake-description"></td>
						</tr>
					</table>
				</div>
				<div class="col">
					<table width="100%">
						<tr>
							<td width="40%">Nama Cake</td>
							<td width="1%">:</td>
							<td width="59%" style="border-bottom: 1px solid #000;" id="cake-name"></td>
						</tr>
						<tr>
							<td>Tipe Cake</td>
							<td>:</td>
							<td style="border-bottom: 1px solid #000;" id="cake-type"></td>
						</tr>
						<tr>
							<td>Karakter/Code</td>
							<td>:</td>
							<td style="border-bottom: 1px solid #000;" id="cake-character"></td>
						</tr>
						<tr>
							<td>Bentuk/Ukuran</td>
							<td>:</td>
							<td style="border-bottom: 1px solid #000;" id="cake-shape"></td>
						</tr>
						<tr>
							<td>Variant Rasa</td>
							<td>:</td>
							<td style="border-bottom: 1px solid #000;" id="variant-cake"></td>
						</tr>
						<tr>
							<td>Lain - lain</td>
							<td>:</td>
							<td style="border-bottom: 1px solid #000;" id="other"></td>
						</tr>
						<tr>
							<td>Harga Lain - lain</td>
							<td>:</td>
							<td style="border-bottom: 1px solid #000;" id="other-price"></td>
						</tr>
						<tr>
							<td>Harga</td>
							<td>:</td>
							<td style="border-bottom: 1px solid #000;" id="price"></td>
						</tr>
						<tr>
							<td>Discount</td>
							<td>:</td>
							<td style="border-bottom: 1px solid #000;" id="discount"></td>
						</tr>
						<tr>
							<td>Ongkir</td>
							<td>:</td>
							<td style="border-bottom: 1px solid #000;" id="delivery-fee"></td>
						</tr>
						<tr>
							<td>Total</td>
							<td>:</td>
							<td style="border-bottom: 1px solid #000;" id="total"></td>
						</tr>
						<tr>
							<td>DP</td>
							<td>:</td>
							<td style="border-bottom: 1px solid #000;" id="down-payment"></td>
						</tr>
						<tr>
							<td>Sisa Pembayaran</td>
							<td>:</td>
							<td style="border-bottom: 1px solid #000;" id="payment-left"></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="row mt-1">
			<div class="col">
				<table align="center" class="text-center">
					<tr>
						<td>Hormat Kami,</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>______________________</td>
					</tr>
					<tr>
						<td>Kalika Cake Shop</td>
					</tr>
					<tr>
						<td id="cashier-name"></td>
					</tr>
				</table>
			</div>
			<div class="col">
				<div class="boxed" style="height: 75px; width: 100%;">
					<span class="p-2">Catatan :</span>
				</div>
			</div>
			<div class="col">
				<table align="center" class="text-center">
					<tr>
						<td>Penerima,</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>______________________</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<script src="{{ asset('templates/midone/vendor/jquery/jquery-3.6.0.min.js') }}"></script>
	<script src="{{ asset('templates/midone/vendor/moment/moment.min.js') }}"></script>
	<script src="{{ asset('templates/midone/vendor/moment/moment-with-locales.min.js') }}"></script>
	<script src="{{ asset('templates/midone/js/custom.js') }}"></script>
	<script type="text/javascript">
		let id = '{{$id}}';
		getCustomOrder(id);

		function getCustomOrder(customOrderId) {
	        $.ajax({
	            url: API_URL+"/api/custom_orders/"+customOrderId,
	            type: 'GET',
	            headers: { 'Authorization': 'Bearer '+TOKEN },
	            dataType: 'JSON',
	            async: false,
	            beforeSend: function() {

	            },
	            success: function(res, textStatus, jqXHR){
					$('#number').text(res.data.number);
					$('#order-date').text(moment(res.data.created_at).format('DD MMM YYYY hh:mm:ss'));
					$('#shipment-type').text(shipmentType(res.data.shipment_type));
					$('#seller').text(res.data.seller.code+' '+res.data.seller.name);
					$('#customer-name').text(res.data.customer_name);
					$('#customer-address').text(res.data.customer_address);
					$('#customer-phone').text(res.data.customer_phone);
					$('#delivery-date').text(moment(res.data.delivery_date).format('DD MMM YYYY'));
					$('#delivery-time').text(moment(res.data.delivery_date).format('hh:mm:ss'));
					$('#custom-cake-name').text(res.data.cake_custom_name);
					$('#custom-cake-age').text(res.data.candle);
					$('#custom-cake-description').text();
					$('#cake-name').text(res.data.product_name);
					$('#cake-type').text(res.data.cake_type.name+' - '+res.data.cake_type.description);
					$('#cake-character').text(res.data.cake_character);
					$('#cake-shape').text(res.data.cake_shape+'/'+res.data.cake_size+' cm');
					$('#variant-cake').text(res.data.variant_cake.name);
					$('#other').text(res.data.other);
					$('#other-price').text(formatRupiah(res.data.additional_price.toString(), 'Rp '));
					$('#price').text(formatRupiah(res.data.price.toString(), 'Rp '));
					$('#discount').text(formatRupiah(res.data.discount.toString(), 'Rp '));
					$('#delivery-fee').text(formatRupiah(res.data.delivery_cost.toString(), 'Rp '));
					$('#total').text(formatRupiah(res.data.total.toString(), 'Rp '));
					$('#down-payment').text(formatRupiah(res.data.down_payment.toString(), 'Rp ')+' ('+res.data.payment_method_name+')');
					$('#payment-left').text(formatRupiah((res.data.down_payment - res.data.total).toString(), 'Rp '));
					$('#cashier-name').text(res.data.created_by_name);

					 window.print();
					 setTimeout(window.close, 500);
	            },
	        });
		}
	</script>
</body>
</html>