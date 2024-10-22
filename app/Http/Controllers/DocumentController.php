<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function create($uuid){
        if (!$order = Order::where(['uuid' => $uuid])->first()) {
            return redirect('/order/list')->withErrors([
                'message' => 'Order not found',
            ]);
        }
        
        return view('report.upload', [
            'title' => 'Tambah Dokumen',
            'page' => 'order',
            'order' => $order,
            'subpage1' => 'report',
        ]);
    }
}
