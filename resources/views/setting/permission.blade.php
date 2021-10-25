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

<div class="grid grid-cols-12 gap-5 mt-5" id="list-role">

</div>

<div class="intro-y box mt-5">
    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200 dark:border-dark-5">
        <h2 class="font-medium text-base mr-auto">
            Hak Akses
        </h2>
    </div>
    <div class="p-5" id="checkbox-switch">
        <div class="preview">
            <div>
                <label><strong>Master</strong></label>
            </div>
            <div id="data-master">
                
            </div>
            <hr>
            <div class="mt-5">
                <label><strong>Inventory</strong></label>
            </div>
            <div id="data-inventory" class="mb-5">
                
            </div>
            <hr>
            <div class="mt-5">
                <label><strong>Penjualan</strong></label>
            </div>
            <div id="data-sales" class="mb-5">
                
            </div>
            <hr>
            <div class="mt-5">
                <label><strong>Pembelian</strong></label>
            </div>
            <div id="data-purchase" class="mb-5">
                
            </div>
            <hr>
            <div class="mt-5">
                <label><strong>Hutang Piutang</strong></label>
            </div>
            <div id="data-dr" class="mb-5">
                
            </div>
            <hr>
            <div class="mt-5">
                <label><strong>Biaya</strong></label>
            </div>
            <div class="mt-3 mb-5">
                <div class="flex flex-col sm:flex-row mt-2" id="data-cost">

                </div>
            </div>
            <hr>
            <div class="mt-5">
                <label><strong>Produksi</strong></label>
            </div>
            <div class="mt-3 mb-5">
                <div class="flex flex-col sm:flex-row mt-2" id="data-production">

                </div>
            </div>
            <hr>
            <div class="mt-5">
                <label><strong>Laporan</strong></label>
            </div>
            <div class="mt-3 mb-5">
                <div class="flex flex-col sm:flex-row mt-2" id="data-report">

                </div>
            </div>
            <hr>
            <div class="mt-5">
                <label><strong>Setting</strong></label>
            </div>
            <div id="data-setting" class="mb-5">
                
            </div>
        </div>
    </div>
</div>
@endsection

@section('additionalFileJS')

@endsection

@section('additionalScriptJS')
<script type="text/javascript">
    roleId = 0;

    getRoles();
    getPermissions();
    getRoleHasPermissions(roleId);

    function getRoleHasPermissions(roleId) {
        $.ajax({
            url: API_URL+"/api/role_has_permissions?role_id="+roleId,
            type: 'GET',
            headers: { 'Authorization': 'Bearer '+TOKEN },
            dataType: 'JSON',
            beforeSend: function() {
                $('input[type="checkbox"]').prop('checked', false);
            },
            success: function(res, textStatus, jqXHR){
                $.each(res.data, function (index, item) {
                    $('input#'+item.permission_id).prop('checked', true);
                });
            },
            error: function(jqXHR, textStatus, errorThrown){

            },
        })
    }

    $(document).on("change","input[type=checkbox]",function() {
        if ($(this).prop('checked')) {
            storePermission(this.id);
        } else {
            deletePermission(this.id);
        }

        buildMenu(userPermissions, getUrl);
    });

    function storePermission(permissionId) {
        $.ajax({
            type: 'POST',
            url: API_URL+"/api/role_has_permissions",
            headers: { 'Authorization': 'Bearer '+TOKEN },
            data: JSON.stringify({"role_id": parseInt(roleId), "permission_id": parseInt(permissionId)}),
            contentType: 'application/json',
            dataType: 'JSON',
            beforeSend: function() {
                
            },
            success: function(res) {
                Swal.fire({
                  icon: 'success',
                  title: 'Success!',
                  text: res.message,
                  timer: 750,
                  timerProgressBar: true,
                  showConfirmButton: false
                }).then(result => {
                  if (result) {
                      if (result.dismiss === Swal.DismissReason.timer) {
                        if (parseInt(ROLE_ID) == parseInt(roleId)) {
                            var result = $.grep(JSON.parse(userPermissions), function(e) { 
                                return e.id === res.data.permission_id; 
                            });
                            
                            if (result.length < 1) {
                                let dataUserPermission = JSON.parse(userPermissions);

                                dataUserPermission.push({
                                    id: res.data.id,
                                    role_id: res.data.role_id,
                                    permission_id: res.data.permission_id,
                                    permission_name: res.data.permission_name,
                                });

                                userPermissions = JSON.stringify(dataUserPermission);
                                localStorage.setItem("_p", userPermissions);
                            }
                        }
                      }
                  }
                });
            },
            error: function(jqXHR, textStatus, errorThrown){
                console.log(jqXHR.responseJSON);
            },
        });
    }

    function deletePermission(permissionId) {
        $.ajax({
            type: 'DELETE',
            url: API_URL+"/api/role_has_permissions",
            headers: { 'Authorization': 'Bearer '+TOKEN },
            data: JSON.stringify({"role_id": parseInt(roleId), "permission_id": parseInt(permissionId)}),
            contentType: 'application/json',
            dataType: 'JSON',
            beforeSend: function() {
                
            },
            success: function(res) {
                Swal.fire({
                  icon: 'success',
                  title: 'Success!',
                  text: res.message,
                  timer: 750,
                  timerProgressBar: true,
                  showConfirmButton: false
                }).then(result => {
                  if (result) {
                      if (result.dismiss === Swal.DismissReason.timer) {
                        console.log(parseInt(ROLE_ID));
                        console.log(parseInt(roleId));
                        if (parseInt(ROLE_ID) == parseInt(roleId)) {
                            let dataUserPermission = JSON.parse(userPermissions);

                            $.each(dataUserPermission, function(i, el){
                              if (parseInt(this.permission_id) == parseInt(permissionId) && parseInt(this.role_id) == parseInt(roleId)) {
                                dataUserPermission.splice(i, 1);
                              }
                            });

                            userPermissions = JSON.stringify(dataUserPermission);
                            localStorage.setItem("_p", userPermissions);
                        }
                      }
                  }
                });
            },
            error: function(jqXHR, textStatus, errorThrown){
                console.log(jqXHR.responseJSON);
            },
        });
    }

    function getRoles() {
        $.ajax({
            url: API_URL+"/api/roles",
            type: 'GET',
            headers: { 'Authorization': 'Bearer '+TOKEN },
            dataType: 'JSON',
            async: false,
            success: function(res, textStatus, jqXHR){
                let opt = ''

                $.each(res.data, function (index, item) {
                    if (index < 1) {
                        roleId = item.id;
                        opt += '<div class="choose-role col-span-12 sm:col-span-4 xxl:col-span-3 box p-5 cursor-pointer zoom-in bg-theme-1 dark:bg-theme-1" data-id="'+item.id+'">';
                        opt += '<div class="font-medium text-base text-white">'+item.name.toUpperCase()+'</div>';
                    } else {
                        opt += '<div class="choose-role col-span-12 sm:col-span-4 xxl:col-span-3 box p-5 cursor-pointer zoom-in" data-id="'+item.id+'">';
                        opt += '<div class="font-medium text-base">'+item.name.toUpperCase()+'</div>';
                    }
                    opt += '</div>';
                })
                $('#list-role').html(opt)
            },
            error: function(jqXHR, textStatus, errorThrown){

            },
        })
    }

    function getPermissions() {
        let _master = ['expense_categories', 'divisions', 'units', 'unit_conversions', 'categories', 'products', 'cake_variants', 'cake_types', 'stores', 'suppliers', 'customers', 'store_consignments', 'payment_methods', 'sellers', 'raw_materials'];
        let _inventory = ['stock_opnames', 'check_stocks'];
        let _sales = ['sales', 'custom_orders', 'sales_consignments', 'sales_returns'];
        let _purchase = ['purchase_orders', 'purchase_invoices', 'purchase_returns'];
        let _dR = ['debts', 'receivables'];
        let _reports = ['payments.report', 'sales.report', 'custom_orders.report', 'sales_consignments.report', 'purchase_invoices.report', 'sales_returns.report', 'purchase_returns.report', 'debts.report', 'receivables.report', 'costs.report', 'stock_mutations.report', 'productions.report', 'profit_loss.report', 'ledger_debt.report', 'ledger_receivable.report', 'ledger_cash_bank.report'];
        let _settings = ['users', 'permissions', 'roles', 'general_settings'];

        $.ajax({
            url: API_URL+"/api/permissions",
            type: 'GET',
            headers: { 'Authorization': 'Bearer '+TOKEN },
            dataType: 'JSON',
            success: function(res, textStatus, jqXHR){
                let buildCheckboxMaster = '';
                let buildCheckboxInventory = '';
                let buildCheckboxSales = '';
                let buildCheckboxPurchase = '';
                let buildCheckboxDr = '';
                let buildCheckboxReport = '';
                let buildCheckboxSetting = '';
                let buildCheckboxProduction = '';
                let buildCheckboxCost = '';

                $.each(res.data, function (index, item) {
                    if (_master.includes((item.name).split('.')[0])) {
                        if (item.name.toString().toLowerCase().indexOf(".") === -1) {
                            buildCheckboxMaster += '<div class="mt-3">';
                            buildCheckboxMaster += '    <h2><strong>'+makeTitle(item.name)+'</strong></h2> ';
                            buildCheckboxMaster += '    <div class="flex flex-col sm:flex-row mt-2">';
                            buildCheckboxMaster += '        <div class="flex items-center text-gray-700 dark:text-gray-500 mr-2">';
                            buildCheckboxMaster += '            <input type="checkbox" class="input border mr-2" id="'+item.id+'">';
                            buildCheckboxMaster += '            <label class="cursor-pointer select-none" for="'+item.id+'">List</label>';
                            buildCheckboxMaster += '        </div>';
                            $.each(res.data, function (key, value) {
                                if (value.name.indexOf(item.name) !== -1 && value.name.toString().toLowerCase().indexOf(".") !== -1 && (value.name).split('.')[0] == (item.name).split('.')[0] && value.name.toString().toLowerCase().indexOf(".report") === -1) {
                                    buildCheckboxMaster += '        <div class="flex items-center text-gray-700 dark:text-gray-500 mr-2">';
                                    buildCheckboxMaster += '            <input type="checkbox" class="input border mr-2" id="'+value.id+'">';
                                    buildCheckboxMaster += '            <label class="cursor-pointer select-none" for="'+value.id+'">'+makeTitle((value.name).split('.')[1])+'</label>';
                                    buildCheckboxMaster += '        </div>';
                                }
                            })
                            buildCheckboxMaster += '    </div>';
                            buildCheckboxMaster += '</div>';
                        }
                    }

                    if (_inventory.includes((item.name).split('.')[0])) {
                        if (item.name.toString().toLowerCase().indexOf(".") === -1) {
                            buildCheckboxInventory += '<div class="mt-3">';
                            buildCheckboxInventory += '    <h2><strong>'+makeTitle(item.name)+'</strong></h2> ';
                            buildCheckboxInventory += '    <div class="flex flex-col sm:flex-row mt-2">';
                            buildCheckboxInventory += '        <div class="flex items-center text-gray-700 dark:text-gray-500 mr-2">';
                            buildCheckboxInventory += '            <input type="checkbox" class="input border mr-2" id="'+item.id+'">';
                            buildCheckboxInventory += '            <label class="cursor-pointer select-none" for="'+item.id+'">List</label>';
                            buildCheckboxInventory += '        </div>';
                            $.each(res.data, function (key, value) {
                                if (value.name.indexOf(item.name) !== -1 && value.name.toString().toLowerCase().indexOf(".") !== -1 && (value.name).split('.')[0] == (item.name).split('.')[0] && value.name.toString().toLowerCase().indexOf(".report") === -1) {
                                    buildCheckboxInventory += '        <div class="flex items-center text-gray-700 dark:text-gray-500 mr-2">';
                                    buildCheckboxInventory += '            <input type="checkbox" class="input border mr-2" id="'+value.id+'">';
                                    buildCheckboxInventory += '            <label class="cursor-pointer select-none" for="'+value.id+'">'+makeTitle((value.name).split('.')[1])+'</label>';
                                    buildCheckboxInventory += '        </div>';
                                }
                            })
                            buildCheckboxInventory += '    </div>';
                            buildCheckboxInventory += '</div>';
                        }
                    }

                    if (_sales.includes((item.name).split('.')[0])) {
                        if (item.name.toString().toLowerCase().indexOf(".") === -1) {
                            buildCheckboxSales += '<div class="mt-3">';
                            buildCheckboxSales += '    <h2><strong>'+makeTitle(item.name)+'</strong></h2> ';
                            buildCheckboxSales += '    <div class="flex flex-col sm:flex-row mt-2">';
                            buildCheckboxSales += '        <div class="flex items-center text-gray-700 dark:text-gray-500 mr-2">';
                            buildCheckboxSales += '            <input type="checkbox" class="input border mr-2" id="'+item.id+'">';
                            buildCheckboxSales += '            <label class="cursor-pointer select-none" for="'+item.id+'">List</label>';
                            buildCheckboxSales += '        </div>';
                            $.each(res.data, function (key, value) {
                                if (value.name.indexOf(item.name) !== -1 && value.name.toString().toLowerCase().indexOf(".") !== -1 && (value.name).split('.')[0] == (item.name).split('.')[0] && value.name.toString().toLowerCase().indexOf(".report") === -1) {
                                    buildCheckboxSales += '        <div class="flex items-center text-gray-700 dark:text-gray-500 mr-2">';
                                    buildCheckboxSales += '            <input type="checkbox" class="input border mr-2" id="'+value.id+'">';
                                    buildCheckboxSales += '            <label class="cursor-pointer select-none" for="'+value.id+'">'+makeTitle((value.name).split('.')[1])+'</label>';
                                    buildCheckboxSales += '        </div>';
                                }
                            })
                            buildCheckboxSales += '    </div>';
                            buildCheckboxSales += '</div>';
                        }
                    }

                    if (_purchase.includes((item.name).split('.')[0])) {
                        if (item.name.toString().toLowerCase().indexOf(".") === -1) {
                            buildCheckboxPurchase += '<div class="mt-3">';
                            buildCheckboxPurchase += '    <h2><strong>'+makeTitle(item.name)+'</strong></h2> ';
                            buildCheckboxPurchase += '    <div class="flex flex-col sm:flex-row mt-2">';
                            buildCheckboxPurchase += '        <div class="flex items-center text-gray-700 dark:text-gray-500 mr-2">';
                            buildCheckboxPurchase += '            <input type="checkbox" class="input border mr-2" id="'+item.id+'">';
                            buildCheckboxPurchase += '            <label class="cursor-pointer select-none" for="'+item.id+'">List</label>';
                            buildCheckboxPurchase += '        </div>';
                            $.each(res.data, function (key, value) {
                                if (value.name.indexOf(item.name) !== -1 && value.name.toString().toLowerCase().indexOf(".") !== -1 && (value.name).split('.')[0] == (item.name).split('.')[0] && value.name.toString().toLowerCase().indexOf(".report") === -1) {
                                    buildCheckboxPurchase += '        <div class="flex items-center text-gray-700 dark:text-gray-500 mr-2">';
                                    buildCheckboxPurchase += '            <input type="checkbox" class="input border mr-2" id="'+value.id+'">';
                                    buildCheckboxPurchase += '            <label class="cursor-pointer select-none" for="'+value.id+'">'+makeTitle((value.name).split('.')[1])+'</label>';
                                    buildCheckboxPurchase += '        </div>';
                                }
                            })
                            buildCheckboxPurchase += '    </div>';
                            buildCheckboxPurchase += '</div>';
                        }
                    }

                    if (_dR.includes((item.name).split('.')[0])) {
                        if (item.name.toString().toLowerCase().indexOf(".") === -1) {
                            buildCheckboxDr += '<div class="mt-3">';
                            buildCheckboxDr += '    <h2><strong>'+makeTitle(item.name)+'</strong></h2> ';
                            buildCheckboxDr += '    <div class="flex flex-col sm:flex-row mt-2">';
                            buildCheckboxDr += '        <div class="flex items-center text-gray-700 dark:text-gray-500 mr-2">';
                            buildCheckboxDr += '            <input type="checkbox" class="input border mr-2" id="'+item.id+'">';
                            buildCheckboxDr += '            <label class="cursor-pointer select-none" for="'+item.id+'">List</label>';
                            buildCheckboxDr += '        </div>';
                            $.each(res.data, function (key, value) {
                                if (value.name.indexOf(item.name) !== -1 && value.name.toString().toLowerCase().indexOf(".") !== -1 && (value.name).split('.')[0] == (item.name).split('.')[0] && value.name.toString().toLowerCase().indexOf(".report") === -1) {
                                    buildCheckboxDr += '        <div class="flex items-center text-gray-700 dark:text-gray-500 mr-2">';
                                    buildCheckboxDr += '            <input type="checkbox" class="input border mr-2" id="'+value.id+'">';
                                    buildCheckboxDr += '            <label class="cursor-pointer select-none" for="'+value.id+'">'+makeTitle((value.name).split('.')[1])+'</label>';
                                    buildCheckboxDr += '        </div>';
                                }
                            })
                            buildCheckboxDr += '    </div>';
                            buildCheckboxDr += '</div>';
                        }
                    }

                    if (item.name.toString().toLowerCase().indexOf(".report") !== -1) {
                        if (_reports.includes((item.name))) {
                            buildCheckboxReport += '        <div class="flex items-center text-gray-700 dark:text-gray-500 mr-2">';
                            buildCheckboxReport += '            <input type="checkbox" class="input border mr-2" id="'+item.id+'">';
                            buildCheckboxReport += '            <label class="cursor-pointer select-none" for="'+item.id+'">'+makeTitle((item.name).split('.')[0])+'</label>';
                            buildCheckboxReport += '        </div>';
                        }
                    }

                    if (item.name.toString().toLowerCase().indexOf("productions.") !== -1 && item.name.toString().toLowerCase().indexOf(".report") === -1) {
                        buildCheckboxProduction += '        <div class="flex items-center text-gray-700 dark:text-gray-500 mr-2">';
                        buildCheckboxProduction += '            <input type="checkbox" class="input border mr-2" id="'+item.id+'">';
                        buildCheckboxProduction += '            <label class="cursor-pointer select-none" for="'+item.id+'">'+makeTitle((item.name).split('.')[1])+'</label>';
                        buildCheckboxProduction += '        </div>';
                    }

                    if (item.name.toString().toLowerCase().indexOf("costs.") !== -1 && item.name.toString().toLowerCase().indexOf(".report") === -1) {
                        buildCheckboxCost += '        <div class="flex items-center text-gray-700 dark:text-gray-500 mr-2">';
                        buildCheckboxCost += '            <input type="checkbox" class="input border mr-2" id="'+item.id+'">';
                        buildCheckboxCost += '            <label class="cursor-pointer select-none" for="'+item.id+'">'+makeTitle((item.name).split('.')[1])+'</label>';
                        buildCheckboxCost += '        </div>';
                    }

                    if (_settings.includes((item.name).split('.')[0])) {
                        if (item.name.toString().toLowerCase().indexOf(".") === -1) {
                            buildCheckboxSetting += '<div class="mt-3">';
                            buildCheckboxSetting += '    <h2><strong>'+makeTitle(item.name)+'</strong></h2> ';
                            buildCheckboxSetting += '    <div class="flex flex-col sm:flex-row mt-2">';
                            buildCheckboxSetting += '        <div class="flex items-center text-gray-700 dark:text-gray-500 mr-2">';
                            buildCheckboxSetting += '            <input type="checkbox" class="input border mr-2" id="'+item.id+'">';
                            buildCheckboxSetting += '            <label class="cursor-pointer select-none" for="'+item.id+'">List</label>';
                            buildCheckboxSetting += '        </div>';
                            $.each(res.data, function (key, value) {
                                if (value.name.indexOf(item.name) !== -1 && value.name.toString().toLowerCase().indexOf(".") !== -1 && (value.name).split('.')[0] == (item.name).split('.')[0] && value.name.toString().toLowerCase().indexOf(".report") === -1) {
                                    buildCheckboxSetting += '        <div class="flex items-center text-gray-700 dark:text-gray-500 mr-2">';
                                    buildCheckboxSetting += '            <input type="checkbox" class="input border mr-2" id="'+value.id+'">';
                                    buildCheckboxSetting += '            <label class="cursor-pointer select-none" for="'+value.id+'">'+makeTitle((value.name).split('.')[1])+'</label>';
                                    buildCheckboxSetting += '        </div>';
                                }
                            })
                            buildCheckboxSetting += '    </div>';
                            buildCheckboxSetting += '</div>';
                        }
                    }
                });

                $('#data-master').html(buildCheckboxMaster);
                $('#data-inventory').html(buildCheckboxInventory);
                $('#data-sales').html(buildCheckboxSales);
                $('#data-purchase').html(buildCheckboxPurchase);
                $('#data-dr').html(buildCheckboxDr);
                $('#data-report').html(buildCheckboxReport);
                $('#data-setting').html(buildCheckboxSetting);
                $('#data-production').html(buildCheckboxProduction);
                $('#data-cost').html(buildCheckboxCost);
            },
            error: function(jqXHR, textStatus, errorThrown){

            },
        })
    }

    $(document).on("click","div.choose-role",function() {
        let id = $(this).data('id');

        $('.choose-role').removeClass('bg-theme-1 dark:bg-theme-1');
        $('.choose-role > div').removeClass('text-white');
        $(this).addClass('bg-theme-1 dark:bg-theme-1');
        $(this).find('div').addClass('text-white');
        roleId = id;
        getRoleHasPermissions(id);
    });
</script>
@endsection