<?php

namespace Mj\PocketCore\Middleware;

use Mj\PocketCore\Exceptions\NotMatchMiddleware;

class Middleware
{
    public const MAP = [
        'guest' => Guest::class,
        'auth' => Authenticated::class,
        'admin' => Admin::class,
    ];

    public static function resolve($key)
    {
        if (!$key) {
            return;
        }

        $middleware = static::MAP[$key] ?? false;

        if (!$middleware) {
            throw new NotMatchMiddleware($key);
        }

        (new $middleware)->handle();
    }
}