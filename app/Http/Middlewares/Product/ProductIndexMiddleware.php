<?php

namespace App\Http\Middlewares\Product;

use Mj\PocketCore\Exceptions\ForbiddenException;

class ProductIndexMiddleware
{
    public function handle()
    {
        if (!auth()->check() || !auth()->user()->hasPermission('user-index')) {
            throw new ForbiddenException();
        }
    }
}