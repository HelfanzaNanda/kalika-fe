<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    public function index()
    {
    	$title = 'Order Pembelian';
        return view('purchase.purchase_order.'.__FUNCTION__, compact('title'));
    }

    public function create()
    {
        return view('purchase.purchase_order.'.__FUNCTION__, [
            'title' => ' Tambah Pembelian'
        ]);
    }
    
    public function edit($id)
    {
        return view('purchase.purchase_order.'.__FUNCTION__, [
            'title' => ' Edit Pembelian',
            'id' => $id
        ]);
    }

    public function receipt($id)
    {
        return view('purchase.purchase_order.'.__FUNCTION__, [
            'title' => ' Penerimaan Pembelian',
            'id' => $id
        ]);
    }
}
