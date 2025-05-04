<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();
        if ($token !== 'i_am_admin') {
            abort(403);
        }

        $response = $next($request);

        $response->headers->set("X-Request-id", "some_id");

        return $response;
    }

    public function terminate()
    {
    }
}
