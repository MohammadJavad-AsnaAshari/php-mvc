<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\UserController;
use Mj\PocketCore\Router;

Router::get('/', 'home');
Router::get('/article/{id:\d+}', [ArticleController::class, 'dynamic']);
Router::get('/article', [ArticleController::class, 'index']);
Router::get('/article/create', [ArticleController::class, 'create']);
Router::post('/article/create', [ArticleController::class, 'store']);

Router::get('/user/create', [UserController::class, 'create']);