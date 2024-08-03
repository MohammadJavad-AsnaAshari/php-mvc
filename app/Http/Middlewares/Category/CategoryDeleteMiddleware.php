<?php

namespace App\Http\Middlewares\Category;

use Mj\PocketCore\Exceptions\ForbiddenException;

class CategoryDeleteMiddleware
{
    public function handle()
    {
        if (!auth()->check() || !auth()->user()->hasPermission('category-delete')) {
            throw new ForbiddenException();
        }
    }
}