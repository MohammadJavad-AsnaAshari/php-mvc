<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ShopController;
use App\Models\Comment;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use Mj\PocketCore\Router;

Router::get('/', [HomeController::class, 'index']);
Router::get('/about-us', [HomeController::class, 'aboutUs']);

Router::get('/shop', [ShopController::class, 'index']);
Router::get('/shop/{product}', [ShopController::class, 'show']);
Router::get('/popular', [ShopController::class, 'popular']);

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
Router::get('/test/user/articles', function () {
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

Router::get('/test/comment/user/{comment}', function ($comment) {
    $comment = (new Comment())->find($comment);

    dd($comment->user()->first());
});

Router::get('/test/comment/product/{comment}', function ($comment) {
    $comment = (new Comment())->find($comment);

    dd($comment->product()->first());
});

Router::get('/test/role/admin' , function() {
    try {
        $user = (new User())->find(1);
        $roles = $user->roles();
        foreach ($roles as $role) {
            echo $role->name . "<br>";
        }
    } catch (Exception $exception) {
        echo $exception->getMessage();
    }
});

Router::get('/test/user/admin', function () {
    try {
        $role = (new Role())->find(1);
        $users = $role->users();
        foreach ($users as $user) {
            echo $user->name . "<br>";
        }
    } catch (Exception $exception) {
        echo $exception->getMessage();
    }
});

Router::get('/test/where_in', function() {
    $users = (new User())->whereIn('id', [2, 1])->get();

    foreach ($users as $user) {
        echo $user->name . "<br>";
    }
});