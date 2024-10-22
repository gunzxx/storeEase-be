<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\JobDesk;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test(){
        // $document = Document::with(['media'])->get();
        // return response()->json($document);
        $document = JobDesk::find(4);
        $document->delete();
        return response()->json($document);
    }
}
