<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index', [
            'admin' => auth()->user(),
            'page' => 'profile',
            'title' => 'Admin Profile',
        ]);
    }

    public function update(Request $request)
    {
        if ($request->new_password) {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'new_password' => 'min:8|confirmed',
                'new_password_confirmation' => 'min:8',
            ]);

            $admin = Admin::find(auth()->user()->id);
            if (!$admin) {
                auth()->logout();
                return redirect('/login');
            }

            if ($request->email != $admin->email) {
                $checkUser = Admin::where(['email' => $request->email])->first();
                if ($checkUser) {
                    return redirect('/')->withErrors([
                        'email' => 'Email sudah digunakan',
                    ]);
                }
            }

            $admin->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->new_password),
            ]);

            return redirect('/')->with([
                'success' => 'Data berhasil diupdate',
            ]);
        }

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);

        $admin = Admin::find(auth()->user()->id);
        if ($request->name != $admin->name || $request->email != $admin->email) {
            if($request->name != $admin->name){
                $admin->update([
                    'name' => $request->name,
                ]);
            }
            if($request->email != $admin->email){
                $admin->update([
                    'email' => $request->email,
                ]);
            }

            return redirect('/')->with([
                'success' => 'Data berhasil diupdate',
            ]);
        }

        return redirect('/');
    }
}
