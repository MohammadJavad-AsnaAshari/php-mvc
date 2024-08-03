<?php

namespace App\Http\Middlewares\Permission;

use Mj\PocketCore\Exceptions\ForbiddenException;

class PermissionEditMiddleware
{
    public function handle()
    {
        if (!auth()->check() || !auth()->user()->hasPermission('permission-edit')) {
            throw new ForbiddenException();
        }
    }
}