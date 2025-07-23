<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CustomerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah pengguna terautentikasi dan memiliki peran 'customer'
        if (Auth::check() && Auth::user()->role === 'customer') {
            // Jika ya, lanjutkan ke request berikutnya
            return $next($request);
        }

        // Jika tidak, kembalikan response error 403 (Forbidden)
        return response()->json(['message' => 'This action is unauthorized. Only customers can perform transactions.'], 403);
    }
}
