<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index(){
        return view('auth.login');
    }

    public function handleLogin(Request $request){
        $credentials = $request->only('email', 'password');

        if (auth()->guard('adminweb')->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'wrong' => 'Email atau password salah',
        ]);
    }
}
