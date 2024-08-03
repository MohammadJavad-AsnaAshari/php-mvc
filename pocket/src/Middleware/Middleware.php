<?php

namespace Mj\PocketCore\Middleware;

use App\Http\Middlewares\Category\CategoryCreateMiddleware;
use App\Http\Middlewares\Category\CategoryDeleteMiddleware;
use App\Http\Middlewares\Category\CategoryEditMiddleware;
use App\Http\Middlewares\Category\CategoryIndexMiddleware;
use App\Http\Middlewares\Comment\CommentDeleteMiddleware;
use App\Http\Middlewares\Comment\CommentEditMiddleware;
use App\Http\Middlewares\Comment\CommentIndexMiddleware;
use App\Http\Middlewares\Database\DatabaseBackupMiddleware;
use App\Http\Middlewares\Database\DatabaseRecoveryMiddleware;
use App\Http\Middlewares\Order\OrderIndexMiddleware;
use App\Http\Middlewares\Permission\PermissionCreateMiddleware;
use App\Http\Middlewares\Permission\PermissionDeleteMiddleware;
use App\Http\Middlewares\Permission\PermissionEditMiddleware;
use App\Http\Middlewares\Permission\PermissionIndexMiddleware;
use App\Http\Middlewares\Product\ProductCreateMiddleware;
use App\Http\Middlewares\Product\ProductDeleteMiddleware;
use App\Http\Middlewares\Product\ProductEditMiddleware;
use App\Http\Middlewares\Product\ProductIndexMiddleware;
use App\Http\Middlewares\User\UserCreateMiddleware;
use App\Http\Middlewares\User\UserDeleteMiddleware;
use App\Http\Middlewares\User\UserEditMiddleware;
use App\Http\Middlewares\User\UserIndexMiddleware;
use Mj\PocketCore\Exceptions\NotMatchMiddleware;

class Middleware
{
    public const MAP = [
        'guest' => Guest::class,
        'auth' => Authenticated::class,
        'admin' => Admin::class,
        'user-index' => UserIndexMiddleware::class,
        'user-edit' => UserEditMiddleware::class,
        'user-delete' => UserDeleteMiddleware::class,
        'user-create' => UserCreateMiddleware::class,
        'permission-index' => PermissionIndexMiddleware::class,
        'permission-edit' => PermissionEditMiddleware::class,
        'permission-delete' => PermissionDeleteMiddleware::class,
        'permission-create' => PermissionCreateMiddleware::class,
        'product-index' => ProductIndexMiddleware::class,
        'product-edit' => ProductEditMiddleware::class,
        'product-delete' => ProductDeleteMiddleware::class,
        'product-create' => ProductCreateMiddleware::class,
        'category-index' => CategoryIndexMiddleware::class,
        'category-edit' => CategoryEditMiddleware::class,
        'category-delete' => CategoryDeleteMiddleware::class,
        'category-create' => CategoryCreateMiddleware::class,
        'comment-index' => CommentIndexMiddleware::class,
        'comment-edit' => CommentEditMiddleware::class,
        'comment-delete' => CommentDeleteMiddleware::class,
        'order-index' => OrderIndexMiddleware::class,
        'database-backup' => DatabaseBackupMiddleware::class,
        'database-recovery' => DatabaseRecoveryMiddleware::class,
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