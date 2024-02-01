<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = new \Mj\PocketCore\Application();

$app->router->get('/article', function () {
    return 'article page';
});

$app->router->get('/series', function () {
    return 'series page';
});

$app->router->get('/about', function () {
    return 'about page';
});

$app->run();