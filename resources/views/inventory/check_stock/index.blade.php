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
		<button class="button text-white bg-theme-1 shadow-md mr-2" id="filter-button">Filter</button>
		<button class="button text-white bg-theme-1 shadow-md mr-2" id="pdf-button">PDF</button>
	</div>
</div>
<div class="intro-y datatable-wrapper box p-5 mt-5">
    <table class="table table-report table-report--bordered display datatable w-full" id="main-table">
        <thead>
            <tr>
                <th class="border-b-2 text-center whitespace-no-wrap">Produk</th>
                <th class="border-b-2 text-center whitespace-no-wrap">Stok</th>
                <th class="border-b-2 text-center whitespace-no-wrap">Minimum Stok</th>
                <th class="border-b-2 text-center whitespace-no-wrap">Divisi</th>
                <th class="border-b-2 text-center whitespace-no-wrap">Kategori</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
<div class="modal" id="main-modal">
   <div class="modal__content modal__content--xl">
        <form id="main-form">
            <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto" id="modal-title"></h2>
            </div>
            <div class="p-5 grid grid-cols-12 gap-4 row-gap-3">
				<div class="col-span-12 sm:col-span-6"> 
					<label>Divisi</label> 
					<select name="division_id" id="input-division-id" class="single-select input w-full border mt-2 flex-1"></select> 
				</div>
				<div class="col-span-12 sm:col-span-6"> 
					<label>Toko</label> 
					<select name="store_id" id="input-store-id" class="single-select input w-full border mt-2 flex-1"></select> 
				</div>
            </div>
            <div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5"> 
                <button type="button" class="modal-close button w-20 border text-gray-700 dark:border-dark-5 dark:text-gray-300 mr-1" data-id="main-modal">Cancel</button> 
                <button type="submit" class="button w-20 bg-theme-1 text-white">Filter</button>
            </div>
        </form>
   </div>
</div>
@endsection

@section('additionalFileJS')

@endsection

@section('additionalScriptJS')
<script type="text/javascript">

    drawDatatable()
	$(document).on("click", "button#filter-button", function() {
		resetAllInputOnForm('#main-form')
        $('h2#modal-title').text('Filter {{$title}}')
		getStores()
		getDivisions()
		initSelect2()
        $('#main-modal').modal('show');
    });

	function initSelect2(){
		$(".single-select").select2({
			//placeholder: "Choose One",
		});
	}

	$( 'form#main-form' ).submit( function( e ) {
        e.preventDefault();
		$('#main-table').DataTable().ajax.reload( function ( json ) {
			feather.replace();
		} );
		$('#main-modal').modal('hide');
	})

    function drawDatatable() {
        $("#main-table").DataTable({
            "destroy": true,
            //"pageLength": 10,
			"searching": false,
			"paging":   false,
            "processing": true,
            "serverSide": true,
            "ajax":{
                "url": API_URL+"/api/check_stock_datatables",
                "headers": { 'Authorization': 'Bearer '+TOKEN },
                "dataType": "json",
                "type": "POST",
                "data":function(d) { 
                  	d.store_id = $('#input-store-id').val()
                  	d.division_id = $('#input-division-id').val()
                },
            },
            "columns": [
                {data: 'product_name', name: 'product_name', className: 'text-center border-b'},
                {data: 'qty', name: 'qty', className: 'text-center border-b'},
                {data: 'minimum_stock', name: 'minimum_stock', className: 'text-center border-b'},
                {data: 'division_name', name: 'division_name', className: 'text-center border-b'},
                {data: 'category_name', name: 'category_name', className: 'text-center border-b'},
            ],
            "order": [0, 'desc'],
            "initComplete": function(settings, json) {
                feather.replace();
            },
		});
    }

	$(document).on('click', '#pdf-button', function (e) {  
		e.preventDefault()
		const data = {
			'store_id' : parseInt($('#input-store-id').val()),
			'division_id' : parseInt($('#input-division-id').val()),
		}
		$.ajax({
            type: 'POST',
            url: API_URL+"/api/check_stock_pdf",
            headers: { 'Authorization': 'Bearer '+TOKEN },
            data: JSON.stringify(data),
            contentType: 'application/json',
            dataType: 'JSON',
            beforeSend: function() {
                
            },
            success: function(res) {
				const link = document.createElement('a');
				link.href = API_URL+"/api/download?path=" + res.data;
				link.target = "_blank";
				document.body.appendChild(link);
				link.click();
				document.body.removeChild(link);
            },
            error: function(jqXHR, textStatus, errorThrown){
                console.log(jqXHR.responseJSON);
            },
        });
	})


	function getStores() {
        $.ajax({
            url: API_URL+"/api/stores",
            type: 'GET',
            headers: { 'Authorization': 'Bearer '+TOKEN },
            dataType: 'JSON',
            success: function(res, textStatus, jqXHR){
                let opt = ''
                opt += '<option value=""> Semua </option>'
                $.each(res.data, function (index, item) {  
                    opt += '<option value="'+item.id+'">'+item.name+'</option>'
                })
                $('#input-store-id').html(opt)
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
                opt += '<option value=""> Semua </option>'
                $.each(res.data, function (index, item) {  
                    opt += '<option value="'+item.id+'">'+item.name+'</option>'
                })
                $('#input-division-id').html(opt)
            },
            error: function(jqXHR, textStatus, errorThrown){

            },
        })
    }
</script>
@endsection