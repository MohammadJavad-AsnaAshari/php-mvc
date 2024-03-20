<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Mj\PocketCore\Router;
use App\Http\Controllers\Auth\RegisterController;

Router::get('/', [HomeController::class, 'index']);

Router::get('/auth/register', [RegisterController::class, 'registerView']);
Router::post('/auth/register', [RegisterController::class, 'register']);
Router::get('/auth/login', [LoginController::class, 'loginView']);
Router::post('/auth/login', [LoginController::class, 'login']);

Router::get('/panel', function () {
    dd(auth()->user()->name);
});

Router::get('/article/{id:\d+}', [ArticleController::class, 'dynamic']);
Router::get('/article', [ArticleController::class, 'index']);
Router::get('/article/create', [ArticleController::class, 'create']);
Router::post('/article/create', [ArticleController::class, 'store']);

Router::get('/user/create', [UserController::class, 'create']);
Router::get('/user/update/{id}', [UserController::class, 'update']);
Router::get('/user/delete/{id}', [UserController::class, 'delete']);