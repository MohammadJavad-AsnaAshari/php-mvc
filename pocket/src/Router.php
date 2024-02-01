<?php

namespace Mj\PocketCore;

class Router
{
    private array $routeMap = [];
    public function get(string $url, $callback)
    {
        $this->routeMap['get'][$url] = $callback;
    }

    public function resolve()
    {
        $method = strtolower($_SERVER["REQUEST_METHOD"]);
        $url = strtolower($_SERVER['REQUEST_URI']);
        $pos = strpos($url, '?'); // ? position

        if ($method === 'get') {
            if($pos) {
                $url = substr($url, 0, $pos);
            }
            if (isset($this->routeMap[$method][$url])) {
                $callback = $this->routeMap[$method][$url];

                return $callback();
            }

            return 'The `GET` route is not set yet! 404';
        }

        return 'The `METHOD` is not set yet! 404';
    }
}