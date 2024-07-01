<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::all();
        return view('vendor.index', [
            'title' => 'Vendor',
            'page' => 'vendor',
            'subpage1' => 'list',
            'vendors' => $vendors,
        ]);
    }

    public function edit($vendorId)
    {
        $vendor = Vendor::find($vendorId);
        if (!$vendor) {
            return redirect('/vendor')->withErrors([
                'data' => 'data tidak ditemukan',
            ]);
        }

        return view('vendor.edit', [
            'title' => 'Edit Vendor',
            'page' => 'vendor',
            'subpage1' => 'list',
            'vendor' => $vendor,
        ]);
    }
    
    public function update($vendorId, Request $request)
    {
        if ($request->new_password) {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'new_password' => 'min:8|confirmed',
                'new_password_confirmation' => 'min:8',
            ]);

            $vendor = Vendor::find($vendorId);
            if (!$vendor) {
                return redirect('/vendor')->withErrors([
                    'data' => 'data tidak ditemukan',
                ]);
            }

            if ($request->email != $vendor->email) {
                $checkUser = Vendor::where(['email' => $request->email])->first();
                if ($checkUser) {
                    return redirect()->back()->withErrors([
                        'email' => 'Email sudah digunakan',
                    ])->withInput();
                }
            }

            $vendor->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => bcrypt($request->new_password),
            ]);

            return redirect('/vendor')->with([
                'success' => 'Data berhasil diupdate',
            ]);
        }

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
        ]);

        $vendor = Vendor::find($vendorId);
        if (!$vendor) {
            return redirect('/vendor')->withErrors([
                'data' => 'data tidak ditemukan',
            ]);
        }

        if ($request->name != $vendor->name || $request->email != $vendor->email) {
            if ($request->name != $vendor->name) {
                $vendor->update([
                    'name' => $request->name,
                ]);
            }
            if ($request->email != $vendor->email) {
                $checkUser = Vendor::where(['email' => $request->email])->first();
                if ($checkUser) {
                    return redirect()->back()->withErrors([
                        'email' => 'Email sudah digunakan',
                    ])->withInput();
                }

                $vendor->update([
                    'email' => $request->email,
                ]);
            }

            return redirect('/vendor')->with([
                'success' => 'Data berhasil diupdate',
            ]);
        }

        return redirect('/vendor');
    }

    public function delete($vendorId)
    {
        $vendor = Vendor::find($vendorId);
        if (!$vendor) {
            return response()->json([
                'message' => 'data tidak ditemukan',
            ], 404);
        }

        $vendor->delete();
        return response()->json([
            'message' => 'data berhasil dihapus',
        ]);
    }
}
