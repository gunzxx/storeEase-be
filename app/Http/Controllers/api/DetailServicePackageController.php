<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\DetailServicePackage;
use Illuminate\Http\Request;

class DetailServicePackageController extends Controller
{
    public function index()
    {
        $detailServicePackage = DetailServicePackage::
            with(['service'])
            // ->with(['package'])
            ->with('package', function($packages){
                $packages->with(['media']);
            })
            ->get();

        $detailServicePackageNew = $detailServicePackage->map(function($detailPackage){
            $mediaUrls = $detailPackage->package->getMedia('preview_img')->map(function($media){
                return $media->getUrl();
            });

            $detailPackage['preview_img'] = $mediaUrls;
            unset($detailPackage->package['media']);
            return $detailPackage;
        });

        return response()->json([
            'data' => $detailServicePackageNew,
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
