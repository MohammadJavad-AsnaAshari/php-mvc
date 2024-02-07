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


}