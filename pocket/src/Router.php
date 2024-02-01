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

        if ($pos) {
            $url = substr($url, 0, $pos);
        }

        if ($method === 'get') {
            $params = [];
            if (isset($this->routeMap[$method][$url])) {
                $callback = $this->routeMap[$method][$url];
            } else {
                $routeCallback = $this->getCallbackFromDynamicRoute();
                if (!$routeCallback) {
                    throw new \Exception('Not Found 404');
                }

                $callback = $routeCallback[0];
                $params = $routeCallback[1];
            }
            return call_user_func($callback, ...array_values($params));
        }

        return 'The `METHOD` is not set yet! 404';
    }

    private function getCallbackFromDynamicRoute()
    {
        $method = strtolower($_SERVER["REQUEST_METHOD"]);
        $url = strtolower($_SERVER['REQUEST_URI']);
        $pos = strpos($url, '?'); // ? position

        if ($pos) {
            $url = substr($url, 0, $pos);
        }

        $routes = $this->routeMap[$method];

        foreach ($routes as $route => $callback) {
            $routeNames = [];

            if (!$route) {
                continue;
            }

            if (preg_match_all('/\{(\w+)}/', $route, $matches)) {
                $routeNames = $matches[1];
            };

            $routeRegex = "@^".preg_replace('/\{(\w+)}/', '([-\w]+)', $route)."$@";

            if (preg_match_all($routeRegex, $url, $matches)) {
                $values = [];
                unset($matches[0]);

                foreach ($matches as $match) {
                    $values[] = $match[0];
                }

                $routeParams = array_combine($routeNames, $values);

                return [0 => $callback, 1 => $routeParams];
            }
        }

        return false;
    }
}