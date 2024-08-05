<?php

namespace App\Http\Middlewares\User;

use Mj\PocketCore\Exceptions\ForbiddenException;

class UserExportMiddleware
{
    public function handle()
    {
        if (!auth()->check() || !auth()->user()->hasPermission('user-export')) {
            throw new ForbiddenException();
        }
    }
}