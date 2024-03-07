<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Mj\PocketCore\Router;

Router::get('/', [HomeController::class, 'index']);

Router::get('/article/{id:\d+}', [ArticleController::class, 'dynamic']);
Router::get('/article', [ArticleController::class, 'index']);
Router::get('/article/create', [ArticleController::class, 'create']);
Router::post('/article/create', [ArticleController::class, 'store']);

Router::get('/user/create', [UserController::class, 'create']);
Router::get('/user/update/{id}', [UserController::class, 'update']);
Router::get('/user/delete/{id}', [UserController::class, 'delete']);

Router::get('/admin', 'admin.master');