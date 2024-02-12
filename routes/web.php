<?php

use Mj\PocketCore\Router;

$root = dirname(__DIR__) . DIRECTORY_SEPARATOR;

Router::get('/article/{id:\d+}', function ($id) {
    return "article dynamic page. id: $id";
});

Router::get('/article', function () {
    return 'article page';
});

Router::get('/series', function () {
    return 'series page';
});

Router::get('/about', function () {
    return 'about page';
});

Router::get('/article/create', function () use ($root) {
    include_once $root . "public" . DIRECTORY_SEPARATOR . "article.html";
});

Router::post('/article/create', function () {
    return 'hello world! this is post method!';
});