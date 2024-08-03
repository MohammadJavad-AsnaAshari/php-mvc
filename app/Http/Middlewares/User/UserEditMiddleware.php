<?php

namespace App\Http\Middlewares\User;

use Mj\PocketCore\Exceptions\ForbiddenException;

class UserEditMiddleware
{
    public function handle()
    {
        if (!auth()->check() || !auth()->user()->hasPermission('user-edit')) {
            throw new ForbiddenException();
        }
    }
}