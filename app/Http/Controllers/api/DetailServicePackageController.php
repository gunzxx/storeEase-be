<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\DetailServicePackage;
use App\Models\PackageCategory;
use Illuminate\Http\Request;

class DetailServicePackageController extends Controller
{
    public function index()
    {
        $packages = PackageCategory::with(['package'])
            ->with("package", function ($packages) {
                $packages->with(['media']);
            })
            ->get();

        $packages->map(function ($categoryPackages) {
            $categoryPackages->package->map(function ($package) {
                return $package['preview_url'] = $package->getMedia('preview_img')->map(function ($media) {
                    return $media->getUrl();
                });
            });

            $categoryPackages->package->map(function ($package) {
                unset($package['media']);
            });
            return $categoryPackages;
        });

        // $categoryNew = $packages->map(function($detailPackage){
        //     $mediaUrls = $detailPackage->package->getMedia('preview_img')->map(function($media){
        //         return $media->getUrl();
        //     });
        //     $detailPackage['preview_img'] = $mediaUrls;
        //     unset($detailPackage->package['media']);
        //     return $detailPackage;
        // });

        return response()->json([
            'data' => $packages,
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
