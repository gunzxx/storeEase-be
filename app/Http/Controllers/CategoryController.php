<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('category.index', [
            'title' => 'Category',
            'page' => 'vendor',
            'subpage1' => 'category',
            'categories' => $categories,
        ]);
    }

    public function create()
    {
        $categories = Category::all();
        return view('category.create', [
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

        Category::create([
            'name' => $request->name,
        ]);

        return redirect('/category')->with([
            'success' => 'Data berhasil ditambahkan',
        ]);;
    }

    public function edit($categoryId)
    {
        $category = Category::find($categoryId);
        if (!$category) {
            return redirect('/category')->withErrors([
                'data' => 'data tidak ditemukan',
            ]);
        }

        return view('category.edit', [
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

        $category = Category::find($categoryId);
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
        $category = Category::find($categoryId);
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
