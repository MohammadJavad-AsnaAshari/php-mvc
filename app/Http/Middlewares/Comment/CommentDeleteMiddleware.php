<?php

namespace App\Http\Middlewares\Comment;

use Mj\PocketCore\Exceptions\ForbiddenException;

class CommentDeleteMiddleware
{
    public function handle()
    {
        if (!auth()->check() || !auth()->user()->hasPermission('comment-delete')) {
            throw new ForbiddenException();
        }
    }
}