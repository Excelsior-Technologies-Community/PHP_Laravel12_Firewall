<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\BlockedIp;

class FirewallMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $ip = $request->ip();

        // Check if IP is blocked
        $blocked = BlockedIp::where('ip_address', $ip)->first();

        if ($blocked) {
            return response()->view('blocked');
        }

        return $next($request);
    }
}