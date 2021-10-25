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
		{{-- <button class="button text-white bg-theme-1 shadow-md mr-2" id="add-button">Tambah {{$title}}</button> --}}
	</div>
</div>
<div class="intro-y datatable-wrapper box p-5 mt-5">
	<form id="main-form">
		<div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
			<h2 class="font-medium text-base mr-auto" id="modal-title"></h2>
		</div>

		<div class="p-5 grid grid-cols-12 gap-4 row-gap-3 input-form">
		</div>
		<div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5">
			<button type="button"
				class="modal-close button w-20 border text-gray-700 dark:border-dark-5 dark:text-gray-300 mr-1"
				data-id="main-modal">Cancel</button>
			<button type="submit" class="button w-20 bg-theme-1 text-white">Submit</button>
		</div>
	</form>
</div>
@endsection

@section('additionalFileJS')

@endsection

@section('additionalScriptJS')
<script type="text/javascript">
	getGeneralSettings()


	function getGeneralSettings() {  
		$.ajax({
            url: API_URL+"/api/general_settings",
            type: 'GET',
            headers: { 'Authorization': 'Bearer '+TOKEN },
            dataType: 'JSON',
            success: function(res, textStatus, jqXHR){
                let form = ''
                res.data.forEach(item => {
					form  += '<div class="col-span-12 sm:col-span-6"> '
					form  += '	<label>'+ ucwords(item.item.replace('_', ' '))+'</label> '
					form  += '	<input type="text" name="'+item.item+'" class="input w-full border mt-2 flex-1" id="input-'+item.item+'" value="'+item.value+'"> '
					form  += '</div>'
				});
                $('.input-form').html(form)
            },
            error: function(jqXHR, textStatus, errorThrown){

            },
        })
	}

    $( 'form#main-form' ).submit( function( e ) {
        e.preventDefault();
        var form_data  =  new FormData(this);
		let data = {}
		for (var pair of form_data.entries()) {
			data[pair[0]] = pair[1]
		}

        $.ajax({
            type: 'POST',
            url: API_URL+"/api/general_settings",
            headers: { 'Authorization': 'Bearer '+TOKEN },
            data: data,
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
						location.reload()
                  }
                });
            },
			error: function(jqXHR, textStatus, errorThrown){
				console.log(jqXHR.responseJSON);
			},
        });
    });
</script>
@endsection