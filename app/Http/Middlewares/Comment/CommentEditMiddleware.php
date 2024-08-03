<?php

namespace App\Http\Middlewares\Comment;

use Mj\PocketCore\Exceptions\ForbiddenException;

class CommentEditMiddleware
{
    public function handle()
    {
        if (!auth()->check() || !auth()->user()->hasPermission('comment-edit')) {
            throw new ForbiddenException();
        }
    }
}