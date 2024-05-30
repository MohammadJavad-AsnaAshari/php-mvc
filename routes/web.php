<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Client\HomeController;
use App\Models\Product;
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

Router::get('/products/edit/{product}', [HomeController::class, 'productEdit']);
Router::post('/products/update/{product}', [HomeController::class, 'productUpdate']);



// -------------------------------------------------- test --------------------------------------------------
Router::get('/test', function () {
    $user = auth()->user();
    $articles = $user->articles()->get();

    foreach($articles as $article){
        echo $article->title . "<br>";
    }
});

Router::get('/test/product/comments/{product}', function ($product) {
    $product = (new Product())->find($product);
    $comments = $product->comments()->get();

    foreach ($comments as $comment) {
        echo $comment->comment . "<br>";
    }
});