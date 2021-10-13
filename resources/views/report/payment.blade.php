@extends('layouts.main')

@section('title', $title)

@section('additionalFileCSS')
	<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
@endsection

@section('content')
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        
    </h2>
    {{-- <div class="w-full sm:w-auto flex mt-4 sm:mt-0"> --}}
        {{-- <div class="sm:ml-auto mr-3 mt-3 sm:mt-0 relative text-gray-700 dark:text-gray-300"> --}}
            <select id="input-store-id" class="single-select input w-2/4 border mt-2 flex-1"></select>
            <select id="input-user-id" class="single-select input w-2/4 border mt-2 flex-1"></select>
        {{-- </div> --}}
    {{-- </div> --}}
    <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
        <div class="sm:ml-auto mr-3 mt-3 sm:mt-0 relative text-gray-700 dark:text-gray-300">
            <i data-feather="calendar" class="w-4 h-4 z-10 absolute my-auto inset-y-0 ml-3 left-0"></i>
            <input id="daterangepicker" type="text" data-daterange="true"
                class="datepicker input w-full sm:w-56 box pl-10">
                <input type="hidden" name="filter_start_date" id="filter-start-date">
                <input type="hidden" name="filter_end_date" id="filter-end-date">
        </div>
        {{-- <button class="button text-white bg-theme-1 shadow-md mr-2" id="pdf-button">PDF</button> --}}
    </div>
</div>
<div class="intro-y datatable-wrapper box p-5 mt-5">
	<table class="table table-report table-report--bordered display datatable w-full" id="main-table">
		<thead>
			<tr>
				<th>Id</th>
				<th class="border-b-2 text-center whitespace-no-wrap">No. Ref</th>
				<th class="border-b-2 text-center whitespace-no-wrap">Tipe</th>
				<th class="border-b-2 text-center whitespace-no-wrap">Total</th>
				<th class="border-b-2 text-center whitespace-no-wrap">Metode Pembayaran</th>
				<th class="border-b-2 text-center whitespace-no-wrap">Dibuat Pada</th>
				<th class="border-b-2 text-center whitespace-no-wrap">Dibuat Oleh</th>
				{{-- <th class="border-b-2 whitespace-no-wrap">Action</th> --}}
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
    getStores();
    getCashiers();
    initSelect2();

    function initSelect2(){
        $(".single-select").select2({
            
        });
    }

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
                "url": API_URL+"/api/payment_datatables",
                "headers": { 'Authorization': 'Bearer '+TOKEN },
                "dataType": "json",
                "type": "POST",
                "data":function(d) { 
                  d.start_date = $('#filter-start-date').val()
                  d.end_date = $('#filter-end-date').val()
                },
            },
            "columns": [
                { data: 'id', name: 'id', width: '5%', "visible": false },
                { data: 'number', name: 'number', className: 'text-center border-b' },
                { data: 'model', name: 'model', className: 'text-center border-b',
                	render : (data) => {
                        console.log(data)
                        if (data == 'PurchaseOrder') {
                        	return "Order Pembelian";
                        } else if (data == 'SalesConsignment') {
                        	return "Penjualan Konsinyasi";
                        } else if (data == 'Sales') {
                        	return "Penjualan";
                        } else if (data == 'CustomOrder') {
                        	return "Penjualan Pesanan";
                        }
                        return data
                    }
                },
                { data: 'total', name: 'total', className: 'text-center border-b', render : data => formatRupiah(data.toString(), 'Rp ') },
                { data: 'payment_method', name: 'payment_method', className: 'text-center border-b'},
                { data: 'created_at', name: 'created_at', className: 'text-center border-b', render : data => moment(data).format('DD MMMM YYYY') },
                { data: 'created_by_name', name: 'created_by_name', className: 'text-center border-b'},
                // {data: 'action', name: 'action', orderable: false, className: 'border-b w-5'}
            ],
            "order": [0, 'desc'],
			dom: 'Bfrtip',
            // lengthChange: false,
			buttons: [
				'copy', 'csv', 'excel', 'pdf', 'print'
				// {
				// 	extend: 'pdf',
				// 	customize: function(doc) {
				// 		doc.content[1].table.widths =
				// 			Array(doc.content[1].table.body[0].length + 1).join('*').split('');
				// 	},
				// 	footer: false,
				// 	exportOptions: {
				// 		modifier: {
				// 			order: 'index',
				// 			page: 'all',
				// 			search: 'none'
				// 		},
				// 		columns: [1, 2, 3, 4]
				// 	},
				// 	action: newExportAction,
				// 	title: 'Laporan Hutang'
				// },
			],
            // "initComplete": function(settings, json) {
            //     feather.replace();
            // }
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
                opt += '<option value=""> Pilih Toko </option>'
                opt += '<option value="0"> Semua Toko </option>'
                $.each(res.data, function (index, item) {  
                    opt += '<option value="'+item.id+'">'+item.name+'</option>'
                })
                $('#input-store-id').html(opt)
            },
            error: function(jqXHR, textStatus, errorThrown){

            },
        })
    }

    function getCashiers() {
        $.ajax({
            url: API_URL+"/api/users",
            type: 'GET',
            headers: { 'Authorization': 'Bearer '+TOKEN },
            dataType: 'JSON',
            success: function(res, textStatus, jqXHR){
                let opt = ''
                opt += '<option value=""> Pilih Kasir </option>'
                opt += '<option value="0"> Semua Kasir </option>'
                $.each(res.data, function (index, item) {  
                    opt += '<option value="'+item.id+'">'+item.name+'</option>'
                })
                $('#input-user-id').html(opt)
            },
            error: function(jqXHR, textStatus, errorThrown){

            },
        })
    }
</script>
@endsection