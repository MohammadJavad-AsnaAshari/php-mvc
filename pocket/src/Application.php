<?php

namespace Mj\PocketCore;

class Application
{
    public Router $router;

    public static string $ROOT_DIR;

    public function __construct(string $root_dir)
    {
        self::$ROOT_DIR = $root_dir;
        $this->router = new Router();
    }

    public function run()
    {
        echo $this->router->resolve();
    }
}