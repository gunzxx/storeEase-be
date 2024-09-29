<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerProfileController extends Controller
{
    public function detail(){
        $id = auth()->user()->id;
        $user = Customer::find($id);
        return response()->json([
            'data' => $user,
        ]);
    }
    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => 'data tidak valid',
            ]);
        }

        if(!$user = Customer::find(auth()->user()->id)){
            return response()->json([
                'message' => 'user tidak ditemukan',
            ]);
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return response()->json([
            'message' => 'data berhasil diperbarui',
        ]);
    }
}
