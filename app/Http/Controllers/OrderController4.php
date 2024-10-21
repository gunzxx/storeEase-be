<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController4 extends Controller
{
    public function to4($uuid, Request $request)
    {
        $order = Order::where(['uuid' => $uuid])->with('document', function ($document) {
            $document->where(['type' => 'Invoice Down Payment']);
        })
        ->with('invoice', function($invoice){
            $invoice->where(['type' => 'Invoice Down Payment']);
        })
        ->first();

        if (!$order) {
            return redirect('/order/list')->withErrors([
                'message' => 'Order not found',
            ]);
        }

        if ($order->document->count() < 1) {
            return redirect("/order/$uuid/detail")->withErrors([
                'document' => 'Harap unggah File Invoice Down Payment'
            ]);
        }

        if ($order->invoice->count() < 1) {
            return redirect("/order/$uuid/detail")->withErrors([
                'document' => 'Harap unggah Bukti Transaksi'
            ]);
        }

        $order->update([
            'status_order_id' => 4,
        ]);

        return redirect("/order/$uuid/detail")->with([
            'success' => 'Data has been updated',
        ]);
    }
}