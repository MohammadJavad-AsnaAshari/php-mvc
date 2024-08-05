<?php

namespace App\Http\Middlewares\Permission;

use Mj\PocketCore\Exceptions\ForbiddenException;

class PermissionExportMiddleware
{
    public function handle()
    {
        if (!auth()->check() || !auth()->user()->hasPermission('permission-export')) {
            throw new ForbiddenException();
        }
    }
}