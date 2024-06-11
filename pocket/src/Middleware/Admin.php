<?php

namespace Mj\PocketCore\Middleware;

use Mj\PocketCore\Exceptions\UnauthorizedException;

class Admin
{
    public function handle()
    {
        if (!auth()->check() || !auth()->user()->hasRole('admin')) {
            throw new UnauthorizedException();
        }
    }
}