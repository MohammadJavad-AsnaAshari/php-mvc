<?php

namespace App\Http\Middlewares\User;

use Mj\PocketCore\Exceptions\ForbiddenException;

class UserIndexMiddleware
{
    public function handle()
    {
        if (!auth()->check() || !auth()->user()->hasPermission('user-index')) {
            throw new ForbiddenException();
        }
    }
}