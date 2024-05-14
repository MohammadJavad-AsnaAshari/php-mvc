<?php

namespace Mj\PocketCore;

use Mj\PocketCore\Exceptions\NotFoundException;

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

    protected array $routeFiles = [];

    public function __construct()
    {
        self::$request = new Request();
    }

    public static function get(string $url, $callback, array $middlewares = []): void
    {
        self::$routeMap['get'][$url] = $callback;
        self::$routeMap['middlewares']['get'][$url] = $middlewares;
    }

    public static function post(string $url, $callback, array $middlewares = []): void
    {
        self::$routeMap['post'][$url] = $callback;
        self::$routeMap['middlewares']['post'][$url] = $middlewares;
    }

    /**
     * @return mixed|string
     * @throws \Exception
     */
    public function resolve()
    {
        foreach ($this->routeFiles as $file) {
            require_once $file;
        }

        $method = self::$request->getMethod();
        $url = self::$request->getUrl();

        if ($method === 'get' || $method === 'post') {
            $params = [];

            return $this->getCallbackForUrl($method, $url, $params);
        }

        throw new NotFoundException('The `METHOD` is not set yet!');
    }

    public function setRouterFile(string $path): Router
    {
        $this->routeFiles[] = $path;
        return $this;
    }

    /**
     * @param string $method
     * @param string $url
     * @param mixed $params
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
                throw new NotFoundException();
            }

            $callback = $routeCallback[0];
            $params = $routeCallback[1];
        }

        // Check if there are any middleware attached to the current route
        $middlewares = self::$routeMap['middlewares'][$method][$url] ?? [];

        // Loop through the middleware and execute them
        $request = self::$request; // Get the current request object
        $next = function () use ($callback, $params) {
            // Define a closure that calls the route callback with the $params array
            return call_user_func($callback, ...array_values($params));
        };

        foreach ($middlewares as $middleware) {
            $middlewareInstance = new $middleware;
            $request = $middlewareInstance->handle($request, $next); // Pass the current request object and the closure to the middleware's handle method
        }

        if (is_string($callback)) {
            return app()->view->render($callback);
        }

        if (is_array($callback)) {
            $controllerMethod = new \ReflectionMethod($callback[0], $callback[1]);

            $autoInjection = [];
            foreach ($controllerMethod->getParameters() as $value) {
                if (class_exists($class = $value->getType()->getName())) {
                    $autoInjection[$value->getName()] = new $class;
                }
            }

            return $controllerMethod->invoke(new $callback[0], ...$autoInjection, ...$params);
        }

        return call_user_func($callback, ...array_values($params));
    }

    /**
     * @param string $method
     * @param string $url
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
     * @param string $route
     * @return string
     */
    private static function convertRouteToRegex(string $route): string
    {
        return "@^" . preg_replace_callback(
                '/\{\w+(:([^}]+))?}/',
                fn($matches) => isset($matches[2]) ? "({$matches[2]})" : "([-\w]+)",
                $route
            ) . "$@";
    }
}