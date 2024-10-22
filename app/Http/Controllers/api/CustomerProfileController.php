<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerProfileController extends Controller
{
    public function detail()
    {
        if (!$customer = Customer::find(auth()->user()->id)) {
            return response()->json([
                'message' => 'user not found',
            ], 404);
        }

        $customer['profile_img'] = $customer->getFirstMediaUrl('profile_img') == "" ? env('APP_URL', 'https://be.storease.id') . "/img/profile/default.png" : $customer->getFirstMediaUrl('profile_img');

        return response()->json([
            'data' => $customer->only(['name', 'email', 'address', 'phone', 'profile_img']),
        ]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'address' => 'required|min:5',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'data invalid',
            ], 400);
        }

        if (!$customer = Customer::find(auth()->user()->id)) {
            return response()->json([
                'message' => 'user not found',
            ]);
        }

        if ($request->file('profile_img')) {
            $validator2 = Validator::make($request->all(), [
                "profile_img" => "mimetypes:image/*|max:2048",
            ]);

            if ($validator2->fails()) {
                if ($validator2->errors()->first() == "The profile field must not be greater than 2048 kilobytes.") {
                    return response()->json(['message' => "image size is too big, max size is 2048KB"], 400);
                }
                return response()->json(['message' => $validator2->errors()->first()], 400);
            }

            $customer->addMediaFromRequest("profile_img")->toMediaCollection("profile_img");
            $customer = Customer::find($customer->id);

            $customer->update([
                'name' => $request->name,
                'email' => $request->email,
                'address' => $request->address,
                'password' => bcrypt($request->password),
            ]);
        } else {
            $customer->update([
                'name' => $request->name,
                'email' => $request->email,
                'address' => $request->address,
                'password' => bcrypt($request->password),
            ]);
        }

        return response()->json([
            'message' => 'data has been updated',
        ]);
    }
}
