<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\Vendor;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $products = Service::with(['serviceCategory', 'vendor'])->get();
        return view('service.index', [
            'title' => 'Product',
            'page' => 'vendor',
            'subpage1' => 'vendor-service',
            'products' => $products,
        ]);
    }

    public function create()
    {
        $categories = ServiceCategory::all();
        $vendors = Vendor::all();

        return view('service.create', [
            'title' => 'Edit Category',
            'page' => 'vendor',
            'subpage1' => 'vendor-service',
            'categories' => $categories,
            'vendors' => $vendors,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'price' => 'required|numeric',
            'category_id' => 'required',
            'vendor_id' => 'required',
        ]);

        try {
            Service::create([
                'name' => $request->name,
                'price' => $request->price,
                'service_category_id' => $request->category_id,
                'vendor_id' => $request->vendor_id,
            ]);

            return redirect('/vendor-service')->with([
                'success' => 'Data berhasil ditambahkan',
            ]);
        } catch (\Throwable $th) {
            if ($th->errorInfo[0] == 23000) {
                return back()->withErrors([
                    'email' => 'email has been used'
                ]);
            }

            return redirect('/vendor-service')->withErrors([
                'success' => $th->errorInfo[2],
            ]);
        }
    }

    public function edit($productId)
    {
        $product = Service::with(['serviceCategory', 'vendor'])->find($productId);
        if (!$product) {
            return redirect('/product')->withErrors([
                'data' => 'data tidak ditemukan',
            ]);
        }

        $categories = ServiceCategory::all();
        $vendors = Vendor::all();

        return view('service.edit', [
            'title' => 'Edit Category',
            'page' => 'vendor',
            'subpage1' => 'vendor-service',
            'product' => $product,
            'categories' => $categories,
            'vendors' => $vendors,
        ]);
    }

    public function update($productId, Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'price' => 'required|numeric',
            'category_id' => 'required',
            'vendor_id' => 'required',
        ]);

        $product = Service::find($productId);
        if (!$product) {
            return redirect('/product')->withErrors([
                'data' => 'data tidak ditemukan',
            ]);
        }

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'vendor_id' => $request->vendor_id,
        ]);

        return redirect('/product')->with([
            'success' => 'Data berhasil diupdate',
        ]);;
    }

    public function delete($productId)
    {
        $product = Service::find($productId);
        if (!$product) {
            return response()->json([
                'message' => 'data tidak ditemukan',
            ], 404);
        }

        $product->delete();
        return response()->json([
            'message' => 'data berhasil dihapus',
        ]);
    }
}
