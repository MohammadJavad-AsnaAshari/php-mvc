<?php

namespace App\Http\Middlewares\Permission;

use Mj\PocketCore\Exceptions\ForbiddenException;

class PermissionDeleteMiddleware
{
    public function handle()
    {
        if (!auth()->check() || !auth()->user()->hasPermission('permission-delete')) {
            throw new ForbiddenException();
        }
    }
}