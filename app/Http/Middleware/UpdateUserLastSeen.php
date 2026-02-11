<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateUserLastSeen
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $user = auth()->user();
            
            // Only update if last_seen_at is null or older than 1 minute
            // This prevents excessive database writes
            if (!$user->last_seen_at || $user->last_seen_at->lt(now()->subMinute())) {
                $user->updateLastSeen();
            }
        }

        return $next($request);
    }
}
