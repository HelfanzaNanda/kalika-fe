@extends('layouts.main')

@section('title', $title)

@section('additionalFileCSS')

@endsection

@section('content')
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        {{$title}}
    </h2>
    <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
        {{-- <a href="javascript:;" data-toggle="modal" data-target="#new-order-modal" class="button text-white bg-theme-1 shadow-md mr-2">New Order</a>  --}}
        <div class="pos-dropdown dropdown relative ml-auto sm:ml-0">
            <button class="dropdown-toggle button px-2 box text-gray-700 dark:text-gray-300">
                <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-feather="chevron-down"></i> </span>
            </button>
            <div class="pos-dropdown__dropdown-box dropdown-box mt-10 absolute top-0 right-0 z-20">
                <div class="dropdown-box__content box dark:bg-dark-1 p-2" id="latest-invoice-list">
                    
                </div>
            </div>
        </div>
    </div>
</div>
<div class="pos intro-y grid grid-cols-12 gap-5 mt-5">
    <!-- BEGIN: Item List -->
    <div class="intro-y col-span-12 lg:col-span-8">
        <div class="mt-4 mb-4">
            <button class="button button--lg w-full text-white bg-theme-1 shadow-md ml-auto" id="category-btn">Pilih Kategori</button>
        </div>
        <div class="lg:flex intro-y">
            <div class="relative text-gray-700 dark:text-gray-300 w-full">
                <input type="text" class="input input--lg w-full box pr-10 placeholder-theme-13" placeholder="Cari Produk..." id="search-product">
                <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-feather="search"></i> 
            </div>
        </div>

        <div class="grid grid-cols-12 gap-5 mt-5 pt-5 border-t border-theme-5" id="product-list">

        </div>
    </div>
    <!-- END: Item List -->
    <!-- BEGIN: Ticket -->
    <div class="col-span-12 lg:col-span-4">
        <div class="box flex p-5 mt-3">
            <div class="w-full relative text-gray-700">
                <label>Pilih Toko Konsinyasi :</label>
                <select id="input-store-consignment-id" class="single-select select2 input w-full border mt-4 flex-1"></select>
            </div>
        </div>
        <div class="pos__ticket box p-2 mt-5" id="cart-list">
            
        </div>
        <div class="box p-5 mt-5">
            <div class="flex">
                <div class="mr-auto">Subtotal</div>
                <div id="subtotal">Rp 0</div>
            </div>
            <div class="flex mt-4">
                <div class="mr-auto">Diskon</div>
                <div class="text-theme-6"><input type="text" class="input w-full bg-gray-200 pr-10 placeholder-theme-13" placeholder="Nominal Diskon..." id="discount"></div>
            </div>
{{--                     <div class="flex mt-4">
                <div class="mr-auto">Tax</div>
                <div>15%</div>
            </div> --}}
            <div class="flex mt-4 pt-4 border-t border-gray-200 dark:border-dark-5">
                <div class="mr-auto font-medium text-base">Total</div>
                <div class="font-medium text-base" id="total">Rp 0</div>
            </div>
        </div>
        <div class="flex mt-5">
            <button class="button w-full border border-gray-400 dark:border-dark-5 text-gray-600 dark:text-gray-300">Kosongkan Pesanan</button>
        </div>
        <div class="flex mt-5">
             <button class="button w-full inline-block mr-1 mb-2 border border-theme-1 text-theme-1 dark:border-theme-10 dark:text-theme-10">Simpan Ke Draft</button>
        </div>
        <div class="flex mt-5">
            <button class="button w-full text-white bg-theme-1 shadow-md ml-auto" id="pay">Bayar</button>
        </div>
    </div>
    <!-- END: Ticket -->
</div>
<!-- BEGIN: New Order Modal -->
<div class="modal" id="pay-modal">
    <div class="modal__content">
        <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
            <h2 class="font-medium text-base mr-auto">
                Pembayaran
            </h2>
        </div>
        <div class="p-5 grid grid-cols-12 gap-4 row-gap-3">
            <div class="col-span-12">
                <label>TOTAL :</label>
                <h1 class="text-4xl font-medium leading-none text-center" id="pay-sales-total">0</h1>
            </div>
            <div class="col-span-12">
                <label>Metode Pembayaran :</label>
                <select id="input-payment-method" class="single-select select2 input w-full border mt-2 flex-1"></select>
                <input type="text" class="input w-full border mt-2 flex-1" placeholder="Catatan" id="input-payment-method-note">
            </div>
            <div class="col-span-12">
                <label>Jumlah Bayar :</label>
                <div class="grid grid-cols-12 gap-5 p-5">
                    <div class="col-span-4 sm:col-span-4 xxl:col-span-3 box bg-theme-5 p-5 cursor-pointer zoom-in" id="pay-amount" data-amount="20000">
                        <div class="font-medium text-base">20rb</div>
                    </div>
                    <div class="col-span-4 sm:col-span-4 xxl:col-span-3 box bg-theme-5 p-5 cursor-pointer zoom-in" id="pay-amount" data-amount="50000">
                        <div class="font-medium text-base">50rb</div>
                    </div>
                    <div class="col-span-4 sm:col-span-4 xxl:col-span-3 box bg-theme-5 p-5 cursor-pointer zoom-in" id="pay-amount" data-amount="100000">
                        <div class="font-medium text-base">100rb</div>
                    </div>
                    <div class="col-span-4 sm:col-span-4 xxl:col-span-3 box bg-theme-5 p-5 cursor-pointer zoom-in" id="pay-amount" data-amount="200000">
                        <div class="font-medium text-base">200rb</div>
                    </div>
                    <div class="col-span-4 sm:col-span-4 xxl:col-span-3 box bg-theme-5 p-5 cursor-pointer zoom-in" id="pay-amount" data-amount="300000">
                        <div class="font-medium text-base">300rb</div>
                    </div>
                    <div class="col-span-4 sm:col-span-4 xxl:col-span-3 box bg-theme-5 p-5 cursor-pointer zoom-in" id="pay-amount" data-amount="0">
                        <div class="font-medium text-base text-center">PAS</div>
                    </div>
                </div>
                <input type="text" class="input w-full border mt-2 flex-1" placeholder="Jumlah Bayar" id="input-pay-amount" value="0">
            </div>

            <div class="col-span-12">
                <label>Kembalian :</label>
                <h1 class="text-4xl font-medium leading-none text-center text-theme-6" id="change">0</h1>
            </div>
        </div>
        <div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5">
            <button type="button" data-dismiss="modal" class="button w-32 border dark:border-dark-5 text-gray-700 dark:text-gray-300 mr-1">Cancel</button>
            <button type="button" class="button w-32 bg-theme-1 text-white" id="finish-payment-btn">Selesai</button>
        </div>
    </div>
</div>
<!-- END: New Order Modal -->
<!-- BEGIN: Add Item Modal -->
<div class="modal" id="cart-product-detail">
    <div class="modal__content">
        <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
            <input type="hidden" id="cart-product-detail-product-id">
            <h2 class="font-medium text-base mr-auto" id="cart-product-detail-title">
                Loading...
            </h2>
        </div>
        <div class="p-5 grid grid-cols-12 gap-4 row-gap-3">
            <div class="col-span-12">
                <label>Quantity</label>
                <div class="flex mt-2 flex-1">
                    <button type="button" class="button w-12 border bg-gray-200 dark:bg-dark-1 text-gray-600 dark:text-gray-300 mr-1" id="cart-product-detail-minus">-</button>
                    <input type="text" class="input w-full border text-center" placeholder="Item quantity" value="0" id="cart-product-detail-qty">
                    <button type="button" class="button w-12 border bg-gray-200 dark:bg-dark-1 text-gray-600 dark:text-gray-300 ml-1" id="cart-product-detail-plus">+</button>
                </div>
            </div>
            <div class="col-span-12" id="cart-product-detail-price">

            </div>
        </div>
        <div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5">
            <button type="button" data-dismiss="modal" class="button w-24 border dark:border-dark-5 text-gray-700 dark:text-gray-300 mr-1">Cancel</button>
            <button type="button" class="button w-24 bg-theme-1 text-white" id="cart-product-detail-modify">Ubah</button>
        </div>
    </div>
</div>
<!-- END: Add Item Modal -->
<div class="modal" id="category-modal">
   <div class="modal__content modal__content--xl">
        <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
            <h2 class="font-medium text-base mr-auto">Pilih Kategori</h2>
        </div>
        <div class="grid grid-cols-12 gap-5 p-5" id="category-list">

        </div>
   </div>
</div>
@endsection 

@section('additionalFileJS')

@endsection

@section('additionalScriptJS')
<script type="text/javascript">
    let id = "{{isset($_GET['edit']) && $_GET['edit'] ? $_GET['edit'] : 0 }}";
    let selectedCategoryId = 0;
    let tempProduct = [];
    let cart = [];
    let discount = 0;
    let subtotal = 0;
    let total = 0;
    let currentSalesConsignmentId = 0;
    let currentPaymentId = 0;

    getCategories();
    getProducts();
    getStoreConsignment();
    buildCart();
    getPaymentMethods();
    getSalesConsignment();

    if (parseInt(id) > 0) {
        getSalesConsignmentById(id);
    }

    function getSalesConsignment() {
        $.ajax({
            url: API_URL+"/api/sales_consignments",
            type: 'GET',
            headers: { 'Authorization': 'Bearer '+TOKEN },
            dataType: 'JSON',
            async: false,
            success: function(res, textStatus, jqXHR){
                let html = ''
                
                $.each(res.data, function (index, item) {
                    html += '<a href="javascript:;" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md" id="latest-invoice" data-id="'+item.id+'"> <i data-feather="activity" class="w-4 h-4 mr-2"></i> <span class="truncate">'+item.number+'</span> </a>'
                });

                $('#latest-invoice-list').html(html);

                feather.replace();
            },
            error: function(jqXHR, textStatus, errorThrown){

            },
        })
    }

    function getCategories() {
        $.ajax({
            url: API_URL+"/api/categories?active=1",
            type: 'GET',
            headers: { 'Authorization': 'Bearer '+TOKEN },
            dataType: 'JSON',
            async: false,
            success: function(res, textStatus, jqXHR){
                let html = ''

                $.each(res.data, function (index, item) {
                    html += '<div class="selected-category col-span-12 sm:col-span-4 xxl:col-span-3 box bg-theme-5 p-5 cursor-pointer zoom-in" id="selected-category" data-id="'+item.id+'">';
                    html += '    <div class="font-medium text-base">'+item.name+'</div>';
                    html += '    <div class="text-gray-600">'+item.total_product+' Item(s)</div>';
                    html += '</div>';
                });

                $('#category-list').html(html)
            },
            error: function(jqXHR, textStatus, errorThrown){

            },
        });
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

    function getStoreConsignment() {
        $.ajax({
            url: API_URL+"/api/store_consignments",
            type: 'GET',
            headers: { 'Authorization': 'Bearer '+TOKEN },
            dataType: 'JSON',
            async: false,
            success: function(res, textStatus, jqXHR){
                let opt = ''
                opt += '<option value=""> - Pilih Toko Konsinyasi - </option>'
                $.each(res.data, function (index, item) {  
                    opt += '<option value="'+item.id+'">'+item.store_name+'</option>'
                })
                $('#input-store-consignment-id').html(opt)
            },
            error: function(jqXHR, textStatus, errorThrown){

            },
        })
    }

    function getProducts(name = "") {
        let productName = '';
        let searchCategory = '';
        if (name != '') {
            productName = '&name='+name;
        }
        if (selectedCategoryId > 0 && name == '') {
            searchCategory = '&category_id='+selectedCategoryId;
        }

        $.ajax({
            url: API_URL+"/api/products?active=1"+searchCategory+productName,
            type: 'GET',
            headers: { 'Authorization': 'Bearer '+TOKEN },
            dataType: 'JSON',
            async: false,
            success: function(res, textStatus, jqXHR){
                let html = ''

                $.each(res.data, function (index, item) {
                    // Save on Temporary array, so as not to call to the server again to get detail
                    tempProduct[item.id] = item;

                    html += '<a href="javascript:;" class="intro-y block col-span-12 sm:col-span-4 xxl:col-span-3" id="product-click" data-id="'+item.id+'">';
                    html += '    <div class="box rounded-md p-3 relative zoom-in">';
                    html += '        <div class="flex-none pos-image relative block">';
                    html += '            <div class="pos-image__preview image-fit">';
                    html += '                <img alt="Kalika Cake Product" src="{{ asset('templates/midone/images/logo_kalika.png') }}">';
                    html += '            </div>';
                    html += '        </div>';
                    html += '        <div class="block font-medium text-center truncate mt-3">'+item.name+'</div>';
                    html += '    </div>';
                    html += '</a>';
                });

                $('#product-list').html(html)
            },
            error: function(jqXHR, textStatus, errorThrown){

            },
        })
    }

    function buildCart() {
        let html = '';

        if (cart.length > 0) {
            $.each(cart, function (index, item) {
                if (item != null) {
                    html += '<a href="javascript:;" class="flex items-center p-3 cursor-pointer transition duration-300 ease-in-out bg-white dark:bg-dark-3 hover:bg-gray-200 dark:hover:bg-dark-1 rounded-md" id="modify-item-cart" data-id="'+index+'">';
                    html += '    <div class="pos__ticket__item-name truncate mr-1">'+item.name+'</div>';
                    html += '    <div class="text-gray-600">x '+item.quantity+' \@Rp '+item.unit_price+'</div>';
                    html += '    <i data-feather="edit" class="w-4 h-4 text-gray-600 ml-2"></i> ';
                    html += '    <div class="ml-auto">Rp '+item.quantity * item.unit_price+'</div>';
                    html += '</a>';
                }
            });
        } else {
            html += '<h2 class="text-3xl text-gray-700 dark:text-gray-600 font-medium leading-none p-10 text-center">Silahkan Pilih Produk</h2>';
        }

        calculateSubtotal();

        $('#cart-list').html(html);
    }

    function calculateSubtotal() {
        subtotal = 0;
        $.each(cart, function (index, item) {
            if (item != null) {
                subtotal += parseFloat(item.quantity) * parseFloat(item.unit_price);
            }
        });

        $('#subtotal').text(subtotal);
        calculateGrandTotal();
    }


    function calculateGrandTotal() {
        total = subtotal - discount;

        $('#total').text(total);
    }
    
    // Select product on Product list
    $(document).on("click","a#product-click",function() {
        let productId = $(this).data('id');
        let price = 0;
        if (tempProduct[productId]["product_price"].length > 0) {
            price = tempProduct[productId]["product_price"][0]["price"];
        }
        cart[productId] = {
            "id": productId,
            "name": tempProduct[productId]['name'],
            "quantity": cart[productId] == null ? 1 : parseInt(cart[productId]["quantity"]) + 1,
            "unit_price": parseFloat(price)
        };

        buildCart();
    }); 
    
    // Click product on cart
    $(document).on("click", "a#modify-item-cart", function() {
        let productId = $(this).data('id');
        let product = tempProduct[productId];
        let productCart = cart[productId];
        let htmlPrice = '';
        
        $('#cart-product-detail-title').text(product.name);
        $('#cart-product-detail-qty').val(productCart.quantity);
        $('#cart-product-detail-product-id').val(productId);

        if (product.is_custom_price) {
            htmlPrice += '<label>Harga</label>';
            htmlPrice += '<input type="text" class="input w-full border mt-2 flex-1" id="cart-product-detail-price-input" value="'+productCart["unit_price"]+'">';
        } else {
            htmlPrice += '<label>Harga</label>';
            htmlPrice += '<select class="input w-full border mt-2 flex-1" id="cart-product-detail-price-input">';
            htmlPrice += '    <option value=""> - Pilih Harga - </option>';
            $.each(product["product_price"], function (index, item) {
                if (parseFloat(productCart["unit_price"]) == item.price) {
                    htmlPrice += '    <option value="'+item.price+'" selected>'+item.name+' ('+item.price+')</option>';
                } else {
                    htmlPrice += '    <option value="'+item.price+'">'+item.name+' ('+item.price+')</option>';
                }
            });
            htmlPrice += '</select>';
        }

        $('#cart-product-detail-price').html(htmlPrice);
        $('#cart-product-detail').modal('show');
    });
    
    $(document).on("click","button#cart-product-detail-modify",function() {
        let productId = $('#cart-product-detail-product-id').val();
        let qty = $('#cart-product-detail-qty').val();
        let price = $('#cart-product-detail-price-input').val();

        cart[productId]["quantity"] = qty;
        cart[productId]["unit_price"] = price;

        buildCart();
        $('#cart-product-detail').modal('hide');
    });

    $(document).on("click","button#cart-product-detail-plus",function() {
        let qty = $('#cart-product-detail-qty').val();
        $('#cart-product-detail-qty').val(parseFloat(qty) + 1);
    });

    $(document).on("click","button#cart-product-detail-minus",function() {
        let qty = $('#cart-product-detail-qty').val();
        if (qty < 1) {
            return;
        }
        $('#cart-product-detail-qty').val(parseFloat(qty) - 1);
    });

    $(document).on("click", "button#pay", function() {
        $('#pay-sales-total').text(total);
        let payAmount = $('#input-pay-amount').val();
        $('#change').text(parseFloat(payAmount) - parseFloat(total));
        $('#pay-modal').modal('show');
    });

    // Show choose category modal
    $(document).on("click","button#category-btn",function() {
        $('#category-modal').modal('show');
    });
    
    // Select data on category modal
    $(document).on("click","div#selected-category",function() {
        selectedCategoryId = $(this).data('id');

        getProducts();

        $('.selected-category').each(function() {
            $(this).removeClass('col-span-12 sm:col-span-4 xxl:col-span-3 box bg-theme-1 dark:bg-theme-1 p-5 cursor-pointer zoom-in');
            $(this).addClass('col-span-12 sm:col-span-4 xxl:col-span-3 box bg-theme-5 p-5 cursor-pointer zoom-in');
            $(this).find('div:eq(0)').removeClass('text-white');
            $(this).find('div:eq(1)').removeClass('text-theme-25 dark:text-gray-400 text-gray-600');
            $(this).find('div:eq(1)').addClass('text-gray-600');
            if ($(this).data('id') == selectedCategoryId) {
                $(this).removeClass('bg-theme-5');
                $(this).addClass('bg-theme-1 dark:bg-theme-1');
                $(this).find('div:eq(0)').addClass('text-white');
                $(this).find('div:eq(1)').removeClass('text-gray-600');
                $(this).find('div:eq(1)').addClass('text-theme-25 dark:text-gray-400');
            }
        });

        $('#category-modal').modal('hide');
    });

    $(document).on("keyup","input#discount",function() {
        discount = parseFloat($(this).val());
        
        calculateGrandTotal();
    });

    $(document).on("click", "div#pay-amount",function() {
        let amount = $(this).data('amount');
        if (amount < 1) {
            amount = $('#pay-sales-total').text();
        }
        
        $('#input-pay-amount').val(amount);
        calculateChange();
    });

    $(document).on("keyup", "#input-pay-amount",function() {
        calculateChange();
    });

    function calculateChange() {
        let customerPayAmount = $('#input-pay-amount').val();
        
        let result = customerPayAmount - total;

        $('#change').text(result);
    }
    
    $(document).on("click", "a#latest-invoice",function() {
        let salesConsignmentId = $(this).data('id');
        
        getSalesConsignmentById(salesConsignmentId);
    });

    function getSalesConsignmentById(consignmentId) {
        $.ajax({
            url: API_URL+"/api/sales_consignments/"+consignmentId,
            type: 'GET',
            headers: { 'Authorization': 'Bearer '+TOKEN },
            dataType: 'JSON',
            async: false,
            beforeSend: function() {
                clearAll()
            },
            success: function(res, textStatus, jqXHR){
                $.each(res.data.sales_consignment_details, function (index, item) {
                    cart[item.product_id] = {
                        "id": item.product_id,
                        "name": item.product.name,
                        "quantity": item.qty,
                        "unit_price": item.unit_price
                    };
                    
                    item.product["id"] = item.product_id;
                    tempProduct[item.product_id] = item.product;

                    subtotal += parseFloat(item.unit_price) * parseFloat(item.qty);
                });

                // discount = res.data.discount_value;

                total = subtotal;

                $('#input-pay-amount').val(res.data.customer_pay);
                $('#change').text(res.data.customer_change);
                $('#pay-sales-total').text(res.data.total);
                $('#discount').val(res.data.discount_value);
                $('#input-payment-method').val(res.data.payment.payment_method_id).trigger('change');
                $('#input-payment-method-note').val(res.data.payment.payment_note);
                $('#input-store-consignment-id').val(res.data.store_consignment_id).trigger('change');

                currentSalesConsignmentId = res.data.id;
                currentPaymentId = res.data.payment.id;

                buildCart();
            },
            error: function(jqXHR, textStatus, errorThrown){

            },
        });
    }

    $(document).on("click", "button#finish-payment-btn",function() {
        let salesConsigmentBodyReq = {
            "id": currentSalesConsignmentId,
            "store_consignment_id": parseInt($('#input-store-consignment-id').find(':selected').val()),
            "payment": {
                "id": currentPaymentId,
                "payment_method_id": parseInt($('#input-payment-method').find(':selected').val()),
                "total": parseFloat($('#pay-sales-total').text()),
                "change": parseFloat($('#change').text()),
                "payment_note": $('#input-payment-method-note').val()
            },
        }

        let salesConsignmentDetailBodyReq = [];
        
        $.each(cart, function (index, item) {
            if (item != null) {
                salesConsignmentDetailBodyReq.push({
                    'product_id': index,
                    'qty': parseFloat(item.quantity),
                    'discount': 0,
                    'unit_price': parseFloat(item.unit_price)
                });
            }
        });

        salesConsigmentBodyReq['sales_consignment_details'] = salesConsignmentDetailBodyReq;

        $.ajax({
            type: 'POST',
            url: API_URL+"/api/sales_consignments",
            headers: { 'Authorization': 'Bearer '+TOKEN },
            data: JSON.stringify(salesConsigmentBodyReq),
            contentType: 'application/json',
            dataType: 'JSON',
            beforeSend: function() {
                
            },
            success: function(res) {
                Swal.fire({
                  icon: 'success',
                  title: 'Sukses',
                  text: res.message
                }).then((result) => {
                  if (result.isConfirmed) {
                    //TODO CLEAR ALL
                    clearAll();

                    $('#pay-modal').modal('hide');
                  }
                });
            },
            error: function(jqXHR, textStatus, errorThrown){
                console.log(jqXHR.responseJSON);
            },
        });
    });

    function clearAll() {
        cart = [];
        discount = 0;
        subtotal = 0;
        total = 0;

        $('#input-pay-amount').val(0);
        $('#change').text(0);
        $('#pay-sales-total').text(0);
        $('#discount').val(0);
        $('#input-payment-method').val('').trigger('change');
        $('#input-payment-method-note').val('');
        $('#input-store-consignment-id').val('').trigger('change');

        currentSalesConsignmentId = 0;
        currentPaymentId = 0;

        buildCart();
    }

    $(document).on("keyup", "input#search-product",function() {
        if (($(this).val()).length > 2) {
            getProducts($(this).val());
        }
    });
</script>
@endsection