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
        </div>
    </div>
</div>
<div class="pos intro-y grid grid-cols-12 gap-5 mt-5">
    <!-- BEGIN: Item List -->
    <div class="intro-y col-span-12 lg:col-span-8">
        <div class="mt-4 mb-4">
            <button class="button button--lg w-full text-white bg-theme-1 shadow-md ml-auto" id="division-btn">Cari Bahan Baku Berdasarkan Divisi</button>
        </div>
        <div class="lg:flex intro-y">
            <div class="relative text-gray-700 dark:text-gray-300 w-full">
                <input type="text" class="input input--lg w-full box pr-10 placeholder-theme-13" placeholder="Cari Bahan Baku..." id="search-raw-material">
                <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-feather="search"></i> 
            </div>
        </div>

        <!-- BEGIN: Striped Rows -->
        <div class="intro-y box mt-5">
            <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200">
                <h2 class="font-medium text-base mr-auto">
                    Silahkan Pilih Bahan Baku
                </h2>
            </div>
            <div class="p-5" id="striped-rows-table">
                <div class="preview">
                    <div class="overflow-x-auto">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="border-b-2 dark:border-dark-5 whitespace-no-wrap">#</th>
                                    <th class="border-b-2 dark:border-dark-5 whitespace-no-wrap">Bahan Baku</th>
                                    <th class="border-b-2 dark:border-dark-5 whitespace-no-wrap">Harga</th>
                                    <th class="border-b-2 dark:border-dark-5 whitespace-no-wrap">Stock</th>
                                </tr>
                            </thead>
                            <tbody id="product-list">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Striped Rows -->
    </div>
    <!-- END: Item List -->
    <!-- BEGIN: Ticket -->
    <div class="col-span-12 lg:col-span-4">
        <div class="box flex p-5 mt-3">
            <div class="w-full relative text-gray-700">
                <label>Pilih Produk :</label>
                <select id="input-product" class="single-select select2 input w-full border mt-4 flex-1"></select>
            </div>
        </div>
        <div class="pos__ticket box p-2 mt-5" id="cart-list">
            
        </div>
        <div class="box flex p-5 mt-3">
            <div class="w-full relative text-gray-700">
                <div class="flex flex-col sm:flex-row items-center"> 
                    <label class="w-full sm:w-20 sm:text-left sm:mr-5">Overhead (%)</label> 
                    <input type="number" class="input w-full border mt-2 flex-1" placeholder="Persentase Harga Overhead" id="input-percentage-overhead"> 
                </div>
                <div class="flex flex-col sm:flex-row items-center mt-3"> 
                    <label class="w-full sm:w-20 sm:text-left sm:mr-5">Margin (%)</label> 
                    <input type="number" class="input w-full border mt-2 flex-1" placeholder="Persentase Harga Margin" id="input-percentage-margin"> 
                </div>
            </div>
        </div>
        <div class="box p-5 mt-5">
            <div class="flex">
                <div class="mr-auto">Total</div>
                <div id="subtotal">Rp 0</div>
            </div>
            <div class="flex mt-4 pt-4 border-t border-gray-200 dark:border-dark-5">
                <div class="mr-auto font-medium text-base">Harga HPP</div>
                <div class="font-medium text-base" id="total-hpp">Rp 0</div>
            </div>
            <div class="flex mt-4 pt-4 border-t border-gray-200 dark:border-dark-5">
                <div class="mr-auto font-medium text-base">Harga Overhead</div>
                <div class="font-medium text-base" id="total-overhead">Rp 0</div>
            </div>
            <div class="flex mt-4 pt-4 border-t border-gray-200 dark:border-dark-5">
                <div class="mr-auto font-medium text-base">Harga Rekomendasi</div>
                <div class="font-medium text-base" id="total-margin">Rp 0</div>
            </div>
        </div>
        <div class="flex mt-5">
            <button class="button w-full border border-gray-400 dark:border-dark-5 text-gray-600 dark:text-gray-300">Kosongkan Bahan Baku</button>
        </div>
        <div class="flex mt-5">
            <button class="button w-full text-white bg-theme-1 shadow-md ml-auto" id="submit">Simpan</button>
        </div>
    </div>
    <!-- END: Ticket -->
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
    let tempProduct = [];
    let cart = [];
    let discount = 0;
    let subtotal = 0;
    let total = 0;
    let currentProductionId = 0;

    buildCart();
    getProducts();

    function getProducts() {
        $.ajax({
            url: API_URL+"/api/products",
            type: 'GET',
            headers: { 'Authorization': 'Bearer '+TOKEN },
            dataType: 'JSON',
            async: false,
            success: function(res, textStatus, jqXHR){
                let opt = ''
                opt += '<option value=""> - Pilih Produk - </option>'
                $.each(res.data, function (index, item) {  
                    opt += '<option value="'+item.id+'">'+item.name+'</option>'
                })
                $('#input-product').html(opt)
            },
            error: function(jqXHR, textStatus, errorThrown){

            },
        });
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
            html += '<h2 class="text-3xl text-gray-700 dark:text-gray-600 font-medium leading-none p-10 text-center">Bahan Baku Produk</h2>';
        }
        
        calculateSubtotal();
        calculateOverhead();
        calculateMargin();
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
        $('#total-hpp').text(subtotal);
    }

    function calculateOverhead() {
        let overheadPrice = subtotal + (subtotal*(parseFloat($('input#input-percentage-overhead').val())/100));

        $('#total-overhead').text(overheadPrice);
    }

    function calculateMargin() {
        let recommendationPrice = subtotal + (subtotal*(parseFloat($('input#input-percentage-margin').val())/100));

        $('#total-margin').text(recommendationPrice);
    }

    $(document).on("keyup", "input#input-percentage-overhead",function() {
        calculateOverhead();
    });

    $(document).on("keyup", "input#input-percentage-margin",function() {
        calculateMargin();
    });

    $(document).on("keyup", "input#search-raw-material",function() {
        if (($(this).val()).length > 2) {
            getRawMaterials($(this).val());
        }
    });

    function getRawMaterials(name) {
        let productName = '';
        if (name != '') {
            productName = '&name='+name;
        }
        $.ajax({
            url: API_URL+"/api/raw_materials?active=1"+productName,
            type: 'GET',
            headers: { 'Authorization': 'Bearer '+TOKEN },
            dataType: 'JSON',
            async: false,
            success: function(res, textStatus, jqXHR){
                let html = ''

                $.each(res.data, function (index, item) {
                    // Save on Temporary array, so as not to call to the server again to get detail
                    tempProduct[item.id] = item;
                    if (index % 2 == 0) {
                        html += '<tr class="bg-gray-200 dark:bg-dark-1" style="cursor: pointer;" id="product-click" data-id="'+item.id+'">';
                    } else {
                        html += '<tr style="cursor: pointer;" id="product-click" data-id="'+item.id+'">';
                    }
                    html += '    <td class="border-b dark:border-dark-5">'+(index+1)+'</td>';
                    html += '    <td class="border-b dark:border-dark-5">'+item.name+'</td>';
                    html += '    <td class="border-b dark:border-dark-5">'+item.price+'</td>';
                    html += '    <td class="border-b dark:border-dark-5">'+item.stock+'</td>';
                    html += '</tr>';
                });

                $('#product-list').html(html)
            },
            error: function(jqXHR, textStatus, errorThrown){

            },
        })
    }

    // Select product on Product list
    $(document).on("click","tr#product-click",function() {
        let productId = $(this).data('id');
        
        cart[productId] = {
            "id": productId,
            "name": tempProduct[productId]['name'],
            "quantity": cart[productId] == null ? 1 : parseInt(cart[productId]["quantity"]) + 1,
            "unit_price": parseFloat(tempProduct[productId]['price'])
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

        htmlPrice += '<label>Harga</label>';
        htmlPrice += '<input type="text" class="input w-full border mt-2 flex-1" id="cart-product-detail-price-input" value="'+productCart['unit_price']+'">';

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

    $(document).on("click", "button#submit",function() {
        let recipeBodyReq = {
            "id": currentProductionId,
            "product_id": parseInt($('#input-product').find(':selected').val()),
            "qty": 1,
            "overhead_percentage": parseFloat($('#input-percentage-overhead').val()),
            "recommendation_percentage": parseFloat($('#input-percentage-margin').val()),
        }

        let recipeDetailBodyReq = [];
        
        $.each(cart, function (index, item) {
            if (item != null) {
                recipeDetailBodyReq.push({
                    'raw_material_id': index,
                    'quantity': parseFloat(item.quantity),
                    'unit_id': 0,
                    'price': parseFloat(item.unit_price)
                });
            }
        });

        recipeBodyReq['recipe_details'] = recipeDetailBodyReq;

        $.ajax({
            type: 'POST',
            url: API_URL+"/api/recipes",
            headers: { 'Authorization': 'Bearer '+TOKEN },
            data: JSON.stringify(recipeBodyReq),
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
                    // clearAll();
                  }
                });
            },
            error: function(jqXHR, textStatus, errorThrown){
                console.log(jqXHR.responseJSON);
            },
        });
    });

    function clearAll() {
        tempProduct = [];
        cart = [];
        discount = 0;
        subtotal = 0;
        total = 0;
        currentProductionId = 0;

        $('#input-percentage-overhead').val(0);
        $('#input-percentage-margin').val(0);
        $('#subtotal').text(0);
        $('#total-hpp').text(0);
        $('#total-overhead').text(0);
        $('#total-margin').text(0);

        buildCart();
    }

    $(document).on("change", "#input-product",function(e) {
        e.preventDefault();
        let productId = $(this).find(':selected').val();

        $.ajax({
            url: API_URL+"/api/recipe_by_product_id/"+productId,
            type: 'GET',
            headers: { 'Authorization': 'Bearer '+TOKEN },
            dataType: 'JSON',
            async: false,
            beforeSend: function() {
                clearAll();
            },
            success: function(res, textStatus, jqXHR){
                if (res.data.id > 0) {
                    $.each(res.data.recipe_details, function (index, item) {
                        cart[item.raw_material_id] = {
                            "id": item.raw_material_id,
                            "name": item.raw_material.name,
                            "quantity": item.quantity,
                            "unit_price": item.price
                        };
                        
                        tempProduct[item.raw_material_id] = item.raw_material;

                        subtotal += parseFloat(item.price) * parseFloat(item.quantity);
                    });

                    total = subtotal;

                    $('#input-percentage-overhead').val(res.data.overhead_percentage);
                    $('#input-percentage-margin').val(res.data.recommendation_percentage);
                    $('#subtotal').text(subtotal);
                    $('#total-hpp').text(total);
                    $('#total-overhead').text(res.data.overhead_price);
                    $('#total-margin').text(res.data.recommendation_price);

                    currentProductionId = res.data.id;

                    buildCart();
                }
            },
            error: function(jqXHR, textStatus, errorThrown){

            },
        });
    });
</script>
@endsection