<?php

namespace App\Http\Controllers\api\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request){
        return response()->json([
            'message' => 'berhasil'
        ]);
    }
}
