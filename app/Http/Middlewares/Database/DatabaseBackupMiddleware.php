<?php

namespace App\Http\Middlewares\Database;

use Mj\PocketCore\Exceptions\ForbiddenException;

class DatabaseBackupMiddleware
{
    public function handle()
    {
        if (!auth()->check() || !auth()->user()->hasPermission('database-backup')) {
            throw new ForbiddenException();
        }
    }
}