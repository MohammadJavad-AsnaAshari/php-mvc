<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\UserController;
use Mj\PocketCore\Router;

Router::get('/', [HomeController::class, 'indexHome']);
Router::get('/shop', [HomeController::class, 'indexShop']);

Router::get('/auth/register', [RegisterController::class, 'registerView'], ['guest']);
Router::post('/auth/register', [RegisterController::class, 'register'], ['guest']);
Router::get('/auth/login', [LoginController::class, 'loginView'], ['guest']);
Router::post('/auth/login', [LoginController::class, 'login'], ['guest']);
Router::get('/auth/logout', [LogoutController::class, 'logout']);

Router::get('/panel', function () {
    if (auth()->check()) {
        dd(auth()->user()->name);
    }
}, [\App\Http\Middlewares\AuthMiddleware::class]);

Router::get('/article/{id:\d+}', [ArticleController::class, 'dynamic']);
Router::get('/article', [ArticleController::class, 'index']);
Router::get('/article/create', [ArticleController::class, 'create']);
Router::post('/article/create', [ArticleController::class, 'store']);

Router::get('/user/create', [UserController::class, 'create']);
Router::get('/user/update/{id}', [UserController::class, 'update']);
Router::get('/user/delete/{id}', [UserController::class, 'delete']);