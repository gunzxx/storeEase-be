<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController2 extends Controller
{
    public function to2($uuid, Request $request)
    {
        $order = Order::where(['uuid' => $uuid])->first();
        if (!$order) {
            return redirect('/order/list')->withErrors([
                'message' => 'Order not found',
            ]);
        }

        $request->validate([
            'meeting_date' => 'required',
        ]);

        $order->update([
            'first_meet_date' => $request->meeting_date,
            'status_order_id' => 2,
        ]);
        return redirect("/order/$uuid/detail")->with([
            'success' => 'Data has been updated',
        ]);
    }

    public function uploadMeetingReport($uuid)
    {
        $order = Order::where(['uuid' => $uuid])->first();
        if (!$order) {
            return redirect('/order/list')->withErrors([
                'message' => 'Order not found',
            ]);
        }
        $package = $order->detailServicePackage->package;

        return view('order.detail.2-upload', [
            'title' => 'Unggah Notulensi Rapat Perdana',
            'page' => 'order',
            'subpage1' => 'order',
            'order' => $order,
            'package' => $package,
        ]);
    }

    public function storeMeetingReport($uuid, Request $request)
    {
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
        if ($request->type != 'Notulensi Rapat Perdana') {
            return redirect()->back()->withErrors([
                'type' => 'Hanya menerima file bertipe Notulensi Rapat Perdana'
            ]);
        }

        if ($document = Document::where(['order_id' => $order->id, 'type' => 'Notulensi Rapat Perdana'])->first()) {
            $document->delete();
        }
        $document = Document::create([
            'name' => $request->name,
            'type' => $request->type,
            'order_id' => $order->id,
        ]);

        $document->addMediaFromRequest('document')->toMediaCollection('first_meet');

        return redirect("/order/{$order->uuid}/detail")->with([
            'success' => 'Data has been updated',
        ]);
    }
}
