<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\DetailServicePackage;
use Illuminate\Http\Request;

class DetailServicePackageController extends Controller
{
    public function index()
    {
        $detailServicePackage = DetailServicePackage::with(['service', 'package'])->get();
        return response()->json([
            'data' => $detailServicePackage,
            'message' => 'success',
        ]);
    }

    public function single($id)
    {
        $detailServicePackage = DetailServicePackage::with(['service', 'package'])->find($id);

        return response()->json([
            'data' => $detailServicePackage,
            'message' => 'success',
        ]);
    }
}
