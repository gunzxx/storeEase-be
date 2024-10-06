<?php

namespace App\Http\Controllers;

use App\Models\DetailServicePackage;
use App\Models\Package;
use App\Models\Service;
use Illuminate\Http\Request;

class DetailServicePackageController extends Controller
{
    public function index(){
        $detailServicePackages = DetailServicePackage::with(['service', 'package'])->get();

        return view('detailServicePackage.index', [
            'title' => 'Detail Package Service',
            'page' => 'package',
            'subpage1' => 'package-detail',
            'detailServicePackages' => $detailServicePackages,
        ]);
    }
    
    public function create()
    {
        $services = Service::all();
        $packages = Package::all();

        return view('detailServicePackage.create', [
            'title' => 'Create Detail Package Service',
            'page' => 'package',
            'subpage1' => 'package-detail',
            'packages' => $packages,
            'services' => $services,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required',
            'package_id' => 'required',
        ]);

        DetailServicePackage::create([
            'service_id' => $request->service_id,
            'package_id' => $request->package_id,
        ]);

        return redirect('/package-detail')->with([
            'success' => 'Data berhasil ditambahkan',
        ]);
    }

    public function edit($id)
    {
        $detailServicePackage = DetailServicePackage::with(['service', 'package'])->find($id);
        if (!$detailServicePackage) {
            return redirect('/package-detail')->withErrors([
                'data' => 'data tidak ditemukan',
            ]);
        }
        
        $services = Service::all();
        $packages = Package::all();

        return view('detailServicePackage.edit', [
            'title' => 'Edit Detail Package Service',
            'page' => 'package',
            'subpage1' => 'package-detail',
            'packages' => $packages,
            'services' => $services,
            'detailServicePackage' => $detailServicePackage,
        ]);
    }

    public function update($id, Request $request){
        $request->validate([
            'service_id' => 'required',
            'package_id' => 'required',
        ]);

        $detailServicePackage = DetailServicePackage::find($id);
        if (!$detailServicePackage) {
            return redirect('/package-detail')->withErrors([
                'data' => 'data tidak ditemukan',
            ]);
        }

        $detailServicePackage->update([
            'service_id' => $request->service_id,
            'package_id' => $request->package_id,
        ]);

        return redirect('/package-detail')->with([
            'success' => 'Data berhasil diupdate',
        ]);;
    }

    public function delete($id)
    {
        $detailServicePackage = DetailServicePackage::find($id);
        if (!$detailServicePackage) {
            return response()->json([
                'message' => 'data tidak ditemukan',
            ], 404);
        }

        $detailServicePackage->delete();
        return response()->json([
            'message' => 'data berhasil dihapus',
        ]);
    }
}
