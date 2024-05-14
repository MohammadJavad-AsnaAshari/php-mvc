<?php

namespace Mj\PocketCore\Middleware;

use Mj\PocketCore\Exceptions\UnauthorizedException;

class Authenticated
{
    public function handle()
    {
        if (!auth()->check()) {
            throw new UnauthorizedException();
        }
    }
}