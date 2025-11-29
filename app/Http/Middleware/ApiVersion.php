<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * API Version Middleware
 *
 * Handles API versioning by adding version headers to responses
 * and validating API version compatibility.
 */
class ApiVersion
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Add API version headers to response
        $response->headers->set('X-API-Version', config('api.current_version'));
        $response->headers->set('X-API-Supported-Versions', implode(', ', config('api.supported_versions')));
        $response->headers->set('X-API-Deprecation-Info', config('api.deprecation_url'));

        // Add content type if not set
        if (! $response->headers->has('Content-Type')) {
            $response->headers->set('Content-Type', 'application/json');
        }

        return $response;
    }
}
