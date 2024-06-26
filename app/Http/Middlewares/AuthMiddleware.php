<?php

namespace App\Http\Middlewares;

use Mj\PocketCore\Exceptions\UnauthorizedException;

class AuthMiddleware
{
    public function handle()
    {
        if (!auth()->check()) {
            throw new UnauthorizedException();
        }
    }
}