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
<div class="intro-y box p-5 mt-5 overflow-x-auto">
    <table class="table">
        <thead>
            <tr>
                <th class="border-b-2 text-center whitespace-no-wrap">Nama Biaya</th>
                <th class="border-b-2 text-center whitespace-no-wrap">Total</th>
            </tr>
        </thead>
		<tfoot>
			<tr>
				<th>Total</th>
				<th></th>
			</tr>
		</tfoot>
        <tbody>
            
        </tbody>
    </table>
</div>
@endsection

@section('additionalFileJS')

@endsection

@section('additionalScriptJS')
<script type="text/javascript">
	getExpenses()

	$('#daterangepicker').on('apply.daterangepicker', function(ev, picker) {
		let startDate = picker.startDate.format('YYYY-MM-DD')
		let endDate = picker.endDate.format('YYYY-MM-DD')
		$('#filter-start-date').val(startDate)
		$('#filter-end-date').val(endDate)
		getExpenses(startDate, endDate)
  	});

	$('#daterangepicker').on('cancel.daterangepicker', function(ev, picker) {
		$(this).val('');
		getExpenses()
	});

	$(document).on('click', '#pdf-button', function (e) {  
		e.preventDefault()
		const data = {
			'start_date' : $('#filter-start-date').val() || moment().startOf('month').format('YYYY-MM-DD'),
			'end_date' : $('#filter-end-date').val() || moment().endOf('month').format('YYYY-MM-DD')
		}
		$.ajax({
            type: 'POST',
            url: API_URL+"/api/expense_pdf",
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

	function getExpenses(startDate = null, endDate = null) {
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
            url: API_URL+"/api/report_expense_datatables",
            type: 'POST',
            headers: { 'Authorization': 'Bearer '+TOKEN },
            dataType: 'JSON',
			data : JSON.stringify(data),
			contentType: 'application/json',
            success: function(res, textStatus, jqXHR){
				let total = 0
				let tr = ''
				res.data.forEach(item => {
					tr += '<tr>'
					tr += '		<td class="border-b">'+item.category_name+'</td>'
					tr += '		<td class="border-b">'+formatRupiah(item.total.toString(), ' ')+'</td>'
					tr += '</tr>'
					total += item.total
				});
				$("table tbody").html(tr)
				$("table tfoot tr").children().eq(1).html(formatRupiah(total.toString(), 'Rp. '))
            },
            error: function(jqXHR, textStatus, errorThrown){

            },
        })
    }
</script>
@endsection

