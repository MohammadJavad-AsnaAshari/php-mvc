<?php

namespace Mj\PocketCore;

use Dotenv\Dotenv;
use Exception;
use Mj\PocketCore\Database\Database;

class Application
{
    public static Application $app;
    public Router $router;
    public static string $ROOT_DIR;
    public Database $database;
    public Request $request;
    public Response $response;
    public Session $session;
    public View $view;

    public function __construct(string $root_dir)
    {
        self::$app = $this;
        self::$ROOT_DIR = $root_dir;

        $dotenv = Dotenv::createImmutable($root_dir);
        $dotenv->load();

        $this->router = new Router();
        $this->database = new Database();
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->view = new View();
    }

    public function run()
    {
        try {
            echo $this->router->resolve();
        } catch (Exception $exception) {
            if ($exception->getCode()) {
                $errorCode = $exception->getCode();
            } else {
                $errorCode = 500;
            }

            echo $this->view->render("errors.$errorCode", [
                'error' => $exception
            ]);
        }
    }
}