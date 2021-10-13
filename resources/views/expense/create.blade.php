@extends('layouts.main')

@section('title', $title)

@section('additionalFileCSS')
	<style>
		.select2.select2-container{
			width: 100% !important
		}
	</style>
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
						<th class="border-b-2 text-center whitespace-no-wrap">Kategori Biaya</th>
						<th class="border-b-2 text-center whitespace-no-wrap">Jumlah</th>
						<th class="border-b-2 text-center whitespace-no-wrap">Deskripsi</th>
						<th class="border-b-2 text-center whitespace-no-wrap">Aksi</th>
					</tr>
				</thead>
				<tbody>
					<tr class="item-0">
						<td>
							<select name="expense_category_id[]" id="input-expense-category-id-0" class="input w-full border mt-2 flex-1"></select>
						</td>
						<td>
							<input type="number" name="amount[]" id="input-amount-0" class="amount input w-full border mt-2 flex-1"/>
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
		<div class="flex px-5 justify-between mb-2">
			<button type="button" class="button btn-add-item w-40 bg-theme-1 text-white">Tambah Pengeluaran</button> 
			<div class="text-right">
				<label for="">Total</label>
				<h4><strong class="total">Rp 0</strong></h4>
			</div>
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
	let index = 0
	setNameCurrentUser()
    getExpenseCategories()
	initSelect2()

	function initSelect2(){
		$("#input-expense-category-id-"+index).select2({
			placeholder: "Silahkan Pilih"
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
				//console.log('id', '#input-expense-category-id-'+index);
                $('#input-expense-category-id-'+index).html(opt)
            },
            error: function(jqXHR, textStatus, errorThrown){

            },
        })
    }
    

	$(document).on('click', '.btn-add-item', function (e) {  
		e.preventDefault()
		index++
		$('#details-table tbody').append(setHtmlItem())
		initSelect2()
		getExpenseCategories()
	})

	$(document).on('click', '.btn-remove-item', function (e) {  
		e.preventDefault()
		const key = $(this).data('key')
		$('.item-'+key).remove()
	})

	function setHtmlItem() {  
		let html = ''
		html += '<tr class="item-'+index+'">'
		html += '	<td>'
		html += '		<select name="expense_category_id[]" id="input-expense-category-id-'+index+'" class="input w-full border mt-2 flex-1"></select>'
		html += '	</td>'
		html += '	<td>'
		html += '		<input type="number" name="amount[]" id="input-amount-'+index+'" class="amount input w-full border mt-2 flex-1"/>'
		html += '	</td>'
		html += '	<td>'
		html += '		<textarea name="description[]" id="input-description-'+index+'" class="input w-full border mt-2 flex-1" rows="2"></textarea>'
		html += '	</td>'
		html += '	<td>'
		html += '		<button data-key="'+index+'" type="button" class="w-6 h-6 rounded flex text-white font-semibold justify-center items-center btn-remove-item bg-theme-6 text-white">'
		html += '			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x mx-auto"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>'
		html += '		</button>'
		html += '	</td>'
		html += '</tr>'
		return html
	}

	$(document).on('keyup', '.amount', function (e) {  
		e.preventDefault()
		countAmount()
	})

	function countAmount() {  
		let total = 0
		$('.amount').each(function (index, element) {  
			total += parseInt($(this).val())
		})
		if (isNaN(total)) {
			total = 0
		}
		$('.total').html(formatRupiah(total.toString(), 'Rp '))
	}

    $( 'form#main-form' ).submit( function( e ) {
        e.preventDefault();
		const data = {
			"expense_details" : []
		}
		
		$('#details-table tbody > tr').each(function (index, element) {  
			let item = {
				'expense_category_id' : parseInt($(this).find('select').val()),
				'amount' : parseInt($(this).find('.amount').val()),
				'description' : $(this).find('textarea').val(),
			}
			data.expense_details.push(item)
		})

		console.log(JSON.stringify(data));
        $.ajax({
            type: 'POST',
            url: API_URL+"/api/expenses",
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
					  window.location.href = "{{ route('expense.index') }}"
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