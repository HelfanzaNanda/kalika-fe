if ($("#datepicker-popup").length) {
  $('#datepicker-popup').datepicker({
    enableOnReadonly: true,
    todayHighlight: true,
    autoclose: true,
    format: 'yyyy-mm-dd'
  });
}

function addSeparator(nStr, inD = '.', outD = '.', sep = '.') {
  nStr += '';
  var dpos = nStr.indexOf(inD);
  var nStrEnd = '';
  if (dpos != -1) {
    nStrEnd = outD + nStr.substring(dpos + 1, nStr.length);
    nStr = nStr.substring(0, dpos);
  }
  var rgx = /(\d+)(\d{3})/;
  while (rgx.test(nStr)) {
    nStr = nStr.replace(rgx, '$1' + sep + '$2');
  }
  return nStr + nStrEnd;
}

function formatDateIndo(str) {
  var dataMonth = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
  
  if (str) {
    var result = str.split('-');

    var date = result[2];
    var month = dataMonth[parseInt(result[1]) - 1];
    var year = result[0];

    return date + ' ' + month + ' ' + year;
  }

  return str;
}

function formatDateTimeIndo(str) {
  var dataMonth = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
  
  if (str) {
    var dateTime = str.split(' ');

    var result = dateTime[0].split('-');

    var date = result[2];
    var month = dataMonth[parseInt(result[1]) - 1];
    var year = result[0];

    return date + ' ' + month + ' ' + year + ' ' + dateTime[1];
  }

  return str;
}

var toHHMMSS = (secs) => {
    var sec_num = parseInt(secs, 10)
    var hours   = Math.floor(sec_num / 3600)
    var minutes = Math.floor(sec_num / 60) % 60
    var seconds = sec_num % 60

    return [hours,minutes,seconds]
        .map(v => v < 10 ? "0" + v : v)
        .filter((v,i) => v !== "00" || i > 0)
        .join(":")
}

function getAge(dateString) {
  var now = new Date();
  var today = new Date(now.getYear(),now.getMonth(),now.getDate());

  var yearNow = now.getYear();
  var monthNow = now.getMonth();
  var dateNow = now.getDate();

  var dob = new Date(dateString.substring(0,4),
                     dateString.substring(5,7)-1,                   
                     dateString.substring(8,10)                  
                     );

  var yearDob = dob.getYear();
  var monthDob = dob.getMonth();
  var dateDob = dob.getDate();
  var age = {};
  var ageString = "";
  var yearString = "";
  var monthString = "";
  var dayString = "";


  yearAge = yearNow - yearDob;

  if (monthNow >= monthDob)
    var monthAge = monthNow - monthDob;
  else {
    yearAge--;
    var monthAge = 12 + monthNow -monthDob;
  }

  if (dateNow >= dateDob)
    var dateAge = dateNow - dateDob;
  else {
    monthAge--;
    var dateAge = 31 + dateNow - dateDob;

    if (monthAge < 0) {
      monthAge = 11;
      yearAge--;
    }
  }

  age = {
      years: yearAge,
      months: monthAge,
      days: dateAge
      };

  if ( age.years > 1 ) yearString = " thn";
  else yearString = " thn";
  if ( age.months> 1 ) monthString = " bln";
  else monthString = " bln";
  if ( age.days > 1 ) dayString = " hr";
  else dayString = " hr";

  if ( (age.years > 0) && (age.months > 0) && (age.days > 0) )
    ageString = age.years + yearString + ", " + age.months + monthString + ", " + age.days + dayString;
  else if ( (age.years == 0) && (age.months == 0) && (age.days > 0) )
    ageString = age.days + dayString;
  else if ( (age.years > 0) && (age.months == 0) && (age.days == 0) )
    ageString = age.years + yearString + ". Selamat Ulang Tahun!";
  else if ( (age.years > 0) && (age.months > 0) && (age.days == 0) )
    ageString = age.years + yearString + ", " + age.months + monthString;
  else if ( (age.years == 0) && (age.months > 0) && (age.days > 0) )
    ageString = age.months + monthString + ", " + age.days + dayString;
  else if ( (age.years > 0) && (age.months == 0) && (age.days > 0) )
    ageString = age.years + yearString + ", " + age.days + dayString;
  else if ( (age.years == 0) && (age.months > 0) && (age.days == 0) )
    ageString = age.months + monthString;
  else ageString = "Oops! Could not calculate age!";

  return ageString;
}

function addCommas(nStr) {
    nStr += '';
    var x = nStr.split('.');
    var x1 = x[0];
    var x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

function detectFloat(source) {
    let float = accounting.unformat(source);
    let posComma = source.indexOf('.');
    if (posComma > -1) {
        let posDot = source.indexOf(',');
        if (posDot > -1 && posComma > posDot) {
            let germanFloat = accounting.unformat(source, '.');
            if (Math.abs(germanFloat) > Math.abs(float)) {
                float = germanFloat;
            }
        } else {
            // source = source.replace(/,/g, '.');
            float = accounting.unformat(source, '.');
        }
    }
    return float;
}

function slugify(content) {
    return content.toLowerCase().replace(/ /g,'-').replace(/[^\w-]+/g,'');
}

function buildMenu(permissions) {
  let _menu = {
    'divisions': {
      'name': 'Divisi',
      'url': '/divisions'
    },
    'categories': {
      'name': 'Kategori',
      'url': '/categories'
    },
    'products': {
      'name': 'Produk',
      'url': '/products'
    },
    'cake_variants': {
      'name': 'Variant Cake',
      'url': '/cake_variants'
    },
    'cake_types': {
      'name': 'Tipe Cake',
      'url': '/cake_types'
    },
    'stores': {
      'name': 'Toko',
      'url': '/stores'
    },
    'suppliers': {
      'name': 'Supplier',
      'url': '/suppliers'
    },
    'customers': {
      'name': 'Kustomer',
      'url': '/customers'
    },
    'store_consignments': {
      'name': 'Konsinyasi',
      'url': '/store_consignments'
    },
    'payment_methods': {
      'name': 'Metode Pembayaran',
      'url': '/payment_methods'
    },
    'sellers': {
      'name': 'Penjual',
      'url': '/sellers'
    },
    'costs': {
      'name': 'Biaya',
      'url': '/costs'
    },
    'raw_materials': {
      'name': 'Bahan Baku',
      'url': '/raw_materials'
    },
    'cash_registers': {
      'name': 'Uang Kasir',
      'url': '/cash_registers'
    },
    'beginning_stocks': {
      'name': 'Stok Awal',
      'url': '/beginning_stocks'
    },
    'stock_opnames': {
      'name': 'Stok Opname',
      'url': '/stock_opnames'
    },
    'sales': {
      'name': 'Penjualan',
      'url': '/sales'
    },
    'custom_orders': {
      'name': 'Penjualan Pesanan',
      'url': '/custom_orders'
    },
    'sales_consignments': {
      'name': 'Penjualan Konsinyasi',
      'url': '/sales_consignments'
    },
    'sales_returns': {
      'name': 'Retur Penjualan',
      'url': '/sales_returns'
    },
    'purchase_orders': {
      'name': 'Order Pembelian (PO)',
      'url': '/purchase_orders'
    },
    'purchase_invoices': {
      'name': 'Penerimaan Pembelian',
      'url': '/purchase_invoices'
    },
    'purchase_returns': {
      'name': 'Retur Pembelian',
      'url': '/purchase_returns'
    },
    'debts': {
      'name': 'Hutang',
      'url': '/debts'
    },
    'receivables': {
      'name': 'Piutang',
      'url': '/receivables'
    },
    'purchase_invoices.report': {
      'name': 'Laporan Pembelian',
      'url': '/purchase'
    },
    'sales_returns.report': {
      'name': 'Laporan Retur Penjualan',
      'url': '/sales_returns'
    },
    'purchase_returns.report': {
      'name': 'Laporan Return Pembelian',
      'url': '/purchase_returns'
    },
    'debts.report': {
      'name': 'Laporan Hutang',
      'url': '/debts'
    },
    'receivables.report': {
      'name': 'Laporan Piutang',
      'url': '/receivables'
    },
    'sales.report': {
      'name': 'Laporan Penjualan',
      'url': '/sales'
    },
    'costs.report': {
      'name': 'Laporan Biaya',
      'url': '/costs'
    },
    'stock_mutations.report': {
      'name': 'Laporan Stok Mutasi',
      'url': '/stock_mutations'
    },
    'productions.report': {
      'name': 'Laporan Produksi',
      'url': '/productions'
    },
    'profit_loss.report': {
      'name': 'Laporan L/R',
      'url': '/profit_loss'
    },
    'users': {
      'name': 'Pengguna',
      'url': '/users'
    },
    'permissions': {
      'name': 'Hak Akses',
      'url': '/permissions'
    },
    'roles': {
      'name': 'Role',
      'url': '/roles'
    },
  };

  let _master = ['divisions', 'categories', 'products', 'cake_variants', 'cake_types', 'stores', 'suppliers', 'customers', 'store_consignments', 'payment_methods', 'sellers', 'costs', 'raw_materials', 'cash_registers']
  let _inventory = ['beginning_stocks', 'stock_opnames'];
  let _sales = ['sales', 'custom_orders', 'sales_consignments', 'sales_returns'];
  let _purchase = ['purchase_orders', 'purchase_invoices', 'purchase_returns'];
  let _dR = ['debts', 'receivables'];
  let _reports = ['sales.report', 'purchase_invoices.report', 'sales_returns.report', 'purchase_returns.report', 'debts.report', 'receivables.report', 'costs.report', 'stock_mutations.report', 'productions.report', 'profit_loss.report'];
  let _settings = ['users', 'permissions', 'roles'];

  let _p = JSON.parse(permissions);
  let masterMenu = '';
  let inventoryMenu = '';
  let salesMenu = '';
  let purchaseMenu = '';
  let drMenu = '';
  let reportMenu = '';
  let settingMenu = '';
  let costMenu = '';
  let productionMenu = '';

  $.each(_p, function(key, value) {
    if (value.permission_name.toString().toLowerCase().indexOf(".") === -1) {
      if (_master.includes(value.permission_name)) {
        masterMenu += '        <li>';
        masterMenu += '            <a href="'+BASE_URL+'/master'+_menu[value.permission_name]['url']+'" class="side-menu">';
        masterMenu += '                <div class="side-menu__icon"> <i data-feather="activity"></i></div>';
        masterMenu += '                <div class="side-menu__title">'+_menu[value.permission_name]['name']+'</div>';
        masterMenu += '            </a>';
        masterMenu += '        </li>';
      }

      if (_inventory.includes(value.permission_name)) {
        inventoryMenu += '        <li>';
        inventoryMenu += '            <a href="'+BASE_URL+'/inventory'+_menu[value.permission_name]['url']+'" class="side-menu">';
        inventoryMenu += '                <div class="side-menu__icon"> <i data-feather="activity"></i></div>';
        inventoryMenu += '                <div class="side-menu__title">'+_menu[value.permission_name]['name']+'</div>';
        inventoryMenu += '            </a>';
        inventoryMenu += '        </li>';
      }

      if (_sales.includes(value.permission_name)) {
        salesMenu += '        <li>';
        salesMenu += '            <a href="'+BASE_URL+'/sales'+_menu[value.permission_name]['url']+'" class="side-menu">';
        salesMenu += '                <div class="side-menu__icon"> <i data-feather="activity"></i></div>';
        salesMenu += '                <div class="side-menu__title">'+_menu[value.permission_name]['name']+'</div>';
        salesMenu += '            </a>';
        salesMenu += '        </li>';
      }

      if (_purchase.includes(value.permission_name)) {
        purchaseMenu += '        <li>';
        purchaseMenu += '            <a href="'+BASE_URL+'/purchase'+_menu[value.permission_name]['url']+'" class="side-menu">';
        purchaseMenu += '                <div class="side-menu__icon"> <i data-feather="activity"></i></div>';
        purchaseMenu += '                <div class="side-menu__title">'+_menu[value.permission_name]['name']+'</div>';
        purchaseMenu += '            </a>';
        purchaseMenu += '        </li>';
      }

      if (_dR.includes(value.permission_name)) {
        drMenu += '        <li>';
        drMenu += '            <a href="'+BASE_URL+'/debt_receivable'+_menu[value.permission_name]['url']+'" class="side-menu">';
        drMenu += '                <div class="side-menu__icon"> <i data-feather="activity"></i></div>';
        drMenu += '                <div class="side-menu__title">'+_menu[value.permission_name]['name']+'</div>';
        drMenu += '            </a>';
        drMenu += '        </li>';
      }

      if (_settings.includes(value.permission_name)) {
        settingMenu += '        <li>';
        settingMenu += '            <a href="'+BASE_URL+'/setting'+_menu[value.permission_name]['url']+'" class="side-menu">';
        settingMenu += '                <div class="side-menu__icon"> <i data-feather="activity"></i></div>';
        settingMenu += '                <div class="side-menu__title">'+_menu[value.permission_name]['name']+'</div>';
        settingMenu += '            </a>';
        settingMenu += '        </li>';
      }

      if (value.permission_name == 'expenses') {
        costMenu += '<li>';
        costMenu += '    <a href="'+BASE_URL+'/expense" class="side-menu">    ';
        costMenu += '        <div class="side-menu__icon"> <i data-feather="dollar-sign"></i></div>';
        costMenu += '        <div class="side-menu__title">Biaya</div>';
        costMenu += '    </a>';
        costMenu += '</li>';
      }

      if (value.permission_name == 'productions') {
        productionMenu += '<li>';
        productionMenu += '    <a href="'+BASE_URL+'/production" class="side-menu">    ';
        productionMenu += '        <div class="side-menu__icon"> <i data-feather="settings"></i></div>';
        productionMenu += '        <div class="side-menu__title">Produksi</div>';
        productionMenu += '    </a>';
        productionMenu += '</li>';
      }
    } else if (value.permission_name.toString().toLowerCase().indexOf(".report") !== -1) {
      if (_reports.includes(value.permission_name)) {
        reportMenu += '        <li>';
        reportMenu += '            <a href="'+BASE_URL+'/report'+_menu[value.permission_name]['url']+'" class="side-menu">';
        reportMenu += '                <div class="side-menu__icon"> <i data-feather="activity"></i></div>';
        reportMenu += '                <div class="side-menu__title">'+_menu[value.permission_name]['name']+'</div>';
        reportMenu += '            </a>';
        reportMenu += '        </li>';
      }
    }
  });

  let html = '';

  html += '<li>';
  html += '    <a href="'+BASE_URL+'" class="side-menu side-menu--active">';
  html += '        <div class="side-menu__icon"> <i data-feather="home"></i></div>';
  html += '            <div class="side-menu__title">Dashboard</div>';
  html += '    </a>';
  html += '</li>';
  
  if (masterMenu != '') {
    html += '<li>';
    html += '    <a href="javascript:;" class="side-menu">';
    html += '        <div class="side-menu__icon"> <i data-feather="archive"></i></div>';
    html += '        <div class="side-menu__title">Data Master <i data-feather="chevron-down" class="side-menu__sub-icon"></i></div>';
    html += '    </a>';
    html += '    <ul>';
    html += masterMenu;
    html += '    </ul>';
    html += '</li>';
  }
  
  if (inventoryMenu != '') {
    html += '<li>';
    html += '    <a href="javascript:;" class="side-menu">';
    html += '        <div class="side-menu__icon"> <i data-feather="box"></i></div>';
    html += '        <div class="side-menu__title">Inventory<i data-feather="chevron-down" class="side-menu__sub-icon"></i></div>';
    html += '    </a>';
    html += '    <ul>';
    html += inventoryMenu;
    html += '    </ul>';
    html += '</li>';
  }
  
  if (salesMenu != '') {
    html += '<li>';
    html += '    <a href="javascript:;" class="side-menu">';
    html += '        <div class="side-menu__icon"> <i data-feather="corner-right-up"></i></div>';
    html += '        <div class="side-menu__title">Penjualan <i data-feather="chevron-down" class="side-menu__sub-icon"></i></div>';
    html += '    </a>';
    html += '    <ul>';
    html += salesMenu;
    html += '    </ul>';
    html += '</li>';
  }
  
  if (purchaseMenu != '') {
    html += '<li>';
    html += '    <a href="javascript:;" class="side-menu">';
    html += '        <div class="side-menu__icon"> <i data-feather="corner-right-down"></i></div>';
    html += '        <div class="side-menu__title">Pembelian <i data-feather="chevron-down" class="side-menu__sub-icon"></i></div>';
    html += '    </a>';
    html += '    <ul>';
    html += purchaseMenu;
    html += '    </ul>';
    html += '</li>';
  }
  
  if (drMenu != '') {
    html += '<li>';
    html += '    <a href="javascript:;" class="side-menu">';
    html += '        <div class="side-menu__icon"> <i data-feather="repeat"></i></div>';
    html += '        <div class="side-menu__title">Hutang Piutang <i data-feather="chevron-down" class="side-menu__sub-icon"></i></div>';
    html += '    </a>';
    html += '    <ul>';
    html += drMenu;
    html += '    </ul>';
    html += '</li>';
  }

  html += costMenu;
  html += productionMenu;
  
  if (reportMenu != '') {
    html += '<li>';
    html += '    <a href="javascript:;" class="side-menu">';
    html += '        <div class="side-menu__icon"> <i data-feather="file-text"></i></div>';
    html += '        <div class="side-menu__title">Laporan <i data-feather="chevron-down" class="side-menu__sub-icon"></i></div>';
    html += '    </a>';
    html += '    <ul>';
    html += reportMenu;
    html += '    </ul>';
    html += '</li>';
  }
  
  if (settingMenu != '') {
    html += '<li>';
    html += '    <a href="javascript:;" class="side-menu">';
    html += '        <div class="side-menu__icon"> <i data-feather="tool"></i></div>';
    html += '        <div class="side-menu__title">Pengaturan <i data-feather="chevron-down" class="side-menu__sub-icon"></i></div>';
    html += '    </a>';
    html += '    <ul>';
    html += settingMenu;
    html += '    </ul>';
    html += '</li>';
  }
  
  $('ul#menu-build-placeholder').html(html);
  feather.replace();

  $('.side-menu').on('click', function () {
    if ($(this).parent().find('ul').length) {
      if ($(this).parent().find('ul').first().is(':visible')) {
        $(this).find('.side-menu__sub-icon').removeClass('transform rotate-180');
        $(this).removeClass('side-menu--open');
        $(this).parent().find('ul').first().slideUp({
          done: function done() {
            $(this).removeClass('side-menu__sub-open');
          }
        });
      } else {
        $(this).find('.side-menu__sub-icon').addClass('transform rotate-180');
        $(this).addClass('side-menu--open');
        $(this).parent().find('ul').first().slideDown({
          done: function done() {
            $(this).addClass('side-menu__sub-open');
          }
        });
      }
    }
  });
}