<?php

namespace Mj\PocketCore;

class Router
{
    private array $routeMap = [];
    public function get(string $url, $callback)
    {
        $this->routeMap['get'][$url] = $callback;
    }
}