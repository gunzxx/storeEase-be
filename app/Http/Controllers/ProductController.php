<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Vendor;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'vendor'])->get();
        return view('product.index', [
            'title' => 'Product',
            'page' => 'vendor',
            'subpage1' => 'product',
            'products' => $products,
        ]);
    }
    
    public function edit($productId)
    {
        $product = Product::with(['category', 'vendor'])->find($productId);
        if (!$product) {
            return redirect('/product')->withErrors([
                'data' => 'data tidak ditemukan',
            ]);
        }

        $categories = Category::all();
        $vendors = Vendor::all();

        return view('product.edit', [
            'title' => 'Edit Category',
            'page' => 'vendor',
            'subpage1' => 'product',
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

        $product = Product::find($productId);
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
        $product = Product::find($productId);
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
