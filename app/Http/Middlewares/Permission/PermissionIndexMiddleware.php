<?php

namespace App\Http\Middlewares\Permission;

use Mj\PocketCore\Exceptions\ForbiddenException;

class PermissionIndexMiddleware
{
    public function handle()
    {
        if (!auth()->check() || !auth()->user()->hasPermission('permission-index')) {
            throw new ForbiddenException();
        }
    }
}