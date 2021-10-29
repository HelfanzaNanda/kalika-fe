<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Tanda Terima</title>
	<link rel="stylesheet" href="{{ asset('templates/midone/css/bootstrap.min.css') }}" />
	<style type="text/css">
		body {
		    font-size: 0.65em;
		}

		.boxed-red {
			border: 1px dotted red;
		}

		.boxed {
			border: 1px solid black;
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
				<p id="delivery-date-left" class="text-center">asd</p>
				<p id="number-left" class="text-center">123asd</p>
				<table width="100%">
					<tr>
						<td width="25%">Kepada Yth.</td>
						<td width="1%">:</td>
						<td width="74%" style="border-bottom: 1px solid #000;" id="recipient-name-left">asd</td>
					</tr>
					<tr>
						<td>Telepon</td>
						<td>:</td>
						<td style="border-bottom: 1px solid #000;" id="recipient-phone-left">asd</td>
					</tr>
					<tr>
						<td>Alamat</td>
						<td>:</td>
						<td style="border-bottom: 1px solid #000;" id="recipient-address-left">asd</td>
					</tr>
					<tr>
						<td colspan="3">Mohon diterima dengan baik :</td>
					</tr>
					<tr>
						<td>Nama Kue</td>
						<td>:</td>
						<td style="border-bottom: 1px solid #000;" id="cake-name-left">asd</td>
					</tr>
					<tr>
						<td>Atas Pesanan</td>
						<td>:</td>
						<td style="border-bottom: 1px solid #000;" id="customer-name-left">asd</td>
					</tr>
					<tr>
						<td>Alamat</td>
						<td>:</td>
						<td style="border-bottom: 1px solid #000;" id="customer-address-left">asd</td>
					</tr>
					<tr>
						<td>Telepon</td>
						<td>:</td>
						<td style="border-bottom: 1px solid #000;" id="customer-phone-left">asd</td>
					</tr>
				</table>
			</div>
			<div class="col">
				<div class="row">
					<div class="col">
						<img src="{{asset('templates/midone/images/logo_kalika.png')}}" height="60">
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
							<tr>
								<td>IG</td>
								<td>:</td>
								<td>@kalikacakeshop</td>
							</tr>
						</table>
					</div>
					<div class="col">
						<h4 class="text-center">TANDA TERIMA</h4>
						<p class="text-center" id="delivery-date">asd</p>
						<p class="text-center" id="number">123asd</p>
					</div>
				</div>
				<div class="boxed-red">
					<div class="row p-2">
						<div class="col">
							<table width="100%">
								<tr>
									<td width="25%">Kepada Yth.</td>
									<td width="1%">:</td>
									<td width="74%" style="border-bottom: 1px solid #000;" id="recipient-name">asd</td>
								</tr>
								<tr>
									<td>Telepon</td>
									<td>:</td>
									<td style="border-bottom: 1px solid #000;" id="recipient-phone">asd</td>
								</tr>
								<tr>
									<td>Alamat</td>
									<td>:</td>
									<td style="border-bottom: 1px solid #000;" id="recipient-address">asd</td>
								</tr>
								<tr>
									<td colspan="3">Mohon diterima dengan baik :</td>
								</tr>
								<tr>
									<td>Nama Kue</td>
									<td>:</td>
									<td style="border-bottom: 1px solid #000;" id="cake-name">asd</td>
								</tr>
								<tr>
									<td>Atas Pesanan</td>
									<td>:</td>
									<td style="border-bottom: 1px solid #000;" id="customer-name">asd</td>
								</tr>
								<tr>
									<td>Alamat</td>
									<td>:</td>
									<td style="border-bottom: 1px solid #000;" id="customer-address">asd</td>
								</tr>
								<tr>
									<td>Telepon</td>
									<td>:</td>
									<td style="border-bottom: 1px solid #000;" id="customer-phone">asd</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
				<div class="row mt-1">
					<div class="col">
						<div class="boxed" style="height: 55px; width: 100%;">
							<span class="p-2">Catatan :</span>
						</div>
						<p style="font-style: italic;">*Lembar Arsip</p>
					</div>
				</div>
				<div class="row">
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
							<tr>
								<td>Jam Diterima : </td>
							</tr>
						</table>
					</div>
				</div>
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
					$('#delivery-date').text(moment(res.data.delivery_date).format('DD MMM YYYY hh:mm:ss'));
					$('#recipient-name').text(res.data.recipient_name);
					$('#recipient-phone').text(res.data.recipient_phone);
					$('#recipient-address').text(res.data.recipient_address);
					$('#customer-name').text(res.data.customer_name);
					$('#customer-address').text(res.data.customer_address);
					$('#customer-phone').text(res.data.customer_phone);
					$('#cake-name').text(res.data.product_name);
					$('#cashier-name').text(res.data.created_by_name);

					$('#number-left').text(res.data.number);
					$('#delivery-date-left').text(moment(res.data.delivery_date).format('DD MMM YYYY hh:mm:ss'));
					$('#recipient-name-left').text(res.data.recipient_name);
					$('#recipient-phone-left').text(res.data.recipient_phone);
					$('#recipient-address-left').text(res.data.recipient_address);
					$('#customer-name-left').text(res.data.customer_name);
					$('#customer-address-left').text(res.data.customer_address);
					$('#customer-phone-left').text(res.data.customer_phone);
					$('#cake-name-left').text(res.data.product_name);
					$('#cashier-name-left').text(res.data.created_by_name);

					 window.print();
					 setTimeout(window.close, 500);
	            },
	        });
		}
	</script>
</body>
</html>