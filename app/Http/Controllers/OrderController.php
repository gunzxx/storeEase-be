<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['vendor', 'customer'])->get();
        return view('order.index', [
            'title' => 'Order',
            'page' => 'order',
            'orders' => $orders,
        ]);
    }

    public function detail($orderId)
    {
        $order = Order::find($orderId);
        $orders = OrderDetail::join('products', 'order_details.product_id', '=', 'products.id')
            ->where(['order_id' => $order->id])
            ->select('order_details.*', 'products.price', DB::raw('order_details.quantity * products.price as total_price'))
            ->with(['order', 'product'])
            ->get();
        // dd($orders);
        return view('order.detail', [
            'title' => 'Order Detail',
            'page' => 'order',
            'orders' => $orders,
        ]);
    }

    public function delete($orderId)
    {
        $order = Order::find($orderId);
        if (!$order) {
            return response()->json([
                'message' => 'data tidak ditemukan',
            ], 404);
        }

        $order->delete();
        return response()->json([
            'message' => 'data berhasil dihapus',
        ]);
    }
}
