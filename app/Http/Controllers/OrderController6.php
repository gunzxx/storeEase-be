<?php

namespace App\Http\Controllers;

use App\Models\JobDesk;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController6 extends Controller
{
    public function to6($uuid)
    {
        $order = Order::where(['uuid' => $uuid])->with('document', function ($document) {
            $document->where(['type' => 'Invoice Final Payment']);
        })
            ->with('invoice', function ($invoice) {
                $invoice->where(['type' => 'Invoice Final Payment']);
            })
            ->first();

        if (!$order) {
            return redirect('/order/list')->withErrors([
                'message' => 'Order not found',
            ]);
        }

        if ($order->document->count() < 1) {
            return redirect("/order/$uuid/detail")->withErrors([
                'document' => 'Harap unggah File Invoice Final Payment'
            ]);
        }

        if ($order->invoice->count() < 1) {
            return redirect("/order/$uuid/detail")->withErrors([
                'document' => 'Harap unggah Bukti Transaksi'
            ]);
        }

        JobDesk::create([
            'name' => 'Persiapan Akhir',
            'order_id' => $order->id,
        ]);

        $order->update([
            'status_order_id' => 6,
        ]);

        return redirect("/order/$uuid/detail")->with([
            'success' => 'Data has been updated',
        ]);
    }
}
