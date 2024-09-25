<?php

namespace App\Http\Middleware;

use Closure;

class NotFoundMiddleware
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if ($response->status() == 404) {
            return response()->json([
                'message' => 'Path not found',
            ], 404);
        }

        return $response;
    }
}
