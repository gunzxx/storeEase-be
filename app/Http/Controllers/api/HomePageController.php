<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    public function index(){
        $serviceCategory = ServiceCategory::with(['service'])->get();
        return response()->json([
            'data' => $serviceCategory,
            'message' => 'success',
        ]);
    }
}
