<?php

namespace App\Http\Middleware;
use Illuminate\Auth\AuthenticationException;

use Closure;

class ApiToken
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
        if ($request->header('Authorization') != env('API_KEY')) {
            throw new AuthenticationException;
        }

        return $next($request);
    }
}
