@extends('layouts.main')

@section('title', $title)

@section('additionalFileCSS')

@endsection

@section('content')
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Data {{$title}}
    </h2>
</div>
<div class="intro-y box mt-3">
	<form id="main-form">
		<div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
			<h2 class="font-medium text-base mr-auto" id="modal-title"></h2>
		</div>
		<div class="px-5 py-3 grid grid-cols-12 gap-4 row-gap-3">
			<div class="col-span-12 sm:col-span-6"> 
				<label>Nama </label> 
				<input type="text" readonly name="name" id="input-name" class="input w-full border mt-2 flex-1"/>
			</div>
			
		</div>
		<div class="px-5">
			<table class="table table-report table-report--bordered display w-full" id="details-table">
				<thead>
					<tr>
						<th class="border-b-2 text-center whitespace-no-wrap">Expense Category</th>
						<th class="border-b-2 text-center whitespace-no-wrap">Amount</th>
						<th class="border-b-2 text-center whitespace-no-wrap">Description</th>
						<th class="border-b-2 text-center whitespace-no-wrap">Aksi</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<select name="expense_category_id[]" id="input-expense-category-id-0" class="single-select input w-full border mt-2 flex-1"></select>
						</td>
						<td>
							<input type="number" name="amount[]" id="input-amount-0" class="input w-full border mt-2 flex-1"/>
						</td>
						<td>
							<textarea name="description[]" id="input-description-0" class="input w-full border mt-2 flex-1" rows="2"></textarea>
						</td>
						<td>
							<button style="display: none" type="button" class="w-6 h-6 rounded flex text-white font-semibold justify-center items-center btn-remove-item bg-theme-6 text-white">
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x mx-auto"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
							</button>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="flex justify-center mb-2">
			<button type="button" class="button btn-add-item w-20 bg-theme-1 text-white">Add Row</button> 
		</div>
		<div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5"> 
			<a href="{{ route('expense.index') }}" type="button" class="modal-close button w-20 border text-gray-700 dark:border-dark-5 dark:text-gray-300 mr-1" data-id="main-modal">Kembali</a> 
			<button type="submit" class="button w-20 bg-theme-1 text-white">Submit</button> 
		</div>
	</form>
</div>
@endsection

@section('additionalFileJS')

@endsection

@section('additionalScriptJS')
<script type="text/javascript">
	setNameCurrentUser()
    getExpenseCategories()
	initSelect2()

	let index = 0

	function initSelect2(){
		$(".single-select").select2({
			placeholder: "Choose One",
			allowClear: true
		});
	}

	function setNameCurrentUser() {  
		const currentUser = localStorage.getItem('_r')
		if (currentUser !== null) {
			const user = JSON.parse(currentUser)
			$('#input-name').val(user.name)
		}
	}

    function getExpenseCategories() {
        $.ajax({
            url: API_URL+"/api/expense_categories",
            type: 'GET',
            headers: { 'Authorization': 'Bearer '+TOKEN },
            dataType: 'JSON',
            success: function(res, textStatus, jqXHR){
                let opt = ''
                opt += '<option value=""> - Pilih Kategori - </option>'
                $.each(res.data, function (index, item) {  
                    opt += '<option value="'+item.id+'">'+item.name+'</option>'
                })
                $('#input-expense-category-id-0').html(opt)
            },
            error: function(jqXHR, textStatus, errorThrown){

            },
        })
    }
    

	$(document).on('click', '.btn-add-item', function (e) {  
		e.preventDefault()
		const newTr = $('#details-table tbody').children().eq(0).clone().appendTo('#details-table tbody')
		$(newTr).find('input').val('')
		$(newTr).find('textarea').val('').change();
		$(newTr).find('select').val('').trigger('change')
		$(newTr).find('button').css('display', '')
	})

	$(document).on('click', '.btn-remove-item', function (e) {  
		e.preventDefault()
		const rowIndex = $(this).closest("tr").index();
		$(`#details-table tbody tr:eq(${rowIndex})`).remove()
	})

    $( 'form#main-form' ).submit( function( e ) {
        e.preventDefault();
        var form_data  =  new FormData(this)
		let data = {}
		for (var pair of form_data.entries()) {
			const arrInt = ['store_id', 'product_id', 'cake_size', 
			'price', 'additional_price', 'discount', 'delivery_cost']
			if (arrInt.includes(pair[0])) {
				data[pair[0]] = parseInt(pair[1])
			} else {	
				data[pair[0]] = pair[1]
			}
		}
        $.ajax({
            type: 'POST',
            url: API_URL+"/api/custom_orders",
            headers: { 'Authorization': 'Bearer '+TOKEN },
            data: JSON.stringify(data),
			contentType: 'application/json',
			dataType: 'JSON',
            beforeSend: function() {
                $('.loading-area').show();
            },
            success: function(res) {
				console.log(res);
                Swal.fire({
                  icon: 'success',
                  title: 'Sukses',
                  text: res.message
                }).then((result) => {
                  if (result.isConfirmed) {
					  window.location.href = "{{ route('custom.order.index') }}"
                  }
                });
            },
			error: function(jqXHR, textStatus, errorThrown){
				console.log(jqXHR.responseJSON);
			},
        })
    });
</script>
@endsection