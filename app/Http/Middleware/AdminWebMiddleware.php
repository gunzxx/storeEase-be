<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminWebMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Asumsikan bahwa Anda memiliki guard 'adminweb' untuk otentikasi admin
        if (Auth::guard('adminweb')->check()) {
            return $next($request);
        }

        return redirect('/login');
    }
}
