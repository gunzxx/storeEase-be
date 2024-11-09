<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\DetailServicePackage;
use App\Models\Order;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;


class OrderController extends Controller
{
    public function order()
    {
        $orders = Order::all();
        return response()->json([
            'data' => $orders,
            'uuid' => $orders->first()->uuid,
        ]);
    }


    public function single($id)
    {
        if (!$order = Order::where(['id' => $id, 'customer_id' => auth()->user()->id])
            ->with(['customer', 'detailServicePackage'])
            ->with('document', function ($document) {
                $document->with('media');
            })
            ->with('jobDesk', function ($document) {
                $document->with('jobList');
            })
            ->first()) {
            return response()->json([
                'message' => 'Data not found',
            ], 404);
        }

        $order['status_name'] = $order->statusOrder->name;
        $order['package'] = $order->detailServicePackage->package;
        $order['thumbnail'] = $order->detailServicePackage->package->getFirstMediaUrl('preview_img') != "" ? $order->detailServicePackage->package->getFirstMediaUrl('preview_img') : url('/img/package/default.png');
        $order['service'] = $order->detailServicePackage->service;
        unset($order->detailServicePackage);
        unset($order->statusOrder);

        return response()->json([
            'data' => $order,
            'message' => 'Success',
        ]);
    }

    public function category(Request $request)
    {
        if ($request->status_order_id) {
            $orders = Order::where([
                    'status_order_id' => $request->status_order_id,
                    'customer_id' => auth()->user()->id,
                ])
                ->with('detailServicePackage', function ($detailServicePackage) {
                    $detailServicePackage->with('package');
                })
                ->with('statusOrder')
                ->get();
        } else {
            $orders = Order::where([
                'customer_id' => auth()->user()->id,
            ])
            ->with(['statusOrder'])
                ->with('detailServicePackage', function ($detailServicePackage) {
                    $detailServicePackage->with('package', function ($package) {
                        $package->with('media');
                    });
                })
                ->get();
        }

        $orders->map(function ($order) {
            $order['status_name'] = $order->statusOrder->name;
            $order['package'] = $order->detailServicePackage->package;
            $order['thumbnail'] = $order->detailServicePackage->package->getFirstMediaUrl('preview_img') != "" ? $order->detailServicePackage->package->getFirstMediaUrl('preview_img') : url('/img/package/default.png');
            $order['service'] = $order->detailServicePackage->service;
            $order['package_id'] = $order->detailServicePackage->package_id;

            $order->detailServicePackage->package['preview_img'] = $order->detailServicePackage->package->getMedia()->map(function($media){
                $media->getUrl();
            });
            unset($order->detailServicePackage->package['media']);
            unset($order->detailServicePackage);
            unset($order->statusOrder);
        });

        $orders = $orders->toArray();
        ksort($orders);

        return response()->json([
            'data' => $orders,
            'message' => 'Success',
        ]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'wedding_date' => 'required',
            'package_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Data invalid',
            ], 400);
        }

        if (!DetailServicePackage::find($request->package_id)) {
            return response()->json([
                'message' => 'id paket tidak valid',
            ], 400);
        }

        $data = [
            'uuid' => Uuid::uuid4(),
            'wedding_date' => $request->wedding_date,
            'detail_service_package_id' => $request->package_id,
            'customer_id' => auth()->user()->id,
        ];

        $order = Order::create($data);

        return response()->json([
            'data' => $order,
            'message' => 'Data has been created',
        ]);
    }
}
