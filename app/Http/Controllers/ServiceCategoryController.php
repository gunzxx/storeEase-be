<?php

namespace App\Http\Controllers;

use App\Models\ServiceCategory;
use Illuminate\Http\Request;

class ServiceCategoryController extends Controller
{
    public function index()
    {
        $categories = ServiceCategory::all();
        return view('serviceCategory.index', [
            'title' => 'Category',
            'page' => 'vendor',
            'subpage1' => 'category',
            'categories' => $categories,
        ]);
    }

    public function create()
    {
        $categories = ServiceCategory::all();
        return view('serviceCategory.create', [
            'title' => 'Category',
            'page' => 'vendor',
            'subpage1' => 'category',
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
        ]);

        ServiceCategory::create([
            'name' => $request->name,
        ]);

        return redirect('/category')->with([
            'success' => 'Data berhasil ditambahkan',
        ]);;
    }

    public function edit($categoryId)
    {
        $category = ServiceCategory::find($categoryId);
        if (!$category) {
            return redirect('/category')->withErrors([
                'data' => 'data tidak ditemukan',
            ]);
        }

        return view('serviceCategory.edit', [
            'title' => 'Edit Category',
            'page' => 'vendor',
            'subpage1' => 'category',
            'category' => $category,
        ]);
    }

    public function update($categoryId, Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
        ]);

        $category = ServiceCategory::find($categoryId);
        if (!$category) {
            return redirect('/category')->withErrors([
                'data' => 'data tidak ditemukan',
            ]);
        }

        $category->update([
            'name' => $request->name,
        ]);

        return redirect('/category')->with([
            'success' => 'Data berhasil diupdate',
        ]);;
    }

    public function delete($categoryId)
    {
        $category = ServiceCategory::find($categoryId);
        if (!$category) {
            return response()->json([
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        $category->delete();
        return response()->json([
            'message' => 'data berhasil dihapus',
        ]);
    }
}
