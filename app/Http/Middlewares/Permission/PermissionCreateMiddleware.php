<?php

namespace App\Http\Middlewares\Permission;

use Mj\PocketCore\Exceptions\ForbiddenException;

class PermissionCreateMiddleware
{
    public function handle()
    {
        if (!auth()->check() || !auth()->user()->hasPermission('permission-create')) {
            throw new ForbiddenException();
        }
    }
}