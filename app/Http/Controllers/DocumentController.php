<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Order;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function create($uuid)
    {
        if (!$order = Order::where(['uuid' => $uuid])->first()) {
            return redirect('/order/list')->withErrors([
                'message' => 'Order not found',
            ]);
        }

        return view('document.upload', [
            'title' => 'Tambah Dokumen',
            'page' => 'order',
            'order' => $order,
            'subpage1' => 'report',
        ]);
    }

    public function store($uuid, Request $request)
    {
        if (!$order = Order::where(['uuid' => $uuid])->first()) {
            return redirect('/order/list')->withErrors([
                'message' => 'Order not found',
            ]);
        }
        
        $request->validate([
            'name' => 'required',
            'document' => 'required|mimes:pdf|max:2048',
        ]);

        if ($request->other_type) {
            $request->validate([
                'other_type' => 'required',
            ]);

            $document = Document::create([
                'name' => $request->name,
                'type' => $request->other_type,
                'order_id' => $order->id,
            ]);
        } else {
            $request->validate([
                'type' => 'required',
            ]);

            $document = Document::create([
                'name' => $request->name,
                'type' => $request->type,
                'order_id' => $order->id,
            ]);
        }

        $document
            ->addMediaFromRequest('document')
            ->toMediaCollection();

        return redirect("/order/$uuid/detail")->with(['success' => 'Data has been created']);
    }

    public function edit($uuid, $documentId)
    {
        if (!$order = Order::where(['uuid' => $uuid])->first()) {
            return redirect('/order/list')->withErrors([
                'message' => 'Order not found',
            ]);
        }
        if (!$document = Document::find($documentId)) {
            return redirect('/order/list')->withErrors([
                'message' => 'Document not found',
            ]);
        }

        $options = [
            "Notulensi Rapat Perdana",
            "Desain Venue",
            "MOU",
            "Invoice Down Payment",
            "Invoice Final Payment",
            "Desain Tata Ruang",
            "Tata Acara(Rundown)",
            "Laporan Akhir"
        ];

        return view('document.edit', [
            'title' => 'Tambah Dokumen',
            'page' => 'order',
            'order' => $order,
            'document' => $document,
            'options' => $options,
            'subpage1' => 'report',
        ]);
    }

    public function update($uuid, $documentId, Request $request)
    {
        if (!$order = Order::where(['uuid' => $uuid])->first()) {
            return redirect('/order/list')->withErrors([
                'message' => 'Order not found',
            ]);
        }
        if(!$document = Document::find($documentId)){
            return redirect('/order/report')->withErrors([
                'message' => 'Data tidak ditemukan',
            ]);
        }

        $request->validate([
            'name' => 'required',
        ]);
        
        if($request->other_type){
            $request->validate([
                'other_type' => 'required',
            ]);

            $document->update([
                'name' => $request->name,
                'type' => $request->other_type,
            ]);
        }else{
            $request->validate([
                'type' => 'required',
            ]);

            $document->update([
                'name' => $request->name,
                'type' => $request->type,
            ]);
        }

        if($request->hasFile('document')){
            foreach ($document->getMedia() as $media) {
                $media->delete();
            }
            $request->validate([
                'document' => 'required|mimes:pdf|max:2048',
            ]);

            $document
                ->addMediaFromRequest('document')
                ->toMediaCollection();
        }

        return redirect("/order/$uuid/detail")->with(['success' => 'Data has been updated']);
    }
}
