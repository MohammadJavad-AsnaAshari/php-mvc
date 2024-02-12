<?php

use Mj\PocketCore\Application;
use Mj\PocketCore\Router;

$root = dirname(__DIR__).DIRECTORY_SEPARATOR;

define('APP_PATH', $root.'app'.DIRECTORY_SEPARATOR);
define('VENDOR_PATH', $root.'vendor'.DIRECTORY_SEPARATOR);

require_once VENDOR_PATH."autoload.php";

$app = new Application();

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

Router::get('/article/create', function () {
    include_once __DIR__."/article.html";
});

Router::post('/article/create', function () {
    return 'hello world! this is post method!';
});

$app->run();