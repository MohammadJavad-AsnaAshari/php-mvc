<?php

namespace App\Http\Middlewares\Comment;

use Mj\PocketCore\Exceptions\ForbiddenException;

class CommentIndexMiddleware
{
    public function handle()
    {
        if (!auth()->check() || !auth()->user()->hasPermission('comment-index')) {
            throw new ForbiddenException();
        }
    }
}