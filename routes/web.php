<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Client\HomeController;
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
},
    [\App\Http\Middlewares\AuthMiddleware::class]
);