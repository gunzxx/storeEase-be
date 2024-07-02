<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::all();
        return view('package.index', [
            'title' => 'Package',
            'page' => 'package',
            'packages' => $packages,
        ]);
    }

    public function edit($packageId)
    {
        $package = Package::find($packageId);
        if (!$package) {
            return redirect('/package')->withErrors([
                'data' => 'data tidak ditemukan',
            ]);
        }

        return view('package.edit', [
            'title' => 'Edit Package',
            'page' => 'package',
            'package' => $package,
        ]);
    }

    public function update($packageId, Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'price' => 'required|numeric',
            'detail' => 'required',
        ]);

        $package = Package::find($packageId);
        if (!$package) {
            return redirect('/package')->withErrors([
                'data' => 'data tidak ditemukan',
            ]);
        }

        $package->update([
            'name' => $request->name,
            'price' => $request->price,
            'detail' => $request->detail,
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
