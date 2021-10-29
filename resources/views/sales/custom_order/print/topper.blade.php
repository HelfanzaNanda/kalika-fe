<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Pesanan Produksi</title>
	<link rel="stylesheet" href="{{ asset('templates/midone/css/bootstrap.min.css') }}" />
	<style type="text/css">
		body {
		    font-size: 1em;
		}

		.boxed {
			border: 1px solid black ;
		}

		textarea {
			border-width:0px;
			border:none;
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
				<h5>Cetak Topper/Nama/Foto</h5>
				<table>
					<tr>
						<td>No. Nota</td>
						<td>:</td>
						<td id="number">asd</td>
					</tr>
					<tr>
						<td>Hari/Tgl</td>
						<td>:</td>
						<td id="delivery-date">asd</td>
					</tr>
					<tr>
						<td>Nama Cake</td>
						<td>:</td>
						<td id="cake-name">asd</td>
					</tr>
					<tr>
						<td>Tipe Cake</td>
						<td>:</td>
						<td id="type-cake">asd</td>
					</tr>
					<tr>
						<td>Karakter/Code</td>
						<td>:</td>
						<td id="character-cake">asd</td>
					</tr>
					<tr>
						<td>Varian Rasa</td>
						<td>:</td>
						<td id="cake-variant">asd</td>
					</tr>
					<tr>
						<td>Bentuk/Ukuran</td>
						<td>:</td>
						<td id="size-cake">asd</td>
					</tr>
					<tr>
						<td>Cerita</td>
						<td>:</td>
						<td><textarea placeholder="Isikan Cerita..." autofocus></textarea></td>
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
	            	let dayName = indonesianDay(moment(res.data.delivery_date).format('dddd'));
					$('#number').text(res.data.number);
					$('#delivery-date').text(dayName+", "+moment(res.data.delivery_date).format('DD MMM YYYY'));
					$('#delivery-time').text(moment(res.data.delivery_date).format('hh:mm:ss'));
					$('#cashier-name').text("*("+res.data.created_by_name+")");
					$('#product-name').text(res.data.product_name);
					$('#type-cake').text(res.data.cake_type.name+" - "+res.data.cake_type.description);
					$('#character-cake').text(res.data.cake_character);
					$('#size-cake').text(res.data.cake_shape+" / "+res.data.cake_size+" cm");
					$('#cake-variant').text(res.data.variant_cake.name);
					$('#cake-name').text(res.data.cake_custom_name);
					$('#candle').text(res.data.candle);
	            },
	        });
		}
	</script>
</body>
</html>