<?php

namespace App\Http\Middlewares\Product;

use Mj\PocketCore\Exceptions\ForbiddenException;

class ProductEditMiddleware
{
    public function handle()
    {
        if (!auth()->check() || !auth()->user()->hasPermission('product-edit')) {
            throw new ForbiddenException();
        }
    }
}