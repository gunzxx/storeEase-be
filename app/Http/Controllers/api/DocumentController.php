<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index(Request $request, $order_id)
    {
        $documents = Document::where([
            'order_id' => $order_id,
        ])->get();

        // $document_url = $documents->map(function($document){
        //     return $document->media->map(function($media){
        //         $data['name'] = $media->name;
        //         $data['url'] = $media->getUrl();
        //         return $data;
        //     });
        // });

        $document_url = $documents->map(function ($document) {
            return $document->media->map(function ($media) {
                return $media->getUrl();
            });
        });

        $document_url = array_merge(...$document_url->toArray());

        return response()->json([
            ...$document_url,
        ]);
    }
}
