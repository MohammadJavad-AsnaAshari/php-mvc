<?php

namespace Mj\PocketCore;

class Router
{
    /**
     * @var array|array[]
     */
    private static array $routeMap = [
        'get' => [],
        'post' => []
    ];

    private static Request $request;

    public static function __callStatic($name, $arguments)
    {
        self::$request = new Request();
        $method = strtolower($name);
        if (in_array($method, ['get', 'post'])) {
            self::$routeMap[$method][$arguments[0]] = $arguments[1];
        }
    }

    /**
     * @return mixed|string
     * @throws \Exception
     */
    public function resolve()
    {
        $method = self::$request->getMethod();
        $url = self::$request->getUrl();

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
    private static function getCallbackForUrl(string $method, string $url, mixed $params): mixed
    {
        if (isset(self::$routeMap[$method][$url])) {
            $callback = self::$routeMap[$method][$url];
        } else {
            $routeCallback = self::getCallbackFromDynamicRoute($method, $url);
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
    private static function getCallbackFromDynamicRoute(string $method, string $url): bool|array
    {
        $routes = self::$routeMap[$method];

        foreach ($routes as $route => $callback) {
            $routeNames = [];

            if (!$route) {
                continue;
            }

            if (preg_match_all('/\{(\w+)(:[^}]+)?}/', $route, $matches)) {
                $routeNames = $matches[1];
            };

            $routeRegex = self::convertRouteToRegex($route);

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
    private static function convertRouteToRegex(string $route): string
    {
        return "@^".preg_replace_callback(
                '/\{\w+(:([^}]+))?}/',
                fn($matches) => isset($matches[2]) ? "({$matches[2]})" : "([-\w]+)",
                $route
            )."$@";
    }
}