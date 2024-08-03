<?php

namespace App\Http\Middlewares\User;

use Mj\PocketCore\Exceptions\ForbiddenException;

class UserCreateMiddleware
{
    public function handle()
    {
        if (!auth()->check() || !auth()->user()->hasPermission('user-create')) {
            throw new ForbiddenException();
        }
    }
}