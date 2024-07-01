<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return view('customer.index', [
            'title' => 'Customer',
            'page' => 'customer',
            'customers' => $customers,
        ]);
    }

    public function edit($customerId)
    {
        $customer = Customer::find($customerId);
        if (!$customer) {
            return redirect('/customer')->withErrors([
                'data' => 'data tidak ditemukan',
            ]);
        }

        return view('customer.edit', [
            'title' => 'Edit Customer',
            'page' => 'customer',
            'customer' => $customer,
        ]);
    }

    public function update($customerId, Request $request)
    {
        if ($request->new_password) {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'new_password' => 'min:8|confirmed',
                'new_password_confirmation' => 'min:8',
            ]);

            $customer = Customer::find($customerId);
            if (!$customer) {
                return redirect('/customer')->withErrors([
                    'data' => 'data tidak ditemukan',
                ]);
            }
            
            if ($request->email != $customer->email) {
                $checkUser = Customer::where(['email' => $request->email])->first();
                if ($checkUser) {
                    return redirect()->back()->withErrors([
                        'email' => 'Email sudah digunakan',
                    ])->withInput();
                }
            }

            $customer->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => bcrypt($request->new_password),
            ]);

            return redirect('/customer')->with([
                'success' => 'Data berhasil diupdate',
            ]);
        }

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
        ]);

        $customer = Customer::find($customerId);
        if (!$customer) {
            return redirect('/customer')->withErrors([
                'data' => 'data tidak ditemukan',
            ]);
        }

        if ($request->name != $customer->name || $request->email != $customer->email) {
            if ($request->name != $customer->name) {
                $customer->update([
                    'name' => $request->name,
                ]);
            }
            if ($request->email != $customer->email) {
                $checkUser = Customer::where(['email' => $request->email])->first();
                if ($checkUser) {
                    return redirect()->back()->withErrors([
                        'email' => 'Email sudah digunakan',
                    ])->withInput();
                }
                $customer->update([
                    'email' => $request->email,
                ]);
            }

            return redirect('/customer')->with([
                'success' => 'Data berhasil diupdate',
            ]);
        }

        return redirect('/customer');
    }

    public function delete($customerId)
    {
        $customer = Customer::find($customerId);
        if (!$customer) {
            return response()->json([
                'message' => 'data tidak ditemukan',
            ], 404);
        }
        
        $customer->delete();
        return response()->json([
            'message' => 'data berhasil dihapus',
        ]);
    }
}
