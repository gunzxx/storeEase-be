<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(){
        $orders = Order::all();
        return view('order.index', [
            'title' => 'Order',
            'page' => 'order',
            'subpage1' => 'list',
            'orders' => $orders,
        ]);
    }
}
