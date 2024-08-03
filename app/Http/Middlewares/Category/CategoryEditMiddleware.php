<?php

namespace App\Http\Middlewares\Category;

use Mj\PocketCore\Exceptions\ForbiddenException;

class CategoryEditMiddleware
{
    public function handle()
    {
        if (!auth()->check() || !auth()->user()->hasPermission('category-edit')) {
            throw new ForbiddenException();
        }
    }
}