<?php

namespace App\Http\Middlewares\Category;

use Mj\PocketCore\Exceptions\ForbiddenException;

class CategoryCreateMiddleware
{
    public function handle()
    {
        if (!auth()->check() || !auth()->user()->hasPermission('category-create')) {
            throw new ForbiddenException();
        }
    }
}