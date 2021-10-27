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

		.table tr {
		    border-bottom: 1px solid black;
		}

		.table tr:last-child { 
		    border-bottom: none; 
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
				<h3 class="text-center">NOTA PENJUALAN</h3>
			</div>
			<div class="col">
				<table align="right">
					<tr>
						<td>No. Nota</td>
						<td>:</td>
						<td id="number"></td>
					</tr>
					<tr>
						<td>Tanggal Kirim</td>
						<td>:</td>
						<td id="delivery-date"></td>
					</tr>
					<tr>
						<td>Customer</td>
						<td>:</td>
						<td id="customer"></td>
					</tr>
				</table>
			</div>
		</div>

		<table style="width: 100%; border:1px black solid;" class="table">
			<thead>
				<tr>
					<td class="pl-5">Nama Produk</td>
					<td>Qty</td>
					<td>Harga</td>
					<td>Diskon (%)</td>
					<td class="pr-5">Total</td>
				</tr>
			</thead>
			<tbody id="consignment-list">
				
			</tbody>
			<tfoot>
				<tr>
					<td colspan="4" class="text-end pl-5">Total</td>
					<td class="text-end pr-5" id="total">Rp 100000</td>
				</tr>
			</tfoot>
		</table>

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
				<table align="center" class="text-center">
					<tr>
						<td>Pengirim,</td>
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
		getConsignment(id);

		function getConsignment(consignmentId) {
	        $.ajax({
	            url: API_URL+"/api/sales_consignments/"+consignmentId,
	            type: 'GET',
	            headers: { 'Authorization': 'Bearer '+TOKEN },
	            dataType: 'JSON',
	            async: false,
	            beforeSend: function() {

	            },
	            success: function(res, textStatus, jqXHR){
					$('#number').text(res.data.number);
					$('#delivery-date').text(moment(res.data.date).format('DD MMM YYYY hh:mm:ss'));
					$('#customer').text(res.data.store_consignment.store_name);
			        $.ajax({
			            url: API_URL+"/api/users/"+res.data.created_by,
			            type: 'GET',
			            headers: { 'Authorization': 'Bearer '+TOKEN },
			            dataType: 'JSON',
			            async: false,
			            beforeSend: function() {
							
			            },
			            success: function(res, textStatus, jqXHR){
							$('#cashier-name').text(res.data.name);
			            }
			    	});

			    	let html = '';
					let total = 0;
	                $.each(res.data.sales_consignment_details, function (index, item) {
	                	let subtotal = item.unit_price * item.qty;
				    	html += '<tr>';
				    	html += '	<td class="pl-5">'+item.product.name+'</td>';
				    	html += '	<td>'+item.qty+'</td>';
				    	html += '	<td class="text-end">'+formatRupiah(item.unit_price.toString(), 'Rp ')+'</td>';
				    	html += '	<td>'+res.data.store_consignment.discount+'</td>';
				    	html += '	<td class="text-end pr-5">'+formatRupiah((subtotal - (subtotal * res.data.store_consignment.discount/100)).toString(), 'Rp ')+'</td>';
				    	html += '</tr>';

				    	total += (subtotal - (subtotal * res.data.store_consignment.discount/100));
	                });

	                $('#consignment-list').html(html);
	                $('#total').text(formatRupiah(total.toString(), 'Rp '));

					 window.print();
					 setTimeout(window.close, 500);
	            },
	        });
		}
	</script>
</body>
</html>