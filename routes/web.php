<?php

use App\Http\Controllers\ArticleController;
use Mj\PocketCore\Router;

$root = dirname(__DIR__) . DIRECTORY_SEPARATOR;

Router::get('/article/{id:\d+}', [ArticleController::class, 'dynamic']);

Router::get('/article', [ArticleController::class, 'index']);

Router::get('/article/create', [ArticleController::class, 'create']);

Router::post('/article/create', [ArticleController::class, 'store']);