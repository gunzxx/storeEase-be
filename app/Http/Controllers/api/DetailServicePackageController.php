<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\DetailServicePackage;
use App\Models\Package;
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
                $package['preview_url'] = $package->getMedia('preview_img')->map(function ($media) {
                    return $media->getUrl();
                });

                unset($package['media']);
                return $package;
            });

            return $categoryPackages;
        });

        return response()->json([
            'data' => $packages,
            'message' => 'success',
        ]);
    }

    public function single($id)
    {
        if (!$package = Package::with(['media', 'packageCategory'])->find($id)) {
            return response()->json([
                'message' => 'package not found',
            ], 404);
        }

        $url = $package->getMedia('preview_img')->map(function ($media) {
            return $media->getUrl();
        });
        unset($package['media']);
        $package['preview_url'] = $url;

        return response()->json([
            'data' => $package,
            'message' => 'success',
        ]);
    }

    public function all()
    {
        $packages = Package::with(['media'])->get();

        $packages->map(function ($package) {
            $package['preview_url'] = $package->media->map(function ($media) {
                return $media->getUrl();
            });
            $package['category'] = $package->packageCategory->name;

            unset($package['packageCategory']);
            unset($package['media']);
            return $package;
        });

        return response()->json([
            'data' => $packages,
            'message' => 'success',
        ]);
    }
}
