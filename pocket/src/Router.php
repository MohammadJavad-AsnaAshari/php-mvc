<?php

namespace Mj\PocketCore;

class Router
{
    /**
     * @var array|array[]
     */
    private array $routeMap = [
        'get' => [],
        'post' => []
    ];

    private Request $request;

    public function __construct()
    {
        $this->request = new Request();
    }

    /**
     * @param  string  $url
     * @param $callback
     * @return void
     */
    public function get(string $url, $callback)
    {
        $this->routeMap['get'][$url] = $callback;
    }

    /**
     * @param  string  $url
     * @param $callback
     * @return void
     */
    public function post(string $url, $callback)
    {
        $this->routeMap['post'][$url] = $callback;
    }

    /**
     * @return mixed|string
     * @throws \Exception
     */
    public function resolve()
    {
        $method = $this->request->getMethod();
        $url = $this->request->getUrl();

        if ($method === 'get' || $method === 'post') {
            $params = [];
            return $this->getCallbackForUrl($method, $url, $params);
        }

        return 'The `METHOD` is not set yet! 404';
    }

    /**
     * @param  string  $method
     * @param  string  $url
     * @param  mixed  $params
     * @return mixed
     * @throws \Exception
     */
    private function getCallbackForUrl(string $method, string $url, mixed $params): mixed
    {
        if (isset($this->routeMap[$method][$url])) {
            $callback = $this->routeMap[$method][$url];
        } else {
            $routeCallback = $this->getCallbackFromDynamicRoute($method, $url);
            if (!$routeCallback) {
                throw new \Exception('Not Found 404');
            }

            $callback = $routeCallback[0];
            $params = $routeCallback[1];
        }

        return call_user_func($callback, ...array_values($params));
    }

    /**
     * @param  string  $method
     * @param  string  $url
     * @return bool|array
     */
    private function getCallbackFromDynamicRoute(string $method, string $url): bool|array
    {
        $routes = $this->routeMap[$method];

        foreach ($routes as $route => $callback) {
            $routeNames = [];

            if (!$route) {
                continue;
            }

            if (preg_match_all('/\{(\w+)(:[^}]+)?}/', $route, $matches)) {
                $routeNames = $matches[1];
            };

            $routeRegex = $this->convertRouteToRegex($route);

            if (preg_match_all($routeRegex, $url, $matches)) {
                $values = [];
                unset($matches[0]);

                foreach ($matches as $match) {
                    $values[] = $match[0];
                }

                $routeParams = array_combine($routeNames, $values);

                return [$callback, $routeParams];
            }
        }

        return false;
    }

    /**
     * @param  string  $route
     * @return string
     */
    private function convertRouteToRegex(string $route): string
    {
        return "@^".preg_replace_callback(
                '/\{\w+(:([^}]+))?}/',
                fn($matches) => isset($matches[2]) ? "({$matches[2]})" : "([-\w]+)",
                $route
            )."$@";
    }
}