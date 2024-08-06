<?php

use Mj\PocketCore\Application;
use Mj\PocketCore\Auth;
use Mj\PocketCore\Controller;
use Mj\PocketCore\Request;
use Mj\PocketCore\Response;
use Mj\PocketCore\Session;

if (!function_exists('dd')) {
    function dd(mixed $value): void
    {
        var_dump($value);
        die();
    }
}

if (!function_exists('app')) {
    function app(): Application
    {
        return Application::$app;
    }
}

if (!function_exists('request')) {
    function request($key = null): Request|string
    {
        if (is_null($key)) {
            return app()->request;
        }

        return app()->request->input($key);
    }
}

if (!function_exists('response')) {
    function response(): Response
    {
        return app()->response;
    }
}

if (!function_exists('redirect')) {
    function redirect(string $url): Response
    {
        return response()->redirect($url);
    }
}

if (!function_exists('session')) {
    function session(): Session
    {
        return app()->session;
    }
}

if (!function_exists('auth')) {
    function auth(): Auth
    {
        return new Auth();
    }
}

if (!function_exists('view')) {
    function view(string $view, array $data = [])
    {
        return (new Controller())->render($view, $data);
    }
}

if (!function_exists('isActive')) {
    function isActive($key, $activeClassName = 'active')
    {
        if (is_array($key)) {
            return in_array(request()->getUrl(), $key) ? $activeClassName : '';
        }

        return request()->getUrl() === $key ? $activeClassName : '';
    }
}

if (!function_exists('isUrl')) {
    function isUrl($url, $activeClassName = 'active')
    {
        return request()->isUrl($url) ? $activeClassName : '';
    }
}

if (!function_exists('logTransaction')) {
    function logTransaction(string $status, string $class, string $function, string|null $error = null): void
    {
        $logDir = ROOT . 'storage/logs/transaction';
        if (!file_exists($logDir)) {
            mkdir($logDir, 0777, true);
        }
        $logFile = fopen($logDir . '/log.txt', 'a');
        $message = '[' . $status . '] - ' . $class . '::' . $function . ' | ' . date('Y-m-d H:i:s');
        if ($error) {
            $message .= "\n" . '[error message] - ' . $error;
        }
        fwrite($logFile, $message . "\n");
        fclose($logFile);
    }
}


