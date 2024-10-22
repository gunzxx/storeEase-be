<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test(){
        // $document = Document::with(['media'])->get();
        // return response()->json($document);
        $document = Document::find(3);
        // $document->delete();
        return response()->json($document);
    }
}
