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
                <th class="border-b-2 text-center whitespace-no-wrap">No Ref</th>
                <th class="border-b-2 text-center whitespace-no-wrap">Dibuat Pada</th>
                <th class="border-b-2 text-center whitespace-no-wrap">Toko</th>
                <th class="border-b-2 text-center whitespace-no-wrap">Total</th>
                <th class="border-b-2 text-center whitespace-no-wrap">Dibuat Oleh</th>
            </tr>
        </thead>
        <tbody></tbody>
		<tfoot>
            <tr>
                <th class="whitespace-no-wrap"></th>
                <th class="whitespace-no-wrap"></th>
                <th class="whitespace-no-wrap"></th>
                <th class="whitespace-no-wrap"></th>
                <th class="whitespace-no-wrap"></th>
            </tr>
        </tfoot>
    </table>
</div>
<div class="modal" id="main-modal">
   <div class="modal__content modal__content--xl">
        <form id="main-form">
            <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto" id="modal-title"></h2>
            </div>
            <div class="p-5 grid grid-cols-12 gap-4 row-gap-3">
                <input type="hidden" name="id" id="input-id" value="0"> 
                <div class="col-span-12 sm:col-span-6"> 
                    <label>Date Range</label> 
					<div class="w-full sm:ml-auto mr-3 mt-3 sm:mt-0 relative text-gray-700 dark:text-gray-300">
						<i data-feather="calendar" class="w-4 h-4 z-10 absolute my-auto inset-y-0 ml-3 left-0"></i>
						<input id="daterangepicker" type="text" data-daterange="true"
							class="datepicker input w-full sm:w-56 box pl-10">
							<input type="hidden" name="filter_start_date" id="filter-start-date">
							<input type="hidden" name="filter_end_date" id="filter-end-date">
					</div>
                </div>
				<div class="col-span-12 sm:col-span-6"> 
					<label>Kasir</label> 
					<select name="created_by" id="input-created-by" class="single-select input w-full border mt-2 flex-1"></select> 
				</div>
				<div class="col-span-12 sm:col-span-6"> 
					<label>Toko Konsinyasi</label> 
					<select name="store_consignment_id" id="input-store-consignment-id" class="single-select input w-full border mt-2 flex-1"></select> 
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
		getUsers()
		getStoreConsignments()
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

	$('#daterangepicker').on('apply.daterangepicker', function(ev, picker) {
		$('#filter-start-date').val(picker.startDate.format('YYYY-MM-DD'))
		$('#filter-end-date').val(picker.endDate.format('YYYY-MM-DD'))
  	});

	$('#daterangepicker').on('cancel.daterangepicker', function(ev, picker) {
		$(this).val('');
	});

    function drawDatatable() {
        $("#main-table").DataTable({
            "destroy": true,
            //"pageLength": 10,
			"searching": false,
			"paging":   false,
            "processing": true,
            "serverSide": true,
            "ajax":{
                "url": API_URL+"/api/report_sales_consignment_datatables",
                "headers": { 'Authorization': 'Bearer '+TOKEN },
                "dataType": "json",
                "type": "POST",
                "data":function(d) { 
					d.start_date = $('#filter-start-date').val() || moment().format('YYYY-MM-DD')
                  	d.end_date = $('#filter-end-date').val() || moment().add(1, 'd').format('YYYY-MM-DD')
                  	d.created_by = $('#input-created-by').val()
                  	d.payment_method_id = $('#input-payment-method-id').val()
                },
            },
            "columns": [
				{data: 'number', name: 'number', className: 'text-center border-b'},
                {
					data: 'created_at', name: 'created_at', 
					className: 'text-center border-b',
					render : data => moment(data).format('DD MMM YYYY hh:mm:ss')
				},
				{data: 'store_consignment_name', name: 'store_consignment_name', className: 'text-center border-b'},
				{
					data: 'total', name: 'total', 
					className: 'text-center border-b',
					render : data => formatRupiah(data.toString(), 'Rp ')
				},
				{data: 'created_by_name', name: 'created_by_name', className: 'text-center border-b'},
            ],
            "order": [0, 'desc'],
            "initComplete": function(settings, json) {
                feather.replace();
            },
			"footerCallback": function ( row, data, start, end, display ) {
				let api = this.api();
				let intVal = function (i) {
					return typeof i === 'string' ? i.replace(/[\$,]/g, '')*1 :
						typeof i === 'number' ? i : 0;
				};
				let total = api.column(3).data().reduce((a, b) => intVal(a) + intVal(b), 0 );
					
				$( api.column(0).footer()).html('Total');
				$( api.column(3).footer()).html(formatRupiah(total.toString(), ''));
			},
		});
    }

	$(document).on('click', '#pdf-button', function (e) {  
		e.preventDefault()
		const data = {
			'start_date' : $('#filter-start-date').val() || moment().format('YYYY-MM-DD'),
			'end_date' : $('#filter-end-date').val() || moment().add(1, 'd').format('YYYY-MM-DD'),
			'created_by' : parseInt($('#input-created-by').val()),
			'payment_method_id' : parseInt($('#input-payment-method-id').val())
		}
		$.ajax({
            type: 'POST',
            url: API_URL+"/api/sales_consignment_pdf",
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
	
	function getUsers() {
        $.ajax({
            url: API_URL+"/api/users",
            type: 'GET',
            headers: { 'Authorization': 'Bearer '+TOKEN },
            dataType: 'JSON',
            success: function(res, textStatus, jqXHR){
                let opt = ''
                opt += '<option value=""> Semua </option>'
                $.each(res.data, function (index, item) {  
                    opt += '<option value="'+item.id+'">'+item.name+'</option>'
                })
                $('#input-created-by').html(opt)
            },
            error: function(jqXHR, textStatus, errorThrown){

            },
        })
    }
	
	function getStoreConsignments() {
        $.ajax({
            url: API_URL+"/api/store_consignments",
            type: 'GET',
            headers: { 'Authorization': 'Bearer '+TOKEN },
            dataType: 'JSON',
            success: function(res, textStatus, jqXHR){
                let opt = ''
                opt += '<option value=""> Semua </option>'
                $.each(res.data, function (index, item) {  
                    opt += '<option value="'+item.id+'">'+item.store_name+'</option>'
                })
                $('#input-store-consignment-id').html(opt)
            },
            error: function(jqXHR, textStatus, errorThrown){

            },
        })
    }
</script>
@endsection