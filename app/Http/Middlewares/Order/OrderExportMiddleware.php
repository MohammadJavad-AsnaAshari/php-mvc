<?php

namespace App\Http\Middlewares\Order;

use Mj\PocketCore\Exceptions\ForbiddenException;

class OrderExportMiddleware
{
    public function handle()
    {
        if (!auth()->check() || !auth()->user()->hasPermission('order-export')) {
            throw new ForbiddenException();
        }
    }
}