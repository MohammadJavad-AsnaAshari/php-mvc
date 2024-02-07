<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = new \Mj\PocketCore\Application();

$app->router->get('/article/{id:\d+}', function ($id) {
    return "article dynamic page. id: $id";
});

$app->router->get('/article', function () {
    return 'article page';
});

$app->router->get('/series', function () {
    return 'series page';
});

$app->router->get('/about', function () {
    return 'about page';
});

$app->router->get('/article/create', function () {
    include_once __DIR__ . "/article.html";
});

$app->router->post('/article/create', function () {
    return 'hello world! this is post method!';
});

$app->run();