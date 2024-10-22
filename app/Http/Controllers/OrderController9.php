<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController9 extends Controller
{
    public function to9($uuid){
        if (!$order = Order::where(['uuid' => $uuid])->first()) {
            return redirect('/order/list')->withErrors([
                'message' => 'Order not found',
            ]);
        }

        $order->update([
            'status_order_id' => 9,
        ]);

        return redirect("/order/$uuid/detail")->with([
            'success' => 'Data has been updated',
        ]);
    }
}
