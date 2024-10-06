<?php

namespace App\Http\Controllers;

use App\Models\PackageCategory;
use Illuminate\Http\Request;

class PackageCategoryController extends Controller
{
    public function index(){
        $packageCategories = PackageCategory::all();

        return view('packageCategory.index', [
            'title' => 'Package Category',
            'page' => 'package',
            'subpage1' => 'package-category',
            'packageCategories' => $packageCategories,
        ]);
    }

    public function create(){
        return view('packageCategory.create', [
            'title' => 'Create Package Category',
            'page' => 'package',
            'subpage1' => 'package-category',
        ]);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
        ]);

        PackageCategory::create([
            'name' => $request->name,
        ]);

        return redirect('/package-category')->with([
            'success' => 'Data berhasil ditambahkan',
        ]);;
    }
    
    public function edit($id)
    {
        $packageCategory = PackageCategory::find($id);
        if (!$packageCategory) {
            return redirect('/package-category')->withErrors([
                'data' => 'data tidak ditemukan',
            ]);
        }

        return view('packageCategory.edit', [
            'title' => 'Edit Package Category',
            'page' => 'package',
            'subpage1' => 'package-category',
            'packageCategory' => $packageCategory,
        ]);
    }
    
    public function update($packageId, Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
        ]);

        $package = PackageCategory::find($packageId);
        if (!$package) {
            return redirect('/package-category')->withErrors([
                'data' => 'data tidak ditemukan',
            ]);
        }

        $package->update([
            'name' => $request->name,
        ]);

        return redirect('/package-category')->with([
            'success' => 'Data berhasil diupdate',
        ]);;
    }

    public function delete($id)
    {
        $packageCategory = PackageCategory::find($id);
        if (!$packageCategory) {
            return response()->json([
                'message' => 'data tidak ditemukan',
            ], 404);
        }

        $packageCategory->delete();
        return response()->json([
            'message' => 'data berhasil dihapus',
        ]);
    }
}
