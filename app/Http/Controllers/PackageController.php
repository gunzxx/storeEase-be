<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\PackageCategory;
use Illuminate\Http\Request;

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

        return view('package.create', [
            'title' => 'Create Package',
            'page' => 'package',
            'subpage1' => 'package-list',
            'packageCategories' => $packageCategories,
        ]);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'price' => 'required|numeric',
            'description' => 'required',
            'packageCategory' => 'required',
        ]);

        Package::create([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'package_category_id' => $request->packageCategory,
        ]);

        return redirect('/package')->with([
            'success' => 'Data berhasil ditambahkan',
        ]);;
    }

    public function edit($packageId)
    {
        $package = Package::find($packageId);
        if (!$package) {
            return redirect('/package')->withErrors([
                'data' => 'data tidak ditemukan',
            ]);
        }

        $packageCategories = PackageCategory::all();

        return view('package.edit', [
            'title' => 'Edit Package',
            'page' => 'package',
            'subpage1' => 'package-list',
            'package' => $package,
            'packageCategories' => $packageCategories,
        ]);
    }

    public function update($packageId, Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'price' => 'required|numeric',
            'description' => 'required',
            'packageCategory' => 'required',
        ]);

        $package = Package::find($packageId);
        if (!$package) {
            return redirect('/package')->withErrors([
                'data' => 'data tidak ditemukan',
            ]);
        }

        if($request->hasFile('preview_img')){
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
}
