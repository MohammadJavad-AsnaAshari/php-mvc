<?php

namespace Mj\PocketCore;

use Dotenv\Dotenv;
use Mj\PocketCore\Database\Database;

class Application
{
    public static Application $app;
    public Router $router;
    public static string $ROOT_DIR;
    public Database $database;

    public function __construct(string $root_dir)
    {
        self::$app = $this;
        self::$ROOT_DIR = $root_dir;

        $dotenv = Dotenv::createImmutable($root_dir);
        $dotenv->load();

        $this->router = new Router();
        $this->database = new Database();
    }

    public function run()
    {
        echo $this->router->resolve();
    }
}