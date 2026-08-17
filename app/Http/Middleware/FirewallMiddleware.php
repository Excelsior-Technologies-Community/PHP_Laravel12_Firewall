<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\BlockedIp;
use App\Models\BlockedAttempt;
use Illuminate\Support\Carbon;

class FirewallMiddleware
{
    /**
     * Maximum blocked attempts allowed within the time window.
     */
    private const MAX_ATTEMPTS = 5;

    /**
     * Time window in minutes.
     */
    private const ATTEMPT_WINDOW = 10;

    /**
     * Ignore duplicate requests for the same IP and URL
     * within this number of seconds.
     */
    private const DUPLICATE_WINDOW = 2;

    public function handle(Request $request, Closure $next): Response
    {
        $ip = $request->ip();

        // Check whether the IP is currently blocked.
        $blocked = BlockedIp::where('ip_address', $ip)->first();

        if ($blocked) {

            /*
             * Prevent duplicate logging when the same IP requests
             * the same URL within a very short period.
             */
            $recentAttempt = BlockedAttempt::where('ip_address', $ip)
                ->where('url', $request->fullUrl())
                ->where('method', $request->method())
                ->where(
                    'created_at',
                    '>=',
                    Carbon::now()->subSeconds(self::DUPLICATE_WINDOW)
                )
                ->exists();

            // Log only if this is not a duplicate request.
            if (!$recentAttempt) {
                BlockedAttempt::create([
                    'ip_address' => $ip,
                    'url' => $request->fullUrl(),
                    'method' => $request->method(),
                    'user_agent' => $request->userAgent(),
                ]);
            }

            // Count recent blocked attempts.
            $attemptCount = BlockedAttempt::where('ip_address', $ip)
                ->where(
                    'created_at',
                    '>=',
                    Carbon::now()->subMinutes(self::ATTEMPT_WINDOW)
                )
                ->count();

            // Automatically update the reason after repeated attempts.
            if (
                $attemptCount >= self::MAX_ATTEMPTS &&
                !str_contains(
                    strtolower($blocked->reason ?? ''),
                    'automatically blocked'
                )
            ) {
                $blocked->update([
                    'reason' => 'Automatically blocked after repeated unauthorized access attempts.',
                ]);
            }

            return response()->view('blocked', [
                'attemptCount' => $attemptCount,
            ], 403);
        }

        return $next($request);
    }
}