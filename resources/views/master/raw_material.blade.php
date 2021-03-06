@extends('layouts.main')

@section('title', $title)

@section('additionalFileCSS')

@endsection

@section('content')
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
	<h2 class="text-lg font-medium mr-auto">
		Data {{$title}}
	</h2>
	<div class="w-full sm:w-auto flex mt-4 sm:mt-0">
		<button class="button text-white bg-theme-1 shadow-md mr-2" id="add-button">Tambah {{$title}}</button>
	</div>
</div>
<div class="intro-y datatable-wrapper box p-5 mt-5">
	<table class="table table-report table-report--bordered display datatable w-full" id="main-table">
		<thead>
			<tr>
				<th>Id</th>
				<th class="border-b-2 text-center whitespace-no-wrap">Nama</th>
				<th class="border-b-2 text-center whitespace-no-wrap">Supplier</th>
				<th class="border-b-2 text-center whitespace-no-wrap">Harga</th>
				<th class="border-b-2 text-center whitespace-no-wrap"></th>
				<th class="border-b-2 text-center whitespace-no-wrap"></th>
				<th class="border-b-2 text-center whitespace-no-wrap"></th>
				<th class="border-b-2 text-center whitespace-no-wrap"></th>
				<th class="border-b-2 text-center whitespace-no-wrap">Harga per Unit</th>
				<th class="border-b-2 text-center whitespace-no-wrap">Divisi</th>
				<th class="border-b-2 text-center whitespace-no-wrap">Toko</th>
				<th class="border-b-2 whitespace-no-wrap">Aksi</th>
			</tr>
		</thead>
		<tbody>

		</tbody>
	</table>
</div>
<div class="modal" id="main-modal">
	<div class="modal__content modal__content--lg">
		<form id="main-form">
			<div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
				<h2 class="font-medium text-base mr-auto" id="modal-title"></h2>
			</div>
			<div class="p-5 grid grid-cols-12 gap-4 row-gap-3">
				<input type="hidden" name="id" id="input-id">
				<div class="col-span-12">
					<label>Nama Bahan Baku</label>
					<input type="text" name="name" class="input w-full border flex-1" id="input-name">
				</div>
				<div class="col-span-12">
					<label>Harga</label>
					<input type="number" name="price" class="input w-full border flex-1 calc-price-per-unit" id="input-price">
				</div>
				<div class="col-span-12">
					<label>Jumlah Satuan Terbesar</label>
					<input type="text" name="qty" class="input w-full border flex-1 calc-price-per-unit" id="input-qty">
				</div>
				<div class="col-span-12">
					<label>Satuan Terbesar</label>
					<select name="unit_id" id="input-unit-id" class="single-select input w-full border flex-1"></select>
				</div>
				<div class="col-span-12">
					<label>Unit Per Konversi</label>
					<input type="text" name="qty_conversion" class="input w-full border flex-1 calc-price-per-unit" id="input-qty-conversion">
				</div>
				<div class="col-span-12">
					<label>Konversi Ke</label>
					<select name="smallest_unit_id" id="input-smallest-unit-id" class="single-select input w-full border flex-1"></select>
				</div>
				<div class="col-span-12">
					<label>Supplier</label>
					<select name="supplier_id" id="input-supplier-id" class="single-select input w-full border flex-1"></select>
				</div>
				<div class="col-span-12">
					<label>Toko</label>
					<select name="store_id" id="input-store-id" class="single-select input w-full border flex-1"></select>
				</div>
				<div class="col-span-12">
					<label>Divisi</label>
					<select name="division_id" id="input-division-id" class="single-select input w-full border flex-1"></select>
				</div>
				<div class="col-span-12">
					<label>Harga Per Unit : <span id="price-per-unit">0</span></label>
				</div>
			</div>
			<div class="intro-y box mt-5">
			    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200 dark:border-dark-5">
			        <h2 class="font-medium text-base mr-auto">
			            Stok
			        </h2>
			    </div>
				<div class="p-5 grid grid-cols-12 gap-4 row-gap-3">
					<table class="table table-report table-report--bordered display col-span-12">
						<thead>
							<tr>
								<th class="w-1/2 border-b-2 text-center whitespace-no-wrap">Toko</th>
								<th class="w-1/4 border-b-2 text-center whitespace-no-wrap">Quantity</th>
							</tr>
						</thead>
						<tbody id="product-location-list">

						</tbody>
					</table>
				</div>
			</div>
			<div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5">
				<button type="button"
					class="modal-close button w-20 border text-gray-700 dark:border-dark-5 dark:text-gray-300 mr-1"
					data-id="main-modal">Cancel</button>
				<button type="submit" class="button w-20 bg-theme-1 text-white">Submit</button>
			</div>
		</form>
	</div>
</div>
@endsection

@section('additionalFileJS')

@endsection

@section('additionalScriptJS')
<script type="text/javascript">
	let productLocation = [];

	drawDatatable();
	initSelect2()
	
	$(document).on('keyup', '.calc-price-per-unit', function() {
		calculatePricePerUnit();
	});

	function calculatePricePerUnit() {
		let price = $('#input-price').val();
		let qty = $('#input-qty').val();
		let qtyUnitConversion = $('#input-qty-conversion').val();
		
		let calc = 0;

		calc = (parseFloat(price) * parseFloat(qty)) / parseFloat(qtyUnitConversion);
		$('#price-per-unit').text(Math.round(calc));
	}

	function initSelect2(){
		$(".single-select").select2({
			placeholder: "Silahkan Pilih"
		});
	}

    $(document).on("click","button#add-button",function() {
		resetAllInputOnForm('#main-form')
		getSuppliers();
		getUnits();
		getStores();
		getDivisions();
        $('h2#modal-title').text('Tambah {{$title}}')
        $('#main-modal').modal('show');
    });

    $(document).on("click", "button#edit-data",function(e) {
      	e.preventDefault();
	  	resetAllInputOnForm('#main-form')
      	let id = $(this).data('id');
	  	getProductLocation(id);
	  	getSuppliers()
		getUnits()
		getStores(id)
		getDivisions();
		$.ajax({
			url: API_URL+"/api/raw_materials/"+id,
			type: 'GET',
			headers: { 'Authorization': 'Bearer '+TOKEN },
			dataType: 'JSON',
			success: function(res, textStatus, jqXHR){
				$('#input-id').val(res.data.id);
				$('#input-name').val(res.data.name);
				$('#input-price').val(res.data.price);
				$('#input-stock').val(res.data.stock);
				$('#input-supplier-id').val(res.data.supplier_id).trigger('change');
				$('#input-unit-id').val(res.data.unit_id).trigger('change');
				$('#input-smallest-unit-id').val(res.data.smallest_unit_id).trigger('change');
				$('#input-store-id').val(res.data.store_id).trigger('change');
				$('#modal-title').text('Edit {{$title}}');
				$('#input-division-id').val(res.data.division_id).trigger('change');
				$('#input-qty').val(res.data.qty);
				$('#input-qty-conversion').val(res.data.qty_conversion);
				$('#main-modal').modal('show');
				calculatePricePerUnit();
			},
			error: function(jqXHR, textStatus, errorThrown){

			},
		});
    });

    $( 'form#main-form' ).submit( function( e ) {
        e.preventDefault();
        var form_data  =  new FormData(this)
		let data = {
			"product_locations": []
		}
		for (var pair of form_data.entries()) {
			const arrInt = ['id', 'supplier_id', 'price', 'unit_id', 
			'smallest_unit_id', 'stock', 'store_id', 'division_id', 'qty', 'qty_conversion']
			if (arrInt.includes(pair[0])) {
				data[pair[0]] = parseInt(pair[1])
			}else{	
				data[pair[0]] = pair[1]
			}
		}

		$('#product-location-list > tr').each(function (index, element) {
			let item = {
				'store_id' : parseInt($(this).find('.product_location_store_id').val()),
				'quantity' : parseInt($(this).find('.product_location_quantity').val()),
			}
			data.product_locations.push(item)
		});

        $.ajax({
            type: 'post',
            url: API_URL+"/api/raw_materials",
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
                    $('#main-modal').modal('hide');
                    $('#main-table').DataTable().ajax.reload( function ( json ) {
                        feather.replace();
                    });
                  }
                });
            }
        })
    });

    function drawDatatable() {
        $("#main-table").DataTable({
            "destroy": true,
            "pageLength": 10,
            "processing": true,
            "serverSide": true,
            "ajax":{
                "url": API_URL+"/api/raw_material_datatables",
                "headers": { 'Authorization': 'Bearer '+TOKEN },
                "dataType": "json",
                "type": "POST",
                "data":function(d) { 
                  
                },
            },
            "columns": [
                {data: 'id', name: 'id', width: '5%', "visible": false },
                {data: 'name', name: 'name', className: 'text-center border-b'},
                {data: 'supplier_name', name: 'supplier_name', className: 'text-center border-b'},
                {
					data: 'price', name: 'price', 
					className: 'text-center border-b',
					render : data => formatRupiah(data.toString(), '')
				},
                {data: 'qty', name: 'qty', className: 'text-center border-b'},
                {data: 'unit_name', name: 'unit_name', className: 'text-center border-b'},
                {
					data: 'qty_conversion', name: 'qty_conversion', 
					className: 'text-center border-b',
					render : data => formatRupiah(data.toString(), '')
				},
                {data: 'smallest_unit_name', name: 'smallest_unit_name', className: 'text-center border-b'},
				{
                    data: 'price', 
                    name: 'price', 
                    className: 'text-center border-b',
                    render: function ( data, type, row ) {
                    	let pricePerUnit = 0;
                    	if (row.qty_conversion > 0) {
                    		pricePerUnit = (row.price * row.qty) / row.qty_conversion;
                    	}
                        return formatRupiah(Math.round(pricePerUnit).toString(), '');
                    }
                },
                {data: 'division_name', name: 'division_name', className: 'text-center border-b'},
                {data: 'store_name', name: 'store_name', className: 'text-center border-b'},
                {data: 'action', name: 'action', orderable: false, className: 'border-b w-5'}
            ],
            "order": [0, 'desc'],
            "initComplete": function(settings, json) {
                feather.replace();
            }
        });
    }

    $(document).on('click', 'button#delete-data', function( e ) {
        e.preventDefault();
        let id = $(this).data('id');

        Swal.fire({
          title: "Apakah anda yakin?",
          text: "Anda tidak bisa memulihkan data ini",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
                type: 'DELETE',
                url: API_URL+"/api/raw_materials/"+id,
                headers: {
                  'Authorization': 'Bearer '+TOKEN
                },
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                beforeSend: function() {
                    $('.loading-area').show();
                },
                success: function(res) {
                    Swal.fire(
                      'Terhapus!',
                      'Data anda telah dihapus.',
                      'success'
                    )
                    $('#main-table').DataTable().ajax.reload( function ( json ) {
                        feather.replace();
                    } );
                }
            })
          }
        })
    });

	function getSuppliers() {
		$.ajax({
			url: API_URL+"/api/suppliers",
			type: 'GET',
			headers: { 'Authorization': 'Bearer '+TOKEN },
			dataType: 'JSON',
			success: function(res, textStatus, jqXHR){
				let opt = ''
				$.each(res.data, function (index, item) {  
					opt += '<option value="'+item.id+'">'+item.name+'</option>'
				})
				$('#input-supplier-id').html(opt)
			},
			error: function(jqXHR, textStatus, errorThrown){

			},
		})
	}

	function getUnits() {
		$.ajax({
			url: API_URL+"/api/units",
			type: 'GET',
			headers: { 'Authorization': 'Bearer '+TOKEN },
			dataType: 'JSON',
			success: function(res, textStatus, jqXHR){
				let opt = ''
				$.each(res.data, function (index, item) {  
					opt += '<option value="'+item.id+'">'+item.name+'</option>'
				})
				$('#input-unit-id').html(opt)
				$('#input-smallest-unit-id').html(opt)
			},
			error: function(jqXHR, textStatus, errorThrown){

			},
		})
	}

	function getDivisions() {
		$.ajax({
			url: API_URL+"/api/divisions",
			type: 'GET',
			headers: { 'Authorization': 'Bearer '+TOKEN },
			dataType: 'JSON',
			success: function(res, textStatus, jqXHR){
				let opt = ''
				$.each(res.data, function (index, item) {  
					opt += '<option value="'+item.id+'">'+item.name+'</option>'
				})
				$('#input-division-id').html(opt)
			},
			error: function(jqXHR, textStatus, errorThrown){

			},
		})
	}

	function getStores(productId) {
		$.ajax({
			url: API_URL+"/api/stores",
			type: 'GET',
			headers: { 'Authorization': 'Bearer '+TOKEN },
			dataType: 'JSON',
			success: function(res, textStatus, jqXHR){
				let opt = ''
				let productLocationHtml = ''
				$.each(res.data, function (index, item) {  
					let currentStock = 0;
					if (productId != null && productLocation.length > 0) {
						if (productLocation[item.id][productId] != null) {
							currentStock = productLocation[item.id][productId];
						}
					}

					opt += '<option value="'+item.id+'">'+item.name+'</option>'

					productLocationHtml += '<tr class="item-0">';
					productLocationHtml += '	<td class="text-center"> <input type="hidden" class="product_location_store_id" value="'+item.id+'"/> <label>'+item.name+'</label> </td>';
					productLocationHtml += '	<td> ';
					productLocationHtml += '		<input type="number" id="input-amount-0" class="product_location_quantity input w-full border mt-2 flex-1" value="'+currentStock+'"/> ';
					productLocationHtml += '	</td>';
					productLocationHtml += '</tr>';
				});
				$('#input-store-id').html(opt);
				$('#product-location-list').html(productLocationHtml);
				
			},
			error: function(jqXHR, textStatus, errorThrown){

			},
		})
	}

	function getProductLocation(productId) {
		$.ajax({
			url: API_URL+"/api/product_locations?model=RawMaterial&product_id="+productId,
			type: 'GET',
			headers: { 'Authorization': 'Bearer '+TOKEN },
			dataType: 'JSON',
			async: false,
			success: function(res, textStatus, jqXHR){
				$.each(res.data, function (index, item) {  
					productLocation[item.store_id] = [];
					productLocation[item.store_id][productId] = item.quantity;
				})
			},
			error: function(jqXHR, textStatus, errorThrown){

			},
		})
	}
</script>
@endsection