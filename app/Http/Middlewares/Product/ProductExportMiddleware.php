<?php

namespace App\Http\Middlewares\Product;

use Mj\PocketCore\Exceptions\ForbiddenException;

class ProductExportMiddleware
{
    public function handle()
    {
        if (!auth()->check() || !auth()->user()->hasPermission('product-export')) {
            throw new ForbiddenException();
        }
    }
}