<?php

namespace App\Http\Middlewares\Product;

use Mj\PocketCore\Exceptions\ForbiddenException;

class ProductCreateMiddleware
{
    public function handle()
    {
        if (!auth()->check() || !auth()->user()->hasPermission('product-create')) {
            throw new ForbiddenException();
        }
    }
}