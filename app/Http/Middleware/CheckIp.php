<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class CheckIp
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $allowedIps = [
            "192.168.1.104",
            "192.168.1.106",
            "192.168.1.128",
            "192.168.1.133",
            "192.168.1.125",
            "localhost",
            "127.0.0.1",
            "::1",
        ];

        $allowedRoutes = [
            "api/teams/rankings",
            "api/teams/rankings/global",
            "api/game/clans"
        ];
        Log::debug("[CHECK IP] " . $request->ip() . " for route " . $request->route()->uri());

        if (!in_array($request->ip(), $allowedIps, true)) {
            if (!in_array($request->route()->uri(), $allowedRoutes)) {
                abort(403);
            }
        }

        return $next($request);
    }
}
