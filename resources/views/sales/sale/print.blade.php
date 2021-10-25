<!DOCTYPE html>
<html lang="en">
	<head>
	  <meta charset="utf-8">
	  <title>receipt</title>
	  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/3.0.3/normalize.css">
	  <link rel="stylesheet" href="{{ asset('templates/midone/css/paper.css') }}" />
	  <style>
	    @page { size: 58mm 100mm } /* output size */
	    body.receipt .sheet { width: 58mm; } /* sheet size */
	    @media print { body.receipt { width: 58mm } } /* fix for Chrome */
	    h5, h3 {
	    	margin-top: 0px;
	    	margin-bottom: 5px;
	    }
		body {
		    font-size: 0.75em; /* That is your text's default font size. Here i chose 12px */
		}
		p {
			margin-top: 0px;
			margin-bottom: 1px;
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
	<body class="receipt">
	  <section class="sheet padding-5mm">
	    <center><h3>Kalika Cake Shop</h3></center>
	    <center><h5>Jl. Mekar Puspita No. 42</h5></center>
	    <center><h5>Bandung</h5></center>
	    ---------------------------------------------
	    <table>
	    	<tr>
	    		<td>No</td>
	    		<td>: <span id="number"></span></td>
	    	</tr>
	    	<tr>
	    		<td>Kasir</td>
	    		<td>: <span id="cashier"></span></td>
	    	</tr>
	    	<tr>
	    		<td>Waktu</td>
	    		<td>: <span id="time"></span></td>
	    	</tr>
	    </table>
	    ---------------------------------------------
	    <table style="width: 100%;" id="items">

	    </table>
	    ---------------------------------------------
	    <center><p><span id="total-product">3</span> Produk</p></center>
	    ---------------------------------------------
	    <table style="width: 100%;">
	    	<tr>
	    		<td>Subtotal</td>
	    		<td>:</td>
	    		<td style="text-align:right" id="subtotal">385.000</td>
	    	</tr>
	    	<tr>
	    		<td>Diskon</td>
	    		<td>:</td>
	    		<td style="text-align:right" id="discount">0</td>
	    	</tr>
	    	<tr>
	    		<td>Total</td>
	    		<td>:</td>
	    		<td style="text-align:right" id="total">385.000</td>
	    	</tr>
	    	<tr>
	    		<td colspan="3" style="text-align: center;" id="payment-method">
	    			GRAB FOOD
	    		</td>
	    	</tr>
	    </table>
	    ---------------------------------------------
	    <center><p>TERIMAKASIH</p></center>
	    <center><p>www.kalikacakeshop.com</p></center>
	    <center><p>Telp. 0812 2267 3369</p></center>
	    <center><p>pembulatan akan didonasikan</p></center>
	  </section>
	  <script src="{{ asset('templates/midone/vendor/jquery/jquery-3.6.0.min.js') }}"></script>
	  <script src="{{ asset('templates/midone/vendor/moment/moment.min.js') }}"></script>
      <script src="{{ asset('templates/midone/vendor/moment/moment-with-locales.min.js') }}"></script>
	  <script type="text/javascript">
	  	let salesId = '{{$id}}';
		
		getSalesById(salesId);

		function formatRupiah(angka, prefix){
			var number_string = angka.replace(/[^,\d]/g, '').toString(),
			split   		= number_string.split(','),
			sisa     		= split[0].length % 3,
			rupiah     		= split[0].substr(0, sisa),
			ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

			// tambahkan titik jika yang di input sudah menjadi angka ribuan
			if(ribuan){
				separator = sisa ? '.' : '';
				rupiah += separator + ribuan.join('.');
			}

			rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
			return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
		}

	    function getSalesById(salesId) {
	        $.ajax({
	            url: API_URL+"/api/sales/"+salesId,
	            type: 'GET',
	            headers: { 'Authorization': 'Bearer '+TOKEN },
	            dataType: 'JSON',
	            async: false,
	            beforeSend: function() {

	            },
	            success: function(res, textStatus, jqXHR){
	            	
	            	let html = '';
	            	let totalProducts = 0;

	                $.each(res.data.sales_details, function (index, item) {
	                	totalProducts += item.qty;
				    	html += '<tr>';
				    	html += '	<td colspan="3">'+item.product.name+'</td>';
				    	html += '</tr>';
				    	html += '<tr>';
				    	html += '	<td>x'+item.qty+'</td>';
				    	html += '	<td width="45%" style="text-align:right">'+formatRupiah(item.unit_price.toString())+'</td>';
				    	html += '	<td style="text-align:right">'+formatRupiah(item.total.toString())+'</td>';
				    	html += '</tr>';
	                });

	                $('#items').html(html);

	                $('#total-product').text(totalProducts);
					$('#number').text(res.data.number);
			        $.ajax({
			            url: API_URL+"/api/users/"+res.data.created_by,
			            type: 'GET',
			            headers: { 'Authorization': 'Bearer '+TOKEN },
			            dataType: 'JSON',
			            async: false,
			            beforeSend: function() {
							
			            },
			            success: function(res, textStatus, jqXHR){
							$('#cashier').text(res.data.name);
			            }
			    	});

			        $.ajax({
			            url: API_URL+"/api/payment_methods/"+res.data.payment.payment_method_id,
			            type: 'GET',
			            headers: { 'Authorization': 'Bearer '+TOKEN },
			            dataType: 'JSON',
			            async: false,
			            beforeSend: function() {
							
			            },
			            success: function(res, textStatus, jqXHR){
							$('#payment-method').text(res.data.name);
			            }
			    	});

					$('#time').text(moment(res.data.created_at).format('DD MMM YYYY hh:mm:ss'));
					$('#subtotal').text(formatRupiah((res.data.total - res.data.discount_value).toString()));
					$('#discount').text(formatRupiah(res.data.discount_value.toString()));
					$('#total').text(formatRupiah(res.data.total.toString()));

					window.print();
	            },
	            error: function(jqXHR, textStatus, errorThrown){

	            },
	        });
	    }
	  </script>
	</body>
</html>