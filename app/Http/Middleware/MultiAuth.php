<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MultiAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$guards): Response
    {
        // Jika tidak ada guard yang ditentukan, gunakan default guard (disini memakai guard "web" sesuai pada file config/auth.php)
        if (empty($guards)) {
            $guards = [config('auth.defaults.guard')];
        }

        foreach ($guards as $guard) {
            if (auth()->guard($guard)->check()) {
                // Set guard yang berhasil di-authenticate sebagai default guard
                auth()->shouldUse($guard);
                return $next($request);
            }
        }

        // Jika tidak ada guard yang berhasil, berikan respons 401
        return response()->json(['message' => 'Unauthorized'], 401);
    }

}
