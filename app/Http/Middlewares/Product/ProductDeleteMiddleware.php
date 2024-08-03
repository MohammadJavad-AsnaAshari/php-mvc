<?php

namespace App\Http\Middlewares\Product;

use Mj\PocketCore\Exceptions\ForbiddenException;

class ProductDeleteMiddleware
{
    public function handle()
    {
        if (!auth()->check() || !auth()->user()->hasPermission('product-delete')) {
            throw new ForbiddenException();
        }
    }
}