<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Invoice;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController5 extends Controller
{
    public function to5($uuid){
        if (!$order = Order::where(['uuid' => $uuid])->first()) {
            return redirect('/order/list')->withErrors([
                'message' => 'Order not found',
            ]);
        }

        $order->update([
            'status_order_id' => 5,
        ]);

        return redirect("/order/$uuid/detail")->with([
            'success' => 'Data has been updated',
        ]);
    }

    public function finalPayment($uuid){
        $order = Order::where(['uuid' => $uuid])->first();
        if (!$order) {
            return redirect('/order/list')->withErrors([
                'message' => 'Order not found',
            ]);
        }

        return view('order.detail.5-final-payment', [
            'title' => "Unggah Dokumen Final Payment",
            'page' => 'order',
            'subpage1' => 'order',
            'order' => $order,
        ]);
    }

    public function storeFinalPayment($uuid, Request $request){
        $order = Order::where(['uuid' => $uuid])->first();
        if (!$order) {
            return redirect('/order/list')->withErrors([
                'message' => 'Order not found',
            ]);
        }

        $request->validate([
            'name' => 'required',
            'document' => 'required|mimes:pdf|max:2048',
            'type' => 'required',
        ]);
        if ($request->type != 'Invoice Final Payment') {
            return redirect()->back()->withErrors([
                'type' => 'Hanya menerima file bertipe Invoice Final Payment'
            ]);
        }

        if ($document = Document::where(['order_id' => $order->id, 'type' => 'Invoice Final Payment'])->first()) {
            $document->delete();
        }
        $document = Document::create([
            'name' => $request->name,
            'type' => $request->type,
            'order_id' => $order->id,
        ]);

        $document->addMediaFromRequest('document')->toMediaCollection('final_payment');

        return redirect("/order/{$order->uuid}/detail")->with([
            'success' => 'Data has been updated',
        ]);
    }

    public function invoiceFinalPayment($uuid)
    {
        $order = Order::where(['uuid' => $uuid])->first();
        if (!$order) {
            return redirect('/order/list')->withErrors([
                'message' => 'Order not found',
            ]);
        }

        return view('order.detail.5-invoice-final-payment', [
            'title' => "Unggah Bukti Transaksi Final Payment",
            'page' => 'order',
            'subpage1' => 'order',
            'uuid' => $order->uuid,
        ]);
    }

    public function storeInvoiceFinalPayment($uuid, Request $request){
        $order = Order::where(['uuid' => $uuid])->first();
        if (!$order) {
            return redirect('/order/list')->withErrors([
                'message' => 'Order not found',
            ]);
        }

        $request->validate([
            // 'name' => 'required',
            'invoice' => 'required|mimes:pdf|max:2048',
        ]);

        if ($invoice = Invoice::where(['order_id' => $order->id, 'type' => 'Invoice Final Payment'])->first()) {
            $invoice->delete();
        }
        $invoice = Invoice::create([
            'name' => 'Invoice Final Payment',
            'type' => 'Invoice Final Payment',
            'order_id' => $order->id,
        ]);

        $invoice->addMediaFromRequest('invoice')->toMediaCollection('final_payment');

        return redirect("/order/{$order->uuid}/detail")->with([
            'success' => 'Data has been updated',
        ]);
    }
}
