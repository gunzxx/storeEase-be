<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function single($id){
        $service = Service::find($id);

        return response()->json([
            'data' => $service,
            'message' => 'success',
        ]);
    }
}
