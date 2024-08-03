<?php

namespace App\Http\Middlewares\User;

use Mj\PocketCore\Exceptions\ForbiddenException;

class UserDeleteMiddleware
{
    public function handle()
    {
        if (!auth()->check() || !auth()->user()->hasPermission('user-delete')) {
            throw new ForbiddenException();
        }
    }
}