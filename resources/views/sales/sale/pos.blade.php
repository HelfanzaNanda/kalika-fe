@extends('layouts.main')

@section('title', $title)

@section('additionalFileCSS')

@endsection

@section('content')
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Penjualan
    </h2>
    <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
        <a href="javascript:;" data-toggle="modal" data-target="#new-order-modal" class="button text-white bg-theme-1 shadow-md mr-2">New Order</a> 
        <div class="pos-dropdown dropdown relative ml-auto sm:ml-0">
            <button class="dropdown-toggle button px-2 box text-gray-700 dark:text-gray-300">
                <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-feather="chevron-down"></i> </span>
            </button>
            <div class="pos-dropdown__dropdown-box dropdown-box mt-10 absolute top-0 right-0 z-20">
                <div class="dropdown-box__content box dark:bg-dark-1 p-2">
                    <a href="#" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md"> <i data-feather="activity" class="w-4 h-4 mr-2"></i> <span class="truncate">INV-0206020 - Will Smith</span> </a>
                    <a href="#" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md"> <i data-feather="activity" class="w-4 h-4 mr-2"></i> <span class="truncate">INV-0206022 - Denzel Washington</span> </a>
                    <a href="#" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md"> <i data-feather="activity" class="w-4 h-4 mr-2"></i> <span class="truncate">INV-0206021 - Al Pacino</span> </a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="pos intro-y grid grid-cols-12 gap-5 mt-5">
    <!-- BEGIN: Item List -->
    <div class="intro-y col-span-12 lg:col-span-8">
        <div class="lg:flex intro-y">
            <div class="relative text-gray-700 dark:text-gray-300">
                <input type="text" class="input input--lg w-full lg:w-64 box pr-10 placeholder-theme-13" placeholder="Search item...">
                <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-feather="search"></i> 
            </div>
            <select class="input input--lg box w-full lg:w-auto mt-3 lg:mt-0 ml-auto">
                <option>Sort By</option>
                <option>A to Z</option>
                <option>Z to A</option>
                <option>Lowest Price</option>
                <option>Highest Price</option>
            </select>
        </div>
        <div class="mt-4 mb-4">
			<button class="button button--lg w-full text-white bg-theme-1 shadow-md ml-auto" id="category-btn">Pilih Kategori</button>
        </div>

        <div class="grid grid-cols-12 gap-5 mt-5 pt-5 border-t border-theme-5" id="product-list">

        </div>
    </div>
    <!-- END: Item List -->
    <!-- BEGIN: Ticket -->
    <div class="col-span-12 lg:col-span-4">
        <div class="intro-y pr-1">
            <div class="box p-2">
                <div class="pos__tabs nav-tabs justify-center flex"> <a data-toggle="tab" data-target="#ticket" href="javascript:;" class="flex-1 py-2 rounded-md text-center active">Ticket</a> <a data-toggle="tab" data-target="#details" href="javascript:;" class="flex-1 py-2 rounded-md text-center">Details</a> </div>
            </div>
        </div>
        <div class="tab-content">
            <div class="tab-content__pane active" id="ticket">
                <div class="pos__ticket box p-2 mt-5">
                    <a href="javascript:;" data-toggle="modal" data-target="#add-item-modal" class="flex items-center p-3 cursor-pointer transition duration-300 ease-in-out bg-white dark:bg-dark-3 hover:bg-gray-200 dark:hover:bg-dark-1 rounded-md">
                        <div class="pos__ticket__item-name truncate mr-1">Snack Platter</div>
                        <div class="text-gray-600">x 1</div>
                        <i data-feather="edit" class="w-4 h-4 text-gray-600 ml-2"></i> 
                        <div class="ml-auto">$37</div>
                    </a>
                    <a href="javascript:;" data-toggle="modal" data-target="#add-item-modal" class="flex items-center p-3 cursor-pointer transition duration-300 ease-in-out bg-white dark:bg-dark-3 hover:bg-gray-200 dark:hover:bg-dark-1 rounded-md">
                        <div class="pos__ticket__item-name truncate mr-1">Virginia Cheese Wedges</div>
                        <div class="text-gray-600">x 1</div>
                        <i data-feather="edit" class="w-4 h-4 text-gray-600 ml-2"></i> 
                        <div class="ml-auto">$49</div>
                    </a>
                    <a href="javascript:;" data-toggle="modal" data-target="#add-item-modal" class="flex items-center p-3 cursor-pointer transition duration-300 ease-in-out bg-white dark:bg-dark-3 hover:bg-gray-200 dark:hover:bg-dark-1 rounded-md">
                        <div class="pos__ticket__item-name truncate mr-1">Crispy Mushroom</div>
                        <div class="text-gray-600">x 1</div>
                        <i data-feather="edit" class="w-4 h-4 text-gray-600 ml-2"></i> 
                        <div class="ml-auto">$162</div>
                    </a>
                    <a href="javascript:;" data-toggle="modal" data-target="#add-item-modal" class="flex items-center p-3 cursor-pointer transition duration-300 ease-in-out bg-white dark:bg-dark-3 hover:bg-gray-200 dark:hover:bg-dark-1 rounded-md">
                        <div class="pos__ticket__item-name truncate mr-1">Avocado Burger</div>
                        <div class="text-gray-600">x 1</div>
                        <i data-feather="edit" class="w-4 h-4 text-gray-600 ml-2"></i> 
                        <div class="ml-auto">$26</div>
                    </a>
                    <a href="javascript:;" data-toggle="modal" data-target="#add-item-modal" class="flex items-center p-3 cursor-pointer transition duration-300 ease-in-out bg-white dark:bg-dark-3 hover:bg-gray-200 dark:hover:bg-dark-1 rounded-md">
                        <div class="pos__ticket__item-name truncate mr-1">Spaghetti Fettucine Aglio with Beef Bacon</div>
                        <div class="text-gray-600">x 1</div>
                        <i data-feather="edit" class="w-4 h-4 text-gray-600 ml-2"></i> 
                        <div class="ml-auto">$103</div>
                    </a>
                </div>
                <div class="box flex p-5 mt-5">
                    <div class="w-full relative text-gray-700">
                        <input type="text" class="input input--lg w-full bg-gray-200 pr-10 placeholder-theme-13" placeholder="Use coupon code...">
                        <i class="w-4 h-4 hidden sm:absolute my-auto inset-y-0 mr-3 right-0" data-feather="search"></i> 
                    </div>
                    <button class="button text-white bg-theme-1 ml-2">Apply</button>
                </div>
                <div class="box p-5 mt-5">
                    <div class="flex">
                        <div class="mr-auto">Subtotal</div>
                        <div>$250</div>
                    </div>
                    <div class="flex mt-4">
                        <div class="mr-auto">Discount</div>
                        <div class="text-theme-6">-$20</div>
                    </div>
                    <div class="flex mt-4">
                        <div class="mr-auto">Tax</div>
                        <div>15%</div>
                    </div>
                    <div class="flex mt-4 pt-4 border-t border-gray-200 dark:border-dark-5">
                        <div class="mr-auto font-medium text-base">Charge</div>
                        <div class="font-medium text-base">$220</div>
                    </div>
                </div>
                <div class="flex mt-5">
                    <button class="button w-32 border border-gray-400 dark:border-dark-5 text-gray-600 dark:text-gray-300">Clear Items</button>
                    <button class="button w-32 text-white bg-theme-1 shadow-md ml-auto">Charge</button>
                </div>
            </div>
            <div class="tab-content__pane" id="details">
                <div class="box p-5 mt-5">
                    <div class="flex items-center border-b dark:border-dark-5 pb-5">
                        <div class="">
                            <div class="text-gray-600">Time</div>
                            <div>02/06/20 02:10 PM</div>
                        </div>
                        <i data-feather="clock" class="w-4 h-4 text-gray-600 ml-auto"></i> 
                    </div>
                    <div class="flex items-center border-b dark:border-dark-5 py-5">
                        <div class="">
                            <div class="text-gray-600">Customer</div>
                            <div>Leonardo DiCaprio</div>
                        </div>
                        <i data-feather="user" class="w-4 h-4 text-gray-600 ml-auto"></i> 
                    </div>
                    <div class="flex items-center border-b dark:border-dark-5 py-5">
                        <div class="">
                            <div class="text-gray-600">People</div>
                            <div>3</div>
                        </div>
                        <i data-feather="users" class="w-4 h-4 text-gray-600 ml-auto"></i> 
                    </div>
                    <div class="flex items-center pt-5">
                        <div class="">
                            <div class="text-gray-600">Table</div>
                            <div>21</div>
                        </div>
                        <i data-feather="mic" class="w-4 h-4 text-gray-600 ml-auto"></i> 
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Ticket -->
</div>
<!-- BEGIN: New Order Modal -->
<div class="modal" id="new-order-modal">
    <div class="modal__content">
        <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
            <h2 class="font-medium text-base mr-auto">
                New Order
            </h2>
        </div>
        <div class="p-5 grid grid-cols-12 gap-4 row-gap-3">
            <div class="col-span-12">
                <label>Name</label>
                <input type="text" class="input w-full border mt-2 flex-1" placeholder="Customer name">
            </div>
            <div class="col-span-12">
                <label>Table</label>
                <input type="text" class="input w-full border mt-2 flex-1" placeholder="Customer table">
            </div>
            <div class="col-span-12">
                <label>Number of People</label>
                <input type="text" class="input w-full border mt-2 flex-1" placeholder="People">
            </div>
        </div>
        <div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5">
            <button type="button" data-dismiss="modal" class="button w-32 border dark:border-dark-5 text-gray-700 dark:text-gray-300 mr-1">Cancel</button>
            <button type="button" class="button w-32 bg-theme-1 text-white">Create Ticket</button>
        </div>
    </div>
</div>
<!-- END: New Order Modal -->
<!-- BEGIN: Add Item Modal -->
<div class="modal" id="add-item-modal">
    <div class="modal__content">
        <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
            <h2 class="font-medium text-base mr-auto">
                Snack Platter
            </h2>
        </div>
        <div class="p-5 grid grid-cols-12 gap-4 row-gap-3">
            <div class="col-span-12">
                <label>Quantity</label>
                <div class="flex mt-2 flex-1">
                    <button type="button" class="button w-12 border bg-gray-200 dark:bg-dark-1 text-gray-600 dark:text-gray-300 mr-1">-</button>
                    <input type="text" class="input w-full border text-center" placeholder="Item quantity" value="2">
                    <button type="button" class="button w-12 border bg-gray-200 dark:bg-dark-1 text-gray-600 dark:text-gray-300 ml-1">+</button>
                </div>
            </div>
            <div class="col-span-12">
                <label>Notes</label>
                <textarea class="input w-full border mt-2 flex-1" placeholder="Item notes"></textarea>
            </div>
        </div>
        <div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5">
            <button type="button" data-dismiss="modal" class="button w-24 border dark:border-dark-5 text-gray-700 dark:text-gray-300 mr-1">Cancel</button>
            <button type="button" class="button w-24 bg-theme-1 text-white">Add Item</button>
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
            {{-- <div class="col-span-12 sm:col-span-4 xxl:col-span-3 box bg-theme-5 p-5 cursor-pointer zoom-in">
                <div class="font-medium text-base">Soup</div>
                <div class="text-gray-600">5 Items</div>
            </div>
            <div class="col-span-12 sm:col-span-4 xxl:col-span-3 box bg-theme-1 dark:bg-theme-1 p-5 cursor-pointer zoom-in">
                <div class="font-medium text-base text-white">Pancake & Toast</div>
                <div class="text-theme-25 dark:text-gray-400">8 Items</div>
            </div> --}}
        </div>
   </div>
</div>
@endsection 

@section('additionalFileJS')

@endsection

@section('additionalScriptJS')
<script type="text/javascript">
	let selectedCategoryId = 0;
	getCategories();
	getProducts();

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
        })
    }

    function getProducts() {
        $.ajax({
            url: API_URL+"/api/products?active=1&category_id="+selectedCategoryId,
            type: 'GET',
            headers: { 'Authorization': 'Bearer '+TOKEN },
            dataType: 'JSON',
            async: false,
            success: function(res, textStatus, jqXHR){
                let html = ''

                $.each(res.data, function (index, item) {
            		html += '<a href="javascript:;" data-toggle="modal" data-target="#add-item-modal" class="intro-y block col-span-12 sm:col-span-4 xxl:col-span-3">';
            		html += '    <div class="box rounded-md p-3 relative zoom-in">';
            		html += '        <div class="flex-none pos-image relative block">';
            		html += '            <div class="pos-image__preview image-fit">';
            		html += '                <img alt="Midone Tailwind HTML Admin Template" src="dist/images/food-beverage-19.jpg">';
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
</script>
@endsection