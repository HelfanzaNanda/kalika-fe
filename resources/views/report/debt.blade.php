@extends('layouts.main')

@section('title', $title)

@section('additionalFileCSS')
	<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
@endsection

@section('content')
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
	<h2 class="text-lg font-medium mr-auto">
		Data {{$title}}
	</h2>
	<div class="w-full sm:w-auto flex mt-4 sm:mt-0">
		<div class="sm:ml-auto mr-3 mt-3 sm:mt-0 relative text-gray-700 dark:text-gray-300">
			<i data-feather="calendar" class="w-4 h-4 z-10 absolute my-auto inset-y-0 ml-3 left-0"></i>
			<input id="daterangepicker" type="text" data-daterange="true"
				class="datepicker input w-full sm:w-56 box pl-10">
			<input type="hidden" name="filter_start_date" id="filter-start-date">
			<input type="hidden" name="filter_end_date" id="filter-end-date">
		</div>
		<button class="button text-white bg-theme-1 shadow-md mr-2" id="pdf-button">PDF</button>
	</div>
</div>
<div class="intro-y datatable-wrapper box p-5 mt-5">
	<table class="table table-report table-report--bordered display datatable w-full" id="main-table">
		<thead>
			<tr>
				<th>Id</th>
				<th class="border-b-2 text-center whitespace-no-wrap">Supplier</th>
                <th class="border-b-2 text-center whitespace-no-wrap">Total Hutang</th>
                <th class="border-b-2 text-center whitespace-no-wrap">Sisa Hutang</th>
                <th class="border-b-2 text-center whitespace-no-wrap">Tanggal</th>
                <th class="border-b-2 text-center whitespace-no-wrap">Note</th>
                <th class="border-b-2 text-center whitespace-no-wrap">Dibuat Oleh</th>
			</tr>
		</thead>
		<tbody>

		</tbody>
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
					<label>Total</label>
					<input type="number" name="total" id="input-total" class="input w-full border mt-2 flex-1">
				</div>
				<div class="col-span-12 sm:col-span-6">
					<label>Konsiyasi</label>
					<select name="store_consignment_id" id="input-store-consignment-id"
						class="single-select input w-full border mt-2 flex-1"></select>
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
<script src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
@endsection

@section('additionalScriptJS')
<script type="text/javascript">
	drawDatatable()

	$('#daterangepicker').on('apply.daterangepicker', function(ev, picker) {
		$('#filter-start-date').val(picker.startDate.format('YYYY-MM-DD'))
		$('#filter-end-date').val(picker.endDate.format('YYYY-MM-DD'))
		$('#main-table').DataTable().ajax.reload( function ( json ) {
			feather.replace();
		} );
  	});

	$('#daterangepicker').on('cancel.daterangepicker', function(ev, picker) {
		$(this).val('');
		$('#main-table').DataTable().ajax.reload( function ( json ) {
			feather.replace();
		} );
	});

    function drawDatatable() {
        $("#main-table").DataTable({
            "destroy": true,
            "pageLength": 10,
            "processing": true,
            "serverSide": true,
            "ajax":{
                "url": API_URL+"/api/report_debt_datatables",
                "headers": { 'Authorization': 'Bearer '+TOKEN },
                "dataType": "json",
                "type": "POST",
                "data":function(d) { 
                  d.start_date = $('#filter-start-date').val() || moment().startOf('month').format('YYYY-MM-DD')
                  d.end_date = $('#filter-end-date').val() || moment().endOf('month').format('YYYY-MM-DD')
                },
            },
            "columns": [
                {data: 'id', name: 'id', width: '5%', "visible": false },
                { data: 'supplier_name', name: 'supplier_name', className: 'text-center border-b'},
                { data: 'total', name: 'total', className: 'text-center border-b', render : data => formatRupiah(data.toString(), 'Rp ') },
                { data: 'debts', name: 'debts', className: 'text-center border-b', render : data => formatRupiah(data.toString(), 'Rp ') },
                { data: 'date', name: 'date', className: 'text-center border-b', render : data => moment(data).format('DD MMM YYYY hh:mm:ss') },
                {data: 'note', name: 'note', className: 'text-center border-b'},
                {data: 'user_name', name: 'user_name', className: 'text-center border-b'},
                // {data: 'action', name: 'action', orderable: false, className: 'border-b w-5'}
            ],
            "order": [0, 'desc'],
        });
    }


	$(document).on('click', '#pdf-button', function (e) {  
		e.preventDefault()
		const data = {
			'start_date' : $('#filter-start-date').val() || moment().startOf('month').format('YYYY-MM-DD'),
			'end_date' : $('#filter-end-date').val() || moment().endOf('month').format('YYYY-MM-DD')
		}
		$.ajax({
            type: 'POST',
            url: API_URL+"/api/debt_pdf",
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
				//console.log(res);
            },
            error: function(jqXHR, textStatus, errorThrown){
                console.log(jqXHR);
            },
        });
	})
	
</script>
@endsection