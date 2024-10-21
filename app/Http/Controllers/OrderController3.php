<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Invoice;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController3 extends Controller
{
    public function to3($uuid, Request $request)
    {
        $order = Order::where(['uuid' => $uuid])->with('document', function ($document) {
            $document->where(['type' => 'Notulensi Rapat Perdana']);
        })->first();

        if (!$order) {
            return redirect('/order/list')->withErrors([
                'message' => 'Order not found',
            ]);
        }

        if ($order->document->count() < 1) {
            return redirect("/order/$uuid/detail")->withErrors([
                'document' => 'Please upload meeting report (Notulensi Rapat Perdana)'
            ]);
        }

        $order->update([
            'status_order_id' => 3,
        ]);

        return redirect("/order/$uuid/detail")->with([
            'success' => 'Data has been updated',
        ]);
    }

    public function downPayment($uuid)
    {
        $order = Order::where(['uuid' => $uuid])->first();
        if (!$order) {
            return redirect('/order/list')->withErrors([
                'message' => 'Order not found',
            ]);
        }

        return view('order.detail.3-down-payment', [
            'title' => "Unggah Down Payment",
            'page' => 'order',
            'subpage1' => 'order',
            'order' => $order,
        ]);
    }
    
    public function storeDownPayment($uuid, Request $request){
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
        if ($request->type != 'Invoice Down Payment') {
            return redirect()->back()->withErrors([
                'type' => 'Hanya menerima file bertipe Invoice Down Payment'
            ]);
        }

        if ($document = Document::where(['order_id' => $order->id, 'type' => 'Invoice Down Payment'])->first()) {
            $document->delete();
        }
        $document = Document::create([
            'name' => $request->name,
            'type' => $request->type,
            'order_id' => $order->id,
        ]);

        $document->addMediaFromRequest('document')->toMediaCollection('down_payment');

        return redirect("/order/{$order->uuid}/detail")->with([
            'success' => 'Data has been updated',
        ]);
    }
    
    public function invoiceDownPayment($uuid)
    {
        $order = Order::where(['uuid' => $uuid])->first();
        if (!$order) {
            return redirect('/order/list')->withErrors([
                'message' => 'Order not found',
            ]);
        }

        return view('order.detail.3-invoice-down-payment', [
            'title' => "Unggah Bukti Transaksi Down Payment",
            'page' => 'order',
            'subpage1' => 'order',
            'uuid' => $order->uuid,
        ]);
    }
    
    public function storeInvoiceDownPayment($uuid, Request $request){
        $order = Order::where(['uuid' => $uuid])->first();
        if (!$order) {
            return redirect('/order/list')->withErrors([
                'message' => 'Order not found',
            ]);
        }

        $request->validate([
            'name' => 'required',
            'invoice' => 'required|mimes:pdf|max:2048',
        ]);

        if ($invoice = Invoice::where(['order_id' => $order->id, 'type' => 'down_payment'])->first()) {
            $invoice->delete();
        }
        $invoice = Invoice::create([
            'name' => $request->name,
            'type' => 'Invoice Down Payment',
            'order_id' => $order->id,
        ]);

        $invoice->addMediaFromRequest('invoice')->toMediaCollection('down_payment');

        return redirect("/order/{$order->uuid}/detail")->with([
            'success' => 'Data has been updated',
        ]);
    }
}
