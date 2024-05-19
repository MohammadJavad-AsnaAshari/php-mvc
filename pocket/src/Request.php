<?php

namespace Mj\PocketCore;

class Request
{
    public function getMethod(): string
    {
        return strtolower($_SERVER["REQUEST_METHOD"]);
    }

    public function getUrl(): string
    {
        $url = strtolower($_SERVER['REQUEST_URI']);
        $pos = strpos($url, '?'); // ? position

        if ($pos) {
            $url = substr($url, 0, $pos);
        }

        return $url;
    }

    public function all(): array
    {
        $data = [];
        if ($this->isGet()) {
            $data = filter_input_array(INPUT_GET, FILTER_SANITIZE_SPECIAL_CHARS);
        } elseif ($this->isPost()) {
            $data = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
        }

        return $data;
    }

    public function input(string $key): ?string
    {
        return $this->all()[$key] ?? null;
    }

    public function has(string $key): bool
    {
        if ($this->isGet()) {
            return isset($_GET[$key]);
        } elseif ($this->isPost()) {
            return isset($_POST[$key]);
        }

        return false;
    }

    public function query(string $key): ?string
    {
        return filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    private function isGet(): bool
    {
        return $this->getMethod() === 'get';
    }

    private function isPost(): bool
    {
        return $this->getMethod() === 'post';
    }
}