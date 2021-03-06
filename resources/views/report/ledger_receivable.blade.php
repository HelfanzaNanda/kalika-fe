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
<div class="intro-y box mt-3">
    <div class="p-5" id="striped-rows-table">
        <div class="preview">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
			                <th class="border-b-2 text-center whitespace-no-wrap">Tanggal</th>
			                <th class="border-b-2 text-center whitespace-no-wrap">No. Ref</th>
			                <th class="border-b-2 text-center whitespace-no-wrap">Kustomer</th>
			                {{-- <th class="border-b-2 text-center whitespace-no-wrap">Keterangan</th> --}}
			                <th class="border-b-2 text-center whitespace-no-wrap">Debit</th>
			                <th class="border-b-2 text-center whitespace-no-wrap">Kredit</th>
			                <th class="border-b-2 text-center whitespace-no-wrap">Saldo</th>
                        </tr>
                    </thead>
                    <tbody id="receivable-data">

                    </tbody>
                    <thead>
                        <tr>
			                <td colspan="3" class="border-b-2 text-center whitespace-no-wrap text-right font-bold">Total</td>
			                <td class="border-b-2 text-center whitespace-no-wrap text-right font-bold" id="total-debit">0</td>
			                <td class="border-b-2 text-center whitespace-no-wrap text-right font-bold" id="total-credit">0</td>
			                <td class="border-b-2 text-center whitespace-no-wrap text-right font-bold" id="total-balance">0</td>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('additionalFileJS')

@endsection

@section('additionalScriptJS')
<script type="text/javascript">
	
	getLedgerReceivable();

	$('#daterangepicker').on('apply.daterangepicker', function(ev, picker) {
		let startDate = picker.startDate.format('YYYY-MM-DD')
		let endDate = picker.endDate.format('YYYY-MM-DD')
		$('#filter-start-date').val(startDate)
		$('#filter-end-date').val(endDate)
		getLedgerReceivable(startDate, endDate);
  	});

	$('#daterangepicker').on('cancel.daterangepicker', function(ev, picker) {
		$(this).val('');
		getLedgerReceivable();
	});


	$(document).on('click', '#pdf-button', function (e) {  
		e.preventDefault()
		const data = {
			'start_date' : $('#filter-start-date').val() || moment().startOf('month').format('YYYY-MM-DD'),
			'end_date' : $('#filter-end-date').val() || moment().endOf('month').format('YYYY-MM-DD')
		}
		$.ajax({
            type: 'POST',
            url: API_URL+"/api/ledger_receivable_pdf",
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
	
	function getLedgerReceivable(startDate = null, endDate = null) {
		if (startDate == null) {
			startDate = moment().startOf('month').format('YYYY-MM-DD')
		}
		if (endDate == null) {
			endDate = moment().endOf('month').format('YYYY-MM-DD')
		}
		let data = {
			start_date : startDate,
			end_date : endDate,
		}
        $.ajax({
            url: API_URL+"/api/ledger_receivables",
            type: 'POST',
            headers: { 'Authorization': 'Bearer '+TOKEN },
            dataType: 'JSON',
			data : JSON.stringify(data),
			contentType: 'application/json',
            success: function(res, textStatus, jqXHR){
				let totalDebit = 0;
				let totalCredit = 0;
				let html = ''
				
				res.data.forEach(item => {
					totalDebit += item.debit;
					totalCredit += item.credit;
					html += '<tr>'
					html += '		<td class="border-b">'+moment(item.date).format('DD MMM YYYY HH:mm:ss')+'</td>'
					html += '		<td class="border-b">'+item.number+'</td>'
					html += '		<td class="border-b">'+item.customer+'</td>'
					// html += '		<td class="border-b">'+item.description+'</td>'
					html += '		<td class="border-b text-right">'+formatRupiah(item.debit.toString(), 'Rp')+'</td>'
					html += '		<td class="border-b text-right">'+formatRupiah(item.credit.toString(), 'Rp')+'</td>'
					html += '		<td class="border-b text-right">'+formatRupiah(item.balance.toString(), 'Rp')+'</td>'
					html += '</tr>'
				});

				$("#receivable-data").html(html)
				$('#total-debit').text(formatRupiah(totalDebit.toString(), 'Rp'));
				$('#total-credit').text(formatRupiah(totalCredit.toString(), 'Rp'));
				$('#total-balance').text(formatRupiah((totalDebit - totalCredit).toString(), 'Rp'));
            },
            error: function(jqXHR, textStatus, errorThrown){

            },
        })
	}
</script>
@endsection