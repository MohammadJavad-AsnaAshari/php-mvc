<?php

namespace App\Http\Middlewares\Order;

use Mj\PocketCore\Exceptions\ForbiddenException;

class OrderIndexMiddleware
{
    public function handle()
    {
        if (!auth()->check() || !auth()->user()->hasPermission('order-index')) {
            throw new ForbiddenException();
        }
    }
}