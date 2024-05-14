<?php

namespace App\Http\Middlewares;

use Closure;
use Mj\PocketCore\Exceptions\UnauthorizedException;
use Mj\PocketCore\Request;
use Mj\PocketCore\Response;

class AuthMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            // User is not authenticated, redirect to login page or display error message
            throw new UnauthorizedException();
        }

        // User is authenticated, continue with the request
        return $next($request);
    }
}