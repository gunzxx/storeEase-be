<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(){
        $documents = Document::orderBy('updated_at', 'DESC')->get();

        return view('report.index',[
            'title' => 'Report',
            'page' => 'order',
            'subpage1' => 'report',
            'documents' => $documents,
        ]);
    }

    public function upload()
    {
        return view('report.upload', [
            'title' => 'Upload Document',
            'page' => 'order',
            'subpage1' => 'report',
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'document' => 'required|mimes:pdf|max:2048',
        ]);
        
        if($request->other_type){
            $request->validate([
                'other_type' => 'required',
            ]);

            $document = Document::create([
                'name' => $request->name,
                'type' => $request->other_type,
            ]);
        }else{
            $request->validate([
                'type' => 'required',
            ]);

            $document = Document::create([
                'name' => $request->name,
                'type' => $request->type,
            ]);
        }

        $document
            ->addMediaFromRequest('document')
            ->toMediaCollection('pdf');

        return redirect('/order/report')->with(['success' => 'Data berhasil ditambahkan']);
    }

    public function delete($id){
        $document = Document::find($id);
        if (!$document) {
            return response()->json([
                'message' => 'data tidak ditemukan',
            ], 404);
        }

        $document->delete();
        return response()->json([
            'message' => 'data berhasil dihapus',
        ]);
    }
    
    public function edit($id)
    {
        $document = Document::find($id);
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

        return view('report.edit', [
            'title' => 'Edit Document',
            'page' => 'order',
            'subpage1' => 'report',
            'document' => $document,
            'options' => $options,
        ]);
    }
    
    public function update(Request $request, $id)
    {
        if(!$document = Document::find($id)){
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
            $request->validate([
                'document' => 'required|mimes:pdf|max:2048',
            ]);

            $document
                ->addMediaFromRequest('document')
                ->toMediaCollection('pdf');
        }

        return redirect('/order/report')->with(['success' => 'Data berhasil diperbarui']);
    }
}
