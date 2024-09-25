<?php

namespace App\Http\Controllers\api\product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request){
        return response()->json([
            'message' => 'berhasil'
        ]);
    }

    public function create(Request $request){
        return response()->json([
            'message' => 'berhasil'
        ]);
    }

    public function update(Request $request){
        return response()->json([
            'message' => 'berhasil'
        ]);
    }

    public function delete(Request $request){
        return response()->json([
            'message' => 'berhasil'
        ]);
    }
}
