<?php

namespace Mj\PocketCore;

class Application
{
    public Router $router;

    public function __construct()
    {
        $this->router = new Router();
    }
}