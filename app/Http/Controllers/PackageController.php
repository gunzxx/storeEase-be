<?php

namespace App\Http\Controllers;

use App\Models\DetailServicePackage;
use App\Models\Package;
use App\Models\PackageCategory;
use App\Models\Service;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::with(['packageCategory'])->get();

        return view('package.index', [
            'title' => 'Package',
            'page' => 'package',
            'subpage1' => 'package-list',
            'packages' => $packages,
        ]);
    }

    public function create()
    {
        $packageCategories = PackageCategory::all();
        $services = Service::all();

        return view('package.create', [
            'title' => 'Create Package',
            'page' => 'package',
            'subpage1' => 'package-list',
            'packageCategories' => $packageCategories,
            'services' => $services,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'price' => 'required|numeric',
            'description' => 'required',
            'packageCategory' => 'required',
            'services' => 'required',
        ]);

        $package = Package::create([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'package_category_id' => $request->packageCategory,
        ]);
        foreach ($request->services as $id) {
            DetailServicePackage::create([
                'service_id' => $id,
                'package_id' => $package->id,
            ]);
        };

        if ($request->hasFile('preview_img')) {
            $request->validate([
                'preview_img.*' => 'mimes:jpeg,jpg,png',
            ]);

            $package = Package::find($package->id);

            foreach ($request->file('preview_img') as $image) {
                $package->addMedia($image)->toMediaCollection('preview_img');
            }
        }

        return redirect('/package')->with([
            'success' => 'Data berhasil ditambahkan',
        ]);;
    }

    public function edit($packageId)
    {
        if (!$package = Package::with(['media', 'detailServicePackage'])->find($packageId)) {
            return redirect('/package')->withErrors([
                'data' => 'data tidak ditemukan',
            ]);
        }

        $packageCategories = PackageCategory::all();
        $services = Service::all();
        $serviceCheck = $package->detailServicePackage->map(fn($detail) => $detail->service->id)->toArray();

        return view('package.edit', [
            'title' => 'Edit Package',
            'page' => 'package',
            'subpage1' => 'package-list',
            'package' => $package,
            'packageCategories' => $packageCategories,
            'services' => $services,
            'serviceCheck' => $serviceCheck,
        ]);
    }

    public function update($packageId, Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'price' => 'required|numeric',
            'description' => 'required',
            'packageCategory' => 'required',
            'services' => 'required',
        ]);

        $package = Package::find($packageId);
        if (!$package) {
            return redirect('/package')->withErrors([
                'data' => 'data tidak ditemukan',
            ]);
        }


        $oldService = $package->detailServicePackage->map(fn($detail) => $detail->service->id)->toArray();
        $removeServiceId = array_diff($oldService, $request->services);
        $newServiceId = array_diff($request->services, $oldService);

        foreach ($removeServiceId as $id) {
            $detail = DetailServicePackage::where([
                'service_id' => $id,
                'package_id' => $package->id,
            ])->first();
            
            if ($detail) {
                $detail->delete();
            }
        }

        foreach ($newServiceId as $id) {
            DetailServicePackage::create([
                'service_id' => $id,
                'package_id' => $package->id,
            ]);
        }
        // dd($removeServiceId, $newServiceId);

        if ($request->hasFile('preview_img')) {
            $request->validate([
                'preview_img.*' => 'mimes:jpeg,jpg,png',
            ]);

            foreach ($request->file('preview_img') as $image) {
                $package->addMedia($image)->toMediaCollection('preview_img');
            }
        }

        $package->update([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'detail' => $request->detail,
            'package_category_id' => $request->packageCategory,
        ]);

        return redirect('/package')->with([
            'success' => 'Data berhasil diupdate',
        ]);;
    }

    public function delete($packageId)
    {
        $package = Package::find($packageId);
        if (!$package) {
            return response()->json([
                'message' => 'data tidak ditemukan',
            ], 404);
        }

        $package->delete();
        return response()->json([
            'message' => 'data berhasil dihapus',
        ]);
    }

    public function deletePreview(Request $request, $id)
    {
        if (!$media = Media::find($id)) {
            return response()->json([
                "message" => "data tidak ditemukan",
            ], 404);
        }

        $media->delete();

        return response()->json([
            'data' => $media,
            "message" => "data berhasil dihapus",
        ]);
    }
}
