<?php

namespace App\Http\Middlewares\Category;

use Mj\PocketCore\Exceptions\ForbiddenException;

class CategoryIndexMiddleware
{
    public function handle()
    {
        if (!auth()->check() || !auth()->user()->hasPermission('category-index')) {
            throw new ForbiddenException();
        }
    }
}