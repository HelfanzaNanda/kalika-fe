@extends('layouts.main')

@section('title', $title)

@section('additionalFileCSS')

@endsection

@section('content')
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        
    </h2>
	<select id="input-store-id" class="single-select input w-2/4 border mt-2 flex-1"></select>
	<select id="input-user-id" class="single-select input w-2/4 border mt-2 flex-1"></select>
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
<div class="intro-y box mt-5">
    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200">
        <h2 class="font-medium text-base mr-auto">
            Data {{$title}}
        </h2>
    </div>

    <div class="p-5" id="striped-rows-table">
        <div class="preview">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr class="bg-gray-700 dark:bg-dark-1 text-white">
                            <th class="border-b-2 dark:border-dark-5 whitespace-no-wrap" colspan="2">Laporan Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="">
                            <td class="border-b dark:border-dark-5">Penjualan Tunai</td>
                            <td class="border-b dark:border-dark-5">: Rp <span id="sales">0</span></td>
                        </tr>
                        <tr class="bg-gray-200 dark:bg-dark-1">
                            <td class="border-b dark:border-dark-5 text-theme-6">Total HPP</td>
                            <td class="border-b dark:border-dark-5 text-theme-6">: (Rp <span id="total_cogs">0</span>)</td>
                        </tr>
                        <tr class="">
                            <td class="border-b dark:border-dark-5">Penjualan Pesanan</td>
                            <td class="border-b dark:border-dark-5">: Rp <span id="custom_order">0</span></td>
                        </tr>
                        <tr class="bg-gray-200 dark:bg-dark-1">
                            <td class="border-b dark:border-dark-5">Penjualan Konsinyasi</td>
                            <td class="border-b dark:border-dark-5">: Rp <span id="sales_consignment">0</span></td>
                        </tr>
                        <tr class="">
                            <td class="border-b dark:border-dark-5">Pembayaran Piutang</td>
                            <td class="border-b dark:border-dark-5">: Rp <span id="receivable_payment">0</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="preview">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr class="bg-gray-700 dark:bg-dark-1 text-white">
                            <th class="border-b-2 dark:border-dark-5 whitespace-no-wrap" colspan="2">Laporan Pengeluaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="">
                            <td class="border-b dark:border-dark-5">Pembayaran Hutang</td>
                            <td class="border-b dark:border-dark-5">: Rp <span id="debt_payment">0</span></td>
                        </tr>
                        <tr class="bg-gray-200 dark:bg-dark-1">
                            <td class="border-b dark:border-dark-5">Retur Penjualan</td>
                            <td class="border-b dark:border-dark-5">: Rp <span id="sales_return">0</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="preview">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr class="bg-gray-700 dark:bg-dark-1 text-white">
                            <th class="border-b-2 dark:border-dark-5 whitespace-no-wrap" colspan="2">Laporan Biaya (Rp <span id="total_cost">0</span>)</th>
                        </tr>
                    </thead>
                    <tbody id="cost-lists">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200">
        <h2 class="font-medium text-base mr-auto" id="total-profit-loss">
            Total Laba Rugi
        </h2>
    </div>
</div>
@endsection

@section('additionalFileJS')

@endsection

@section('additionalScriptJS')
<script type="text/javascript">
    getProfitLoss();
    getStores();
    getCashiers();
    initSelect2();

	function initSelect2(){
        $(".single-select").select2({
            
        });
    }

	$('#daterangepicker').on('apply.daterangepicker', function(ev, picker) {
		let startDate = picker.startDate.format('YYYY-MM-DD')
		let endDate = picker.endDate.format('YYYY-MM-DD')
		$('#filter-start-date').val(startDate)
		$('#filter-end-date').val(endDate)
		getProfitLoss(startDate, endDate)
  	});

	$('#daterangepicker').on('cancel.daterangepicker', function(ev, picker) {
		$(this).val('');
		getProfitLoss()
	});

	$(document).on('change', '#input-store-id, #input-user-id', function (e) {  
		e.preventDefault()
		getProfitLoss()
	})

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

    function getProfitLoss(startDate = null, endDate = null) {
		if (startDate == null) {
			startDate = moment().startOf('month').format('YYYY-MM-DD')
		}
		if (endDate == null) {
			endDate = moment().endOf('month').format('YYYY-MM-DD')
		}
		let data = {
			start_date : startDate,
			end_date : endDate,
			store_id : $('#input-store-id').val() ? parseInt($('#input-store-id').val()) : 0,
			created_by : $('#input-user-id').val() ? parseInt($('#input-user-id').val()) : 0,
		}
		
        $.ajax({
            url: API_URL+"/api/profit_loss",
            type: 'POST',
            headers: { 'Authorization': 'Bearer '+TOKEN },
			data : JSON.stringify(data),
            dataType: 'JSON',
			contentType: 'application/json',
            success: function(res, textStatus, jqXHR){
                $('#sales').text(formatRupiah(res.data.sales.toString()));
                $('#total_cogs').text(formatRupiah(res.data.total_cogs.toString()));
                $('#custom_order').text(formatRupiah(res.data.custom_order.toString()));
                $('#sales_consignment').text(formatRupiah(res.data.sales_consignment.toString()));
                $('#receivable_payment').text(formatRupiah(res.data.receivable_payment.toString()));
                $('#debt_payment').text(formatRupiah(res.data.debt_payment.toString()));
                $('#sales_return').text(formatRupiah(res.data.sales_return.toString()));
                $('#total_cost').text(formatRupiah(res.data.total_cost.toString()));
                
                costList = '';

                $.each(res.data.costs, function (index, item) {  
                    if (index % 2 == 0) {
                        costList += '<tr class="bg-gray-200 dark:bg-dark-1">';
                    } else {
                        costList += '<tr class="">';
                    }
                    costList += '    <td class="border-b dark:border-dark-5">'+item.name+'</td>';
                    costList += '    <td class="border-b dark:border-dark-5">: Rp '+formatRupiah(item.total.toString())+'</td>';
                    costList += '</tr>';
                });

                $('#cost-lists').html(costList);

                totalSales = res.data.sales - res.data.total_cogs + res.data.custom_order + res.data.sales_consignment + res.data.receivable_payment;
                totalExpense = res.data.debt_payment + res.data.sales_return + res.data.total_cost;
                totalProfitLoss = totalSales - totalExpense;
                if (totalProfitLoss > 0) {
                    $('#total-profit-loss').html("Laba "+formatRupiah(totalProfitLoss.toString(), 'Rp '));
                } else {
                    $('#total-profit-loss').html("Rugi "+formatRupiah(totalProfitLoss.toString(), 'Rp '));
                }
            },
            error: function(jqXHR, textStatus, errorThrown){

            },
        })
    }

	$(document).on('click', '#pdf-button', function (e) {  
		e.preventDefault()
		const data = {
			'start_date' : $('#filter-start-date').val() || moment().startOf('month').format('YYYY-MM-DD'),
			'end_date' : $('#filter-end-date').val() || moment().endOf('month').format('YYYY-MM-DD'),
			'store_id' : $('#input-store-id').val() ? parseInt($('#input-store-id').val()) : 0,
			'created_by' : $('#input-user-id').val() ? parseInt($('#input-user-id').val()) : 0,
		}
		$.ajax({
            type: 'POST',
            url: API_URL+"/api/profit_loss_pdf",
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
                console.log(jqXHR);
            },
        });
	})
</script>
@endsection