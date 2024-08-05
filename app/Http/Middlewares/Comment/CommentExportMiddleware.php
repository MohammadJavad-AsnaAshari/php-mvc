<?php

namespace App\Http\Middlewares\Comment;

use Mj\PocketCore\Exceptions\ForbiddenException;

class CommentExportMiddleware
{
    public function handle()
    {
        if (!auth()->check() || !auth()->user()->hasPermission('comment-export')) {
            throw new ForbiddenException();
        }
    }
}