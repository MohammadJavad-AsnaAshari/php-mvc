<?php

namespace App\Http\Middlewares\Database;

use Mj\PocketCore\Exceptions\ForbiddenException;

class DatabaseRecoveryMiddleware
{
    public function handle()
    {
        if (!auth()->check() || !auth()->user()->hasPermission('database-recovery')) {
            throw new ForbiddenException();
        }
    }
}