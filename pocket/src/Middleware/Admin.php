<?php

namespace Mj\PocketCore\Middleware;

use Mj\PocketCore\Exceptions\ForbiddenException;

class Admin
{
    public function handle()
    {
        if (!auth()->check() || !auth()->user()->hasPermission('admin')) {
            throw new ForbiddenException();
        }
    }
}