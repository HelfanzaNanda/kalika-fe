@extends('layouts.main')

@section('title', $title)

@section('additionalFileCSS')

@endsection

@section('content')
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Data {{$title}}
    </h2>
    {{-- <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
        <button class="button text-white bg-theme-1 shadow-md mr-2" id="add-button">Tambah {{$title}}</button>
    </div> --}}
</div>
<div class="intro-y datatable-wrapper box p-5 mt-5">
    <table class="table table-report table-report--bordered display datatable w-full" id="main-table">
        <thead>
            <tr>
                <th>Id</th>
                <th class="border-b-2 text-center whitespace-no-wrap">Toko</th>
                <th class="border-b-2 text-center whitespace-no-wrap">Kustomer</th>
                <th class="border-b-2 text-center whitespace-no-wrap">Uang Kasir</th>
                <th class="border-b-2 text-center whitespace-no-wrap">Persentase Diskon</th>
                <th class="border-b-2 text-center whitespace-no-wrap">Value Diskon</th>
                <th class="border-b-2 text-center whitespace-no-wrap">Total</th>
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
					<input type="number" name="total" id="input-total" class="input w-full border mt-2 flex-1" > 
                </div>
				<div class="col-span-12 sm:col-span-6"> 
					<label>Konsiyasi</label> 
					<select name="store_consignment_id" id="input-store-consignment-id" class="single-select input w-full border mt-2 flex-1"></select> 
				</div>
            </div>
            <div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5"> 
                <button type="button" class="modal-close button w-20 border text-gray-700 dark:border-dark-5 dark:text-gray-300 mr-1" data-id="main-modal">Cancel</button> 
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
    drawDatatable()

    function drawDatatable() {
        $("#main-table").DataTable({
            "destroy": true,
            "pageLength": 10,
            "processing": true,
            "serverSide": true,
            "ajax":{
                "url": API_URL+"/api/report_sale_datatables",
                "headers": { 'Authorization': 'Bearer '+TOKEN },
                "dataType": "json",
                "type": "POST",
                "data":function(d) { 
                  
                },
            },
            "columns": [
                {data: 'id', name: 'id', width: '5%', "visible": false },
                {data: 'store_name', name: 'store_name', className: 'text-center border-b'},
                {data: 'customer_name', name: 'customer_name', className: 'text-center border-b'},
                {data: 'cash_register_cash_in_hand', name: 'cash_register_cash_in_hand', className: 'text-center border-b'},
                {data: 'discount_percentage', name: 'discount_percentage', className: 'text-center border-b'},
                {data: 'discount_value', name: 'discount_value', className: 'text-center border-b'},
                {data: 'total', name: 'total', className: 'text-center border-b'},
                // {data: 'action', name: 'action', orderable: false, className: 'border-b w-5'}
            ],
            "order": [0, 'desc'],
            "initComplete": function(settings, json) {
                feather.replace();
            }
        });
    }
</script>
@endsection