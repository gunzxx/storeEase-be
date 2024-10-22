<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['customer', 'statusOrder'])->with('detailServicePackage', function ($detail) {
            $detail->with('package', function ($package) {
                $package->with(['packageCategory']);
            });
        })->orderBy('updated_at', 'DESC')->get();

        return view('order.index', [
            'title' => 'Order',
            'page' => 'order',
            'subpage1' => 'order',
            'orders' => $orders,
        ]);
    }

    public function detail($uuid)
    {
        $order = Order::where(['uuid' => $uuid])->first();
        if (!$order) {
            return redirect('/order/list')->withErrors([
                'message' => 'Order not found',
            ]);
        }
        $order = Order::where(['uuid' => $uuid])
            ->with('detailServicePackage', function ($detail) {
                $detail->with(['package']);
            })
            ->with('jobDesk', function ($jobDesk) {
                // $jobDesk->with(['package']);
            })
            ->with(['statusOrder', 'customer'])->first();

        $order['wedding_date'] = Carbon::parse($order->wedding_date)->translatedFormat('d F Y');
        $package = $order->detailServicePackage->package;
        $jobDesks = $order->jobDesk;
        
        $jobDesks->map(function ($jobDesk) {
            $jobListFinished = $jobDesk->jobList()->where('finished', true);
            $jobDesk['finished'] = $jobListFinished->count();
            $jobDesk['total'] = $jobDesk->jobList->count();

            return $jobDesk;
        });

        // dd($jobDesks);

        if ($order->status_order_id == 1) {
            return view('order.detail.1', [
                'title' => $order->detailServicePackage->package->name,
                'page' => 'order',
                'subpage1' => 'order',
                'order' => $order,
                'jobDesk' => $jobDesks,
                'package' => $package,
            ]);
        } else if ($order->status_order_id == 2) {
            return view('order.detail.2', [
                'title' => $order->detailServicePackage->package->name,
                'page' => 'order',
                'subpage1' => 'order',
                'order' => $order,
                'jobDesk' => $jobDesks,
                'package' => $package,
            ]);
        } else if ($order->status_order_id == 3) {
            return view('order.detail.3', [
                'title' => $order->detailServicePackage->package->name,
                'page' => 'order',
                'subpage1' => 'order',
                'order' => $order,
                'jobDesk' => $jobDesks,
                'package' => $package,
            ]);
        } else if ($order->status_order_id == 4) {
            return view('order.detail.4', [
                'title' => $order->detailServicePackage->package->name,
                'page' => 'order',
                'subpage1' => 'order',
                'order' => $order,
                'jobDesk' => $jobDesks,
                'package' => $package,
            ]);
        }

        return response()->json($order);
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
