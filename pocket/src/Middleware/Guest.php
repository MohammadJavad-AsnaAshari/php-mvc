<?php

namespace Mj\PocketCore\Middleware;

class Guest
{
    public function handle()
    {
        if (auth()->check()) {
            header('location: /');
            exit();
        }
    }
}