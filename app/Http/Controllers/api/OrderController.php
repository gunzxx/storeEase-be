<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function order(){
        $orders = Order::all();
        return response()->json([
            'data' => $orders,
            'uuid' => $orders->first()->uuid,
        ]);
    }
}
