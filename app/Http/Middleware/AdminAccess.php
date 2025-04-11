<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Kiểm tra xem user đã đăng nhập và có quyền admin không
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request);
        }

        // Nếu không phải admin, redirect về trang home hoặc dashboard
        return redirect()->route('user.dashboard')->with('error', 'Bạn không có quyền truy cập vào trang admin.');
    }
}
