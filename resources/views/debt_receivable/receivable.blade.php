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
    <table class="table table-report table-report--bordered display datatable w-full" id="main-table">
        <thead>
            <tr>
                <th>Id</th>
                <th class="border-b-2 text-center whitespace-no-wrap">Kustomer</th>
                <th class="border-b-2 text-center whitespace-no-wrap">Total Piutang</th>
                <th class="border-b-2 text-center whitespace-no-wrap">Sisa Piutang</th>
                <th class="border-b-2 text-center whitespace-no-wrap">Tanggal</th>
                <th class="border-b-2 text-center whitespace-no-wrap">Note</th>
                <th class="border-b-2 text-center whitespace-no-wrap">Dibuat Oleh</th>
                <th class="border-b-2 whitespace-no-wrap">Aksi</th>
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
                    <label>Receivables</label> 
					<input type="number" name="receivables" id="input-receivables" class="input w-full border mt-2 flex-1" > 
                </div>
                <div class="col-span-12 sm:col-span-6"> 
                    <label>Note</label> 
					<textarea name="note" id="input-note" class="input w-full border mt-2 flex-1" rows="3"></textarea>
                </div>
				<div class="col-span-12 sm:col-span-6"> 
					<label>Date</label> 
					<input type="text" name="date" id="input-date" class="datepicker input w-full border mt-2 flex-1"> 
				</div>
				<div class="col-span-12 sm:col-span-6"> 
					<label>Customer</label> 
					<select name="customer_id" id="input-customer-id" class="single-select input w-full border mt-2 flex-1"></select> 
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

<div class="modal" id="pay-modal">
   <div class="modal__content modal__content--xl">
        <form id="receivable-detail-form">
            <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto" id="modal-title"></h2>
            </div>
            <div class="p-5 grid grid-cols-12 gap-4 row-gap-3">
                <div class="col-span-12 sm:col-span-8">
                    <table class="table table-report table-report--bordered display datatable w-full" id="receivable-detail-table">
                        <thead>
                            <input type="hidden" name="id" id="input-receivable-id" value="0"> 
                            <tr>
                                <th>Id</th>
                                <th class="border-b-2 text-center whitespace-no-wrap">Tgl Bayar</th>
                                <th class="border-b-2 text-center whitespace-no-wrap">Metode</th>
                                <th class="border-b-2 text-center whitespace-no-wrap">Total</th>
                                <th class="border-b-2 text-center whitespace-no-wrap">Ket.</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
                <div class="col-span-12 sm:col-span-4">
                    <label>Metode Pembayaran :</label>
                    <select id="input-payment-method" class="single-select select2 input w-full border mt-2 flex-1"></select>

                    <label>Nominal :</label>
                    <input type="number" class="input w-full border mt-2 flex-1" placeholder="100000" id="input-receivable-amount">

                    <button type="button" class="button w-20 bg-theme-1 text-white mt-4" id="pay-now">Bayar</button> 
                </div>
            </div>
            <div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5"> 
                <button type="button" class="modal-close button w-20 border text-gray-700 dark:border-dark-5 dark:text-gray-300 mr-1" data-id="main-modal">Tutup</button> 
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
	initSelect2()
    getPaymentMethods();

	function initSelect2(){
		$('.single-select').select2({
			placeholder: "Silahkan Pilih",
		});
	}

    $(document).on("click","button#add-button",function(e) {
		e.preventDefault()
		getCustomers()
		getStoreConsignments()
		resetAllInputOnForm('#main-form')
        $('h2#modal-title').text('Tambah {{$title}}')
        $('#main-modal').modal('show');
    });

    $(document).on("click","button#pay-data",function() {
        let id = $(this).data('id');
        $('#input-receivable-id').val(id);
        receivableDatatable(id);
        $('#pay-modal').modal('show');
    });

    $(document).on("click", "button#edit-data",function(e) {
      e.preventDefault();
	  getCustomers()
	   getStoreConsignments()
	  resetAllInputOnForm('#main-form')
      let id = $(this).data('id');
      $.ajax({
        url: API_URL+"/api/receivables/"+id,
        type: 'GET',
        headers: { 'Authorization': 'Bearer '+TOKEN },
        dataType: 'JSON',
        success: function(res, textStatus, jqXHR){
          $('#input-id').val(res.data.id)
          $('#input-total').val(res.data.total)
          $('#input-receivables').val(res.data.receivables)
          $('#input-note').val(res.data.note)
          $('#input-customer-id').val(res.data.customer_id).trigger('change')
          $('#input-store-consignment-id').val(res.data.store_consignment_id).trigger('change')
		  $('#input-date').val(moment(res.data.date).format('YYYY-MM-DD'))
          $('#modal-title').text('Edit {{$title}}');
          $('#main-modal').modal('show');
        },
        error: function(jqXHR, textStatus, errorThrown){

        },
      });
    });

    $( 'form#main-form' ).submit( function( e ) {
        e.preventDefault();
        var form_data  =  new FormData(this)
		let data = {}
		for (var pair of form_data.entries()) {
			if (['id', 'total', 'receivables', 'customer_id', 'store_consignment_id'].includes(pair[0])) {
				data[pair[0]] = parseInt(pair[1])
			}else{	
				data[pair[0]] = pair[1]
			}
		}
        $.ajax({
            type: 'POST',
            url: API_URL+"/api/receivables",
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
                    $('#main-modal').modal('hide');
                    $('#main-table').DataTable().ajax.reload( function ( json ) {
                        feather.replace();
                    });
                  }
                });
            },
			error: function(jqXHR, textStatus, errorThrown){
				console.log(jqXHR.responseJSON);
			},
        })
    });

    function receivableDatatable(id) {
        $("#receivable-detail-table").DataTable({
            "destroy": true,
            "pageLength": 10,
            "processing": true,
            "serverSide": true,
            "searching": false,
            "ordering": false,
            "info": false,
            "paging": false,
            "ajax":{
                "url": API_URL+"/api/receivable_detail_datatables?receivable_id="+id,
                "headers": { 'Authorization': 'Bearer '+TOKEN },
                "dataType": "json",
                "type": "POST",
                "data":function(d) { 
                  
                },
            },
            "columns": [
                {data: 'id', name: 'id', width: '5%', "visible": false },
                { data: 'date_pay', name: 'date_pay', className: 'text-center border-b', render : data => moment(data).format('DD MMM YYYY HH:mm:ss') },
                { data: 'payment_method', name: 'payment_method', className: 'text-center border-b'},
                { data: 'total', name: 'total', className: 'text-center border-b', render : data => formatRupiah(data.toString(), 'Rp ') },
                { data: 'note', name: 'note', className: 'text-center border-b'},
            ],
            "order": [0, 'desc'],
            "initComplete": function(settings, json) {
                feather.replace();
            }
        });
    }

    function drawDatatable() {
        $("#main-table").DataTable({
            "destroy": true,
            "pageLength": 10,
            "processing": true,
            "serverSide": true,
            "ajax":{
                "url": API_URL+"/api/receivable_datatables",
                "headers": { 'Authorization': 'Bearer '+TOKEN },
                "dataType": "json",
                "type": "POST",
                "data":function(d) { 
                  
                },
            },
            "columns": [
                {data: 'id', name: 'id', width: '5%', "visible": false },
                { data: 'store_consignment_name', name: 'store_consignment_name', className: 'text-center border-b' },
                { data: 'total', name: 'total', className: 'text-center border-b', render : data => formatRupiah(data.toString(), 'Rp ') },
                { data: 'receivables', name: 'receivables', className: 'text-center border-b', render : data => formatRupiah(data.toString(), 'Rp ') },
                { data: 'date', name: 'date', className: 'text-center border-b', render : data => moment(data || '').format('DD MMM YYYY hh:mm:ss') },
                {data: 'note', name: 'note', className: 'text-center border-b'},
                {data: 'user_name', name: 'user_name', className: 'text-center border-b'},
                {data: 'action', name: 'action', orderable: false, className: 'border-b w-5'}
            ],
            "order": [0, 'desc'],
            "initComplete": function(settings, json) {
                feather.replace();
            }
        });
    }

    $(document).on('click', 'button#delete-data', function( e ) {
        e.preventDefault();
        let id = $(this).data('id');

        Swal.fire({
          title: "Apakah anda yakin?",
          text: "Anda tidak bisa memulihkan data ini",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
                type: 'DELETE',
                url: API_URL+"/api/receivables/"+id,
                headers: {
                  'Authorization': 'Bearer '+TOKEN
                },
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                beforeSend: function() {
                    $('.loading-area').show();
                },
                success: function(res) {
                    Swal.fire(
                      'Terhapus!',
                      'Data anda telah dihapus.',
                      'success'
                    )
                    $('#main-table').DataTable().ajax.reload( function ( json ) {
                        feather.replace();
                    } );
                }
            })
          }
        })
    });

	function getCustomers() {
        $.ajax({
            url: API_URL+"/api/customers",
            type: 'GET',
            headers: { 'Authorization': 'Bearer '+TOKEN },
            dataType: 'JSON',
            success: function(res, textStatus, jqXHR){
                let opt = ''
                opt += '<option value=""> - Pilih Customer - </option>'
                $.each(res.data, function (index, item) {  
                    opt += '<option value="'+item.id+'">'+item.name+'</option>'
                })
                $('#input-customer-id').html(opt)
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
                opt += '<option value=""> - Pilih Konsiyasi - </option>'
                $.each(res.data, function (index, item) {  
                    opt += '<option value="'+item.id+'">'+item.store_name+'</option>'
                })
                $('#input-store-consignment-id').html(opt)
            },
            error: function(jqXHR, textStatus, errorThrown){

            },
        })
    }

    function getPaymentMethods() {
        $.ajax({
            url: API_URL+"/api/payment_methods",
            type: 'GET',
            headers: { 'Authorization': 'Bearer '+TOKEN },
            dataType: 'JSON',
            success: function(res, textStatus, jqXHR){
                let opt = ''
                opt += '<option value=""> - Pilih Metode Pembayaran - </option>'
                $.each(res.data, function (index, item) {  
                    opt += '<option value="'+item.id+'">'+item.name+'</option>'
                })
                $('#input-payment-method').html(opt)
            },
            error: function(jqXHR, textStatus, errorThrown){

            },
        })
    }

    $(document).on("click","button#pay-now",function() {
        let data = {}
        data.receivable_id = parseInt($('#input-receivable-id').val());
        data.total = parseFloat($('#input-receivable-amount').val());
        data.payment_method_id = parseInt($('#input-payment-method').find(':selected').val());

        $.ajax({
            type: 'POST',
            url: API_URL+"/api/receivable_details",
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
                    $('#input-receivable-amount').val('');
                    $('#input-payment-method').val('').trigger('change');
                    $('#main-table').DataTable().ajax.reload( function ( json ) {
                        feather.replace();
                    });
                    $('#receivable-detail-table').DataTable().ajax.reload();
                  }
                });
            },
            error: function(jqXHR, textStatus, errorThrown){
                Swal.fire({
                  icon: 'error',
                  title: 'Perhatian!',
                  text: jqXHR.responseJSON.message
                }).then((result) => {
                  if (result.isConfirmed) {
                    $('#input-receivable-amount').val('');
                    $('#input-payment-method').val('').trigger('change');
                  }
                });
            },
        });
    });
</script>
@endsection