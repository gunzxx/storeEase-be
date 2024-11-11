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
            ->with(['customer', 'package'])
            ->with('document', function ($document) {
                $document->with('media');
            })
            ->with('invoice', function ($invoice) {
                $invoice->with('media');
            })
            ->with('jobDesk', function ($document) {
                $document->with('jobList');
            })
            ->first()) {
            return response()->json([
                'message' => 'Data not found',
            ], 404);
        }

        $order['thumbnail'] = $order->package->getFirstMediaUrl('preview_img') != "" ? $order->package->getFirstMediaUrl('preview_img') : url('/img/package/default.png');
        $order['services'] = $order->package->detailServicePackage->map(fn($detail) => $detail->service);

        $order->package['preview_url'] = $order->package->getMedia('preview_img')->map(fn($media) => $media->getUrl());

        unset($order->package->media);
        unset($order->package->detailServicePackage);

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
                ->with(['statusOrder', 'package'])
                ->get();
        } else {
            $orders = Order::where([
                'customer_id' => auth()->user()->id,
            ])
                ->with(['statusOrder'])
                ->with('package', function ($package) {
                    $package->with('media');
                })
                ->get();
        }

        $orders->map(function ($order) {
            $order['thumbnail'] = $order->package->getFirstMediaUrl('preview_img') != "" ? $order->package->getFirstMediaUrl('preview_img') : url('/img/package/default.png');
            $order['services'] = $order->package->detailServicePackage->map(fn($detail)=>$detail->service);

            $order->package['preview_url'] = $order->package->getMedia('preview_img')->map(function ($media) {
                $media->getUrl();
            });
            unset($order->package->media);
            unset($order->package->detailServicePackage);
        });

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

        if (!Package::find($request->package_id)) {
            return response()->json([
                'message' => 'id paket tidak valid',
            ], 400);
        }

        $data = [
            'uuid' => Uuid::uuid4(),
            'wedding_date' => $request->wedding_date,
            'package_id' => $request->package_id,
            'customer_id' => auth()->user()->id,
        ];

        $order = Order::create($data);

        return response()->json([
            'data' => $order,
            'message' => 'Data has been created',
        ]);
    }
}
