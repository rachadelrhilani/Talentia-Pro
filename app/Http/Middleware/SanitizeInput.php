<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SanitizeInput
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $input = $request->all();

        array_walk_recursive($input, function (&$value, $key) {
            // Skip password fields and non-string values
            if (is_string($value) && !in_array($key, ['password', 'password_confirmation', '_token'])) {
                $value = strip_tags($value);
            }
        });

        $request->merge($input);

        return $next($request);
    }
}
