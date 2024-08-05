<?php

namespace App\Http\Middlewares\Category;

use Mj\PocketCore\Exceptions\ForbiddenException;

class CategoryExportMiddleware
{
    public function handle()
    {
        if (!auth()->check() || !auth()->user()->hasPermission('category-export')) {
            throw new ForbiddenException();
        }
    }
}